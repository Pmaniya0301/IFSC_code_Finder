#!/usr/bin/env python3
"""
IFSC Data Downloader
Downloads the latest bank branch details and IFSC XLS files from the Reserve Bank of India (RBI) website.
"""

import os
import re
from http.cookiejar import CookieJar
from urllib.parse import urlparse
import requests
from bs4 import BeautifulSoup

def main():
    jar = CookieJar()
    headers = {
        'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    }

    url = "https://www.rbi.org.in/Scripts/bs_viewcontent.aspx?Id=2009"
    print(f"Fetching bank IFSC list from RBI directory: {url}")
    
    try:
        response = requests.get(url, headers=headers, cookies=jar, timeout=15)
        response.raise_for_status()
    except requests.exceptions.RequestException as e:
        print(f"Error fetching directory: {e}")
        return

    soup = BeautifulSoup(response.content, 'html.parser')
    ulist = soup.find_all("a", href=re.compile(r'\.xls[x]?$', re.IGNORECASE))
    
    if not ulist:
        print("No Excel files found on the page.")
        return

    # Create target directory for downloads
    output_dir = 'downloaded_data'
    os.makedirs(output_dir, exist_ok=True)
    print(f"Found {len(ulist)} Excel files. Starting downloads to '{output_dir}/'...")

    for xl in ulist:
        dataurl = xl['href']
        if dataurl.startswith("http://"):
            dataurl = 'https://' + dataurl[7:]
            
        fname = os.path.basename(urlparse(dataurl).path)
        if not fname:
            continue
            
        target_path = os.path.join(output_dir, fname)
        print(f"Downloading: {fname}...")
        
        try:
            xl_response = requests.get(dataurl, headers=headers, cookies=jar, timeout=30)
            xl_response.raise_for_status()
            with open(target_path, 'wb') as f:
                f.write(xl_response.content)
            print(f"Saved to: {target_path}")
        except Exception as e:
            print(f"Failed to download {dataurl}: {e}")

if __name__ == '__main__':
    main()
