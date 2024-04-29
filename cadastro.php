<?php
session_start();

// Verifica se o usuário está logado
if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
}

// Inicializa as variáveis de mensagem
$message = "";
$messageColor = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclui o arquivo de configuração do banco de dados
    include("config.php");

    // Obtém os dados do formulário
    $nome_produto = $_POST["nome_produto"];
    $quantidade = $_POST["quantidade"];
    $unidade_medida = $_POST["unidade_medida"];
    $cod_produto = $_POST["cod_produto"];
    $marca = $_POST["marca"];
    $validade = $_POST["validade"];
    $classificacao = $_POST["classificacao"];
    $fornecedor = $_POST["fornecedor"];

    // Processa a imagem
    // Primeiro, verifica se uma imagem foi enviada
    if(isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
        $imagem = addslashes(file_get_contents($_FILES["imagem"]["tmp_name"]));
    } else {
        // Se não foi enviada, define a imagem como vazia
        $imagem = NULL;
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO produtos (nome_produto, quantidade, unidade_medida, cod_produto, marca, validade, classificacao, fornecedor, imagem) 
            VALUES ('$nome_produto', '$quantidade', '$unidade_medida', '$cod_produto', '$marca', '$validade', '$classificacao', '$fornecedor', '$imagem')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Produto cadastrado com sucesso!";
        $messageColor = "green";
    } else {
        $message = "Erro ao cadastrar o produto: " . mysqli_error($conn);
        $messageColor = "red";
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<script>
    function onlyNumbers(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            // Exibir uma mensagem de erro ou tomar alguma outra ação aqui
            return false;
        }
        return true;
    }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Produtos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>

<body style="background-color: #E2E2E2;">
    <div class="Top-side">
        <div class="pos-f-t">
            <div class="collapse" id="navbarToggleExternalContent">
                <div class="bg-dark p-4">
                    <h5 class="text-white h4">Fazenda Alvorada</h5>
                    <span class="text-muted"><a href="dashboard.php">Home</a></span>
                </div>
            </div>
            <nav class="navbar navbar-dark bg-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div style="color: white;">
                    <?php
                    print "Olá, " . $_SESSION["nome"];
                    ?>
                </div>
                <?php
                print "<a href='logout.php' class='btn btn-danger'>Sair </a> ";
                ?>
            </nav>
        </div>
    </div>
    <div class="back_side" style="margin-top: 12%;margin-left:20%; 
    margin-right:20%;">
        <form class="row g-3 border p-3 rounded " action="cadastro.php" method="post" enctype="multipart/form-data" style="background-color: white;">
            <div class="col-md-4">
                <label for="nome_produto" class="form-label">Nome do produto</label>
                <input type="text" class="form-control" id="nome_produto" name="nome_produto">
            </div>
            <div class="col-md-4">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="text" onkeypress="return onlyNumbers(event)" class="form-control" id="quantidade" name="quantidade">
            </div>
            <div class="col-md-4" style="margin-top: 3%;">
                <label for="unidade_medida" class="form-label">L/Kg/g/Ml</label>
                <select id="unidade_medida" class="form-select" name="unidade_medida">
                    <option selected>L</option>
                    <option>Kg</option>
                    <option>g</option>
                    <option>Ml</option>
                </select>
            </div>
            <div class="col-12">
                <label for="cod_produto" class="form-label">Cod.Produto</label>
                <input type="text" onkeypress="return onlyNumbers(event)" class="form-control" id="cod_produto" name="cod_produto">
            </div>
            <div class="col-12">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca">
            </div>
            <div class="col-md-6">
                <label for="validade" class="form-label">Validade</label>
                <input type="date" class="form-control" id="validade" name="validade">
            </div>
            <div class="col-md-4" style="margin-top: 3%;">
                <label for="classificacao" class="form-label">Classificação</label>
                <select id="classificacao" class="form-select" name="classificacao">
                    <option selected>Insumos</option>
                    <option>Fungicida</option>
                    <option>Fertilizante</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="fornecedor" class="form-label">Fornecedor</label>
                <input type="text" class="form-control" id="fornecedor" name="fornecedor">
            </div>
            <div class="mt-3 ml-3">
                <label for="imagem" class="form-label">Imagem do Produto</label>
                <input class="form-control" type="file" id="imagem" name="imagem">
            </div>
            <div class="col-12" style="margin-top: 3%;">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>
        <?php if (!empty($message)) { ?>
            <div style="color: <?php echo $messageColor; ?>; text-align: center;"><?php echo $message; ?></div>
        <?php } ?>

    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
