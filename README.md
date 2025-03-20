# rijksoverheid-opendata

This project allows you to download and view travel advice and school holiday data from the Government of the Netherlands.

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

## 4. Import School Holiday Data
Schedule `importSchoolHolidays.php` in order to import School Holiday data from the Government of the Netherlands and save it into your database. You can use a cron job for this:
```sh
# Example cron job to run the script daily at midnight
0 0 * * * /usr/bin/php /path/to/importSchoolHolidays.php
```

## 5. Import Travel Advice Data
Schedule `importTravelAdvice.php` in order to import Travel Advice data from the Government of the Netherlands and save it into your database. You can use a cron job for this:
```sh
# Example cron job to run the script daily at midnight
0 0 * * * /usr/bin/php /path/to/importTravelAdvice.php
```

## 6. View Dashboard
Open `rijksoverheid.php` in your browser.

## 7. How to Obtain the Software
You can obtain the source code for this project from the GitHub repository: https://github.com/fredzj/rijksoverheid-opendata

To clone the repository, use the following command:

```sh
git clone https://github.com/fredzj/rijksoverheid-opendata.git
```

## 8. How to Provide Feedback
If you encounter any issues or have suggestions for improvements, please open an issue in the GitHub repository: https://github.com/fredzj/rijksoverheid-opendata/issues

You can also provide feedback by submitting a pull request with your proposed changes.

## 9. How to Contribute
We welcome contributions to this project! To contribute:

1. Fork the repository on GitHub.
2. Create a new branch for your feature or bug fix:
```sh
git checkout -b feature-or-bugfix-name
```
3. Make your changes and commit them:
```sh
git commit -m "Description of your changes"
```
4. Push your changes to your fork:
```sh
git push origin feature-or-bugfix-name
```
5. Open a pull request in the original repository.

Please ensure your code adheres to the project's coding standards and includes appropriate documentation.

## 10. License
This project is licensed under the MIT License. See the LICENSE file for details.

[![OpenSSF Scorecard](https://api.scorecard.dev/projects/github.com/fredzj/rijksoverheid-opendata/badge)](https://scorecard.dev/viewer/?uri=github.com/fredzj/rijksoverheid-opendata)