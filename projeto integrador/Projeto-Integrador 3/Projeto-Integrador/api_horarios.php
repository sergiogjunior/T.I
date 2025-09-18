<?php
header('Content-Type: application/json');
include 'config.php';

$data = isset($_GET['data']) ? $_GET['data'] : die();
$id_profissional = isset($_GET['id_profissional']) ? (int)$_GET['id_profissional'] : die();
$dia_semana = date('w', strtotime($data)); // 0=Dom, 1=Seg, ...

$horarios_possiveis = [];

try {
    // 1. Busca os turnos de trabalho do profissional para aquele dia da semana
    $stmt_turnos = $conexao->prepare("SELECT hora_inicio, hora_fim FROM HorariosTrabalho WHERE profissional_id = ? AND dia_semana = ?");
    $stmt_turnos->bind_param("ii", $id_profissional, $dia_semana);
    $stmt_turnos->execute();
    $result_turnos = $stmt_turnos->get_result();

    // 2. Gera os horários possíveis com base nos turnos (ex: de hora em hora)
    while ($turno = $result_turnos->fetch_assoc()) {
        $inicio = new DateTime($turno['hora_inicio']);
        $fim = new DateTime($turno['hora_fim']);
        $intervalo = new DateInterval('PT1H'); // Intervalo de 1 hora

        $periodo = new DatePeriod($inicio, $intervalo, $fim); // O fim não é incluído
        foreach ($periodo as $hora) {
            $horarios_possiveis[] = $hora->format('H:i');
        }
    }
    $stmt_turnos->close();

    // 3. Busca agendamentos existentes para remover da lista
    $stmt_agendados = $conexao->prepare("SELECT TIME_FORMAT(hora_agendamento, '%H:%i') as hora FROM Agendamentos WHERE profissional_id = ? AND data_agendamento = ?");
    $stmt_agendados->bind_param("is", $id_profissional, $data);
    $stmt_agendados->execute();
    $result_agendados = $stmt_agendados->get_result();
    $horarios_ocupados = [];
    while ($row = $result_agendados->fetch_assoc()) {
        $horarios_ocupados[] = $row['hora'];
    }
    $stmt_agendados->close();
    
    // 4. Filtra e retorna os horários disponíveis
    $horarios_disponiveis = array_diff($horarios_possiveis, $horarios_ocupados);
    echo json_encode(array_values($horarios_disponiveis));

} catch (Exception $e) { /* ... Bloco de erro ... */ }
?>