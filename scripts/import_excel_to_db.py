#!/usr/bin/env python3
"""
IFSC Data Importer
Parses downloaded RBI Excel sheets and imports bank branch directories into MySQL database.
"""

import os
import re
import pymysql
import openpyxl

# DB configurations
DB_HOST = "localhost"
DB_USER = "root"
DB_PASS = ""
DB_NAME = "ifscdb"

def clean_value(val):
    if val is None:
        return ""
    return str(val).strip()

def extract_zip(address):
    # Try to extract 6-digit zip code from address
    match = re.search(r'\b\d{6}\b', address)
    if match:
        try:
            return int(match.group(0))
        except ValueError:
            pass
    return 0

def extract_phone(phone_val):
    if not phone_val:
        return 0
    # Clean non-digit characters
    digits = re.sub(r'\D', '', str(phone_val))
    if digits:
        try:
            # SQL bigint limits or length checks
            num = int(digits)
            return num if len(str(num)) <= 10 else int(str(num)[:10])
        except ValueError:
            pass
    return 0

def main():
    folder = r"e:\code\ifsc\downloaded_data"
    if not os.path.exists(folder) or not os.listdir(folder):
        print(f"No downloaded Excel files found in '{folder}'. Please run the downloader first.")
        return

    print("Connecting to local MySQL database...")
    try:
        conn = pymysql.connect(
            host=DB_HOST,
            user=DB_USER,
            password=DB_PASS,
            database=DB_NAME,
            charset='utf8mb4',
            cursorclass=pymysql.cursors.DictCursor
        )
    except Exception as e:
        print(f"Database connection failed: {e}")
        print("Make sure XAMPP MySQL is started and running on port 3306.")
        return

    cursor = conn.cursor()

    # Load cache for faster lookups
    print("Loading database cache...")
    cursor.execute("SELECT ID, BankName FROM tblbank")
    bank_cache = {r['BankName'].upper(): r['ID'] for r in cursor.fetchall()}

    cursor.execute("SELECT ID, State FROM tblstate")
    state_cache = {r['State'].upper(): r['ID'] for r in cursor.fetchall()}

    cursor.execute("SELECT ID, StateID, City FROM tblcity")
    city_cache = {(r['StateID'], r['City'].upper()): r['ID'] for r in cursor.fetchall()}

    cursor.execute("SELECT IFSCCode FROM tblbankdetail")
    ifsc_set = {r['IFSCCode'].upper() for r in cursor.fetchall()}

    files = [f for f in os.listdir(folder) if f.endswith(".xlsx")]
    print(f"Found {len(files)} Excel files for processing.")

    for file_idx, filename in enumerate(files, 1):
        filepath = os.path.join(folder, filename)
        print(f"[{file_idx}/{len(files)}] Processing {filename}...")

        try:
            wb = openpyxl.load_workbook(filepath, read_only=True)
            sheet = wb.active
        except Exception as e:
            print(f"Error loading workbook {filename}: {e}")
            continue

        rows_to_insert = []
        headers = None

        for idx, row in enumerate(sheet.iter_rows(values_only=True)):
            # Detect headers
            if idx == 0 or not headers:
                # Basic check for headers
                if any(x in str(row).upper() for x in ['BANK', 'IFSC', 'BRANCH']):
                    headers = [str(h).upper().strip() if h else "" for h in row]
                    continue
                else:
                    # Skip rows until headers are found
                    continue

            # Ensure row is not empty
            if not any(row):
                continue

            # Map values based on header names
            data = {}
            for col_idx, header in enumerate(headers):
                if col_idx < len(row):
                    data[header] = clean_value(row[col_idx])

            bank_name = data.get('BANK', '')
            ifsc_code = data.get('IFSC', '').upper()
            branch = data.get('BRANCH', '')
            address = data.get('ADDRESS', '')
            city_name = data.get('CITY1', '')
            state_name = data.get('STATE', '')
            phone_val = data.get('PHONE', '')

            # Basic validations
            if not bank_name or not ifsc_code:
                continue

            # Skip duplicate entries
            if ifsc_code in ifsc_set:
                continue

            # 1. Resolve Bank
            bank_key = bank_name.upper()
            if bank_key not in bank_cache:
                short_name = bank_name[:10].upper()
                cursor.execute(
                    "INSERT INTO tblbank (BankName, ShortName) VALUES (%s, %s)",
                    (bank_name, short_name)
                )
                bank_id = cursor.lastrowid
                bank_cache[bank_key] = bank_id
            else:
                bank_id = bank_cache[bank_key]

            # 2. Resolve State
            state_key = state_name.upper() if state_name else "UNKNOWN"
            state_display = state_name if state_name else "Unknown"
            if state_key not in state_cache:
                cursor.execute("INSERT INTO tblstate (State) VALUES (%s)", (state_display,))
                state_id = cursor.lastrowid
                state_cache[state_key] = state_id
            else:
                state_id = state_cache[state_key]

            # 3. Resolve City
            city_key = city_name.upper() if city_name else "UNKNOWN"
            city_display = city_name if city_name else "Unknown"
            city_cache_key = (state_id, city_key)
            if city_cache_key not in city_cache:
                cursor.execute(
                    "INSERT INTO tblcity (StateID, City) VALUES (%s, %s)",
                    (state_id, city_display)
                )
                city_id = cursor.lastrowid
                city_cache[city_cache_key] = city_id
            else:
                city_id = city_cache[city_cache_key]

            # Extract phone, branch code, zip code
            phone_num = extract_phone(phone_val)
            branch_code = ifsc_code[-6:]
            zip_code = extract_zip(address)

            rows_to_insert.append((
                ifsc_code,
                ifsc_code, # MICRCode defaulted to IFSC
                str(bank_id), # BankName column stores string representation of bank ID
                address,
                state_id,
                city_id,
                branch,
                phone_num,
                branch_code,
                zip_code
            ))

            ifsc_set.add(ifsc_code)

            # Insert batch every 500 records
            if len(rows_to_insert) >= 500:
                cursor.executemany(
                    "INSERT INTO tblbankdetail (IFSCCode, MICRCode, BankName, Address, StateID, CityID, Branch, PhoneNumber, BranchCode, ZipCode) "
                    "VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    rows_to_insert
                )
                conn.commit()
                rows_to_insert = []

        # Insert remaining rows for the file
        if rows_to_insert:
            cursor.executemany(
                "INSERT INTO tblbankdetail (IFSCCode, MICRCode, BankName, Address, StateID, CityID, Branch, PhoneNumber, BranchCode, ZipCode) "
                "VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                rows_to_insert
            )
            conn.commit()

        print(f"Finished file {filename}. Total branch entries tracked: {len(ifsc_set)}")

    conn.close()
    print("Database sync complete!")

if __name__ == '__main__':
    main()
