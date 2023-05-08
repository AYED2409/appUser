const aumentar = document.getElementById('aumentarEtiqueta');
const listaEtiquetas = document.getElementById('listaEtiquetas');
const input = document.getElementById('etiquetas');
const inputEtiquetas = document.getElementById('etiqueta');
const btnEnviar = document.getElementById('enviar');
const btnsEliminar = document.querySelectorAll('.eliminar');

var res = "";
aumentar.addEventListener('click', () => {
    if(input.value == "" ) {
        input.setAttribute('placeholder','la etiqueta debe ser una palabra');
    }else {
        var divEtiqueta = document.createElement('div');
        divEtiqueta.setAttribute('id',input.value);
        divEtiqueta.classList.add('etiqueta');
        divEtiqueta.classList.add('d-flex');
        divEtiqueta.dataset.value = input.value;
        var divValor = document.createElement('div');
        var divEliminar = document.createElement('div');
        divEliminar.setAttribute('class','btn btn-danger eliminar');
        divEliminar.textContent = "x";
        divValor.textContent = input.value;
        divValor.classList.add('p-2');
        divEtiqueta.appendChild(divValor);
        divEtiqueta.appendChild(divEliminar);
        listaEtiquetas.appendChild(divEtiqueta);  
        input.setAttribute('placeholder','');
        input.value = "";
    }
    
})

btnEnviar.addEventListener('click', () => {
    getEtiquetas();
})

const getEtiquetas = () => {
    var etiquetas = document.querySelectorAll('.etiqueta');
    etiquetas.forEach( etiqueta => {
        res = res + " " + etiqueta.dataset.value
    })
    inputEtiquetas.value = res;
}

document.addEventListener('click', (e) => {
    if(e.target.matches('.eliminar')) {
        let padre = e.target.parentNode;
        listaEtiquetas.removeChild(padre);
    }
})