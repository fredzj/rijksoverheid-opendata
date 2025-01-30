<?php
class TravelAdviceImporter {
    private $db;
    private $url;
    private $outputColumns;
    private $outputValues;
    private $outputDataLines = 0;

    /**
     * TravelAdviceImporter constructor.
     * 
     * @param Database $db The database connection object.
     * @param string $url The URL to fetch XML data from.
     */
    public function __construct($db, $url) {
		$this->db  = $db;
        $this->url = $url;
        $this->initializeOutputColumns();
    }

    /**
     * Initializes the output columns for the database tables.
     */
    private function initializeOutputColumns() {
        $this->outputColumns = [
            'traveladvice'               => ['id', 'type', 'canonical', 'dataurl', 'title', 'introduction', 'location', 'modificationdate', 'modifications', 'authorities', 'creators', 'lastmodified', 'issued', 'available', 'license', 'rightsholders', 'language'],
            'traveladvice_contentblocks' => ['id', 'paragraph', 'paragraphtitle', 'sequence'],
            'traveladvice_files'         => ['id', 'fileurl', 'mimetype', 'filesize', 'filename', 'filetitle', 'filedescription', 'filemodifieddate', 'maptype']
        ];
    }

    /**
     * Download travel advice and save to the database.
     *
     * @return void
     */
    public function import() {
        $this->truncateTables();

        for ($offset = OPENDATA_OFFSET; $offset < 400; $offset += OPENDATA_ROWS) {
            $nextURL = str_replace(['{{OFFSET}}', '{{ROWS}}'], [$offset, OPENDATA_ROWS], $this->url);

            echo date("[G:i:s] ") . 'Reading XML Feed ' . $nextURL . PHP_EOL;
            if (($file_contents = file_get_contents($nextURL)) !== false) {
                $this->process_bulk_countries($file_contents);
            }
        }

        echo date("[G:i:s] ") . '- ' . $this->outputDataLines . ' rows processed' . PHP_EOL;
    }

    /**
     * Save all bulk-level travel advice content to the database.
     *
     * @param string $file_contents Contents of the bulk-level XML file.
     *
     * @return void
     */
    private function process_bulk_countries($file_contents) {
        $documents = simplexml_load_string($file_contents);

        foreach ($documents->document as $document) {
            echo date("[G:i:s] ") . '- Reading XML Feed ' . $document->dataurl . PHP_EOL;
            if (($file_contents = file_get_contents($document->dataurl)) !== false) {
                $this->process_one_country($file_contents);
            }
        }
    }

    /**
     * Save all country-level travel advice content to the database.
     *
     * @param string $file_contents Contents of the country-level XML file.
     *
     * @return void
     */
    private function process_one_country($file_contents) {
        sleep(1);

        $document = simplexml_load_string($file_contents);

        echo date("[G:i:s] ") . '-- Reading XML Feed ' . $document->travelAdvice . PHP_EOL;
        if (($contents = @file_get_contents($document->travelAdvice)) !== false) {
            $reisadvies = simplexml_load_string($contents);

            # Collect data for travel advice
            $this->outputValues['traveladvice'] = [
                $reisadvies->id,
                $reisadvies->type,
                $reisadvies->canonical,
                $reisadvies->dataurl,
                addslashes($reisadvies->title),
                addslashes(preg_replace('/\s+/', ' ', $reisadvies->introduction)),
                addslashes($reisadvies->location),
                addslashes($reisadvies->modificationdate),
                addslashes($reisadvies->modifications),
                $reisadvies->authorities->department,
                $reisadvies->creators->department,
                $reisadvies->lastmodified,
                $reisadvies->issued,
                $reisadvies->available,
                $reisadvies->license,
                $reisadvies->rightsholders->department,
                $reisadvies->language
            ];
            $this->db->insert('vendor_rijksoverheid_nl_traveladvice', $this->outputColumns['traveladvice'], $this->outputValues['traveladvice']);
            $this->outputDataLines++;

            # Collect data for travel advice content blocks
            $sequence = 0;
            foreach ($reisadvies->content->category->contentblock as $contentblock) {
                $this->outputValues['traveladvice_contentblocks'] = [
                    $reisadvies->id,
                    addslashes(preg_replace('/\s+/', ' ', $contentblock->paragraph)),
                    addslashes($contentblock->paragraphtitle),
                    $sequence++
                ];
                $this->db->insert('vendor_rijksoverheid_nl_traveladvice_contentblocks', $this->outputColumns['traveladvice_contentblocks'], $this->outputValues['traveladvice_contentblocks']);
            }

            # Collect data for travel advice files
            foreach ($reisadvies->files->file as $file) {
                $this->outputValues['traveladvice_files'] = [
                    $reisadvies->id,
                    addslashes($file->fileurl),
                    addslashes($file->mimetype),
                    addslashes($file->filesize),
                    addslashes($file->filename),
                    addslashes($file->filetitle),
                    addslashes($file->filedescription),
                    addslashes($file->filemodifieddate),
                    addslashes($file->maptype)
                ];
                $this->db->insert('vendor_rijksoverheid_nl_traveladvice_files', $this->outputColumns['traveladvice_files'], $this->outputValues['traveladvice_files']);

                # Download images
                $this->download_map($file->filename, $file->fileurl);
            }
        } else {
            echo date("[G:i:s] ") . '--- WARNING: file_get_contents FAILED' . PHP_EOL;
        }
    }

    /**
     * Create images in two sizes and three formats for the travel advice map and save these locally.
     *
     * @param string $filename The filename of the image.
     * @param string $fileurl  The URL of the image.
     *
     * @return void
     */
    private function download_map($filename, $fileurl) {
        $image = @imagecreatefrompng($fileurl);

        if (!$image) {
            echo date("[G:i:s] ") . "Warning: imagecreatefrompng(): '$fileurl' is not a valid PNG file" . PHP_EOL;
        } else {
            $image_large = imagescale($image, 468);

            imagepng($image_large, WEBROOT . '/assets/img/' . str_replace('.png', '.png', $filename));
            imagejpeg($image_large, WEBROOT . '/assets/img/' . str_replace('.png', '.jpg', $filename));
            imagewebp($image_large, WEBROOT . '/assets/img/' . str_replace('.png', '.webp', $filename));

            $image_small = imagecreatetruecolor(306, 210);
            list($width, $height) = getimagesize(WEBROOT . '/assets/img/' . $filename);
            $height = 620 * ($width / 903);
            imagecopyresampled($image_small, $image_large, 0, 0, 0, 0, 306, 210, $width, $height);

            imagepng($image_small, WEBROOT . '/assets/img/' . str_replace('.png', '_small.png', $filename));
            imagejpeg($image_small, WEBROOT . '/assets/img/' . str_replace('.png', '_small.jpg', $filename));
            imagewebp($image_small, WEBROOT . '/assets/img/' . str_replace('.png', '_small.webp', $filename));

            imagedestroy($image);
            imagedestroy($image_large);
            imagedestroy($image_small);
        }
    }

    /**
     * Truncates the relevant database tables.
     */
    private function truncateTables() {
        foreach ($this->outputColumns as $table => $columns) {
			$this->db->truncate('vendor_rijksoverheid_nl_' . $table);
        }
    }
}