<?php
class TravelAdviceContentBlock {
    private $db;
    private $outputColumns;

    private $id;
    private $paragraph;
    private $paragraphTitle;
    private $sequence;
    
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
            'traveladvice_contentblocks' => ['id', 'paragraph', 'paragraphtitle', 'sequence']
        ];
    }

    /**
     * Sets the traveladvice contentblock details.
     *
     * @param string $id               The id of the traveladvice.
     * @param string $paragraph        The paragraph of the traveladvice contentblock.
     * @param string $paragraphTitle   The title of the traveladvice contentblock.
     * @param int    $sequence         The sequence of the traveladvice contentblock.
     * 
     * @return void
     */
    public function setTravelAdviceContentBlock(string $id, string $paragraph, string $paragraphTitle, int $sequence): void {
        $this->id             = $id;
        $this->paragraph      = $paragraph;
        $this->paragraphTitle = $paragraphTitle;
        $this->sequence       = $sequence;
    }

    /**
     * Saves the traveladvice contentblock details to the database.
     * 
     * @return void
     */
    public function save(): void {
        $outputValues	= [];
        $outputValues[]	= addslashes($this->id);
        $outputValues[]	= addslashes($this->paragraph);
        $outputValues[]	= addslashes($this->paragraphTitle);
        $outputValues[]	= addslashes($this->sequence);
        $this->db->insert('vendor_rijksoverheid_nl_traveladvice_contentblocks', $this->outputColumns['traveladvice_contentblocks'], $outputValues);
    }
}