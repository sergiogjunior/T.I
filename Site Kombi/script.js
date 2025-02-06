// Adicionando interatividade para o botão "Leia mais"
const buttons = document.querySelectorAll('.ler-mais');

buttons.forEach(button => {
    button.addEventListener('click', () => {
        alert("Você está sendo redirecionado para a postagem completa!");
        // Aqui, você pode redirecionar para outra página ou expandir o conteúdo
    });
});

// Comentário: Adicionando funcionalidade básica para envio de comentários
const formComentario = document.querySelector('.form-comentarios');
formComentario.addEventListener('submit', function(event) {
    event.preventDefault();
    const comentarioTexto = document.getElementById('comentario').value;
    alert("Comentário enviado: " + comentarioTexto);
    // Adicionar a lógica para processar e exibir o comentário
});
