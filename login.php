<?php

    //ABRE UMA VARIAVEL DE SESSÃO
    session_start();

    //SOLICITA O ARQUIVO CONECTADB

    include("conectadb.php");

    //EVENTO APÓS O CLICK NO BOTÃO LOGAR
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $nome = $_POST ['name'];
        $senha = $_POST ['senha'];


        $sql = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_nome = '$nome' AND usu_senha = '$senha'";

        $retorno = mysqli_query($link, $sql);

        //TODO RETORNO DE BANCO É RETORNADA EM ARRAY NO PHP
        while($tbl = mysqli_fetch_array($retorno))
        {
            $cont = $tbl[0];
            
        }


        // VERIFICA SE O USUARIO EXISTE
        //SE $COMT ==== 1 ELE EXISTE E FAZ LOGIN
        //SE $CONT === 0 ELE NAO EXISTE E O USURIO NAO ESTA CADASTRADO

        if($cont == 1){
            $sql = "SELECT * FROM usuarios WHERE usu_nome = '$nome' AND usu_senha = '$senha' AND usu_ativo = 's'";
            //direciona usuario para o adm
            print"<script>window.location.href='admhome.php';</script>";
            }
            else
            {
            print"<script>window.alert('USUARIO OU SENHA INCORRETO');</script>";
            }
    }


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user name</title>
    <link rel="stylesheet" href="./css/estiloadm.css">
</head>
<body>
    <form action="login.php" method="post">
        <h1>name user</h1>
        <input type="text" name="nome" placeholder="NOME">
        <p></p>
        <input type="password" name="senha" placeholder="SENHA">
        <p></p>
        <input type="submit" name="login" placeholder="LOGIN">




    </form>

</body>
</html>