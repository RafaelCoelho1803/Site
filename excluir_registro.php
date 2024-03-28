<?php
// Verifica se o ID do registro a ser excluído foi recebido via GET
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Inclui o arquivo de configuração do banco de dados
    include("config.php");

    // Limpa e valida o ID do registro
    $id_pesagem = mysqli_real_escape_string($conn, $_GET['id']);

    // Query para excluir o registro
    $query_excluir = "DELETE FROM pesagem WHERE id_pesagem = $id_pesagem";

    // Executa a query de exclusão
    if(mysqli_query($conn, $query_excluir)) {
        // Registro excluído com sucesso, redireciona de volta para a página anterior com uma mensagem de sucesso
        session_start();
        $_SESSION['mensagem'] = "Registro excluído com sucesso.";
        header("Location: pesagem.php");
        exit();
    } else {
        // Se houver um erro ao excluir o registro, mostra uma mensagem de erro
        die("Erro ao excluir registro: " . mysqli_error($conn));
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
} else {
    // Se o ID não foi recebido via GET, redireciona de volta para a página anterior com uma mensagem de erro
    header("Location: pesagem.php");
    exit();
}
?>
