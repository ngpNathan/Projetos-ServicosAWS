<?php

use Aws\Ses\Exception\SesException;

require '..\configs\ses.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    $emailRemetente = $_POST['emailRemetente'];
    $emailDestinatario = $_POST['emailDestinatario'];

    $charSet = 'UTF-8';

    //Amazon
    $subject = 'Amazon SES test (AWS SDK for PHP)';
    $plaintextBody = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
    $htmlBody =  '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
              '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
              'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
              'AWS SDK for PHP</a>.</p>';

    try {
        // $ses->sendEmail([
        //     'Destination' => [
        //         'ToAddresses' => [$emailDestinatario]
        //     ],
        //     'ReplyToAddresses' => [$emailRemetente],
        //     'Source' => $emailRemetente,
        //     'Message' => [
        //         'Body' => [
        //             'Html' => [
        //                 'Charset' => $charSet,
        //                 'Data' => $htmlBody,
        //             ],
        //             'Text' => [
        //                 'Charset' => $charSet,
        //                 'Data' => $plaintextBody
        //             ]
        //         ],
        //         'Subject' => [
        //             'Charset' => $charSet,
        //             'Data' => $subject
        //         ]
        //     ]
        // ]);

        echo 'Email enviado com sucesso!';

    } catch (SesException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SES - Enviar email</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="mensagem" placeholder="Digite a mensagem do email" required>
        <input type="text" name="assunto" placeholder="Digite o assunto do email" required>
        <br>
        De<input type="email" name="emailRemetente" placeholder="Remetente" required>
        para<input type="email" name="emailDestinatario" placeholder="Destinatário" required>
        <button type="submit">Enviar email</button>
    </form>
</body>
</html>