<?php

require '..\configs\s3.php';

$objetos = $s3->ListObjects ([
    'Bucket' => $config['s3']['bucket'],
    'Delimiter' => '/',
    'Prefix' => 'cliente-willian/' 
]); //Esse objeto passado como parâmetro permite listar somente os objetos que estão contidos na pasta passada como parâmetro Prefix

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S3 Project - List object</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>File</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($objetos['Contents'] as $objeto) { ?>
                    <tr>
                        <td> <?php 
                                // $objeto['Key'] = str_replace('cliente-willian/', "", $objeto['Key']); //Pode ajudar a retirar a pasta do cliente
                                echo $objeto['Key'];
                            ?> 
                        </td>
                        <td><a href="<?= $s3->getObjectUrl($config['s3']['bucket'], $objeto['Key']); ?>" download="<?= $objeto['Key'] ?>">Download</a></td>
                    </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php foreach($objetos['Contents'] as $objeto) { ?>
        <img src="<?= $s3->getObjectUrl($config['s3']['bucket'], $objeto['Key']); ?>" alt="Imagem tobirama">
    <?php } ?>
</body>
</html>