function horario(){
    let agora = new Date()
    let hora = agora.getHours()
    let minuto = agora.getMinutes()
    let horas = window.document.getElementById('horas')
    let img = window.document.getElementById('imagem')
    let corpo = window.document.getElementById('corpo')

    //hora=0;

    if (hora >= 0 && hora <= 5) {
        horas.innerText = `Boa madrugada, agora são ${hora} hora ${minuto} min!`
        img.src = 'Madrugada.jpg'
        corpo.style.backgroundColor= '#010101'
    } else if (hora < 12) {
        horas.innerText = `Bom dia, agora são ${hora} hora ${minuto} min!`
        img.src = 'Manha.jpg'
        corpo.style.backgroundColor= '#F7CD02'
    } else if (hora < 18) {
        horas.innerText = `Boa tarde, agora são ${hora} hora ${minuto} min!`
        img.src = 'Tarde.jpg'
        corpo.style.backgroundColor= '#AF2B00'
    } else {
        horas.innerText = `Boa noite, agora são ${hora} hora ${minuto} min!`
        img.src = 'Noite.jpg'
        corpo.style.backgroundColor= '#0E0F22'
    }
}