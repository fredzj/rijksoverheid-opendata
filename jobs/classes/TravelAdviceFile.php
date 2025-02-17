<?php
class TravelAdviceFile {
    private $db;
    private $outputColumns;

    private $id;
    private $fileUrl;
    private $mimeType;
    private $fileSize;
    private $fileName;
    private $fileTitle;
    private $fileDescription;
    private $fileModifiedDate;
    private $mapType;
    
    /**
     * Constructor.
     *
     * @param Database $db The database object.
     */
    public function __construct(Database $db) {
        $this->db = $db;
        $this->initializeOutputColumns();
    }

    /**
     * Initializes the output columns for the database table.
     * 
     * @return void
     */
    private function initializeOutputColumns(): void {
        $this->outputColumns = [
            'traveladvice_files' => ['id', 'fileurl', 'mimetype', 'filesize', 'filename', 'filetitle', 'filedescription', 'filemodifieddate', 'maptype']
        ];
    }

    /**
     * Sets the traveladvice file details.
     *
     * @param string $id               The id of the traveladvice.
     * @param string $fileUrl          The URL of the traveladvice file.
     * @param string $mimeType         The mime type of the traveladvice file.
     * @param string $fileSize         The size of the traveladvice file.
     * @param string $fileName         The name of the traveladvice file.
     * @param string $fileTitle        The title of the traveladvice file.
     * @param string $fileDescription  The description of the traveladvice file.
     * @param string $fileModifiedDate The modified date of the traveladvice file.
     * @param string $mapType          The map type of the traveladvice file.
     * 
     * @return void
     */
    public function setTravelAdviceFile(string $id, string $fileUrl, string $mimeType, string $fileSize, string $fileName, string $fileTitle, string $fileDescription, string $fileModifiedDate, string $mapType): void {
        $this->id               = $id;
        $this->fileUrl          = $fileUrl;
        $this->mimeType         = $mimeType;
        $this->fileSize         = $fileSize;
        $this->fileName         = $fileName;
        $this->fileTitle        = $fileTitle;
        $this->fileDescription  = $fileDescription;
        $this->fileModifiedDate = $fileModifiedDate;
        $this->mapType          = $mapType;
    }

    /**
     * Saves the traveladvice file details to the database.
     * 
     * @return void
     */
    public function save(): void {
        $outputValues	= [];
        $outputValues[]	= addslashes($this->id);
        $outputValues[]	= addslashes($this->fileUrl);
        $outputValues[]	= addslashes($this->mimeType);
        $outputValues[]	= addslashes($this->fileSize);
        $outputValues[]	= addslashes($this->fileName);
        $outputValues[]	= addslashes($this->fileTitle);
        $outputValues[]	= addslashes($this->fileDescription);
        $outputValues[]	= addslashes($this->fileModifiedDate);
        $outputValues[]	= addslashes($this->mapType);
        $this->db->insert('vendor_rijksoverheid_nl_traveladvice_files', $this->outputColumns['traveladvice_files'], $outputValues);
    }
}