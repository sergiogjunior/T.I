<?php

include(__DIR__ . '/templates/header.php');

ini_set('display_errors', 1); error_reporting(E_ALL);
// Inclui seu cabeçalho
// Assumindo que o header.php está na pasta /templates/

$page_scripts = ['src/JS/carrossel.js'];

// --- ESTRUTURA DE DADOS CORRIGIDA ---
// No futuro, estes dados virão da tabela `Servicos` do seu banco de dados.
$servicos = [
    [
        'id' => 1,
        'imagem' => 'src/image/caixa1.jpg',
        'nome_servico' => 'Tranças Box Braids', // Chave correta
        'preco' => 250.00 // Preço como número com PONTO
    ],
    [
        'id' => 2,
        'imagem' => 'src/image/caixa2.jpg',
        'nome_servico' => 'Tranças Nagô', // Chave correta
        'preco' => 80.00 // Preço como número com PONTO
    ],
    [
        'id' => 3,
        'imagem' => 'src/image/caixa3.jpg',
        'nome_servico' => 'Manutenção de Dreads', // Chave correta
        'preco' => 150.00 // Preço como número com PONTO
    ],
    [
        'id' => 4,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
    // Você pode adicionar mais serviços aqui
    [
        'id' => 5,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
    [
        'id' => 6,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
    [
        'id' => 7,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
    [
        'id' => 8,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
    [
        'id' => 9,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
    [
        'id' => 10,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
    [
        'id' => 11,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
    [
        'id' => 12,
        'imagem' => 'src/image/caixa4.jpg',
        'nome_servico' => 'Crochet Braids', // Chave correta
        'preco' => 200.00 // Preço como número com PONTO
    ],
];

$produtos = [
    [
        'imagem' => 'src/image/Produto 1.png',
        'info' => '25 Anéis Para Tranças Box Braids Dreads Para Cabelo Prata.',
        'preco' => 13.50
    ],
    [
        'imagem' => 'src/image/Produto 2.png',
        'info' => 'Pomada Modeladora para Tranças e Baby Hair 150g',
        'preco' => 24.90
    ],
    [
        'imagem' => 'src/image/Produto 3.png',
        'info' => 'Jumbo para Tranças Box Braids Super X (Pacote 400g)',
        'preco' => 29.90
    ],
    [
        'imagem' => 'src/image/Produto 4.png',
        'info' => 'Agulha de Crochet Braids para Apliques (Ponta Fina)',
        'preco' => 9.90
    ],
    // Adicione mais 4 produtos para ter 8 no total
    [
        'imagem' => 'src/image/Produto 1.png',
        'info' => 'Kit de Anéis e Pingentes Dourados para Dreads',
        'preco' => 18.00
    ],
    [
        'imagem' => 'src/image/Produto 2.png',
        'info' => 'Mousse Fixador de Tranças e Penteados',
        'preco' => 35.50
    ],
    [
        'imagem' => 'src/image/Produto 3.png',
        'info' => 'Cabelo Orgânico Cacheado para Entrelace (75cm)',
        'preco' => 89.90
    ],
    [
        'imagem' => 'src/image/Produto 4.png',
        'info' => 'Touca de Cetim Difusora para Secagem de Cachos',
        'preco' => 45.00
    ]
];


?>

<section class="destaques"> <h2>Destaques</h2></section>

<section class="info">
    <?php foreach ($servicos as $servico): ?>
        <div class="item-servico">
            <div>
                <img src="<?= htmlspecialchars($servico['imagem']) ?>" alt="<?= htmlspecialchars($servico['nome_servico']) ?>">
                <h2><?= htmlspecialchars($servico['nome_servico']) ?></h2>
            </div>
            <div>
                <p>R$<?= htmlspecialchars(number_format($servico['preco'], 2, ',', '.')) ?></p>

                <div class="servico-botoes">
                    <a href="agendamento.php?servico_id=<?= $servico['id'] ?>" class="btn-servico-agendar">Ver Serviço</a>
                    <a href="#" class="btn-servico-app">Abrir no App</a>
                </div>
            </div>
        </div> 
    <?php endforeach; ?>
</section>

<section class="produtos-carrossel">
    <div class="titulo-decorado-wrapper">
        <img src="src/image/Simbolooffwhite.png" alt="Símbolo da Marca" class="logo-titulo">
        <h2 class="carrossel-titulo-com-linhas">Produtos</h2>
        <img src="src/image/Simbolooffwhite.png" alt="Símbolo da Marca" class="logo-titulo">
    </div>

    <div class="carrossel-container">
        <button id="btn-anterior" class="carrossel-btn">
            <i class="bi bi-chevron-left"></i>
        </button>

        <div id="carrossel-viewport" class="carrossel-viewport">
            <div id="produtos-grid" class="produtos-grid">
                
                <?php foreach ($produtos as $produto): ?>
                    <div class="produto-card">
                        <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['info']) ?>">
                        <p class="produto-info"><?= htmlspecialchars($produto['info']) ?></p>
                        <p class="produto-valor">R$ <?= htmlspecialchars(number_format($produto['preco'], 2, ',', '.')) ?></p>
                        <div class="produto-botoes">
                            <a href="#" class="btn-produto">Ver produto</a>
                            <a href="#" class="btn-app">Compre no App</a>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <button id="btn-proximo" class="carrossel-btn">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</section>

<?php
// Inclui seu rodapé
include 'templates/footer.php';
?>

<?php
// Inclui seu rodapé
include 'templates/footer.php';
?>