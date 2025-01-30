<?php
require 'classes/Database.php';
require 'classes/TravelAdviceImporter.php';
require 'classes/ExitHandler.php';

// Set defaults
date_default_timezone_set(	'Europe/Amsterdam');
mb_internal_encoding(		'UTF-8');
setlocale(LC_ALL,			'nl_NL.utf8');

// Parse the DB configuration file
$path		=	substr(__DIR__, 0, mb_strrpos(__DIR__, '/'));
$filename	=	$path . '/config/db.ini';
if (($dbConfig = parse_ini_file($filename, FALSE, INI_SCANNER_TYPED)) === FALSE) {
	throw new Exception("Parsing file " . $filename	. " FAILED");
}
define("WEBROOT", $path . '/public_html/');
define("OPENDATA_OFFSET", 0);
define("OPENDATA_ROWS", 200);

// Register the exit handler
$timeStart			=	microtime(true);
register_shutdown_function([new ExitHandler($timeStart), 'handleExit']);

// URL to fetch XML data from
$url = 'https://opendata.nederlandwereldwijd.nl/v2/sources/nederlandwereldwijd/infotypes/countries?offset={{OFFSET}}&rows={{ROWS}}&output=xml';

// Create an instance of the importer and run the import
try {
	$db       = new Database($dbConfig);
    $importer = new TravelAdviceImporter($db, $url);
    $importer->import();
} catch (PDOException $e) {
    echo date("[G:i:s] ") . 'Caught PDOException: ' . $e->getMessage() . PHP_EOL;
} catch (Exception $e) {
    echo date("[G:i:s] ") . 'Caught Exception: ' . $e->getMessage() . PHP_EOL;
} finally {
	// The exit handler will be called automatically at the end of the script
}