<?php
header('Content-Type: application/json');
include 'config.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['id_profissional']) || empty($data['id_servico']) || empty($data['data_agendamento']) || empty($data['hora_agendamento'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
    exit;
}

$cliente_id = $_SESSION['usuario_id'];
$id_profissional = $data['id_profissional'];
$id_servico = $data['id_servico'];
$data_agendamento = $data['data_agendamento'];
$hora_agendamento = $data['hora_agendamento'];

try {
    // --- LINHA CORRIGIDA AQUI ---
    $sql = "INSERT INTO Agendamentos (cliente_id, profissional_id, servico_id, data_agendamento, hora_agendamento) 
            VALUES (?, ?, ?, ?, ?)"; // Trocado 'id_profissional' por 'profissional_id'
    
    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("iiiss", 
        $cliente_id, 
        $id_profissional, 
        $id_servico, 
        $data_agendamento, 
        $hora_agendamento
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Agendamento realizado com sucesso!']);
    } else {
        throw new Exception("Não foi possível salvar o agendamento.");
    }

} catch (Exception $e) {
    http_response_code(500);
    if ($conexao->errno == 1062) {
        echo json_encode(['success' => false, 'message' => 'Este horário já foi reservado. Por favor, escolha outro.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()]);
    }

} finally {
    if (isset($stmt)) $stmt->close();
    $conexao->close();
}
?>