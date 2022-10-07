<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    require 'jwtclass.php';
    $myjwt = new myJWT();
    $user = "adminprogweb";
    $pass = "ProgWeb3";
    $db = "progweb3";
    $conn = mysqli_connect("127.0.0.1", $user, $pass, $db);
    if ($conn->connect_errno)
    {
        die("Erro de conexão" . $conn->connect_error);
    } 
    
    $user_id = $_POST["usuario"];
    $user_password = $_POST["senha"];
    $sql = "select * from usuarios where idusuario = '". $user_id ."' and senhausuario = '". $user_password ."'";
    $resultadoQuery = mysqli_query($conn, $sql);
    if ($resultadoQuery->num_rows == 0 ){
        die("Usuário ou senha inválidos");
    }
    $arrayQuery = $resultadoQuery->fetch_assoc();
    echo "</br>";
    echo "usuário digitado: " . $arrayQuery["idusuario"];
    echo "</br></br>";
    echo "</br>";
    echo "senha digitada: " . $arrayQuery["senhausuario"];
    
    $payload = [
        'iss' => 'localhost',
        'nome' => $arrayQuery["nomeusuario"],
        'email' => $arrayQuery["email"]
    ];
    
    echo "</br>";
    echo "</br>";
    $token = $myjwt->generate_token($payload);
    echo $token;
    
    echo "</br>";
    echo "</br>";
    echo "Token validado com sucesso?</br>";
    if ($myjwt->validate_token($token)){
        echo "sim</br>";
    }else{
        echo "não</br>";
    }
    
    
    
?>
</body>
</html>