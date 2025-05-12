<?php  
session_start();

$usuarios = array(
    [
        'id' => '1',
        'perfil' => 'adm',
        'nome' => 'sergio',
        'email' => 'sergiogjunior@gmail.com',
        'senha' => '123'
    ],
    [
        'id' => '2',
        'perfil' => 'user',
        'nome' => 'Jorel Calçado',
        'email' => 'user123@gmail.com',
        'senha' => '123'
    ],
    [
        'id' => '3',
        'perfil' => 'user',
        'nome' => 'Kyan',
        'email' => 'kyanmaloka@gmail.com',
        'senha' => '123'
    ],
);

$usuarioAutenticado = false;

// Corrigido: 'senhalUsuario' para 'senhaUsuario'
$emailUsuario = $_GET['email'];
$senhaUsuario = $_GET['senha'];

// Corrigido: nome da variável $usuariosAutenticado para $usuarios
for ($idx = 0; $idx < count($usuarios); $idx++) {
    if ($emailUsuario == $usuarios[$idx]['email'] && $senhaUsuario == $usuarios[$idx]['senha']) {
        $usuarioAutenticado = true;
        $_SESSION['id'] = $usuarios[$idx]['id'];
        $_SESSION['perfil'] = $usuarios[$idx]['perfil'];
        $_SESSION['nome'] = $usuarios[$idx]['nome'];
        break;
    } else {
        $usuarioAutenticado = false;
    }
}

// Corrigido: ponto e vírgula faltando após header
if ($usuarioAutenticado) {
    $_SESSION['autenticado'] = 'sim';
    header('Location: home.php');
} else {
    $_SESSION['autenticado'] = 'nao';
    header('Location: index.php?login=erro');
}
?>
