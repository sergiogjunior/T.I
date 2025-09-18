<?php
header('Content-Type: application/json');
include 'config.php';
$servicos = [];
try {
    $sql = "SELECT id, nome_servico, duracao_minutos, preco FROM Servicos ORDER BY nome_servico ASC";
    $result = $conexao->query($sql);
    while ($row = $result->fetch_assoc()) {
        $servicos[] = $row;
    }
    echo json_encode($servicos);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar serviços: ' . $e->getMessage()]);
} finally {
    if (isset($conexao)) $conexao->close();
}
?>