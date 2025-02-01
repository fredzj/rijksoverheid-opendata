<?php
header('Content-Type: text/html; charset=utf-8');

require 'classes/Database.php';
require 'classes/RijksoverheidDashboard.php';

// Set defaults
date_default_timezone_set('Europe/Amsterdam');
mb_internal_encoding('UTF-8');
setlocale(LC_ALL, 'nl_NL.utf8');

$dbConfigPath = mb_substr(__DIR__, 0, mb_strrpos(__DIR__, '/'));
$dbConfigPath = mb_substr($dbConfigPath, 0, mb_strrpos($dbConfigPath, '/')) . '/config/db.ini';
	
// Create an instance of the dashboard and get the data
try {
	
    $dashboard = new RijksoverheidDashboard($dbConfigPath);

	$html_traveladvice	=	$dashboard->getHtmlTraveladvice();
	$html_contentblocks	=	$dashboard->getHtmlContentblocks();
	$html_files			=	$dashboard->getHtmlFiles();

    require 'templates/rijksoverheid.php';

} catch (PDOException $e) {
    echo date("[G:i:s] ") . 'Caught PDOException: ' . $e->getMessage() . PHP_EOL;
} catch (Exception $e) {
    echo date("[G:i:s] ") . 'Caught Exception: ' . $e->getMessage() . PHP_EOL;
} finally {
}