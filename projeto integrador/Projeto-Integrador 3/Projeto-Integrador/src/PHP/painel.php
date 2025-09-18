
<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once '../../validador_acesso.php';
require_once '../../config.php';
 
// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: ../Projeto-Integrador/painel.php');
    exit();
}
 
// --- Lógica para buscar os dados do painel ---

// ATUALIZADO: Agora conta apenas agendamentos pendentes ou confirmados para hoje
$sql_hoje = "SELECT COUNT(*) AS total FROM Agendamentos WHERE data_agendamento = CURDATE() AND status_agendamento IN ('pendente', 'confirmado')";
$res_hoje = $conexao->query($sql_hoje);
$agendamentosHoje = $res_hoje ? $res_hoje->fetch_assoc()['total'] : 0;

// Agendamentos Totais (essa lógica pode permanecer a mesma)
$sql_total = "SELECT COUNT(*) AS total FROM Agendamentos";
$res_total = $conexao->query($sql_total);
$agendamentosTotais = $res_total ? $res_total->fetch_assoc()['total'] : 0;

// Receita Total (apenas de agendamentos concluídos)
$sql_receita = "SELECT SUM(s.preco) AS total FROM Agendamentos a JOIN Servicos s ON a.servico_id = s.id WHERE a.status_agendamento = 'concluido'";
$res_receita = $conexao->query($sql_receita);
$receita = $res_receita ? ($res_receita->fetch_assoc()['total'] ?? 0) : 0;

// ATUALIZADO: A tabela de hoje também mostrará apenas agendamentos pendentes ou confirmados
$sql_tabela = "SELECT u.nome AS cliente, a.hora_agendamento AS hora, s.nome_servico AS servico 
               FROM Agendamentos a 
               JOIN Usuarios u ON a.cliente_id = u.id 
               JOIN Servicos s ON a.servico_id = s.id 
               WHERE a.data_agendamento = CURDATE() AND a.status_agendamento IN ('pendente', 'confirmado')
               ORDER BY a.hora_agendamento ASC";
$res_tabela = $conexao->query($sql_tabela);
$agendamentos = [];
if ($res_tabela) {
    while($row = $res_tabela->fetch_assoc()) {
        $agendamentos[] = $row;
    }
}
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Blackelis</title>
    <link rel="stylesheet" href="../CSS/painel.css">
</head>
<body>

<div class="dashboard">
    <aside class="sidebar">
        <div class="logo">
            <img src="src/image/LOGO - offwhite 1.png" alt="Blackelis Logo">
        </div>
        <nav>
            <ul>
                <li class="active"><a href="painel.php"><ion-icon name="grid"></ion-icon>Painel</a></li>
                <li><a href="../../servicos.php"><ion-icon name="cut"></ion-icon>Serviços</a></li>
                <li><a href="../../painel_agendamentos.php"><ion-icon name="calendar-outline"></ion-icon>Agendamentos</a></li>
                <li><a href="../../clientes.php"><ion-icon name="people-outline"></ion-icon>Clientes</a></li>
                <li><a href="../../configuracoes.php"><ion-icon name="settings-outline"></ion-icon>Configurações</a></li>
            </ul>
        </nav>
        <a href="logout.php" class="logout-button">Sair <ion-icon name="log-out-outline"></ion-icon></a>
    </aside>

    <main class="main-content">
        <header class="main-header">
            <h1>Painel</h1>
        </header>

        <section class="summary-cards">
            <div class="card">
                <span class="card-title">Agendamentos Pendentes (Hoje)</span>
                <span class="card-value"><?= htmlspecialchars($agendamentosHoje); ?></span>
            </div>
            <div class="card">
                <span class="card-title">Agendamentos Totais</span>
                <span class="card-value"><?= htmlspecialchars($agendamentosTotais); ?></span>
            </div>
            <div class="card">
                <span class="card-title">Receita</span>
                <span class="card-value">R$ <?= number_format($receita, 2, ',', '.'); ?></span>
            </div>
        </section>

        <section class="appointments-table">
            <h2>Agenda do Dia (Pendentes e Confirmados)</h2>
            <?php if (!empty($agendamentos)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Hora</th>
                        <th>Serviço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <tr>
                            <td><?= htmlspecialchars($agendamento['cliente']); ?></td>
                            <td><?= date('H:i', strtotime($agendamento['hora'])); ?></td>
                            <td><?= htmlspecialchars($agendamento['servico']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="no-appointments">Nenhum agendamento pendente para hoje.</p>
            <?php endif; ?>
        </section>

    </main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>