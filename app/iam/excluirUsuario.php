<?php

use Aws\Iam\Exception\IamException;

require '..\configs\iam.php';
require '..\configs\s3.php';
require '..\configs\config.php';

$users = $iam->listUsers();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $usuarioExcluir = $_POST['excluirUser'];
    
    try {
        //Tirar do(s) grupo(s), deletar loginProfile e políticas
        
        $politicas = $iam->listUserPolicies([
            'UserName' => $usuarioExcluir
        ]);
        
        foreach($politicas['PolicyNames'] as $politica){
            $iam->deleteUserPolicy([
                'UserName' => $usuarioExcluir,
                'PolicyName' => $politica  
            ]);

        }

        $iam->deleteLoginProfile([
            'UserName' => $usuarioExcluir
        ]);

        $gruposUsuarioExcluir = $iam->listGroupsForUser([
            'UserName' => $usuarioExcluir,
        ]);

        foreach($gruposUsuarioExcluir['Groups'] as $grupoUsuarioExcluir){
            $iam->removeUserFromGroup([
                'GroupName' => $grupoUsuarioExcluir['GroupName'],
                'UserName'  => $usuarioExcluir
            ]);
        }

        $iam->deleteUser([
            'UserName' => $usuarioExcluir
        ]);

        //Deleta a pasta do cliente lá no bucket
        $s3->deleteObject([
            'Bucket' => $config['s3']['bucket'],
            'Key' => 'cliente-'.$usuarioExcluir.'/'
        ]);

        echo 'Usuário excluído com sucesso';
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
    <title>IAM Project - Delete user</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <select name="excluirUser" id="">
            <option value="" selected>Selecione...</option>
            <?php foreach($users['Users'] as $user) { ?>
                <option value="<?= $user['UserName'] ?>"> <?= $user['UserName'] ?> </option>
            <?php } ?>
        </select>
        <button type="submit">Excluir</button>
    </form>
</body>
</html>