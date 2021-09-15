<?php

use Aws\Sns\Exception\SnsException;

require '..\configs\sns.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   
    $mensagem = $_POST['mensagem'];
    $numeroTelefone = $_POST['numeroTelefone'];

    try {
       $sns->publish([
           'Message' => $mensagem,
           'PhoneNumber' => $numeroTelefone,
       ]);
       echo 'Mensagem enviada com sucesso';
   } catch (SnsException $e) {
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
    <title>SNS - Enviar mensagem</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="mensagem" placeholder="Digite a mensagem que deseja enviar" required>
        <input type="tel" name="numeroTelefone" pattern="+[0-9]{13}" placeholder="554791234-5678" required>
        <button type="submit">Enviar mensagem</button>
    </form>
</body>
</html>