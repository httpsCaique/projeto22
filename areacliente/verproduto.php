<?php
include("../conectadb.php");
session_start();
//COLETA DE DADOS DE CLIENTE

$idcliente = $_SESSION['idcliente'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nomeproduto = $_POST['nomeproduto'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $totalitem = ($preco * $quantidade);
    $numerocarrinho = MD5($_SESSION['idcliente'] . date('d-m-Y H:i:s'));


    if ($idcliente <= 0) {
        echo"<script>window.alert('VOCE PRECISA LOGAR PARA DICIONAR AO CARRINHO');</script>";
        echo "<script>window.location.href='loja.php';</script>";
    } else {
        //verifica se o cliente tem carrinho aberto
        $sql = "SELECT COUNT(car_numero_carrinho) FROM itens_carrinho INNERT JOIN clientes ON fk_cli_id = cli_id WHERE cli_id = '$idcliente' AND car_finalizado = 'n'";

        $retorno = mysqli_query($link, $sql);



        while ($tbl = mysqli_fetch_array($retorno)) {
            $cont = $tbl[0];
            if ($cont == 0) {
                $sql = "INSERTO INTO itens_carrinho (fk_pro_id, car_item_quantidade, fk_cli_id, car_total_carrinho, car_numero_carrinho, car_finalizado)
            VALUES($id, '$quantidade', '$idcliente', '$totalitem', '$numerocarrinho', 'n')";
                mysqli_query($link, $sql);
                $_SESSION['carrinhoid'] = $numerocarrinho;

                echo "<script>window.alert('PRODUTO ADICIONADO AO CARRINHO');</script>";
                echo "<script>window.location.href='loja.php';</script>";
            } else {
                $sql = "SELECT DISTINCT(car_numero_carrinho) FROM itens_carrinho WHERE fk_cli_id = '$idcliente' AND car_finalizado = 'n'";
                $retorno = mysqli_query($link, $sql);

                while ($tbl = mysqli_fetch_array($retorno)) {
                    $numerocarrinhocliente = $tbl[0];
                    $_SESSION['carrinho'] = $numerocarrinhocliente;
                    $sql = "INSERT INTO itens_carrinho (fk_pro_id, car_item_quantidade, fk_cli_id, car_total_carrinho, car_numero_carrinho, car_finalizado
                VALUES($id, '$quantidade', '$idcliente', '$totalitem', '$numerocarrinho', 'n')";

                    mysqli_query($link, $sql);
                    echo "<script>window.alert('PRODUTO ADICIONADO AO CARRINHO $numerocarrinhocliente');</script>";
                    echo "<script>window.location.href='loja.php';</script>";
                }
            }
        }
    }
}



//trazendo dados via url(get)
$id = $_GET['id'];
$sql = "SELECT * FROM produtos WHERE pro_id = '$id'";
echo ($sql);

$retorno = mysqli_query($link, $sql);
while ($tbl = mysqli_fetch_array($retorno)) {
    $nomeproduto = $tbl[1];
    $descricao = $tbl[2];
    $preco = $tbl[5];
    $imagem_atual = [7];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estiloadm.css">
    <title>VER PRODUTO</title>
</head>

<body>
    <header>
        <nav>
            <ul class="menu">

                <li><a href="loja.php">HOME</a></li>
                <li><a href="#">PRODUTOS</a></li>

                <!-- VALIDAR SE CLIENTE LOGOU -->
                <?php
                if (isset($_SESSION['idcliente'])) {


                ?>
                    <form class="formmenu" action="logout.php" method="post">
                        <h3 class="menu-right2"> Olá <?= $_SESSION['nomecliente']; ?></h3>
                        <li class="menu-right"><a href="perfil.php?id=<?= $sessao_idcliente ?>">PERFIL</a></li>
                        <li class="menu-right"><a href="logout.php">LOGOUT</a></li>
                    </form>
                <?php
                } else {

                ?>

                    <form action="formmenu2">
                        <li class="menu-right"><a href="logincliente.php" style="float: right;">ENTRAR</a></li>
                        <li class="menu-right"><a href="../cadastracliente.php">CADASTRAR</a></li>
                    </form>
                <?php
                }
                ?>


            </ul>
        </nav>
    </header>

    <div class="formulario">
        <form action="verproduto.php" class="visualizaproduto" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="<?= $id ?>">
            <label>NOME</label>
            <input type="text" name="nomeproduto" id="nome" value="<?= $nomeproduto ?>" readonly>
            <label>DESCRIÇÃO</label>
            <textarea name="descricao" readonly><?= $descricao ?>"</textarea>
            <label>QUANTIDADE</label>
            <input type="number" id="quantidade" name="quantidade">

            <label>PREÇO</label>
            <input type="decimal" id="preco" name="preco" value="<?= $preco ?>" readonly>

            <br>

            <input type="submit" value="ADICIONAR AO CARRINHO">

        </form>

    </div>
    <div>
        <td><img name="imagem_atual" class="imagem_atual" src="data:image/jpeg;base64,<?= $imagem_atual ?>"></td>
    </div>
</body>

</html>