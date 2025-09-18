<?php
// Requer os arquivos necessários
require_once 'vendor/autoload.php';
require_once 'config.php'; // Seu arquivo de conexão com o banco

// Inicia a sessão
session_start();

// ===================================================================
// CONFIGURAÇÃO DO CLIENTE GOOGLE COM SUAS CHAVES
// ===================================================================
$clientID = '173340306293-ep4lgss5dhlhgortpka5ksooqfnip6uj.apps.googleusercontent.com';
$clientSecret = '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';
// Caminho de redirecionamento exato do seu projeto
$redirectUri = 'http://localhost/sergio/web_cliente_blacklelis/Projeto-Integrador/google-callback.php';

// Cria e configura o cliente Google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);

// Verifica se o Google retornou um código de autorização na URL
if (isset($_GET['code'])) {
    // Troca o código por um token de acesso
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    // Se houver um erro ao obter o token (ex: chaves erradas), redireciona com erro
    if (isset($token['error'])) {
        header('Location: index.php?erro=google_auth_failed');
        exit();
    }

    $client->setAccessToken($token['access_token']);

    // Pega as informações do perfil do usuário do Google
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    
    $email = $google_account_info->email;
    $nome = $google_account_info->name;
    
    // --- LÓGICA DE BANCO DE DADOS ---
    
    // 1. Verifica se o usuário já existe no seu banco de dados
    $sql_check = "SELECT id, nome, email, tipo_usuario FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql_check);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // CASO 1: Usuário já existe, então fazemos o login
        $usuario = $result->fetch_assoc();
        
        $_SESSION['autenticado'] = 'sim';
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['tipo_usuario']; // tipo_usuario vem do seu banco

        header('Location: painel_cliente.php'); // Redireciona para a área logada
        exit();

    } else {
        // CASO 2: Usuário não existe, então vamos cadastrá-lo
        $senha_aleatoria = bin2hex(random_bytes(16)); 
        $senha_hash = password_hash($senha_aleatoria, PASSWORD_BCRYPT);
        $tipo_usuario = 'cliente';
        $telefone = ''; // O Google não fornece telefone, então salvamos um valor vazio

        // Query ATUALIZADA para incluir o campo 'telefone'
        $sql_insert = "INSERT INTO usuarios (nome, email, telefone, senha, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conexao->prepare($sql_insert);
        $stmt_insert->bind_param('sssss', $nome, $email, $telefone, $senha_hash, $tipo_usuario);
        
        if ($stmt_insert->execute()) {
            // Cadastro realizado, agora fazemos o login
            $id_inserido = $stmt_insert->insert_id;

            $_SESSION['autenticado'] = 'sim';
            $_SESSION['id'] = $id_inserido;
            $_SESSION['nome'] = $nome;
            $_SESSION['perfil'] = $tipo_usuario;
            
            header('Location: painel_cliente.php'); // Redireciona para a área logada
            exit();
        } else {
            // Se houver erro na inserção no banco
            header('Location: index.php?erro=db_insert_failed');
            exit();
        }
    }
    $stmt->close();
    $conexao->close();

} else {
    // Se o usuário chegar a esta página sem o código do Google, redireciona de volta
    header('Location: index.php');
    exit();
}
?>