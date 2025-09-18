// Espera o HTML ser completamente carregado para rodar o script
// É uma boa prática para garantir que todos os elementos (botões, etc.) já existam
document.addEventListener('DOMContentLoaded', function() {
    
    // Seleciona os elementos do carrossel pelo ID
    const btnAnterior = document.getElementById('btn-anterior');
    const btnProximo = document.getElementById('btn-proximo');
    const viewport = document.getElementById('carrossel-viewport');
    
    // Verifica se os elementos foram encontrados antes de continuar
    if (btnAnterior && btnProximo && viewport) {
        
        // Função para rolar o conteúdo
        const rolar = (direcao) => {
            // Pega a largura visível da área dos produtos
            const scrollAmount = viewport.clientWidth;
            
            // Rola para a direita (próximo) ou esquerda (anterior)
            // A propriedade 'behavior: smooth' cria a animação de rolagem suave
            viewport.scrollBy({
                left: direcao * scrollAmount,
                behavior: 'smooth'
            });
        };

        // Adiciona o evento de clique ao botão "próximo"
        btnProximo.addEventListener('click', () => {
            rolar(1); // O valor 1 significa rolar para a direita
        });

        // Adiciona o evento de clique ao botão "anterior"
        btnAnterior.addEventListener('click', () => {
            rolar(-1); // O valor -1 significa rolar para a esquerda
        });

    } else {
        console.error("Um ou mais elementos do carrossel não foram encontrados. Verifique os IDs no HTML.");
    }
});