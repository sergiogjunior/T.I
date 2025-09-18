<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// Verifica se um ID foi passado pela URL
if (isset($_POST['id']))
    { $id = $_POST['id'];

    // Prepara a query para deletar para evitar SQL Injection
    // Adicionamos a checagem de tipo_usuario para garantir que um admin não possa excluir outro admin/profissional por engano
    $sql = "DELETE FROM Usuarios WHERE id = ? AND tipo_usuario = 'cliente'";
    
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("i", $id);
        
        // Se a exclusão for bem-sucedida, redireciona com status de sucesso
        if ($stmt->execute()) {
            header('Location: clientes.php?status=excluido');
            exit();
        }
        $stmt->close();
    }
}

// Se algo der errado (ID não fornecido ou falha no banco), redireciona com status de erro
header('Location: clientes.php?status=erro');
exit();
?>