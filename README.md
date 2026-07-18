# 🏦 IFSC Code Finder Portal

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.4-blue.svg)](https://www.php.net/)
[![Python Version](https://img.shields.io/badge/Python-3.x-blue.svg)](https://www.python.org/)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Security Hardened](https://img.shields.io/badge/Security-Hardened-success.svg)](#security-hardening-and-improvements)

An elegant, secure, and fully featured PHP/MySQL web application designed to help users search, locate, and retrieve IFSC codes, MICR codes, branch addresses, and telephone details for banks across India. It includes an administrative dashboard to manage bank configurations, states, cities, and branch directories.

---

## 🌟 Key Features

*   **Fast Branch Lookup**: Search bank details instantly by typing the Zipcode, Branch name, or Bank name in the user portal.
*   **Comprehensive Admin Dashboard**: Access key metrics such as total banks, states, cities, and registered branches in one screen.
*   **Directory Management**: Full CRUD capabilities for states, cities, banks, facilities, and branch contact details.
*   **RBI Data Downloader**: Includes a modernized Python utility script that fetches the latest official bank IFSC Excel spreadsheets directly from the **Reserve Bank of India (RBI)** web directory.

---

## 🛡️ Security Hardening and Improvements

To make this project production-ready and showcase best-in-class security practices, the codebase has been extensively audited and updated:

### 1. Cross-Site Request Forgery (CSRF) Mitigation
*   **Form Security**: All state-modifying actions (such as admin login, profile updates, adding/editing bank branches) are secured using unique, cryptographically secure session-stored tokens generated with `random_bytes(32)`.
*   **Endpoint Guarding**: GET-based deletion URLs (`manage-*.php?delid=X`) are protected by appending an encrypted `csrf_token` parameter, validated on the backend via timing-attack resistant comparison (`hash_equals`).

### 2. Upgraded Password Cryptography
*   **Modern Hashing Standard**: The deprecated and vulnerable `md5()` password hashing has been completely removed.
*   **BCrypt Implementation**: Passwords are now securely processed using PHP's native `password_hash()` and verified using `password_verify()`.

### 3. Session Authentication Patches
*   **Authorization Guard**: Fixed a critical copy-paste vulnerability in the authentication validation check (`strlen($_SESSION['ifscaid']==0)`) across all 18 administrative pages, completely preventing unauthorized access bypasses.

### 4. Database Security
*   **SQL Injection Prevention**: All SQL statements utilize PDO (PHP Data Objects) with prepared statements and parameter binding (`bindParam()`).

---

## 📁 Project Directory Structure

```text
├── SQL File/
│   └── ifscdb.sql               # Database schema and initial default configurations
├── ifscfinder/                  # Main PHP Web Application
│   ├── admin/                   # Administrative backend control panel
│   │   ├── includes/            # Common layouts (header, footer, database connection, CSRF)
│   │   ├── login.php            # Secure admin login entrypoint
│   │   └── dashboard.php        # Administrative overview console
│   └── assets/                  # User portal CSS, JS libraries, and styling assets
├── scripts/
│   └── ifsc_downloader.py       # Modern Python 3 script to pull latest bank directories from RBI
└── README.md                    # Project documentation
```

---

## 🚀 Setup & Installation Guide

### Prerequisites
*   A local PHP web server setup (e.g., **XAMPP**, **WAMP**, **MAMP**, or standard LAMP stack).
*   **MySQL / MariaDB** database.
*   **Python 3.x** (optional, only for running the RBI scraper).

---

### Step-by-Step Installation

#### 1. Setup the Database
1.  Open **phpMyAdmin** (usually `http://localhost/phpmyadmin`) or your favorite SQL client.
2.  Create a new database named `ifscdb`.
3.  Import the SQL schema file located at `SQL File/ifscdb.sql`.

#### 2. Deploy Web Files
1.  Copy the `ifscfinder` folder.
2.  Paste it inside your local web server's root directory (e.g., `xampp/htdocs/` or `var/www/html/`).

#### 3. Database Connection Configuration
Ensure credentials in `ifscfinder/admin/includes/dbconnection.php` match your local setup:
```php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS',''); // Set your database password if applicable
define('DB_NAME','ifscdb');
```

#### 4. Access the Application
*   **User Portal**: Browse to `http://localhost/ifscfinder/index.php`.
*   **Admin Panel**: Browse to `http://localhost/ifscfinder/admin/login.php`.

**Admin Credentials (Default):**
*   **Username**: `admin`
*   **Password**: `Test@123`

---

## 🐍 Python RBI Data Scraper

The project includes an automatic downloader script to pull Excel spreadsheets containing the latest branch-wise IFSC codes from the official RBI website:

### Requirements
Install Python dependencies:
```bash
pip install requests beautifulsoup4
```

### Usage
Execute the script from the project root:
```bash
python scripts/ifsc_downloader.py
```
This script will parse the RBI portal, extract the URLs of the xls/xlsx spreadsheets, and download them into a `downloaded_data/` folder.

---

## 📄 License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
