/** Ao carregar a página de consulta, exibe o saldo do pacote CPF e CNPJ */
$(document).ready(function(){
    const textSaldoCPF = document.getElementById('num_consultas_cpf');
    const textSaldoCNPJ = document.getElementById('num_consultas_cnpj');
    
    // Pegamos os valores definidos nos inputs hidden
    const endpoint = document.getElementById('endpoint').value;
    const token = document.getElementById('token').value;
    const pacoteCPF = document.getElementById('pacote_cpf').value;
    const pacoteCNPJ = document.getElementById('pacote_cnpj').value;

    // Consulta do saldo do CPF
    const endPointCPF = endpoint.replace('{token}', token)
                                .replace('{pacote}', pacoteCPF)
    fetch(endPointCPF)
        .then(resp => resp.json())
        .then(saldoCPF => {
            if(saldoCPF)
                textSaldoCPF.innerHTML = saldoCPF.pacote.saldo
        })

    // Consulta do saldo do CNPJ
    const endPointCNPJ = endpoint.replace('{token}', token)
                                .replace('{pacote}', pacoteCNPJ)
    fetch(endPointCNPJ)
        .then(resp => resp.json())
        .then(saldoCNPJ => {
            if(saldoCNPJ)
                textSaldoCNPJ.innerHTML = saldoCNPJ.pacote.saldo
        })
});

/** Ao clicar no ícone de copiar do input, copia o value **/
const copyIcons = document.querySelectorAll('div.input-affix > a')
copyIcons.forEach(copyIcon => copyIcon.addEventListener('click', copyText));

/**
 * Pegamos o previousElementSibling do ícone, que é justamente o input,
 * para realizar a cópia do valor
 */
function copyText() {
    const input = this.previousElementSibling
    
    /* Selecionamos o texto do input */
    input.select();
    input.setSelectionRange(0, 99999); /* Para celulares */

    /* Copiamos o valor de dentro do input */
    document.execCommand("copy");

    // Exibimos o toast informando que o texto foi copiado
    showToastSuccess('Texto copiado com sucesso.');
}