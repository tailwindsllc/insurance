<?php

namespace Insurance;

class SqlDumper
{
    public function __construct($pathToWPConfig)
    {
        // We need to require the file.
        require $pathToWPConfig . '/wp-config.php';
    }

    public function dumpSql($dumpPath)
    {
        $sqlFile = $dumpPath . '/' . DB_NAME . '.sql';
        exec('mysqldump -u ' . DB_USER . ' --password="' . DB_PASSWORD . '" -h ' . DB_HOST . ' ' . DB_NAME . ' > ' . $sqlFile);
        return $sqlFile;
    }
}