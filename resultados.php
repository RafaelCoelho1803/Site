<?php
session_start();

if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
}

include("config.php");

$user = $_SESSION["id_user"];

// Inicialização dos filtros
$ano = isset($_GET['ano']) ? $_GET['ano'] : '24'; // Valor padrão: 24
$produto = isset($_GET['produto']) ? $_GET['produto'] : 'S'; // Valor padrão: Soja
$resultados = isset($_GET['resultados']) ? $_GET['resultados'] : 'T'; // Valor padrão: Talhão

// Construção da consulta SQL com base nos filtros
if ($resultados === 'T') {
    $query = "SELECT t.id_talhao, t.Area, 
              SUM(p.peso_liquido) AS peso_liquido, 
              ROUND(SUM((peso_liquido) / 60)) AS sacos,
              ROUND(SUM((peso_liquido) / (60 * t.Area))) AS media_sacos_por_area,
              SUM(p.desconto) AS total_desconto,
              COUNT(p.id_pesagem) AS total_pesagens
              FROM talhoes t 
              LEFT JOIN pesagem p ON t.id_talhao = p.talhao_id 
              LEFT JOIN frete f ON p.frete_id = f.id_frete 
              WHERE p.user_id = $user 
              AND p.ano = $ano
              AND p.produto = '$produto'
              GROUP BY t.id_talhao";
} else {
    $query = "SELECT 
              SUM(p.peso_liquido) AS peso_liquido, 
              ROUND(SUM((peso_liquido) / 60)) AS sacos,
              SUM(p.desconto) AS total_desconto,
              COUNT(p.id_pesagem) AS total_pesagens
              FROM pesagem p 
              LEFT JOIN frete f ON p.frete_id = f.id_frete 
              WHERE p.user_id = $user 
              AND p.ano = $ano
              AND p.produto = '$produto'";                
}

$query_total = "SELECT COUNT(*) as total FROM pesagem WHERE user_id = $user and produto = '$produto' and ano = '$ano'";
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_pesagens = $row_total['total'];

$result = mysqli_query($conn, $query);

// Verifica se houve erro na consulta SQL
if (!$result) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        .Top-side {
            margin-bottom: 20px;
        }
        .Resultados {
            margin-top: 20px;
        }
    </style>
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
    <div class="container-fluid Back-side">
        <form class="row gx-3 gy-2 align-items-center m-4" method="get">
            <div class="col-sm">
                <label class="visually-hidden" for="specificSizeSelect">Ano</label>
                <select class="form-select" id="specificSizeSelect" name="ano">
                    <option <?php if ($ano == '24') echo 'selected' ?>>24</option>
                    <option <?php if ($ano == '25') echo 'selected' ?>>25</option>
                    <option <?php if ($ano == '26') echo 'selected' ?>>26</option>
                    <option <?php if ($ano == '27') echo 'selected' ?>>27</option>
                </select>
            </div>
            <div class="col-sm">
                <label class="visually-hidden" for="specificSizeSelect">Produto</label>
                <select class="form-select" id="specificSizeSelect" name="produto">
                    <option value="S" <?php if ($produto == 'S') echo 'selected' ?>>Soja</option>
                    <option value="M" <?php if ($produto == 'M') echo 'selected' ?>>Milho</option>
                </select>
            </div>    
            <div class="col-sm">    
                <label class="visually-hidden" for="specificSizeSelect">Resultados</label>
                <select class="form-select" id="specificSizeSelect" name="resultados">
                    <option value="T" <?php if ($resultados == 'T') echo 'selected' ?>>Talhão</option>
                    <option value="G" <?php if ($resultados == 'G') echo 'selected' ?>>Gerais</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>
        <div class="Resultados m-4">
            <?php if ($resultados === 'T') { ?>
                <div class="row">
                    <div class="col">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Talhao</th>
                                    <th scope="col">Áreas(He)</th>
                                    <th scope="col">Peso Líquido(Kg)</th>
                                    <th scope="col">Sacos</th>
                                    <th scope="col">Média de Sacos</th>
                                    <th scope="col">Desconto da Área</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                                                              
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id_talhao'] . "</td>";
                                    echo "<td>" . $row['Area'] . "</td>";
                                    echo "<td>" . $row['peso_liquido'] . "</td>";
                                    echo "<td>" . $row['sacos'] . "</td>";
                                    echo "<td>" . $row['media_sacos_por_area'] . "</td>";
                                    $media_desconto = $row['total_desconto'] / $row['total_pesagens'];
                                    echo "<td>" . $media_desconto . "</td>";
                                    echo "</tr>";
                                }
                                ?>                               
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                    <div class="container">

                    </div>
            <?php } ?>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
    
</body>
</html>
