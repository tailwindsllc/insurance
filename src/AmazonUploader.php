<?php

namespace Insurance;

class AmazonUploader
{
    protected $amazon;

    public function __construct(array $s3) {
        $client = new \Aws\S3\S3Client([
            'credentials' => [
                'key' => $s3['key'],
                'secret' => $s3['secret'],
            ],
            'region' => $s3['region'],
            'version' => 'latest',
        ]);

        $adapter = new \League\Flysystem\AwsS3v3\AwsS3Adapter($client, $s3['bucket'], $s3['path']);

        $flysystem = new \League\Flysystem\Filesystem($adapter);
        $this->amazon = $flysystem;
    }

    public function upload($backupName, $backupPath)
    {
        $this->amazon->write($backupName, fopen($backupPath, 'r'));
    }

    public function getFileList()
    {
        return $this->amazon->listContents();
    }

    public function delete($fileName)
    {
        return $this->amazon->delete($fileName);
    }
}