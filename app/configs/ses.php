<?php
    use Aws\Ses\SesClient;

    require '..\..\vendor\autoload.php';

    $config = require('config.php');

    $ses = SesClient::factory([
        'credentials' => [
            'key' => $config['ses']['key'],
            'secret' => $config['ses']['secret'],
        ],
        'region' => $config['region'],
        'version' => $config['version']
    ]);
?>
