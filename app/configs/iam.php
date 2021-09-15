<?php

    use Aws\Iam\IamClient; 

    require '..\..\vendor\autoload.php';

    $config = require('config.php');

    $iam = IamClient::factory([
        'credentials' => [
            'key' => $config['s3']['key'],
            'secret' => $config['s3']['secret'],
        ],
        'region' => $config['region'],
        'version' => $config['version']
    ])
?>