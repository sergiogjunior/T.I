<?php
header('Content-Type: application/json');
include 'config.php'; // Usa seu arquivo de conexão

$profissionais = [];

try {
    // A consulta agora busca os dados das tabelas Usuarios e Profissionais
    $sql = "SELECT 
                u.id, 
                u.nome, 
                p.especialidade,
                p.foto_icone_url,  -- Caminho para o ícone pequeno
                p.foto_card_url    -- Caminho para a foto grande do card
            FROM Usuarios u
            JOIN Profissionais p ON u.id = p.id
            WHERE u.tipo_usuario = 'adm'"; // Busca apenas os administradores (trancistas)
            
    $result = $conexao->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        $profissionais[] = $row;
    }

    echo json_encode($profissionais);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar profissionais: ' . $e->getMessage()]);
} finally {
    if (isset($conexao)) {
        $conexao->close();
    }
}
?>