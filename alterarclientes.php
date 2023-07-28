<?php
include("conectadb.php");
session_start();
$nomeusuario = $_SESSION["nomeusuario"];

$ativo = 's';


//usuario clika no botao salvar
 

$id = $_GET['id'];
$sql = "SELECT * FROM clientes WHERE cli_id = '$id'";

$retorno = mysqli_query($link, $sql);
while ($tbl = mysqli_fetch_array($retorno)) {
    $id = $tbl[0];
    $cpf = $tbl[1];
    $nome = $tbl[2];
    $senha = $tbl[3];
    $datanasc = $tbl[4];
    $telefone = $tbl[5];
    $logradouro = $tbl[6];
    $numero = $tbl[7];
    $cidade = $tbl[8];
    $ativo = $tbl[9];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estiloadm.css">
    <title>ALETRA USUARIOS</title>
</head>

<body>
    <div>
        <ul class="menu">
            <li><a href="cadastrausuario.php">CADASTRA USUARIO</a></li>
            <li><a href="listausuario.php">LISTA USUARIO</a></li>
            <li><a href="cadastraproduto.php">CADASTRA PRODUTO</a></li>
            <li><a href="cadastracliente.php">CADASTRA CLIENTE</a></li>
            <li><a href="listaproduto.php">LISTA PRODUTO</a></li>
            <li><a href="listaclientes.php">LISTA CLIENTE</a></li>
            <li class="menuloja"><a href="logout.php">SAIR</a></li>
            <?php
            #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
            #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
            if ($nomeusuario != null) {
            ?>
                <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->
                <li class="profile"> OLÁ <?= strtoupper($nomeusuario) ?></li>
            <?php
                #ABERTURA DE OUTRO PHP PARA CASO FALSE
            } else {
                echo "<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='login.php';</script>";
            }
            #FIM DO PHP PARA CONTINUAR MEU HTML
            ?>
        </ul>
    </div>

    <div>
        <form action="alterarclientes.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="number" name="cpf" id="cpf" value="<?= $cpf ?>" required>
            <br>
            <input type="text" name="nome" id="nome" value="<?= $nome ?>" required>
            <br>
            <input type="password" name="senha" id="senha" value="<?= $senha ?>" required>
            <br>
            <input type="date" name="datanasc" id="datanasc" value="<?= $datanasc ?>" required>
            <br>
            <input type="number" name="telefone" id="telefone" value="<?= $telefone ?>" required>
            <br>
            <input type="text" name="logradouro" id="logradouro" value="<?= $logradouro ?>" required>
            <br>
            <input type="number" name="numero" id="numero" value="<?= $numero ?>" required>
            <br>
            <input type="text" name="cidade" id="cidade" value="<?= $cidade ?>" required>
            <br>
            <input type="radio" name="ativo" value="s" <?= $ativo == "s" ? "checked" : "" ?>>ATIVO
            <br>
            <input type="radio" name="ativo" value="n" <?= $ativo == "n" ? "checked" : "" ?>>INATIVO

            <input type="submit" name="salvar" id="salvar" value="SALVAR">
        </form>
    </div>


</body>

</html>