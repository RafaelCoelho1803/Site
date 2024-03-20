<?php
    session_start();

    include("config.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_SESSION["id_user"];
        $placa = $_POST["placa"];
        $estado = $_POST["estado"];
        $cor = $_POST["cor"];
        $peso = $_POST["peso"];

        // Validar e escapar os dados para evitar SQL injection
        $user_id = mysqli_real_escape_string($conn, $user_id);
        $placa = mysqli_real_escape_string($conn, $placa);
        $estado = mysqli_real_escape_string($conn, $estado);
        $cor = mysqli_real_escape_string($conn, $cor);
        $peso = mysqli_real_escape_string($conn, $peso);


        $sql = "INSERT INTO `frete`(`user_id`,`placa`, `estado`, `cor`, `peso`) VALUES (?,?, ?, ?, ?)";

        $sql = "INSERT INTO `frete`(`user_id`,`placa`, `estado`, `cor`, `peso`) VALUES (? ,?, ?, ?, ?)";


        // Usar prepared statement para prevenir SQL injection
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            die('Erro na preparação da declaração: ' . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sssss", $user_id, $placa, $estado, $cor, $peso);

        if (mysqli_stmt_execute($stmt)) {
            // Inserção bem-sucedida
            $_SESSION['mensagem'] = 'Registro inserido com sucesso!';
        } else {
            // Erro na inserção
            $_SESSION['mensagem'] = 'Erro ao inserir registro: ' . mysqli_error($conn);
        }

        // Fechar a declaração e a conexão
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Redirecionar para a página frete.php
        header("Location: frete.php");
        exit();
    }
?>
