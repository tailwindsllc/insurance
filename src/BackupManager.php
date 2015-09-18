<?php

namespace Insurance;

class BackupManager
{
    /**
     * @var AmazonUploader
     */
    protected $amazon;

    /**
     * @var array
     */
    protected $rules;

    public function __construct(AmazonUploader $amazon, array $backupRules)
    {
        $this->rules = $backupRules;

        $this->amazon = $amazon;
    }

    public function manageBackups()
    {
        $this->manageBackupGroup(ArchiveGenerator::DATABASE_BACKUP);
        $this->manageBackupGroup(ArchiveGenerator::FULL_BACKUP);
    }

    public function manageBackupGroup($type)
    {
        $files = $this->parseStoredBackups($type);
        ksort($files, SORT_NUMERIC);

        $ruleLimit = $this->rules[$type];

        if(count($files) <= $ruleLimit) {
            return;
        }

        for ($i = 0; $i < $this->rules[$type]; $i++) {
            array_pop($files);
        }

        foreach ($files as $file) {
            $this->amazon->delete($file);
        }
    }

    protected function parseStoredBackups($backupType = null)
    {
        $files = $this->amazon->getFileList();

        $parsedFiles = [
            ArchiveGenerator::FULL_BACKUP => [],
            ArchiveGenerator::DATABASE_BACKUP => [],
        ];

        foreach($files as $file) {
            $fileName = $file['path'];
            $file = explode('_', $fileName);
            $parsedFiles[$file[1]][$file[3]] = $fileName;
        }

        if ($backupType) {
            return $parsedFiles[$backupType];
        }

        return $parsedFiles;
    }
}