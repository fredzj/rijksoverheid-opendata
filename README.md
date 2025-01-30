﻿# rijksoverheid-opendata

This project allows you to download and view travel advice data from the Government of the Netherlands.

## Prerequisites
- A web server (e.g., Apache, Nginx)
- PHP installed on the server
- MySQL or MariaDB database

## Save Database Credentials
1. Enter your hostname, databasename, username, and password in file `/config/db.ini`.

## Create Database Tables
2. Import all `/database/*.sql` files into your database.

## Transfer Files
3. Transfer all files to your server.  

## Download Travel Advice Data
4. Schedule `importTravelAdvice.php` in order to import Travel Advice data from the Government of the Netherlands and save it into your database. You can use a cron job for this:
   ```sh
   # Example cron job to run the script daily at midnight
   0 0 * * * /usr/bin/php /path/to/importTravelAdvice.php

## View Travel Advice Dashboard
5. Open `rijksoverheid.php` in your browser.
