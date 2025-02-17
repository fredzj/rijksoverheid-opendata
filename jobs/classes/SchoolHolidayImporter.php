<?php
/**
 * Class SchoolHolidayImporter
 * 
 * This class is responsible for downloading school holiday data from a specified URL,
 * processing the XML data, and inserting it into the appropriate database tables.
 * It ensures that the database is updated with the latest school holiday information.
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
class SchoolHolidayImporter {
    private $db;
	private $dbConfigPath;
    private $inputUrl;
    private $log;
    private $outputDataLines = 0;
    private $timeStart;

    /**
     * SchoolHolidayImporter constructor.
     * 
     * @param string $dbConfigPath The path to the database configuration file.
     * @param string $url          The URL to fetch XML data from.
     */
    public function __construct(string $dbConfigPath, string $inputUrl) {
		$this->dbConfigPath = $dbConfigPath;
        $this->inputUrl = $inputUrl;
        $this->log = new Log();
        $this->registerExitHandler();
		$this->connectDatabase();
    }

    /**
     * Register the exit handler.
     *
     * @return void
     */
    private function registerExitHandler(): void {
        $this->timeStart = microtime(true);
        register_shutdown_function([new ExitHandler($this->timeStart), 'handleExit']);
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
	private function connectDatabase(): void {
		if (($dbConfig = parse_ini_file($this->dbConfigPath, FALSE, INI_SCANNER_TYPED)) === FALSE) {
			throw new Exception("Parsing file " . $this->dbConfigPath	. " FAILED");
		}
		$this->db = new Database($dbConfig);
	}

    /**
     * Download school holidays and save to the database.
     *
     * @return void
     */
    public function import(): void {

        $this->db->truncate('vendor_rijksoverheid_nl_schoolholidays');
        $this->log->info('Reading XML Feed ' . $this->inputUrl);
        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Accept-language: nl\r\n" .
                            "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n"
            ]
        ];
        $context = stream_context_create($opts);
        if (($file_contents = file_get_contents($this->inputUrl, false, $context)) !== false) {
            $this->save_schoolholidays($file_contents);
        } else {
            $this->log->error('Failed to read XML feed ' . $this->inputUrl);
        }

        $this->log->info('- ' . $this->outputDataLines . ' rows processed');
    }

    /**
     * Save all school holiday content to the database.
     *
     * @param string $file_contents Contents of the XML file.
     *
     * @return void
     */
    private function save_schoolholidays(string $file_contents): void {
 
        $xml = simplexml_load_string($file_contents);

        foreach ($xml->document as $document) {
		    foreach ($document->content->contentblock as $contentblock) {
		    	foreach ($contentblock->vacations->vacation as $vacation) {
		    		foreach ($vacation->regions as $regions) {
                        $schoolholiday = new SchoolHoliday($this->db);
                        $schoolholiday->setSchoolholiday(   trim($contentblock->schoolyear), 
                                                            trim($vacation->type), 
                                                            $vacation->compulsorydates == 'true' ? '1' : '0', 
                                                            $regions->region, 
                                                            $regions->startdate, 
                                                            $regions->enddate);
                        $schoolholiday->save();
		    			$this->outputDataLines++;
			    	}
			    }
		    }
        }
    }
}