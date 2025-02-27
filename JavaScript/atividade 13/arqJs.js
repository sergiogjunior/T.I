function VerfNacionalidade(){
    let nacionalidade = window.document.getElementById('nacionalidade')
    let escolha = String(nacionalidade.value)
    let nasc = window.document.getElementById('nasc')

    switch(escolha){
        case '0':
            nasc.innerText = 'Domingo'
    }
}