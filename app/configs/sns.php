<?php
    use Aws\Sns\SnsClient;

    require '..\..\vendor\autoload.php';

    $config = require('config.php');

    $sns = SnsClient::factory([
        'credentials' => [
            'key' => $config['sns']['key'],
            'secret' => $config['sns']['secret'],
        ],
        'region' => $config['region'],
        'version' => $config['version']
    ]);
?>
