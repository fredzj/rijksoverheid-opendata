# rijksoverheid-opendata

This project allows you to download and view travel advice data from the Government of the Netherlands.

## Prerequisites
- A web server (e.g., Apache, Nginx)
- PHP installed on the server
- MySQL or MariaDB database

## 1. Save Database Credentials
Create a file `/config/db.ini` and enter your database credentials in the following format:
```ini
hostname=your_hostname
databasename=your_databasename
username=your_username
password=your_password
```

### 2. Create Database Tables
Import all SQL files from the database directory into your database:
```sh
mysql -u your_username -p your_databasename < /path/to/database/file.sql
```
## 3. Transfer Files
Transfer all files to your server.  

## 4. Import Travel Advice Data
Schedule `importTravelAdvice.php` in order to import Travel Advice data from the Government of the Netherlands and save it into your database. You can use a cron job for this:
```sh
# Example cron job to run the script daily at midnight
0 0 * * * /usr/bin/php /path/to/importTravelAdvice.php
```

## 5. View Travel Advice Dashboard
Open `rijksoverheid.php` in your browser.
