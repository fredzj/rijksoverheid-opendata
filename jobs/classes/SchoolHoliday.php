<?php
class SchoolHoliday {
    private $db;
    private $outputColumns;

    private $compulsoryDates;
    private $endDate;
    private $region;
    private $schoolYear;
    private $startDate;
    private $type;

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
     * Initializes the output columns for the database tables.
     * 
     * @return void
     */
    private function initializeOutputColumns(): void {
        $this->outputColumns = [
            'schoolholidays' => ['schoolyear', 'type', 'compulsorydates', 'region', 'startdate', 'enddate']
        ];
    }

    /**
     * Sets the schoolholiday details.
     *
     * @param string $schoolYear      The schoolyear of the schoolholiday.
     * @param string $type            The type of schoolholiday.
     * @param string $compulsoryDates The obligation of the dates.
     * @param string $region          The region of the schoolholiday.
     * @param string $startDate       The first start date of the schoolholiday.
     * @param string $endDate         The last date of the schoolholiday.
     * 
     * @return void
     */
    public function setSchoolHoliday(string $schoolYear, string $type, string $compulsoryDates, string $region, string $startDate, string $endDate): void {
        $this->schoolYear      = $schoolYear;
        $this->type            = $type;
        $this->compulsoryDates = $compulsoryDates;
        $this->region          = $region;
        $this->startDate       = $startDate;
        $this->endDate         = $endDate;
    }

    /**
     * Saves the schoolholiday details to the database.
     * 
     * @return void
     */
    public function save(): void {
        $outputValues	= [];
        $outputValues[]	= $this->schoolYear;
        $outputValues[]	= $this->type;
        $outputValues[]	= $this->compulsoryDates;
        $outputValues[]	= $this->region;
        $outputValues[]	= $this->startDate;
        $outputValues[]	= $this->endDate;
        $this->db->insert('vendor_rijksoverheid_nl_schoolholidays', $this->outputColumns['schoolholidays'], $outputValues);
    }
}