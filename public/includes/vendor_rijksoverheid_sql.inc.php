<?php
/**
 * SCRIPT: vendor_rijksoverheid_sql.inc.php
 * PURPOSE: Database routines for Rijksoverheid dashboard.
 * 
 * This file contains functions for interacting with the database, including
 * executing SELECT queries, fetching configuration values, inserting multiple
 * rows into a table, and opening a database connection.
 * 
 * @package rijksoverheid-opendata
 * @version 1.0.0
 * @since 2024
 * @license MIT
 * 
 * COPYRIGHT: 2024 Fred Onis - All rights reserved.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 * @author Fred Onis
 */

/**
 * Executes a SELECT query and returns the fetched rows.
 *
 * @param PDO $dbh The PDO database connection handle.
 * @param string $sql The SQL query to execute.
 * @param array $params The parameters to bind to the SQL query.
 * @return array The fetched rows as an associative array.
 */
function dbget($dbh, $sql, $params = []) {

    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute($params);
        $fetched_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $fetched_rows;

    } catch (PDOException $e) {
        logError('Caught PDOException: ' . $e->getMessage());
        return [];
    }
}

function dbget_traveladvice($dbh) {

	$sql			=	"
	SELECT			*
	FROM			vendor_rijksoverheid_nl_traveladvice
	ORDER BY		location";
	
	return	dbget($dbh, $sql);
}

function dbget_traveladvice_contentblocks($dbh) {

	$sql			=	"
	SELECT			a.location,
					c.*
	FROM			vendor_rijksoverheid_nl_traveladvice a
	JOIN			vendor_rijksoverheid_nl_traveladvice_contentblocks c	ON	c.id	=	a.id
	ORDER BY		a.location, c.sequence";
	
	return	dbget($dbh, $sql);
}

function dbget_traveladvice_files($dbh) {

	$sql			=	"
	SELECT			a.location,
					f.*
	FROM			vendor_rijksoverheid_nl_traveladvice a
	JOIN			vendor_rijksoverheid_nl_traveladvice_files f	ON	f.id	=	a.id
	ORDER BY		a.location";
	
	return	dbget($dbh, $sql);
}

/**
 * Opens a database connection using the provided configuration.
 *
 * @param array $dbconfig The database configuration.
 * @return PDO|null The PDO database connection handle, or null on failure.
 */
function dbopen($dbconfig) {

    try {
        // Validate configuration
        if (empty($dbconfig['db_pdo_driver_name']) || empty($dbconfig['db_hostname']) || empty($dbconfig['db_database']) || empty($dbconfig['db_username']) || empty($dbconfig['db_password'])) {
            throw new InvalidArgumentException('Invalid database configuration');
        }

        // Create PDO instance
        $dsn = $dbconfig['db_pdo_driver_name'] . ':host=' . $dbconfig['db_hostname'] . ';dbname=' . $dbconfig['db_database'] . ';charset=utf8mb4';
        $dbh = new PDO(
            $dsn,
            $dbconfig['db_username'],
            $dbconfig['db_password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => false
            ]
        );

        return $dbh;

    } catch (PDOException $e) {
        logError('Caught PDOException: ' . $e->getMessage());
        return null;

    } catch (InvalidArgumentException $e) {
        logError('Caught InvalidArgumentException: ' . $e->getMessage());
        return null;
    }
}