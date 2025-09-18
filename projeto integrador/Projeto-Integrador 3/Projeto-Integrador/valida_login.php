<?php
// Inicia a sessão no topo do arquivo
session_start();

// Requer o arquivo de conexão com o banco de dados
require_once 'config.php'; // Verifique se o nome do arquivo está correto (config.php ou confing.php)

// A lógica só deve ser executada se o formulário for enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'] ?? '';
    $senha_digitada = $_POST['senha'] ?? '';

    // Validação de campos vazios
    if (empty($email) || empty($senha_digitada)) {
        header('Location: login.php?erro=campos_vazios');
        exit();
    }

    // Busca o usuário no banco de dados pelo e-mail
    // ATENÇÃO: Verifique se o nome da sua tabela é 'Usuarios' ou 'usuarios'
    $sql = "SELECT id, nome, senha FROM Usuarios WHERE email = ?";
    
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se encontrou um usuário
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();

            // Verifica se a senha digitada corresponde à senha criptografada no banco
            if (password_verify($senha_digitada, $usuario['senha'])) {
                // SUCESSO! Senha correta.
                
                // Armazena os dados do usuário na sessão
                $_SESSION['autenticado'] = 'sim';
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];

                // Redireciona para a página inicial, agora logado
                header('Location: index.php');
                exit();
            }
        }
    }
    
    // Se chegou aqui, o e-mail não foi encontrado ou a senha estava errada.
    header('Location: login.php?erro=login_invalido');
    exit();
}
?>