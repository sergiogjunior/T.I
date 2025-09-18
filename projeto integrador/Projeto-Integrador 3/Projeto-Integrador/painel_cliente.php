<?php
// A PRIMEIRA COISA a se fazer é chamar o nosso guardião de acesso.
// Se o usuário não estiver logado, o script para aqui e ele é redirecionado.
require_once 'validador_acesso.php';

// Se o script continuou, significa que o usuário está logado.
// Agora, incluímos o cabeçalho padrão da página.
include 'templates/header.php';
?>

<div class="painel-container">
    
    <div class="painel-header">
        <h1>Olá, <?php echo htmlspecialchars(explode(' ', $_SESSION['usuario_nome'])[0]); ?>!</h1>
        <p>Seja bem-vindo(a) ao seu espaço. O que vamos fazer hoje?</p>
    </div>

    <div class="painel-opcoes">
        <a href="agendamento.php" class="opcao-card">
            <i class="bi bi-calendar-plus"></i>
            <h2>Agendar um Horário</h2>
            <p>Escolha um serviço e veja os horários disponíveis.</p>
        </a>

        <a href="meus_agendamentos.php" class="opcao-card">
            <i class="bi bi-card-list"></i>
            <h2>Meus Agendamentos</h2>
            <p>Veja seu histórico e seus próximos agendamentos.</p>
        </a>

        <a href="meu_perfil.php" class="opcao-card">
            <i class="bi bi-person-circle"></i>
            <h2>Meu Perfil</h2>
            <p>Atualize seus dados de contato e informações.</p>
        </a>
    </div>

</div>

<?php
// Inclui o rodapé padrão da página
include 'templates/footer.php';
?>