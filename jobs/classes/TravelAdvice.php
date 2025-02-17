<?php
class TravelAdvice {
    private $db;
    private $outputColumns;

    private $id;
    private $canonical;
    private $dataUrl;
    private $title;
    private $introduction;
    private $location;
    private $modificationDate;
    private $modifications;
    private $authorities;
    private $creators;
    private $lastModified;
    private $issued;
    private $available;
    private $license;
    private $rightsholders;
    private $language;
    
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
            'traveladvice' => ['id', 'type', 'canonical', 'dataurl', 'title', 'introduction', 'location', 'modificationdate', 'modifications', 'authorities', 'creators', 'lastmodified', 'issued', 'available', 'license', 'rightsholders', 'language']
        ];
    }

    /**
     * Sets the traveladvice details.
     *
     * @param string $id               The id of the traveladvice.
     * @param string $type             The type of information.
     * @param string $canonical        The canonical URL of the traveladvice web page.
     * @param string $dataUrl          The data URL of the traveladvice open data source.
     * @param string $title            The title of the traveladvice.
     * @param string $introduction     The introduction paragraph of the traveladvice.
     * @param string $location         The location of the traveladvice.
     * @param string $modificationDate The modification date and time of the traveladvice.
     * @param string $modifications    The modifications paragraph of the traveladvice.
     * @param string $authorities      The authorities of the traveladvice.
     * @param string $creators         The creators of the traveladvice.
     * @param string $lastModified     The last modified date and time of the traveladvice.
     * @param string $issued           The issued date and time of the traveladvice.
     * @param string $available        The first date of availability of the traveladvice.
     * @param string $license          The license of the traveladvice.
     * @param string $rightsholders    The rightsholders of the traveladvice.
     * @param string $language         The ISO 639-2 language code of the traveladvice.
     * 
     * @return void
     */
    public function setTravelAdvice(string $id, string $type, string $canonical, string $dataUrl, string $title, string $introduction, string $location, string $modificationDate, string $modifications, string $authorities, string $creators, string $lastModified, string $issued, string $available, string $license, string $rightsholders, string $language): void {
        $this->id               = $id;
        $this->type             = $type;
        $this->canonical        = $canonical;
        $this->dataUrl          = $dataUrl;
        $this->title            = $title;
        $this->introduction     = $introduction;
        $this->location         = $location;
        $this->modificationDate = $modificationDate;
        $this->modifications    = $modifications;
        $this->authorities      = $authorities;
        $this->creators         = $creators;
        $this->lastModified     = $lastModified;
        $this->issued           = $issued;
        $this->available        = $available;
        $this->license          = $license;
        $this->rightsholders    = $rightsholders;
        $this->language         = $language;
    }

    /**
     * Saves the traveladvice details to the database.
     * 
     * @return void
     */
    public function save(): void {
        $outputValues	= [];
        $outputValues[]	= addslashes($this->id);
        $outputValues[]	= addslashes($this->type);
        $outputValues[]	= addslashes($this->canonical);
        $outputValues[]	= addslashes($this->dataUrl);
        $outputValues[]	= addslashes($this->title);
        $outputValues[]	= addslashes($this->introduction);
        $outputValues[]	= addslashes($this->location);
        $outputValues[]	= addslashes($this->modificationDate);
        $outputValues[]	= addslashes($this->modifications);
        $outputValues[]	= addslashes($this->authorities);
        $outputValues[]	= addslashes($this->creators);
        $outputValues[]	= addslashes($this->lastModified);
        $outputValues[]	= addslashes($this->issued);
        $outputValues[]	= addslashes($this->available);
        $outputValues[]	= addslashes($this->license);
        $outputValues[]	= addslashes($this->rightsholders);
        $outputValues[]	= addslashes($this->language);
        $this->db->insert('vendor_rijksoverheid_nl_traveladvice', $this->outputColumns['traveladvice'], $outputValues);
    }
}