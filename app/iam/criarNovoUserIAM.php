<?php

use Aws\Iam\Exception\IamException;

require '..\configs\iam.php';
require '..\configs\s3.php';
require '..\configs\config.php';

$grupos = $iam->listGroups();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $grupo = $_POST['grupo'] != "" ? $_POST['grupo'] : ""; 

    try {
        $newUser = $iam->createUser([
           'UserName' => $_POST['nomeUsuario'],
        ]);

        $iam->createLoginProfile([
            'UserName' => $newUser['User']['UserName'],
            'Password' => $newUser['User']['UserName'] . '_11',
            'PasswordResetRequired' => false,
        ]);

        if($grupo != ""){
            $iam->addUserToGroup([
                'GroupName' => $grupo,
                'UserName' => $newUser['User']['UserName']
            ]);
        }

        /*
        ###########
        Verfificar se no bucket de clientes já existe uma pasta/objeto desse cliente, se retornar false, cria uma nova pasta
        OU
        Criar um bucket com o nome desse cliente 
        ###########
        */

        /* Conexão com o S3
        Verifica se o objeto já existe e cria ou não a pasta no bucket
        */
        if(!$s3->doesObjectExist($config['s3']['bucket'], 'cliente-'.$newUser['User']['UserName'].'/' )){
            $s3->putObject([
                'Bucket' => $config['s3']['bucket'],
                'Key' => 'cliente-'.$newUser['User']['UserName'].'/',
                'Body' => ""
            ]);
            echo 'Pasta criada no bucket com sucesso \n';
        }

        //Polítcas 
        $documentPolicy = '{
            "Version": "2012-10-17",
            "Statement": [
                {
                    "Effect": "Allow",
                    "Action": "s3:ListBucket",
                    "Resource": "arn:aws:s3:::nathan-ambisis-cliente",
                    "Condition": {
                        "StringLike": {
                            "s3:prefix": "cliente-'.$newUser['User']['UserName'].'/*"
                        }
                    }
                },
                {
                    "Effect": "Deny",
                    "Action": "s3:ListBucket",
                    "Resource": "arn:aws:s3:::nathan-ambisis-cliente",
                    "Condition": {
                        "StringNotLike": {
                            "s3:prefix": [
                                "cliente-'.$newUser['User']['UserName'].'/*",
                                ""
                            ]
                        },
                        "Null": {
                            "s3:prefix": "false"
                        }
                    }
                }
            ]
        }';

        $iam->putUserPolicy([
            'UserName' => $newUser['User']['UserName'],
            'PolicyName' => 'Allow' .$newUser['User']['UserName'] . 'SeeHisFolder', 
            'PolicyDocument' => $documentPolicy
        ]);

        echo 'Usuário criado com sucesso';
        exit;
    } catch (IamException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IAM Project - Create user</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="nomeUsuario" placeholder="Digite o nome do usuário">
        <button>Criar usuário</button>
        <br>
        <label for="grupo">Grupos: </label>
        <select name="grupo" id="grupo">
            <option value="" selected>Selecione</option>
            <?php foreach($grupos['Groups'] as $grupo) { ?>
                <option value="<?= $grupo['GroupName'] ?>"><?= $grupo['GroupName'] ?></option>
            <?php } ?>
        </select>
    </form>
</body>
</html>