<?php 
include("conectadb.php");
session_start();
$nomeusuario = $_SESSION['nomeusuario'];



//trazer dados
$id = $_GET['id'];
$sql = "SELECT * FROM produtos WHERE pro_id = '$id'";
$retorno = mysqli_query($link, $sql);

while($tbl = mysqli_fetch_array($retorno)){
    $id = $tbl[0];
    $nome = $tbl[1]; 
    $descricao = $tbl[2];
    $quantidade = $tbl[3];
    $custo = $tbl[4];
    $preco = $tbl[5];
    $ativo = $tbl[6];
    $imagem_atual = $tbl[7];
}

//envio das alteraçoes 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $custo = $_POST['custo'];
    $preco = $_POST['preco'];
    $ativo = $_POST['ativo'];
    $imagem_base64 = $_POST['imagem'];
    $imagem = $_POST['imagem_atual'];


    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK)
    {
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem = file_get_contents($imagem_temp);
        $imagem_base64 = base64_encode($imagem);
    }

    if($imagem_atual == $imagem_base64)
    {
        $sql = "UPDATE produtos SET pro_nome = '$nome', pro_descricao = '$descricao', pro_quantidade = '$quantidade', pro_custo = '$custo', pro_preco = '$preco', pro_ativo = '$ativo' WHERE pro_id = '$id'";

        mysqli_query($link, $sql);
        #CADASTROU USUARIO E JOGA MENSAGEM NA TELA E DIRECIONA PARA LISTA USUARIO
        echo"<script>window.alert('PRODUTO CADASTRADO');</script>";
        echo"<script>window.location.href='listaproduto.php';</script>";
    }
    else
    {
        $sql = "UPDATE produtos SET pro_nome = '$nome', pro_descricao = '$descricao', pro_quantidade = '$quantidade', pro_custo = '$custo', pro_preco = '$preco', pro_ativo = '$ativo', imagem1 = '$imagem_base64' WHERE pro_id = '$id'";


        mysqli_query($link, $sql);
        #CADASTROU USUARIO E JOGA MENSAGEM NA TELA E DIRECIONA PARA LISTA USUARIO
        echo"<script>window.alert('PRODUTO CADASTRADO');</script>";
        echo"<script>window.location.href='listaproduto.php';</script>";
    }

    //$sql ="UPDATE clientes SET usu_nome = '$nome', usu_senha = '$senha', usu_ativo = '$ativo' WHERE usu_id = $id";


   





    echo"<script>window.alert('CLIENTE ALTERADO COM SUCESSO!');</script>";    

    echo"<script>window.location.href='admhome.php';</script>";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estiloadm.css">
    <title>Document</title>
</head>
<body>
<div>
        <ul class="menu">
            <li><a href="cadastrausuario.php">CADASTRA USUARIO</a></li>
            <li><a href="listausuario.php">LISTA USUARIO</a></li>
            <li><a href="cadastraprodutos.php">CADASTRA PRODUTO</a></li>
            <li><a href="cadastracliente.php">CADASTRA CLIENTE</a></li>
            <li><a href="listaproduto.php">LISTA PRODUTO</a></li>
            <li><a href="listacliente.php">LISTA CLIENTE</a></li>
            <li><a href="alterarclientes.php">ALTERA CLIENTE</a></li>
            <li class="menuloja"><a href="logout.php">SAIR</a></li>
            <?php
            #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
            #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
            if ($nomeusuario != null) {
            ?>
                <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->
                <li class="profile">OLÁ <?= strtoupper($nomeusuario) ?></li>
            <?php
                #ABERTURA DE OUTRO PHP PARA CASO FALSE
            } else {
                echo "<script>window.alert('clite NÃO AUTENTICADO');
                        window.location.href='login.php';</script>";
            }
            #FIM DO PHP PARA CONTINUAR MEU HTML
            ?>
        </ul>
    </div>

            <div class="formulario">
                <form action="alteraproduto.php" class="visualizaproduto" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="nome" value="<?= $id?>">
                    <label>NOME</label>
                    <input type="text" name="nome" value="<?= $nome?>">
                    <label>DESCRIÇÃO</label>
                    <input type="text" name="descricao" value="<?= $descricao?>">
                    <label>QUANTIDADE</label>
                    <input type="number" name="quantidade" value="<?= $quantidade?>">
                    <label>CUSTO</label>
                    <input type="decimal" name="custo" value="<?= $custo?>">
                    <label>PREÇO</label>
                    <input type="decimal" name="preco" value="<?= $preco?>">
                    <label>STATUS: <?= $ativo == 's' ? "ATIVO" : "INATIVO"?> </label>
                    <br>
                    <input type="radio" id="ativo" name="ativo" value="s" <?= $ativo == "s" ? "cheked" : ""?>><label>ATIVO</label>
                    <input type="radio" id="ativo" name="ativo" value="n" <?= $ativo == "n" ? "cheked" : ""?>><label>INATIVO</label>
                    <input type="file" name="imagem" id="imagem">
                    <br>

                    <input type="submit" value="SALVAR">

                </form>

            </div>

            <td><img name="imagem_atual" class="imagem_atual" src="data:image/jpeg;base64,<?= $imagem_atual ?>"></td>

</body>
</html>