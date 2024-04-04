<?php
session_start();

if (empty($_SESSION)) {
    header("Location: index.php");
    exit();
}

include("config.php");

$user = $_SESSION["id_user"];

// Inicialização dos filtros
$ano = isset($_GET['ano']) ? $_GET['ano'] : '22'; // Valor padrão: 22
$produto = isset($_GET['produto']) ? $_GET['produto'] : 'S'; // Valor padrão: Soja

// Construção da consulta SQL com base nos filtros
$query_talhao = "SELECT t.id_talhao, t.Area, SUM(p.peso_bruto - f.peso) AS peso_liquido, 
                 ROUND(SUM((p.peso_bruto - f.peso) / 60)) AS sacos,
                 ROUND(SUM((p.peso_bruto - f.peso) / (60 * t.Area))) AS media_sacos_por_area
                 FROM talhoes t 
                 LEFT JOIN pesagem p ON t.id_talhao = p.talhao_id 
                 LEFT JOIN frete f ON p.frete_id = f.id_frete 
                 WHERE t.user_id = $user 
                 AND p.ano = $ano
                 AND p.produto = '$produto'
                 GROUP BY t.id_talhao";
                 
$result_talhao = mysqli_query($conn, $query_talhao);


// Verifica se houve erro na consulta SQL
if (!$result_talhao) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

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
    <div class="Back-side">
        <form class="row gx-3 gy-2 align-items-center m-4 " method="get">
            
            <div class="col-">
                <label class="visually-hidden" for="specificSizeSelect">Ano</label>
                <select class="form-select" id="specificSizeSelect" name="ano">
                <option <?php if ($ano == '22') echo 'selected' ?>>22</option>
                <option <?php if ($ano == '23') echo 'selected' ?>>23</option>
                <option <?php if ($ano == '24') echo 'selected' ?>>24</option>
                <option <?php if ($ano == '25') echo 'selected' ?>>25</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label class="visually-hidden" for="specificSizeSelect">Produto</label>
                <select class="form-select" id="specificSizeSelect" name="produto">
                <option value="S" <?php if ($produto == 'S') echo 'selected' ?>>Soja</option>
                <option value="M" <?php if ($produto == 'M') echo 'selected' ?>>Milho</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
            
        </form>
        <div class="Resultados">
            <div class="row">
                <div class="col-5">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Talhao</th>
                            <th scope="col">Áreas</th>
                            <th scope="col">Peso Líquido</th>
                            <th scope="col">Sacos</th>
                            <th scope="col">Média de Sacos por Área</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                               
                                // Loop through the results and display each row in the table
                                while ($row = mysqli_fetch_assoc($result_talhao)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id_talhao'] . "</td>";
                                    echo "<td>" . $row['Area'] . "</td>";
                                    echo "<td>" . $row['peso_liquido'] . "</td>";
                                    echo "<td>" . $row['sacos'] . "</td>";
                                    echo "<td>" . $row['media_sacos_por_area'] . "</td>";
                                    echo "</tr>";
                                }
                            ?>                               
                        </tbody>
                    </table>
                </div>
            
                <div class="col-5">
                    
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
    
</body>
</html>
