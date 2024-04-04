<?php
    session_start();
    if(empty($_SESSION) ){
        print "<script>location.href='index.php';</script>";
    }

    include("config.php");

    $user = $_SESSION["id_user"];
    $query_pesagem = "SELECT id_pesagem, talhao_id, frete_id, ano, produto, peso_bruto, peso_liquido, hora, desconto FROM pesagem WHERE user_id = $user";

    $result_pesagem = mysqli_query($conn, $query_pesagem);

    // Verificar se houve erro na consulta
    if (!$result_pesagem) {
        die("Erro na consulta: " . mysqli_error($conn));
    }

    

    $user = $_SESSION["id_user"];
    $query_pesagem = "SELECT p.id_pesagem, p.talhao_id, f.placa AS placa_frete, p.ano, p.produto, p.peso_bruto, p.hora, p.desconto , p.peso_liquido
                  FROM pesagem p
                  INNER JOIN frete f ON p.frete_id = f.id_frete
                  WHERE p.user_id = $user";

    $result_pesagem = mysqli_query($conn, $query_pesagem);
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
    <title>pesagem</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.goFogleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbaToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div style="color: white;">
                <?php 
                print "Olá, ".$_SESSION["nome"] ;
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
                    <h1 class="text-center">REGISTRO PESAGEM</h1>
                </div>
                <form class="row g-3" action="pesagem-back.php" method="POST">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Peso Bruto</label>
                        <input type="text" class="form-control" name="peso_bruto" id="peso_bruto" onkeypress="return onlyNumbers(event)">
                    </div>
                    <div class="col-md-4" style="margin-top: 5%;">
                        <label for="inputState" class="form-label">Placa:</label>
                        <select id="InputState" class="form-select" name="frete">
                            <?php
                            // Assuming you have a database connection in $conn
                            include("config.php");
                            $user = $_SESSION["id_user"] ;

                            // Fetch the options from the database
                            $query = "SELECT placa, cor FROM frete WHERE oculta = 'N' and user_id = $user";
                            $result = mysqli_query($conn, $query);

                            // Check if the query was successful
                            if ($result) {
                                // Loop through the results and add options to the select dropdown
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . htmlspecialchars($row['placa']) . ',' . htmlspecialchars($row['cor']) . '">' . htmlspecialchars($row['placa'] . ' - ' . $row['cor']) . '</option>';
                                }

                                // Free the result set
                                mysqli_free_result($result);
                            } else {
                                // Handle the case where the query fails
                                echo '<option>Error fetching data from the database</option>';
                            }

                            // Close the database connection
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Desconto %</label>
                        <input type="text" class="form-control" name="desconto" id="desconto" onkeypress="return onlyNumbers(event)">
                    </div>
                    <div class="col-md-4" style="margin-top: 5%;">
                        <label for="inputState" class="form-label">Talhao:</label>
                        <select id="inputState" class="form-select" name="talhao" >
                            <?php
                                // Conectar ao banco de dados
                                include("config.php");

                                // Consultar o banco de dados para obter os números do talhão
                                $query = "SELECT id_talhao FROM talhoes";
                                $result = mysqli_query($conn, $query);

                                // Verificar se a consulta foi bem-sucedida
                                if ($result) {
                                    // Iterar sobre os resultados e criar as opções
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['id_talhao'] . '">' . $row['id_talhao'] . '</option>';
                                    }

                                    // Liberar o resultado
                                    mysqli_free_result($result);
                                } else {
                                    // Handle the case where the query fails
                                    echo '<option>Error fetching data from the database</option>';
                                }

                                // Fechar a conexão com o banco de dados
                                mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6" style="margin-top: 5%;">
                    <label for="inputState" class="form-label">Ano:</label>
                        <select id="inputState" class="form-select" name="ano">
                            <option selected>24</option>
                            <option>25</option>
                            <option>26</option>
                            <option>27</option>
                        </select>
                    </div>  
                    
                    <div class="col-md-4" style="margin-top: 5%;">
                    <label for="inputState" class="form-label">Produto:</label>
                        <select id="produto" class="form-select" name="produto">
                            <option selected>Soja</option>
                            <option>Milho</option>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Talhão</th>
                                <th>Placa do Frete</th>
                                <th>Ano</th>
                                <th>Produto</th>
                                <th>Peso Bruto</th>
                                <th>Peso Liqudo</th>
                                <th>Desconto</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                               
                            // Loop through the results and display each row in the table
                            while ($row = mysqli_fetch_assoc($result_pesagem)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_pesagem'] . "</td>";
                                echo "<td>" . $row['talhao_id'] . "</td>";
                                echo "<td>" . $row['placa_frete'];
                                echo "<td>" . $row['ano'] . "</td>";
                                echo "<td>" . $row['produto'] . "</td>";
                                echo "<td>" . $row['peso_bruto'] . "</td>";
                                echo "<td>" . $row['peso_liquido'] . "</td>";
                                echo "<td>" . $row['desconto'] . "</td>";
                                echo "<td><button class='btn btn-danger' onclick='excluirRegistro(" . $row['id_pesagem'] . ")'>Excluir</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                             
            </div>
            <script>
                function excluirRegistro(id_pesagem) {
                    if (confirm("Tem certeza que deseja excluir este registro?")) {
                        window.location.href = "excluir_registro.php?id=" + id_pesagem;
                    }
                }
            </script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  
</body>
</html>