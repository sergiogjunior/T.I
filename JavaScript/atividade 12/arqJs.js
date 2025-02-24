function calcularVel(){

    let velocidade = window.document.getElementById('velocidade');
    let resposta = window.document.getElementById('resposta');
    let vel = Number(velocidade.value);

    if (vel <= 40){
        resposta.innerText = 'Você está dentro da velocidade permitida.'
    } else if (vel > 40 && vel < 100){
        resposta.innerHTML = 'Vai com calma amigão, você vai ser <strong>multado!</strong>'
    } else {
        resposta.innerHTML = 'Vai com calma amigão, seu carro vai ser <strong>apreendido!</strong>'
    }
    
}