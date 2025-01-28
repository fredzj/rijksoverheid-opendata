<?php
/**
 * SCRIPT: downloadTravelAdvice.php
 * PURPOSE: Download API V2 travel advice in XML feeds from the Dutch government and insert the data into the database.
 *
 * This script performs the following tasks:
 * - Downloads travel advice data in XML format from the Dutch government API.
 * - Processes the XML data and extracts relevant information.
 * - Inserts the extracted data into the database.
 * - Downloads and processes images associated with the travel advice.
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
 * Create images in two sizes and three formats for the travel advice map and save these locally.
 *
 * This function downloads an image from the given URL, creates a large and a small version of the image,
 * and saves them in PNG, JPEG, and WebP formats in the specified directory.
 *
 * @param string $filename The filename of the image.
 * @param string $fileurl  The URL of the image.
 *
 * @return void
 */
function download_map($filename, $fileurl) {
	
	$image			=	@imagecreatefrompng($fileurl);
	
	if (!$image) {
		
		echo date("[G:i:s] ") . "Warning:  imagecreatefrompng(): '$fileurl' is not a valid PNG file" . PHP_EOL;
		
	} else {
		
		$image_large	=	imagescale($image, 468);
		
		imagepng( $image_large, WEBROOT . '/assets/img/' . str_replace('.png', '.png', $filename));
		imagejpeg($image_large, WEBROOT . '/assets/img/' . str_replace('.png', '.jpg', $filename));
		imagewebp($image_large, WEBROOT . '/assets/img/' . str_replace('.png', '.webp', $filename));
		
		$image_small			=	imagecreatetruecolor(306, 210);
		list($width, $height)	=	getimagesize(WEBROOT . '/assets/img/' . $filename);
		$height					=	620 * ($width / 903);
		imagecopyresampled($image_small, $image_large, 0, 0, 0, 0, 306, 210, $width, $height);
		
		imagepng( $image_small, WEBROOT . '/assets/img/' . str_replace('.png', '_small.png', $filename));
		imagejpeg($image_small, WEBROOT . '/assets/img/' . str_replace('.png', '_small.jpg', $filename));
		imagewebp($image_small, WEBROOT . '/assets/img/' . str_replace('.png', '_small.webp', $filename));
		
		imagedestroy($image);
		imagedestroy($image_large);
		imagedestroy($image_small);
	}
}

/**
 * Save all country-level travel advice content to the database.
 *
 * This function processes the XML data for a single country, extracts relevant information,
 * and inserts the data into the database. It also downloads and processes images associated
 * with the travel advice.
 *
 * @param PDO    $dbh              PDO instance representing a connection to a database.
 * @param string $file_contents    Contents of the country-level XML file.
 * @param int    &$output_data_lines Number of countries processed (passed by reference).
 *
 * @return void
 */
function process_one_country($dbh, $file_contents, &$output_data_lines) {
	
	sleep(1);
	
	$output_columns_ta				=	['id', 'type', 'canonical', 'dataurl', 'title', 'introduction', 'location', 'modificationdate', 'modifications', 'authorities', 'creators', 'lastmodified', 'issued', 'available', 'license', 'rightsholders', 'language'];
	$output_columns_tacb			=	['id', 'paragraph', 'paragraphtitle', 'sequence'];
	$output_columns_taf				=	['id', 'fileurl', 'mimetype', 'filesize', 'filename', 'filetitle', 'filedescription', 'filemodifieddate', 'maptype'];
	$output_values_ta				=	[];
	$output_values_tacb				=	[];
	$output_values_taf				=	[];

	$document = simplexml_load_string($file_contents);
	
	echo date("[G:i:s] ") . '-- Reading XML Feed ' . $document->travelAdvice . PHP_EOL;
	if (($contents = @file_get_contents($document->travelAdvice)) !== false) {
			
		$reisadvies	=	simplexml_load_string($contents);
		
		# Collect data for traveladvice
		$output_values_ta[]			=	$reisadvies->id;
		$output_values_ta[]			=	$reisadvies->type;
		$output_values_ta[]			=	$reisadvies->canonical;
		$output_values_ta[]			=	$reisadvies->dataurl;
		$output_values_ta[]			=	addslashes($reisadvies->title);
		$output_values_ta[]			=	addslashes(preg_replace('/\s+/', ' ', $reisadvies->introduction));
		$output_values_ta[]			=	addslashes($reisadvies->location);
		$output_values_ta[]			=	addslashes($reisadvies->modificationdate);
		$output_values_ta[]			=	addslashes($reisadvies->modifications);
		$output_values_ta[]			=	$reisadvies->authorities->department;
		$output_values_ta[]			=	$reisadvies->creators->department;
		$output_values_ta[]			=	$reisadvies->lastmodified;
		$output_values_ta[]			=	$reisadvies->issued;
		$output_values_ta[]			=	$reisadvies->available;
		$output_values_ta[]			=	$reisadvies->license;
		$output_values_ta[]			=	$reisadvies->rightsholders->department;
		$output_values_ta[]			=	$reisadvies->language;
		
		# Collect data for traveladvice contentblocks
		$sequence	=	0;
		foreach ($reisadvies->content->category->contentblock as $contentblock) {
		
			$array					=	[];
			$array[]				=	$reisadvies->id;
			$array[]				=	addslashes(preg_replace('/\s+/', ' ', $contentblock->paragraph));
			$array[]				=	addslashes($contentblock->paragraphtitle);
			$array[]				=	$sequence++;
			$output_values_tacb[]	=	"('" . implode("', '", $array) . "')";
		}

		# Collect data for traveladvice files
		foreach ($reisadvies->files->file as $file) {
		
			$array					=	[];
			$array[]				=	$reisadvies->id;
			$array[]				=	addslashes($file->fileurl);
			$array[]				=	addslashes($file->mimetype);
			$array[]				=	addslashes($file->filesize);
			$array[]				=	addslashes($file->filename);
			$array[]				=	addslashes($file->filetitle);
			$array[]				=	addslashes($file->filedescription);
			$array[]				=	addslashes($file->filemodifieddate);
			$array[]				=	addslashes($file->maptype);
			$output_values_taf[]	=	"('" . implode("', '", $array) . "')";
		
			# Download images
			download_map($file->filename, $file->fileurl);
		}
		
		# Insert new rows
		dbinsert($dbh, 'vendor_rijksoverheid_nl_traveladvice',					$output_columns_ta,		$output_values_ta);
		dbinsert($dbh, 'vendor_rijksoverheid_nl_traveladvice_contentblocks',	$output_columns_tacb,	$output_values_tacb);
		dbinsert($dbh, 'vendor_rijksoverheid_nl_traveladvice_files',			$output_columns_taf,	$output_values_taf);
		$output_data_lines++;

	} else {
		
		echo date("[G:i:s] ") . '--- WARNING: file_get_contents FAILED' . PHP_EOL;
	}
	
	return;
}

/**
 * Save all bulk-level travel advice content to the database.
 *
 * This function processes the bulk-level XML data, extracts relevant information for each country,
 * and inserts the data into the database.
 *
 * @param PDO    $dbh              PDO instance representing a connection to a database.
 * @param string $file_contents    Contents of the bulk-level XML file.
 * @param int    &$output_data_lines Number of countries processed (passed by reference).
 *
 * @return void
 */
function process_bulk_countries($dbh, $file_contents, &$output_data_lines) {

	$documents	=	simplexml_load_string($file_contents);
	
	foreach ($documents->document as $document) {
		
		echo date("[G:i:s] ") . '- Reading XML Feed ' . $document->dataurl . PHP_EOL;
		if (($file_contents = file_get_contents($document->dataurl)) !== false) {
			
			process_one_country($dbh, $file_contents, $output_data_lines);
		}
	}
	
	return;
}

/**
 * Download traveladvice and save to the database.
 *
 * @param	PDO		$dbh				PDO instance representing a connection to a database.
 * @param	array	$product			Array structure containing product-level data.
 * @param	array	$properties			Array structure containing property-level data.
 * @param	array	$regions			Array structure containing regions.
 * @param	array	$is_schoolholiday	Array structure containing flags for Dutch schoolholidays as defined by Rijksoverheid.
 *
 * @return	void
 */
try {
	
	###
	### STANDARD INIT ROUTINE
	###
	
	require 'includes/init.inc.php';
	require 'includes/vendor_rijksoverheid_sql.inc.php';
	
	###
	### CUSTOM INIT ROUTINE
	###
	
	define("OPENDATA_OFFSET",	0);
	define("OPENDATA_ROWS",		200);
	define("OPENDATA_URL",		'https://opendata.nederlandwereldwijd.nl/v2/sources/nederlandwereldwijd/infotypes/countries?offset={{OFFSET}}&rows={{ROWS}}&output=xml');
	$output_data_lines			=	0;
	
	###
	### DATABASE INIT ROUTINE
	###
	
	$dbh	=	dbopen($dbconfig);
	
	echo date("[G:i:s] ") . 'Truncate tables' . PHP_EOL;
	dbtruncate($dbh, 'vendor_rijksoverheid_nl_traveladvice');
	dbtruncate($dbh, 'vendor_rijksoverheid_nl_traveladvice_contentblocks');
	dbtruncate($dbh, 'vendor_rijksoverheid_nl_traveladvice_files');

	###
	### PROCESSING ROUTINE
	###

	for ($offset = OPENDATA_OFFSET; $offset < 400; $offset += OPENDATA_ROWS) {

        $nextURL = str_replace(['{{OFFSET}}', '{{ROWS}}'], [$offset, OPENDATA_ROWS], OPENDATA_URL);

		echo date("[G:i:s] ") . 'Reading XML Feed ' . $nextURL . PHP_EOL;
		if (($file_contents = file_get_contents($nextURL)) !== false) {
			
			process_bulk_countries($dbh, $file_contents, $output_data_lines);
		}
	}
	
	echo date("[G:i:s] ") . '- ' . $output_data_lines . ' rows processed' . PHP_EOL;

	###
	### DATABASE EXIT ROUTINE
	###
		
	$dbh = null;

	###
	### STANDARD EXCEPTION ROUTINE
	###

} catch (PDOException $e) {
	echo date("[G:i:s] ") . 'Caught PDOException: ' . $e->getMessage() . PHP_EOL;
} catch (Exception $e) {
	echo date("[G:i:s] ") . 'Caught Exception: '    . $e->getMessage() . PHP_EOL;
} finally {

	###
	### STANDARD EXIT ROUTINE
	###

	require 'includes/exit.inc.php';
}