<?php
// Inclui o arquivo de configuração do banco de dados
include("config.php");

// Obtém o ID do produto
$id_produto = 22;

// Consulta o banco de dados para obter a imagem do produto com o ID fornecido
$sql = "SELECT imagem FROM produtos WHERE id_produto = $id_produto";
$result = mysqli_query($conn, $sql);

// Verifica se a consulta foi bem-sucedida e se encontrou a imagem
if(mysqli_num_rows($result) > 0) {
    // Extrai os dados da imagem do resultado da consulta
    $row = mysqli_fetch_assoc($result);
    // Define o tipo de conteúdo da página como imagem
    header("Content-type: image/jpeg");
    // Exibe a imagem na página
    echo $row['imagem'];
} else {
    // Se não foi encontrada uma imagem para o ID fornecido, exibe uma mensagem de erro
    echo "Imagem não encontrada";
}

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>
