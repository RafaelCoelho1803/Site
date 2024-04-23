<?php
session_start();

if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
}

include("config.php");

$user = $_SESSION["id_user"];

mysqli_close($conn);
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
        <form class="row g-3 border p-3 rounded " style="background-color: white;">
            <div class="col-md-4">
                <label for="inputEmail4" class="form-label">Nome do produto</label>
                <input type="text" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-4">
                <label for="inputPassword4" class="form-label">Quantidade</label>
                <input type="text" class="form-control" id="inputPassword4">
            </div>
            <div class="col-md-4" style="margin-top: 3%;">
                <label for="inputState" class="form-label">L/Kg/g/Ml</label>
                <select id="inputState" class="form-select">
                <option selected>L</option>
                <option>Kg</option>
                <option>g</option>
                <option>Ml</option>
                </select>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Cod.Produto</label>
                <input type="text" class="form-control" id="inputAddress">
            </div>
            <div class="col-12">
                <label for="inputAddress2" class="form-label">Marca</label>
                <input type="text" class="form-control" id="inputAddress2">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">Validade</label>
                <input type="date" class="form-control" id="inputCity">
            </div>
            <div class="col-md-4" style="margin-top: 3%;">
                <label for="inputState" class="form-label">Classificação</label>
                <select id="inputState" class="form-select">
                <option selected>Insumos</option>
                <option>Fungicida</option>
                <option>Fertilizante</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Fornecedor</label>
                <input type="text" class="form-control" id="inputZip">
            </div>
            <div class="mt-3 ml-3">
                <label for="formFile" class="form-label">Imagem do Produto</label>
                <input class="form-control" type="file" id="formFile">
            </div>
            <div class="col-12" style="margin-top: 3%;">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
    </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
