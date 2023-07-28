<?php
include("conectadb.php");
session_start();
$nomeusuario = $_SESSION["nomeusuario"];

 

#JÁ LISTA OS CLIENTES DO MEU BANCO

$sql = "SELECT * FROM clientes WHERE cli_ativo = 's'";
$retorno = mysqli_query($link, $sql);

 

#JA FORÇA TRAZER NA VARIAVEL ATIVO

$ativo = 's';

 

#COLETA BOTÃO DE POST

if($_SERVER['REQUEST_METHOD'] == 'POST')

{

$ativo = $_POST['ativo'];

 

#VERIFICA SE O CLIENTE ESTÁ ATIVO PARA LISTAR

if($ativo == 's')

{

    $sql = "SELECT * FROM clientes WHERE cli_ativo = 's'";
    $retorno = mysqli_query($link, $sql);
}
else
{

    $sql = "SELECT * FROM clientes WHERE cli_ativo = 'n'";

    $retorno = mysqli_query($link, $sql);

}

}

?>

 

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estiloadm.css">
    <title>LISTA CLIENTES</title>
</head>
<body>
<div>
<ul class="menu">

    <li>

    <li><a href="cadastrausuario.php">CADASTRA USUARIO</a></li>
    <li><a href="listausuario.php">LISTA USUARIO</a></li>
    <li><a href="cadastraproduto.php">CADASTRA PRODUTO</a></li>
    <li><a href="listaproduto.php">LISTA PRODUTO</a></li>
    <li><a href="cadastracliente.php">CADASTRA CLIENTE</a></li>
    <li><a href="listacliente.php">LISTA CLIENTE</a></li>
    <li class="menuloja"><a href="logout.php">SAIR<a></li>

    <?php
        if($nomeusuario != null)
        {

            ?>
            <li class="profile">OLÁ <?=strtoupper($nomeusuario)?></li>
            <?php

        }

        else

        {

            echo"<script>window.alert('CLIENTE NÃO AUTENTICADO');
            window.location.href='login.php'; </script>";

        }

 

        ?>

</ul>

</div>

 

<div id ="background">

    <form action="listaclientes.php" method="post">

<input type="radio" name="ativo" class="radio" value="s" required onclick="submit()"<?=$ativo =='s'?"checked":""?>>ATIVOS


<input type="radio" name="ativo" class="radio" value="n" required onclick="submit()"<?=$ativo =='n'?"checked":""?>>INATIVOS

 

    </form>

 

    <div class="container">

        <table border="1">

            <tr>

                <th>CPF</th>
                <th>NOME</th>
                <th>DATA NASCIMENTO</th>
                <th>TELEFONE</th>
                <th>LOGRADOURO</th>
                <th>NUMERO</th>
                <th>CIDADE</th>
                <th>ALTERAR DADOS</th>
                <th>ATIVO?</th>

            <tr>

                <?php

                while($tbl = mysqli_fetch_array($retorno)){

                ?>

                <tr>

                    <td><?=$tbl[1]?></td>
                    <td><?=$tbl[2]?></td>
                    <td><?=$tbl[4]?></td>
                    <td><?=$tbl[5]?></td>
                    <td><?=$tbl[6]?></td>
                    <td><?=$tbl[7]?></td>
                    <td><?=$tbl[8]?></td>

                    <td><a href="alterarclientes.php?id=<?= $tbl[0]?>"><input type = "button" value="ALTERAR DADOS"></a></td>

                    <td><?=$check =($tbl[9] == 's')?"SIM":"NÃO"?>

                    </td>

                </tr>

                    <?php

                }

                    ?>

        </table>

               

    </div>

</div>

 

</body>
</html>

 

 