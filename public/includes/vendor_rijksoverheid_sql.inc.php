<?php
/*

	SCRIPT:		vendor_rijksoverheid_sql.inc.php
	
	PURPOSE:	Database routines for Rijksoverheid dashboard.
	
	Copyright 2024 Fred Onis - All rights reserved.

	dbget
	dbget_traveladvice
	dbget_traveladvice_contentblocks
	dbget_traveladvice_files
	dbopen
*/

function dbget($dbh, $sql) {
	
	$stmt			=	$dbh->prepare($sql);
	
	$stmt->execute();
	$fetched_rows	=	$stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	$stmt			=	null;

	return	$fetched_rows;
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

function dbopen($dbconfig) {

	$dbh	=	new PDO($dbconfig['db_pdo_driver_name']	. ':host=' . $dbconfig['db_hostname']  . ';dbname='	. $dbconfig['db_database'] . ';charset=utf8mb4',
						$dbconfig['db_username'],
						$dbconfig['db_password'],
						array(
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_PERSISTENT => false
						)
	);
	
	return $dbh;
}