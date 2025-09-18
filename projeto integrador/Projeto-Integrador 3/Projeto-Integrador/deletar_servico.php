<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'Administrador') {
    header('Location: index.php');
    exit();
}

// Verifica se um ID válido foi passado pela URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara a query para deletar para evitar SQL Injection
    $sql = "DELETE FROM Servicos WHERE id = ?";
    
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("i", $id);
        
        // Se a exclusão for bem-sucedida, redireciona com status de sucesso
        if ($stmt->execute()) {
            header('Location: servicos.php?status=excluido');
            exit();
        }
        $stmt->close();
    }
}

// Se algo der errado (ID não fornecido ou falha no banco), redireciona com status de erro
header('Location: servicos.php?status=erro');
exit();
?>