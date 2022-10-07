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
    if ($conn->connect_errno){
        die("Erro de conexão" . $conn->connect_error);
    } 
    
    $idUsuario = $_POST["usuario"];
    $senhaUsuario = $_POST["senha"];
    $sql = "select * from usuarios where idusuario = '". $idUsuario ."' and senhausuario = '". $senhaUsuario ."'";
    $resultadoQuery = mysqli_query($conn, $sql);
    if ($resultadoQuery->num_rows == 0 ){
        die("usuário ou senha inválidos");
    }
    $arrayQuery = $resultadoQuery->fetch_assoc();
    echo "<BR>";
    echo "usuário digitado: " . $arrayQuery["idusuario"];
    echo "<BR>";
    echo "<BR>";
    echo "senha digitada: " . $arrayQuery["senhausuario"];
    
    $payload = [
        'iss' => 'localhost',
        'nome' => $arrayQuery["nomeusuario"],
        'email' => $arrayQuery["email"]
    ];
    
    echo "<BR>";
    echo "<BR>";
    $token = $myjwt->criaToken($payload);
    echo $token;
    
    echo "<BR>";
    echo "<BR>";
    echo "Token validado com sucesso?<br>";
    if ($myjwt->validaToken($token)){
        echo "sim<Br>";
    }else{
        echo "não<br>";
    }
    
    
    
?>
</body>
</html>