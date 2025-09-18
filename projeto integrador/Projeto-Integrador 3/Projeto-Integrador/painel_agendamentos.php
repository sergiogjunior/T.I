<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// --- LÓGICA DE FILTROS E BUSCA ---
$view = $_GET['view'] ?? 'hoje'; // Valor padrão: 'hoje'
$searchTerm = $_GET['busca'] ?? '';
$statusFilter = $_GET['status'] ?? 'Todos';

// Base da consulta SQL com JOINs para buscar dados de múltiplas tabelas
$sql = "SELECT 
            a.id,
            a.data_agendamento,
            a.hora_agendamento,
            a.status_agendamento,
            u.nome AS nome_cliente,
            u.telefone AS telefone_cliente,
            s.nome_servico,
            s.duracao_minutos,
            s.preco AS valor
        FROM Agendamentos AS a
        JOIN Usuarios AS u ON a.cliente_id = u.id
        JOIN Servicos AS s ON a.servico_id = s.id";

$whereClauses = [];
$params = [];
$types = '';

// Filtro por Aba (Hoje / Todos)
if ($view === 'hoje') {
    $whereClauses[] = "a.data_agendamento = CURDATE()";
}

// Filtro por Barra de Busca (Cliente ou Serviço)
if (!empty($searchTerm)) {
    $whereClauses[] = "(u.nome LIKE ? OR s.nome_servico LIKE ?)";
    $likeTerm = "%{$searchTerm}%";
    $params[] = $likeTerm;
    $params[] = $likeTerm;
    $types .= 'ss';
}

// Filtro por Status
if ($statusFilter !== 'Todos' && !empty($statusFilter)) {
    $whereClauses[] = "a.status_agendamento = ?";
    $params[] = $statusFilter;
    $types .= 's';
}

// Junta todas as condições WHERE, se houver alguma
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

$sql .= " ORDER BY a.data_agendamento DESC, a.hora_agendamento ASC";

$stmt = $conexao->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$agendamentos = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conexao->close();

// Função para retornar a classe CSS com base no status do seu banco de dados
function getStatusClass($status) {
    switch (strtolower($status)) {
        case 'confirmado': return 'status-agendado';
        case 'concluido': return 'status-finalizado';
        case 'pendente': return 'status-pago'; // Usando 'pago' como exemplo para pendente
        case 'cancelado': return 'status-cancelado';
        default: return '';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos - Blackelis</title>
    <link rel="stylesheet" href="src/CSS/painel_dark.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo"><img src="src/image/LOGO - offwhite 1.png" alt="Blackelis Logo"></div>
        <nav>
            <ul>
                <li><a href="./src/PHP/painel.php"><ion-icon name="grid"></ion-icon>Painel</a></li>
                <li><a href="servicos.php"><ion-icon name="cut"></ion-icon>Serviços</a></li>
                <li class="active"><a href="painel_agendamentos.php"><ion-icon name="calendar-outline"></ion-icon>Agendamentos</a></li>
                <li><a href="clientes.php"><ion-icon name="people-outline"></ion-icon>Clientes</a></li>
                <li><a href="configuracoes.php"><ion-icon name="settings-outline"></ion-icon>Configurações</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-button">Sair <ion-icon name="log-out-outline"></ion-icon></a>
    </aside>

    <main class="main-content">
        <header class="main-header">
            <h1>Agendamentos</h1>
            <a href="agendamento_manual.php" class="add-button">+ Novo Agendamento</a>
        </header>

        <nav class="tabs">
            <a href="?view=hoje" class="<?= $view === 'hoje' ? 'active' : '' ?>">Hoje</a>
            <a href="?view=todos" class="<?= $view === 'todos' ? 'active' : '' ?>">Todos</a>
        </nav>

        <div class="filters">
            <form action="agendamentos.php" method="GET">
                <input type="hidden" name="view" value="<?= htmlspecialchars($view) ?>">
                <div class="search-bar">
                    <input type="search" name="busca" placeholder="Buscar por cliente ou serviço..." value="<?= htmlspecialchars($searchTerm) ?>">
                </div>
                <div class="status-filter">
                    <label for="status">Status</label>
                    <select name="status" id="status" onchange="this.form.submit()">
                        <option value="Todos" <?= $statusFilter === 'Todos' ? 'selected' : '' ?>>Todos</option>
                        <option value="pendente" <?= $statusFilter === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="confirmado" <?= $statusFilter === 'confirmado' ? 'selected' : '' ?>>Confirmado</option>
                        <option value="concluido" <?= $statusFilter === 'concluido' ? 'selected' : '' ?>>Concluído</option>
                        <option value="cancelado" <?= $statusFilter === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>
                <button type="submit" class="filter-button">Buscar</button>
            </form>
        </div>

        <section class="appointments-list">
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($agendamentos)): ?>
                        <?php foreach ($agendamentos as $agendamento): ?>
                            <tr>
                                <td>
                                    <span class="main-info"><?= htmlspecialchars($agendamento['nome_cliente']) ?></span>
                                    <span class="sub-info"><?= htmlspecialchars($agendamento['telefone_cliente']) ?></span>
                                </td>
                                <td>
                                    <span class="main-info"><?= htmlspecialchars($agendamento['nome_servico']) ?></span>
                                    <span class="sub-info"><ion-icon name="time-outline"></ion-icon> <?= htmlspecialchars($agendamento['duracao_minutos']) ?> min</span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($agendamento['data_agendamento'])) ?> às <?= date('H:i', strtotime($agendamento['hora_agendamento'])) ?></td>
                                <td><span class="status-badge <?= getStatusClass($agendamento['status_agendamento']) ?>"><?= htmlspecialchars($agendamento['status_agendamento']) ?></span></td>
                                <td>R$ <?= number_format($agendamento['valor'], 2, ',', '.') ?></td>
                                <td class="actions">
                                <a href="editar_agendamento.php?id=<?= $agendamento['id'] ?>" class="action-icon" title="Editar"><ion-icon name="create-outline"></ion-icon></a>
                                    <a href="#" class="action-icon" title="Excluir"><ion-icon name="trash-outline"></ion-icon></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="no-data">Nenhum agendamento encontrado para os filtros selecionados.</td></tr>
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