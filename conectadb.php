<?php 


    //ARQUIVO DE ACESSO AO BANCO DE DADOS 
    //ALERTA EM MODO PROFISSIONAL AQRQUIVO DEVE-SE MANTER OCULTO E PROTEGIDO


    //LOCALIZA O PC OU SERVIDOR COM O BANCO (NOME DO COMPUTADOR)
    $servidor = "localhost:3307";
    //NOME DO BANCO
    $banco = "projeto22";
    //USUARIO DE ACESSO
    $usuario = "administrador";
    //SENHA DO USUARIO
    $senha = "123";

    //LINK DE CONEXAO
    $link = mysqli_connect($servidor, $usuario, $senha, $banco);




?>