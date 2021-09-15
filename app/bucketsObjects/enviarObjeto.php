<?
    use Aws\S3\Exception\S3Exception;
    
    require '..\configs\s3.php';
        
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_FILES['file']['name'] != ""){
            $file = $_FILES['file'];

            try {
                $s3->putObject([
                    'Bucket' => $config['s3']['bucket'],
                    'Key' => 'uploads/'.$file['name'].'', //Aq é possível criar as pastas para cada cliente
                    'Body' => $file['tmp_name'], 
                    'ACL' => 'public-read'
                ]);
            } catch (S3Exception $e) {
                echo $e->getMessage();
            }
        }
        else{
            echo 'Error, nenhum arquivo selecionado';
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S3 Project - Put object</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="Upload"></input>
    </form>
</body>
</html>