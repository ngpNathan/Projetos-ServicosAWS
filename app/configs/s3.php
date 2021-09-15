<?php
    use Aws\S3\S3Client; //Classe que permite trabalhar com o S3

    require '..\..\vendor\autoload.php';
    
    $config = require('config.php');

    $s3 = S3Client::factory([
        'credentials' => [
            'key' => $config['s3']['key'],
            'secret' => $config['s3']['secret'],
        ],
        'region' => $config['region'],
        'version' => $config['version']
    ]);
?>
