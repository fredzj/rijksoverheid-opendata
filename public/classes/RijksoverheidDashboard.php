<?php
class RijksoverheidDashboard {
    private $db;
    private $dbConfigPath;

    public function __construct($dbConfigPath) {
        $this->db;
        $this->dbConfigPath = $dbConfigPath;
		$this->connectDatabase();
    }

	/**
	 * Connects to the database using the configuration file.
	 *
	 * This method reads the database configuration from the specified INI file,
	 * parses the configuration, and establishes a connection to the database.
	 * If the configuration file cannot be parsed, an exception is thrown.
	 *
	 * @throws Exception If the configuration file cannot be parsed.
	 * @return void
	 */
	private function connectDatabase() {
		if (($dbConfig = parse_ini_file($this->dbConfigPath, FALSE, INI_SCANNER_TYPED)) === FALSE) {
			throw new Exception("Parsing file " . $this->dbConfigPath	. " FAILED");
		}
		$this->db = new Database($dbConfig);
		unset($dbConfig);
	}

	public function getHtmlTraveladvice() {
		$html		=	'';
		
		try {
			foreach ($this->getTraveladvice() as $traveladvice) {
				
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
        } catch (PDOException $e) {
            $html .= '<tr><td colspan="7">Error fetching data: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</td></tr>';
        }
	
		return	'<table class="table table-sm"	data-custom-sort=""
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
	}

	public function getHtmlContentblocks() {
		$html		=	'';
		
		try {
			foreach ($this->getTraveladviceContentblocks() as $contentblock) {
				
				$html	.=	'<tr>';
				$html	.=	'<td>' . $contentblock['id']				. '</td>';
				$html	.=	'<td>' . $contentblock['sequence']			. '</td>';
				$html	.=	'<td>' . $contentblock['paragraphtitle']	. '</td>';
				$html	.=	'<td>' . $contentblock['paragraph']			. '</td>';
				$html	.=	'</tr>';
			}
        } catch (PDOException $e) {
            $html .= '<tr><td colspan="7">Error fetching data: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</td></tr>';
        }
	
		return	'<table class="table table-sm"	data-custom-sort=""
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
	}
	
	public function getHtmlFiles() {
		$html			=	'';
		
		try {
			foreach ($this->getTraveladviceFiles() as $file) {
				
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
        } catch (PDOException $e) {
            $html .= '<tr><td colspan="7">Error fetching data: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</td></tr>';
        }
	
		return	'<table class="table table-sm"	data-custom-sort=""
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
	}

	private function getTraveladvice() {

		$sql			=	"
		SELECT			*
		FROM			vendor_rijksoverheid_nl_traveladvice
		ORDER BY		location";
		
		return	$this->db->query($sql);
	}
	
	private function getTraveladviceContentblocks() {
	
		$sql			=	"
		SELECT			a.location,
						c.*
		FROM			vendor_rijksoverheid_nl_traveladvice a
		JOIN			vendor_rijksoverheid_nl_traveladvice_contentblocks c	ON	c.id	=	a.id
		ORDER BY		a.location, c.sequence";
		
		return	$this->db->query($sql);
	}
	
	private function getTraveladviceFiles() {
	
		$sql			=	"
		SELECT			a.location,
						f.*
		FROM			vendor_rijksoverheid_nl_traveladvice a
		JOIN			vendor_rijksoverheid_nl_traveladvice_files f	ON	f.id	=	a.id
		ORDER BY		a.location";
		
		return	$this->db->query($sql);
	}
}