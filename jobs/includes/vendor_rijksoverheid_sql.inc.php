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
 * Insert data into a database table.
 *
 * @param PDO    $dbh     PDO instance representing a connection to a database.
 * @param string $table   The name of the table.
 * @param array  $columns The columns to insert data into.
 * @param array  $values  The values to insert.
 *
 * @return void
 */
function dbinsert($dbh, $table, $columns, $values) {

	if (count($values) > 0) {
		
		$columns	=	implode(", ", $columns);
		
		if (mb_substr($values[0], 0, 1) == '(') {
			$values		=	implode(", ", $values);
		} else {
			$values		=	"('" . implode("', '", $values) . "')";
		}
		
		try {
			$sql		=	"INSERT IGNORE INTO $table ($columns) VALUES $values";
			$stmt 		=	$dbh->prepare($sql);
			$stmt->execute();
			$stmt->closeCursor();
		} catch (PDOException $e) {
			
			logError('Caught PDOException: ' . $e->getMessage() . ' SQL:' . $sql);
			
		}
	}
}

/**
 * Open a database connection.
 *
 * @param array $dbconfig The database configuration.
 *
 * @return PDO The PDO instance representing the connection.
 */
function dbopen($dbconfig) {
    try {
        $dbh = new PDO(
            $dbconfig['db_pdo_driver_name'] . ':host=' . $dbconfig['db_hostname'] . ';dbname=' . $dbconfig['db_database'] . ';charset=utf8mb4',
            $dbconfig['db_username'],
            $dbconfig['db_password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => false
            ]
        );
        return $dbh;
    } catch (PDOException $e) {
        echo date("[G:i:s] ") . 'Caught PDOException: ' . $e->getMessage() . PHP_EOL;
        throw $e;
    }
}

/**
 * Truncate a database table.
 *
 * @param PDO    $dbh        PDO instance representing a connection to a database.
 * @param string $table_name The name of the table to truncate.
 *
 * @return void
 */
function dbtruncate($dbh, $table_name) {
    try {
        $sql = 'TRUNCATE ' . $table_name;
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        echo date("[G:i:s] ") . '- truncated table ' . $table_name . PHP_EOL;
        $stmt->closeCursor();
    } catch (PDOException $e) {
        echo date("[G:i:s] ") . 'Caught PDOException: ' . $e->getMessage() . ' SQL: ' . $sql . PHP_EOL;
    }
}