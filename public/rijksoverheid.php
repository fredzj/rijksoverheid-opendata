<?php
/*

	SCRIPT:		index.php
	
	PURPOSE:	Show data from Rijksoverheid in a dashboard.
	
	Copyright 2024 Fred Onis - All rights reserved.
	
	get_html_traveladvice
	get_html_contentblocks
	get_html_files

*/

/**
 * Get the traveladvice-level content and put it in an HTML table.
 *
 * @param	object	$dbh				PDO instance representing a connection to a database.
 *
 * @return	string						HTML table with traveladvice-level content.
 */
function get_html_traveladvice($dbh) {
	
	$html		=	'';
	
	foreach (dbget_traveladvice($dbh) as $traveladvice) {
		
		$html	.=	'<tr>';
		$html	.=	'<td>' . $traveladvice['id']				. '</td>';
		$html	.=	'<td>' . $traveladvice['type']				. '</td>';
		$html	.=	'<td><a href="' . $traveladvice['canonical'] . '"	target="_blank">Canonical</a></td>';
		$html	.=	'<td><a href="' . $traveladvice['dataurl'] . '"		target="_blank">Data URL</a></td>';
		$html	.=	'<td>' . $traveladvice['title']				. '</td>';
		$html	.=	'<td>' . $traveladvice['introduction']		. '</td>';
		$html	.=	'<td>' . $traveladvice['location']			. '</td>';
		$html	.=	'<td>' . $traveladvice['modificationdate']	. '</td>';
		$html	.=	'<td>' . $traveladvice['modifications']		. '</td>';
		$html	.=	'<td>' . $traveladvice['authorities']		. '</td>';
		$html	.=	'<td>' . $traveladvice['creators']			. '</td>';
		$html	.=	'<td>' . $traveladvice['lastmodified']		. '</td>';
		$html	.=	'<td>' . $traveladvice['issued']			. '</td>';
		$html	.=	'<td>' . $traveladvice['available']			. '</td>';
		$html	.=	'<td>' . $traveladvice['license']			. '</td>';
		$html	.=	'<td>' . $traveladvice['rightsholders']		. '</td>';
		$html	.=	'<td>' . $traveladvice['language']			. '</td>';
		$html	.=	'</tr>';
	}

	$html	=	'<table class="table table-sm"	data-custom-sort=""
												data-toggle="table"
												data-pagination="true"
												data-search="true"
												data-show-export="true">'
			.	'<thead><tr>'
			.	'<th scope="col" data-field="id"	 			data-sortable="true">ID</th>'
			.	'<th scope="col" data-field="type" 				data-sortable="true">Type</th>'
			.	'<th scope="col" data-field="canonical"	 		data-sortable="true">Canonical</th>'
			.	'<th scope="col" data-field="dataurl"	 		data-sortable="true">Data URL</th>'
			.	'<th scope="col" data-field="title"	 			data-sortable="true">Title</th>'
			.	'<th scope="col" data-field="introduction"		data-sortable="true">Introduction</th>'
			.	'<th scope="col" data-field="location"			data-sortable="true">Location</th>'
			.	'<th scope="col" data-field="modificationdate"	data-sortable="true">Modification Date</th>'
			.	'<th scope="col" data-field="modifications"		data-sortable="true">Modifications</th>'
			.	'<th scope="col" data-field="authorities"		data-sortable="true">Authorities</th>'
			.	'<th scope="col" data-field="creators"			data-sortable="true">Creators</th>'
			.	'<th scope="col" data-field="lastmodified"		data-sortable="true">Last Modified</th>'
			.	'<th scope="col" data-field="issued"			data-sortable="true">Issued</th>'
			.	'<th scope="col" data-field="available"			data-sortable="true">Available</th>'
			.	'<th scope="col" data-field="license"			data-sortable="true">License</th>'
			.	'<th scope="col" data-field="rightsholders"		data-sortable="true">Rightsholders</th>'
			.	'<th scope="col" data-field="language"			data-sortable="true">Language</th>'
			.	'</tr></thead>'
			.	'<tbody>'
			.	$html
			.	'</tbody>'
			.	'</table>';
	
	return $html;
}

/**
 * Get the traveladvice contentblock-level content and put it in an HTML table.
 *
 * @param	object	$dbh				PDO instance representing a connection to a database.
 *
 * @return	string						HTML table with traveladvice contentblock-level content.
 */
function get_html_contentblocks($dbh) {

	$html		=	'';
	
	foreach (dbget_traveladvice_contentblocks($dbh) as $contentblock) {
		
		$html	.=	'<tr>';
		$html	.=	'<td>' . $contentblock['id']				. '</td>';
		$html	.=	'<td>' . $contentblock['sequence']			. '</td>';
		$html	.=	'<td>' . $contentblock['paragraphtitle']	. '</td>';
		$html	.=	'<td>' . $contentblock['paragraph']			. '</td>';
		$html	.=	'</tr>';
	}

	$html	=	'<table class="table table-sm"	data-custom-sort=""
												data-toggle="table"
												data-pagination="true"
												data-search="true"
												data-show-export="true">'
			.	'<thead><tr>'
			.	'<th scope="col" data-field="id"	 			data-sortable="true">ID</th>'
			.	'<th scope="col" data-field="sequence" 			data-sortable="true">Sequence</th>'
			.	'<th scope="col" data-field="paragraphtitle"	data-sortable="true">Paragraph Title</th>'
			.	'<th scope="col" data-field="paragraph"	 		data-sortable="true">Paragraph</th>'
			.	'</tr></thead>'
			.	'<tbody>'
			.	$html
			.	'</tbody>'
			.	'</table>';
	
	return $html;
}

/**
 * Get the traveladvice file-level content and put it in an HTML table.
 *
 * @param	object	$dbh				PDO instance representing a connection to a database.
 *
 * @return	string						HTML table with traveladvice file-level content.
 */
function get_html_files($dbh) {

	$html			=	'';
	
	foreach (dbget_traveladvice_files($dbh) as $file) {
		
		$html	.=	'<tr>';
		$html	.=	'<td>' . $file['id']				. '</td>';
		$html	.=	'<td><a href="' . $file['fileurl'] . '"	target="_blank">File URL</a></td>';
		$html	.=	'<td>' . $file['mimetype']			. '</td>';
		$html	.=	'<td>' . $file['filesize']			. '</td>';
		$html	.=	'<td>' . $file['filename']			. '</td>';
		$html	.=	'<td>' . $file['filetitle']			. '</td>';
		$html	.=	'<td>' . $file['filedescription']	. '</td>';
		$html	.=	'<td>' . $file['filemodifieddate']	. '</td>';
		$html	.=	'<td>' . $file['maptype']			. '</td>';
		$html	.=	'</tr>';
	}

	$html	=	'<table class="table table-sm"	data-custom-sort=""
												data-toggle="table"
												data-pagination="true"
												data-search="true"
												data-show-export="true">'
			.	'<thead><tr>'
			.	'<th scope="col" data-field="id"	 			data-sortable="true">ID</th>'
			.	'<th scope="col" data-field="fileurl" 			data-sortable="true">File URL</th>'
			.	'<th scope="col" data-field="mimetype"			data-sortable="true">Mime Type</th>'
			.	'<th scope="col" data-field="filesize"	 		data-sortable="true">File Size</th>'
			.	'<th scope="col" data-field="filename"	 		data-sortable="true">File Name</th>'
			.	'<th scope="col" data-field="filetitle"	 		data-sortable="true">File Title</th>'
			.	'<th scope="col" data-field="filedescription"	data-sortable="true">File Description</th>'
			.	'<th scope="col" data-field="filemodifieddate"	data-sortable="true">File Modified Date</th>'
			.	'<th scope="col" data-field="maptype"	 		data-sortable="true">Map Type</th>'
			.	'</tr></thead>'
			.	'<tbody>'
			.	$html
			.	'</tbody>'
			.	'</table>';
	
	return $html;
}

try {
	
	###
	### STANDARD INIT ROUTINE
	###
	
	require	'includes/init.inc.php';
	
	###
	### CUSTOM INIT ROUTINE
	###

	require	'includes/vendor_rijksoverheid_sql.inc.php';
	
	###
	### DATABASE INIT ROUTINE
	###
	
	$dbh		=	dbopen($dbconfig);

	###
	### PROCESSING ROUTINE
	###
	
	$html_traveladvice	=	get_html_traveladvice(	$dbh);
	$html_contentblocks	=	get_html_contentblocks(	$dbh);
	$html_files			=	get_html_files(			$dbh);

	###
	### DATABASE EXIT ROUTINE
	###
		
	$dbh = null;

	###
	### STANDARD EXCEPTION ROUTINE
	###

} catch (PDOException $e) {
	
	echo date("[G:i:s] ") . 'Caught PDOException: ' . $e->getMessage() . '<br/>';
	
} catch (Exception $e) {
	
	echo date("[G:i:s] ") . 'Caught Exception: ' . $e->getMessage() . '<br/>';
	
} finally {

	###
	### STANDARD EXIT ROUTINE
	###

}
?>
<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Rijksoverheid Reisadviezen</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">
	<style>
	body {
		font-size: small;
	}
	img {
		background-color: #fff;
	}
	</style>
	<script src="https://kit.fontawesome.com/da52944850.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container-fluid">

	<h1>Rijksoverheid Dashboard</h1>

	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="traveladvice-tab"	data-bs-toggle="tab" data-bs-target="#traveladvice-tab-pane"	type="button" role="tab" aria-controls="traveladvice-tab-pane"		aria-selected="true">Traveladvice</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link"		id="contentblocks-tab"	data-bs-toggle="tab" data-bs-target="#contentblocks-tab-pane"	type="button" role="tab" aria-controls="contentblocks-tab-pane"	aria-selected="false">Traveladvice Paragraphs</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link"		id="files-tab"			data-bs-toggle="tab" data-bs-target="#files-tab-pane"			type="button" role="tab" aria-controls="files-tab-pane"		aria-selected="false">Traveladvice Maps</button>
		</li>
	</ul>
	
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active"	id="traveladvice-tab-pane"	role="tabpanel" aria-labelledby="traveladvice-tab"	tabindex="0">
			<?php	echo $html_traveladvice; ?>
		</div>
		<div class="tab-pane fade"				id="contentblocks-tab-pane"	role="tabpanel" aria-labelledby="contentblocks-tab"	tabindex="0">
			<?php	echo $html_contentblocks; ?>
		</div>
		<div class="tab-pane fade"				id="files-tab-pane"			role="tabpanel" aria-labelledby="files-tab"			tabindex="0">
			<?php	echo $html_files; ?>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/export/bootstrap-table-export.min.js"></script>
	<script>
		function customSort(sortName, sortOrder, data) {
			var order = sortOrder === 'desc' ? -1 : 1
			data.sort(function (a, b) {
			var aa = +((a[sortName] + '').replace(/[^\d]/g, ''))
			var bb = +((b[sortName] + '').replace(/[^\d]/g, ''))
			if (aa < bb) {
				return order * -1
			}
			if (aa > bb) {
				return order
			}
			return 0
			})
		}
	</script>
</div>
</body>
</html>