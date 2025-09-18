<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// --- Lógica para buscar os dados dos serviços ---
$servicos = [];
$sql_servicos = "SELECT id, nome_servico, preco, duracao_minutos FROM Servicos ORDER BY nome_servico ASC";
$res_servicos = $conexao->query($sql_servicos);

if ($res_servicos) {
    while ($row = $res_servicos->fetch_assoc()) {
        $servicos[] = $row;
    }
}
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - Blackelis</title>
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
                <li class="active"><a href="servicos.php"><ion-icon name="cut"></ion-icon>Serviços</a></li>
                <li><a href="painel_agendamentos.php"><ion-icon name="calendar-outline"></ion-icon>Agendamentos</a></li>
                <li><a href="clientes.php"><ion-icon name="people-outline"></ion-icon>Clientes</a></li>
                <li><a href="configuracoes.php"><ion-icon name="settings-outline"></ion-icon>Configurações</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-button">Sair <ion-icon name="log-out-outline"></ion-icon></a>
    </aside>

    <main class="main-content">
        <header class="main-header">
            <h1>Serviços</h1>
            <a href="adicionar_servico.php" class="add-button">+ Adicionar serviço</a>
        </header>

        <section class="services-list">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Duração</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($servicos)): ?>
                        <?php foreach ($servicos as $servico): ?>
                            <tr>
                                <td><?= htmlspecialchars($servico['nome_servico']); ?></td>
                                <td>R$ <?= number_format($servico['preco'], 2, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($servico['duracao_minutos']); ?> min</td>
                                <td class="actions">
                                    <a href="editar_servico.php?id=<?= $servico['id']; ?>" class="action-icon"><ion-icon name="create-outline"></ion-icon></a>
                                    <a href="deletar_servico.php?id=<?= $servico['id']; ?>" class="action-icon" onclick="return confirm('Tem certeza?');"><ion-icon name="trash-outline"></ion-icon></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-data">Nenhum serviço cadastrado.</td>
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