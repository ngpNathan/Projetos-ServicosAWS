<?php

require '..\configs\iam.php';
require '..\configs\config.php';

$users = $iam->listUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IAM Project - List groups and users</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Nome usuário</th>
                <th>Grupo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users['Users'] as $user) { 
                
                $gruposUser = $iam->listGroupsForUser(['UserName' => $user['UserName']]);
                $stringGroup = '';
                foreach($gruposUser['Groups'] as $grupo){
                    $stringGroup .= $grupo['GroupName'] . ', ';
                }
                $stringGroup = rtrim($stringGroup, ', ');
            ?>

                <tr>
                    <td><?= $user['UserName'] ?></td>
                    <td><?= $stringGroup ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>