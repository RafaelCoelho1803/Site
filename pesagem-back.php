<?php
session_start();

if (empty($_SESSION)) {
    print "<script>location.href='index.php';</script>";
    exit;
}

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obter os dados do formulário
    $user_id = $_SESSION["id_user"];
    $peso_bruto = $_POST["peso_bruto"];
    $desconto = $_POST["desconto"];
    $ano = $_POST["ano"];
    $talhao = $_POST["talhao"];
    $frete_data = explode(',', $_POST["frete"]);
    $placa_frete = $frete_data[0];
    $cor_frete = $frete_data[1];
    $produto = $_POST["produto"];

    // Extrair a placa da entrada
    $placa_info = explode(',', $frete); // Aqui deve ser $frete, não $placa_cor
    $placa_frete = $frete_data[0];
    $cor_frete = $frete_data[1];

    // Preparar e executar a consulta de inserção
    $query_insert = "INSERT INTO pesagem (talhao_id, frete_id, ano,  peso_bruto, desconto,  user_id , produto , hora) 
                    VALUES ('$talhao', (SELECT id_frete FROM frete WHERE placa = '$placa_frete' AND cor = '$cor_frete'), '$ano', '$peso_bruto', '$desconto',  '$user_id' , '$produto',NOW() )";

    if (mysqli_query($conn, $query_insert)) {
        $_SESSION['mensagem'] = "Dados inseridos com sucesso.";
    } else {
        $_SESSION['mensagem'] = "Erro ao inserir dados: " . mysqli_error($conn);
    }

    // Redirecionar de volta para a página de registro de pesagem
    header("Location: pesagem.php");
    exit;
}
?>
