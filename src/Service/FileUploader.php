<?php

namespace App\Service;

use League\Flysystem\FilesystemOperator;

class FileUploader
{
    public function __construct(
        private FilesystemOperator $defaultStorage
    )
    {
    }

    function uploadBase64File(string $base64File) : string
    {
        $extension = explode('/', mime_content_type($base64File))[1];
        $data = explode(',', $base64File);
        $filename = sprintf('%s.%s', uniqid('product_', true), $extension);

        $this->defaultStorage->write($filename, base64_decode($data[1]));
        return $filename;
    }
}