<?php

require '..\configs\s3.php';

$objetos = $s3->listObjects([
    'Bucket' => $config['s3']['bucket'],
    'Delimiter' => '/',
    'Prefix' => 'cliente-willian/'
    
]); //Esse objeto passado como parâmetro permite listar somente os objetos que estão contidos na pasta passada como parâmetro Prefix

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $objetoKey = $_POST['selectObject'];

    $s3->deleteObject([
        'Bucket' => $config['s3']['bucket'],
        'Key' => $objetoKey
    ]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S3 Project - Excluir object</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">

        <select name="selectObject" id="">
            <option value="" selected>Selecione...</option>
            <?php foreach($objetos['Contents'] as $idx => $objeto) { ?>
                <option value="<?= $objeto['Key'] ?>">
                    <?php
                        echo $objeto['Key'];
                    ?> 
                </option>
            <?php } ?>
        </select>

        <button type="submit">Excluir objeto</button>
    </form>
</body>
</html>