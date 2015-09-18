<?php

namespace Insurance;

class ArchiveGenerator
{
    /**
     * @var \ZipArchive
     */
    protected $zip;

    protected $archiveName;

    const DATABASE_BACKUP = 'database';

    const FULL_BACKUP = 'full';

    public function __construct($path, $website, $type)
    {
        if(strpos($website, '_') !== false) {
            throw new \InvalidArgumentException('Website cannot contain an underscore');
        }

        $archiveName = $website . '_' . $type . '_' . date('Y-m-d-His') . '_' . time() . '.zip';

        $this->archiveName = $archiveName;

        $this->zip = new \ZipArchive();

        $success = $this->zip->open($path . '/' . $archiveName, \ZipArchive::CREATE);

        if (!$success) {
            throw new \InvalidArgumentException('Unable to create the archive!');
        }
    }

    public function addFiles(array $files, $erase = '')
    {
        foreach($files as $file) {
            $this->addFile($file, $erase);
        }
    }

    public function addFile($filePath, $erase = '')
    {
        if($filePath == $erase) {
            throw new \InvalidArgumentException('The file path and the path to be removed cannot be identical');
        }

        $this->zip->addFile($filePath, str_replace($erase, '', $filePath));
    }

    public function close()
    {
        $this->zip->close();
    }

    public function getArchiveName()
    {
        return $this->archiveName;
    }
}