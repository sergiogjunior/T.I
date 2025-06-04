<?php
    include ('config.php');
   
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha_digitada = $_POST['senha'] ?? ''; // Senha em texto puro
    $perfil = $_POST['perfil'] ?? '';

    // VERIFICA SE O E-MAIL JÁ ESTÁ CADASTRADO USANDO PREPARED STATEMENTS
    $sql_check_email = "SELECT id_usuario FROM usuarios WHERE email = ?";
    $stmt_check = $conexao->prepare($sql_check_email);

    if ($stmt_check === false) {
        error_log("Erro na preparação do check de email: " . $conexao->error);
        header('location: cadastro.php?usuario=falha_preparacao');
        exit();
    }
    
    $stmt_check->bind_param('s', $email);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();

    if ($res_check->num_rows > 0) {
        header('location: cadastro.php?email=erro');
        exit();
    }
    $stmt_check->close();

    // VALIDA SE FOI SELECIONADO ALGUMA OPÇÃO DE PERFIL
    if ($perfil === "-- Selecione --" || empty($perfil)) { 
        header('location: cadastro.php?validaperfil=erro');
        exit();
    }

    // HASHING DE SENHA COM MD5 (MANTENDO A LÓGICA SOLICITADA)
    // RECOMENDAÇÃO: MUDE PARA password_hash() para segurança real!
    $senha_hash_md5 = md5($senha_digitada); //

    // INSERÇÃO DOS DADOS NO BANCO USANDO PREPARED STATEMENTS
    $sql_insert = "INSERT INTO usuarios(nome, email, senha, perfil) VALUES(?, ?, ?, ?)";
    $stmt_insert = $conexao->prepare($sql_insert);

    if ($stmt_insert === false) {
        error_log("Erro na preparação do insert de usuário: " . $conexao->error);
        header('location: cadastro.php?usuario=falha_preparacao');
        exit();
    }

    $stmt_insert->bind_param('ssss', $nome, $email, $senha_hash_md5, $perfil); //

    $exec_insert = $stmt_insert->execute();

    if ($exec_insert) {
        header('location: index.php?usuario=sucesso');
    } else { 
        error_log("Erro na execução do insert de usuário: " . $stmt_insert->error);
        header('location: cadastro.php?usuario=falha');
    }

    $stmt_insert->close();
    exit();
?>