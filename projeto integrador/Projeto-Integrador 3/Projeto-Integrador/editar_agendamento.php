<?php
// Inclui o guardião de acesso e a conexão com o banco
require_once 'validador_acesso.php';
require_once 'config.php';

// Garante que apenas administradores acessem
if ($_SESSION['perfil'] !== 'adm') {
    header('Location: index.php');
    exit();
}

// Pega o ID do agendamento da URL e valida
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: painel_agendamentos.php');
    exit();
}

// --- LÓGICA PARA ATUALIZAR (quando o formulário é enviado) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agendamento_id = $_POST['agendamento_id'];
    $status = $_POST['status_agendamento'];
    $data = $_POST['data_agendamento'];
    $hora = $_POST['hora_agendamento'];

    // Lista de status válidos
    $status_validos = ['pendente', 'confirmado', 'concluido', 'cancelado'];

    if (in_array($status, $status_validos)) {
        $sql = "UPDATE Agendamentos SET status_agendamento = ?, data_agendamento = ?, hora_agendamento = ? WHERE id = ?";
        if ($stmt = $conexao->prepare($sql)) {
            $stmt->bind_param("sssi", $status, $data, $hora, $agendamento_id);
            if ($stmt->execute()) {
                header('Location: painel_agendamentos.php?status=editado');
                exit();
            }
        }
    }
}

// --- LÓGICA PARA BUSCAR OS DADOS (quando a página é carregada) ---
$sql_select = "SELECT 
                    a.id, a.data_agendamento, a.hora_agendamento, a.status_agendamento,
                    u_cliente.nome AS nome_cliente,
                    s.nome_servico,
                    u_prof.nome AS nome_profissional
                FROM Agendamentos AS a
                JOIN Usuarios AS u_cliente ON a.cliente_id = u_cliente.id
                JOIN Servicos AS s ON a.servico_id = s.id
                JOIN Usuarios AS u_prof ON a.profissional_id = u_prof.id
                WHERE a.id = ?";

if ($stmt_select = $conexao->prepare($sql_select)) {
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    
    if ($result->num_rows === 1) {
        $agendamento = $result->fetch_assoc();
    } else {
        header('Location: painel_agendamentos.php?status=nao_encontrado');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento - Blackelis</title>
    <link rel="stylesheet" href="src/CSS/painel_dark.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="logo"><img src="src/image/LOGO - offwhite 1.png" alt="Blackelis Logo"></div>
        <nav>
            <ul>
                <li><a href="painel.php"><ion-icon name="grid"></ion-icon>Painel</a></li>
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
            <h1>Editar Agendamento</h1>
        </header>

        <section class="form-section">
            <form action="editar_agendamento.php?id=<?= $id; ?>" method="POST">
                <input type="hidden" name="agendamento_id" value="<?= htmlspecialchars($agendamento['id']); ?>">
                
                <div class="form-group">
                    <label>Cliente</label>
                    <input type="text" value="<?= htmlspecialchars($agendamento['nome_cliente']); ?>" disabled>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Serviço</label>
                        <input type="text" value="<?= htmlspecialchars($agendamento['nome_servico']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Profissional</label>
                        <input type="text" value="<?= htmlspecialchars($agendamento['nome_profissional']); ?>" disabled>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="data_agendamento">Data</label>
                        <input type="date" id="data_agendamento" name="data_agendamento" value="<?= htmlspecialchars($agendamento['data_agendamento']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_agendamento">Hora</label>
                        <input type="time" id="hora_agendamento" name="hora_agendamento" value="<?= htmlspecialchars(date('H:i', strtotime($agendamento['hora_agendamento']))); ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="status_agendamento">Status do Agendamento</label>
                    <select id="status_agendamento" name="status_agendamento" required>
                        <option value="pendente" <?= $agendamento['status_agendamento'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="confirmado" <?= $agendamento['status_agendamento'] == 'confirmado' ? 'selected' : '' ?>>Confirmado</option>
                        <option value="concluido" <?= $agendamento['status_agendamento'] == 'concluido' ? 'selected' : '' ?>>Concluído</option>
                        <option value="cancelado" <?= $agendamento['status_agendamento'] == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>

                <div class="form-actions">
                    <a href="painel_agendamentos.php" class="btn-cancel">Cancelar</a>
                    <button type="submit" class="btn-save">Salvar Alterações</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>