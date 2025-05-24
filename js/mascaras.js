// Mascara CPF       
function CPF(cpf) {

    let valor = cpf.value || cpf.textContent;

    let v = valor.replaceAll('.', '').replaceAll('-', '').replace(/\D/g, '');      
    if (v.length > 3) v = v.substring(0, 3) + '.' + v.substring(3);
    if (v.length > 7) v = v.substring(0, 7) + '.' + v.substring(7);
    if (v.length > 11) v=  v.substring(0, 11) + '-' + v.substring(11, 13);

    if (cpf.value !== undefined) {
        cpf.value = v;
    } else {
        cpf.textContent = v;
    }
};

// Mascara TELEFONE
function TEL(tel){

    let valor = tel.value || tel.textContent;

    let v = valor.replace(/\D/g, '');
    if (v.length > 2) v = '(' + v.slice(0, 2) + ') ' + v.slice(2);
    if (v.length > 7) v = v.slice(0, 10) + '-' + v.slice(10, 14);
    
    if (tel.value !== undefined) {
        tel.value = v;
    } else {
        tel.textContent = v;
    }
};

// Mascara CEP
function CEP(cep) {
    let valor = cep.value || cep.textContent;
    let v = valor.replaceAll('-', '');
    if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5, 8); 

    if (cep.value !== undefined) {
        cep.value = v;
    } else {
        cep.textContent = v;
    }
};  

//// Mascara MOEDA

function MOEDA(moeda) {
    let valor = elemento.value || elemento.textContent;

    let v = valor.replace(/\D/g, '');
    if (v.length === 0) v = '0';
    let formato = (parseInt(v) / 100).toFixed(2);
    let moedaFormatada = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(formato);

    if (elemento.value !== undefined) {
        moeda.value = moedaFormatada;
    } else {
        moeda.textContent = moedaFormatada;
    }
};

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.cpf').forEach(function (el) {
        CPF(el);
    });

    document.querySelectorAll('.tel').forEach(function (el) {
        TEL(el);
    });

    document.querySelectorAll('.cep').forEach(function (el) {
        CEP(el);
    });

    document.querySelectorAll('.moeda').forEach(function (el) {
        MOEDA(el);
    });
});


        
