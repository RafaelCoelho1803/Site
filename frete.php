<?php
session_start();

if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
}

include("config.php");

// Lógica para mostrar/ocultar registros
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mostrar'])) {
        $id_mostrar = $_POST['id_mostrar'];
        $query_mostrar = "UPDATE frete SET oculta = 'N' WHERE id_frete = $id_mostrar";
        $result_mostrar = mysqli_query($conn, $query_mostrar);

        if ($result_mostrar) {
            $_SESSION['mensagem'] = 'Registro mostrado com sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro ao mostrar o registro: ' . mysqli_error($conn);
        }
    } elseif (isset($_POST['ocultar'])) {
        $id_ocultar = $_POST['id_ocultar'];
        $query_ocultar = "UPDATE frete SET oculta = 'S' WHERE id_frete = $id_ocultar";
        $result_ocultar = mysqli_query($conn, $query_ocultar);

        if ($result_ocultar) {
            $_SESSION['mensagem'] = 'Registro oculto com sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro ao ocultar o registro: ' . mysqli_error($conn);
        }
    }

    header("Location: frete.php");
    exit();
}

// Consulta para obter registros

$query_pesagem = "SELECT id_frete, placa, estado, cor, peso, oculta FROM frete";

$user = $_SESSION["id_user"];
$query_pesagem = "SELECT id_frete, placa, estado, cor, peso, oculta FROM frete WHERE user_id = $user";

$result_pesagem = mysqli_query($conn, $query_pesagem);

// Verifica se a consulta foi bem-sucedida
if (!$result_pesagem) {
    die('Erro ao buscar dados do banco de dados: ' . mysqli_error($conn));
}

// Obtém os registros de pesagem
$registros_pesagem = mysqli_fetch_all($result_pesagem, MYSQLI_ASSOC);

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caminhoes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>

<body>
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
    <div class="Back-Side" style="margin: 10%;">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <h1 class="text-center">REGISTRO CAMINHÕES</h1>
                </div>
                <form class="row g-3" action="frete-back.php" method="POST">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Placa</label>
                        <input type="text" class="form-control" name="placa" id="placa">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Cor</label>
                        <input type="text" class="form-control" name="cor" id="cor">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Peso</label>
                        <input type="text" class="form-control" name="peso" id="cor">
                    </div>
                    <div class="col-md-4" style="margin-top: 5%;">
                        <label for="inputState" class="form-label">Estado</label>
                        <select id="inputState" class="form-select" name="estado">
                            <option selected>MT</option>
                            <option>GO</option>
                            <option>...</option>
                            <option>...</option>
                            <option>...</option>
                            <option>...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="col-12" style="margin-top: 2%;">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                    <?php
                    // Verificar se há uma mensagem de sucesso
                    if (!empty($_SESSION['mensagem'])) {
                        echo '<div class="alert alert-success mt-3 ml-3" role="alert">';
                        echo $_SESSION['mensagem'];
                        echo '</div>';

                        // Limpar a variável de sessão
                        unset($_SESSION['mensagem']);
                    }
                    ?>
                </form>
            </div>
            <div class="col-md-6">
                <div class="col-form">
                    <!-- Tabela -->
                    <?php
                    // Exibir a tabela de registros
                    echo '<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Placa</th>
                                    <th>Estado</th>
                                    <th>Cor</th>
                                    <th>Peso</th>
                                    <th>Oculta</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>';

                    // Iterar sobre os registros de pesagem
                    foreach ($registros_pesagem as $registro_pesagem) {
                        echo '<tr>
                                <td>' . $registro_pesagem['id_frete'] . '</td>
                                <td>' . $registro_pesagem['placa'] . '</td>
                                <td>' . $registro_pesagem['estado'] . '</td>
                                <td>' . $registro_pesagem['cor'] . '</td>
                                <td>' . $registro_pesagem['peso'] . '</td>
                                <td>' . $registro_pesagem['oculta'] . '</td>
                                <td>';

                        if ($registro_pesagem['oculta'] == 'S') {
                            // Se estiver oculta, mostrar o botão "Mostrar"
                            echo '<form action="frete.php" method="post">
                                    <input type="hidden" name="id_mostrar" value="' . $registro_pesagem['id_frete'] . '">
                                    <button type="submit" class="btn btn-success" name="mostrar">Mostrar</button>
                                </form>';
                        } else {
                            // Se não estiver oculta, mostrar o botão "Ocultar"
                            echo '<form action="frete.php" method="post">
                                    <input type="hidden" name="id_ocultar" value="' . $registro_pesagem['id_frete'] . '">
                                    <button type="submit" class="btn btn-danger" name="ocultar">Ocultar</button>
                                </form>';
                        }

                        echo '</td></tr>';
                    }

                    echo '</tbody></table>';
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
