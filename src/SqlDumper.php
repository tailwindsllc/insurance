<?php

namespace Insurance;

class SqlDumper
{
    protected $database;

    public function __construct(array $database)
    {
        $this->database = $database;
    }

    public function dumpSql($dumpPath)
    {
        $database = $this->database;

        $sqlFile = $dumpPath . '/' . $database['name'] . '.sql';
        exec('mysqldump -u ' . $database['user'] . ' --password="' . $database['pass'] . '" -h ' . $database['host'] . ' ' . $database['name'] . ' > ' . $sqlFile);
        return $sqlFile;
    }
}