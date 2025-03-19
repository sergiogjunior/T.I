function executarDesafio() {
    let qtd = parseInt(prompt("Quantos números deseja digitar?"));
    let numeros = [];

    for (let i = 0; i < qtd; i++) {
        let numero = parseInt(prompt(`Digite o ${i + 1}º número:`));
        numeros.push(numero);
    }

    numeros.push(10);

    numeros.sort((a, b) => a - b);

    let index10 = numeros.indexOf(10);

    document.getElementById("resultado").innerHTML = `
        <strong>Números digitados (ordenados):</strong> ${numeros.join(", ")}<br>
        <strong>Quantidade de números digitados:</strong> ${qtd}<br>
        <strong>Posição do número 10:</strong> ${index10}
    `;
}
