function calcular() {
    let preco = parseFloat(document.getElementById("preco").value);
    let tipo = document.querySelector('input[name="combustivel"]:checked').value;
    let eficiencia = parseFloat(document.getElementById("eficiencia").value) / 100;
    let resultado = document.getElementById("resultado");
   
    if (!preco || preco <= 0) {
        resultado.textContent = "Insira um valor válido.";
        return;
    }
   
    let precoLimite = tipo === "gasolina" ? preco * eficiencia : preco / eficiencia;
    resultado.textContent = `Abasteça com ${tipo === "gasolina" ? "álcool" : "gasolina"} se o preço for até R$ ${precoLimite.toFixed(2)}.`;
}
 