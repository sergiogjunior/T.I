<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// --- Lógica para buscar e pesquisar clientes ---
$clientes = [];
$searchTerm = $_GET['busca'] ?? ''; // Pega o termo de busca da URL

// Prepara a base da consulta SQL para buscar apenas clientes
$sql = "SELECT id, nome, email, telefone FROM Usuarios WHERE tipo_usuario = 'cliente'";

// Se um termo de busca foi enviado, adiciona a condição LIKE
if (!empty($searchTerm)) {
    $sql .= " AND (nome LIKE ? OR email LIKE ?)";
}

$sql .= " ORDER BY nome ASC";

$stmt = $conexao->prepare($sql);

// Se houver um termo de busca, associa os parâmetros
if (!empty($searchTerm)) {
    $likeTerm = "%{$searchTerm}%";
    $stmt->bind_param("ss", $likeTerm, $likeTerm);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}
$stmt->close();
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Blackelis</title>
    <link rel="stylesheet" href="src/CSS/painel_dark.css">
</head>
<body>

<div class="dashboard">
    <aside class="sidebar">
        <div class="logo">
            <img src="src/image/LOGO - offwhite 1.png" alt="Blackelis Logo">
        </div>
        <nav>
            <ul>
                <li><a href="./src/PHP/painel.php"><ion-icon name="grid"></ion-icon>Painel</a></li>
                <li><a href="servicos.php"><ion-icon name="cut"></ion-icon>Serviços</a></li>
                <li><a href="painel_agendamentos.php"><ion-icon name="calendar-outline"></ion-icon>Agendamentos</a></li>
                <li class="active"><a href="clientes.php"><ion-icon name="people-outline"></ion-icon>Clientes</a></li>
                <li><a href="configuracoes.php"><ion-icon name="settings-outline"></ion-icon>Configurações</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-button">Sair <ion-icon name="log-out-outline"></ion-icon></a>
    </aside>

    <main class="main-content">
        <header class="main-header">
            <h1>Clientes</h1>
            <a href="adicionar_cliente.php" class="add-button">+ Adicionar cliente</a>
        </header>

        <div class="search-bar">
            <form action="clientes.php" method="GET">
                <input type="search" name="busca" placeholder="Buscar por nome ou e-mail..." value="<?= htmlspecialchars($searchTerm) ?>">
                <button type="submit"><ion-icon name="search-outline"></ion-icon></button>
            </form>
        </div>

        <section class="clients-list">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= htmlspecialchars($cliente['nome']); ?></td>
                                <td><?= htmlspecialchars($cliente['email']); ?></td>
                                <td><?= htmlspecialchars($cliente['telefone']); ?></td>
                                <td class="actions">
                                    <a href="editar_cliente.php?id=<?= $cliente['id']; ?>" class="action-icon" title="Editar"><ion-icon name="create-outline"></ion-icon></a>
                                    <a href="deletar_cliente.php?id=<?= $cliente['id']; ?>" class="action-icon" title="Excluir" onclick="return confirm('Tem certeza?');"><ion-icon name="trash-outline"></ion-icon></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-data">Nenhum cliente encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

    </main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>