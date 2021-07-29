const CPF = 'CPF';
const CNPJ = 'CNPJ';

const placeHolders = {
    mask_cpf: '___.___.___-__',
    mask_cnpj: '__.___.___/____-__',
}

// EndPoint do IBGE para consulta de municípios por UF
const ENDPOINT_MUNICIPIOS_IBGE = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/{UF}/municipios';

// Input com o método do form
const formMethod = document.querySelector('[name=_method]');

// Inputs de CPF/CNPJ
const inputTipoCliente = document.getElementById('tipo_cliente');
const inputCPFCNPJ = document.getElementById('des_cpf_cnpj');

// Input dos dados do cliente
const inputNome = document.getElementById('des_nome');
const inputNomeFantasia = document.getElementById('des_nome_fantasia');
const inputTelefone = document.getElementById('des_telefone');
const inputTipoAtividade = document.getElementById('id_tipo_atividade');
const inputEmail = document.getElementById('des_email');

// Inputs de Endereço
const divCep = document.getElementById('divCep');

const inputCEP = document.getElementById('des_cep');
const inputLogradouro = document.getElementById('des_logradouro');
const inputBairro = document.getElementById('des_bairro');
const inputCidade = document.getElementById('des_municipio');
const inputUF = document.getElementById('des_uf');
const inputNumero = document.getElementById('des_numero');
const inputComplemento = document.getElementById('des_complemento');

/** 
 * Ao selecionar algum país, atualiza o campo de estado
 * Se não for o Brasil, seleciona EX no UF e Exterior no munícipio
*/
const inputPais = document.getElementById('des_pais');

// Expressão regular para validar o CEP.
const validacep = /^[0-9]{5,5}([- ]?[0-9]{3,3})?$/;

// URL API Via Cep
const targetURL = 'https://viacep.com.br/ws/';

// Input checkbox para marcação da isenção
const inputFlgIsento = document.getElementById('flg_isento');
const inputInscricaoEstadual = document.getElementById('des_inscricao_estadual');

// Input checkbox para habilitar ou desabilitar o campo de divisão
const inputFlgHabilitar = document.getElementById('flg_habilitar');
const inputDivisao = document.getElementById('des_divisao');

/** Ao clicar no botão, chamamos a função para adicionar mais e-mails **/
const btnAddEmailsAlternativos = document.getElementById('add-emailsAlternativos');
btnAddEmailsAlternativos.onclick = addAlternativeEmails;

/**
 * Chamamos as funções ao carregar a página
*/
$(document).ready(function() {
    /** Chama a função apenas no cadastro **/
    if(formMethod.value == 'POST' && inputInscricaoEstadual.value === '')
        updateInscricaoEstadual()
});

/**
 * Altera a máscara de CPF e CNPJ
 * ao clicar no campo select
*/
inputTipoCliente.onchange = function()
{
    if(this.value == CPF)
    {
        inputCPFCNPJ.placeholder = placeHolders.mask_cpf
        inputCPFCNPJ.classList.remove('cnpj')
        inputCPFCNPJ.classList.add('cpf')

        // Altera a máscara
        $('.cpf').mask('000.000.000-00');
        
    } else {
        inputCPFCNPJ.placeholder = placeHolders.mask_cnpj
        inputCPFCNPJ.classList.remove('cpf')
        inputCPFCNPJ.classList.add('cnpj')

        // Altera a máscara
        $('.cnpj').mask('000.000.000/0000-00');
    }

    // Chama a função para marcar o campo de inscrição estadual como ISENTO, caso seja CPF
    updateInscricaoEstadual();
}

/**
 * Preenche automáticamente os campos do formulário
 * de acordo com o CPF ou CNPJ digitados
*/
inputCPFCNPJ.onblur = async function()
{
    let route = document.getElementById('routeCPFCNPJ').value
    const cpfCnpj = this.value.replace(/[^\d]+/g,'');

    if(cpfCnpj) {
        route = route.replace(':cpfCnpj', cpfCnpj);
    
        fetch(route)
            .then(resp => resp.json())
            .then(dadosCliente => preencheCamposCliente(dadosCliente))
    }
}

/**
 * Ao clicar no checkbox atribui o valor
 * do campo inscrição estadual como 'ISENTO'
*/
inputFlgIsento.onchange = function()
{
    if(this.checked) {
        inputInscricaoEstadual.value = 'ISENTO'
        inputInscricaoEstadual.readOnly = true
    } else {
        inputInscricaoEstadual.value = '';
        inputInscricaoEstadual.readOnly = false
    }
}

/**
 * Ao clicar no checkbox habilita
 * o campo de divisão para digitação
*/
inputFlgHabilitar.onchange = function()
{
    if(this.checked) inputDivisao.readOnly = false
    else inputDivisao.readOnly = true
}

/**
 * Faz a consulta do CEP na API do ViaCep
*/
inputCEP.onblur = function()
{
    // Deixamos apenas os números
    const cep = this.value.replace(/\D/g, '');

    /**
     * Valida o formato do CEP
     * 
     * Caso não passe na validação, não exibimos mensagem de erro
     * pois pode ser um CEP estrangeiro sendo cadastrado
     */
    if(validacep.test(cep) && cep.length == 8) {

        // Monta a URL com o CEP
        const url = `${targetURL}${cep}/json`;

        // Chamada da API
        fetch(url)
            .then(resp => resp.json())
            .then(json => preencheCamposEndereco(json))
            .catch(e => {
                limpaFormularioCep('cepNaoEncontrado')

                /** Chama a função para remover o read only nos campos de endereço */
                readOnlyInputsEndereco(false);
            } )
    } else if(cep.length === 0)
    {
        limpaFormularioCep('cepInvalido')

        /** Chama a função para remover o read only nos campos de endereço */
        readOnlyInputsEndereco(false);
    } else {
        /** Chama a função para remover o read only nos campos de endereço */
        readOnlyInputsEndereco(false);
    }
}

/**
 * Função para preenchimento dos campos
 * de endereço do cliente
 */
function preencheCamposEndereco(jsonEndereco)
{
    inputCEP.classList.remove('is-invalid')

    if(jsonEndereco.erro)
    {
        limpaFormularioCep('cepNaoEncontrado')

        /** Chama a função para remover o read only nos campos de endereço */
        readOnlyInputsEndereco(false);
    } else {
        // Chama a função passando nenhum parâmetro, para remover o erro do input
        limpaFormularioCep();

        //Atualiza os campos com os valores.
        if (jsonEndereco.uf)
        {
            inputUF.value = jsonEndereco.uf;
            $(inputUF).trigger('change');
        }

        if (jsonEndereco.logradouro)
        {
            inputLogradouro.value = jsonEndereco.logradouro;
        } else {
            inputLogradouro.value = '';
        }
    
        if (jsonEndereco.bairro)
        {
            inputBairro.value = jsonEndereco.bairro;
        } else {
            inputBairro.value = '';
        }

        /** Espera um tempo para popular os campos **/
        setTimeout(() => {
            if (jsonEndereco.localidade)
            {
                inputCidade.value = jsonEndereco.localidade;
                $(inputCidade).trigger('change');
            }
        }, 5 * 100);
    
        /**
         * Como utilizamos a API do ViaCep, só trará CEPs do Brasil,
         * portanto, preenchemos automaticamente o campo país com Brasil
         */
        if(jsonEndereco.pais)
        {
            inputPais.value = jsonEndereco.pais;
        } else {
            inputPais.value = 'Brasil';
        }

        $(inputPais).trigger('change');

        /** Chama a função para remover o read only nos campos de endereço */
        readOnlyInputsEndereco();
    }
}
 
/**
 * Limpa os campos de endereço do formulário
 */
function limpaFormularioCep(erroCep = '') {
    const divError = document.querySelectorAll('#divCep > div.invalid-feedback').length === 0 ? document.createElement('div') : document.querySelector('#divCep > div.invalid-feedback');
    divError.classList.add('invalid-feedback');
    divError.innerHTML = erroCep

    if(erroCep) {
        inputCEP.classList.add('is-invalid')
        cepError = (erroCep == 'cepNaoEncontrado') ? 'CEP não encontrado.' : 'CEP inválido.';
        divError.style.display = 'block'

    } else {
        inputCEP.classList.remove('error')
        cepError = '';
        divError.style.display = 'none'
    }

    divError.innerHTML = cepError

    if(document.querySelectorAll('#divCep > div.invalid-feedback').length === 0)
    {
        divCep.appendChild(divError);
    }

    inputLogradouro.value = '';
    inputBairro.value = '';

    inputPais.value = '';
    $(inputPais).trigger('change');

    inputCidade.value = '';
    $(inputCidade).trigger('change');

    inputUF.value = 'AC';
    $(inputUF).trigger('change');
}

/** Função para atribuir ou remover o readonly nos campos de endereço */
function readOnlyInputsEndereco(flgAddReadOnly = true)
{
    if(flgAddReadOnly)
    {
        inputLogradouro.value ? inputLogradouro.readOnly = true : inputLogradouro.readOnly = false
        inputBairro.value ? inputBairro.readOnly = true : inputBairro.readOnly = false

        /** No caso dos inputs select2, adicionamos a classe criada para visualização correta do readonyl */
        inputCidade.classList.add('readOnlySelect2')
        inputPais.classList.add('readOnlySelect2')
        inputUF.classList.add('readOnlySelect2')
    } else {
        inputLogradouro.readOnly = false
        inputBairro.readOnly = false

        /** No caso dos inputs select2, removemos a classe criada para visualização correta do readonyl */
        inputCidade.classList.remove('readOnlySelect2')
        inputPais.classList.remove('readOnlySelect2')
        inputUF.classList.remove('readOnlySelect2')
    }
}

/** Atualiza os campos de estado e munícipio ao alterar o país */
inputPais.onchange = function()
{
    if(this.value != 'Brasil')
    {
        inputUF.value = 'EX';
        $(inputUF).trigger('change');

        /**
         * Chama a função para popular o campo com EXTERIOR
        */
        populateOptionsCidades([{ nome: 'EXTERIOR' }]);
        
        inputCidade.value = 'EXTERIOR';
        $(inputCidade).trigger('change');

        inputLogradouro.value = '';
        inputBairro.value = '';

    } else
    {
        inputUF.value = inputUF.value != 'EX' ? inputUF.value : 'AC';
        $(inputUF).trigger('change');

        inputCidade.value =  inputCidade.value != 'EXTERIOR' ? inputCidade.value : '';
        $(inputCidade).trigger('change');

        inputLogradouro.value = inputLogradouro.value ? inputLogradouro.value : '';
        inputBairro.value = inputBairro.value ? inputBairro.value : '';
    }
}

/**
 * Popula o campo do munícipio de acordo com a UF selecionada
*/
inputUF.onchange = function()
{
    if(this.value != 'EX')
    {
        const endPoint = ENDPOINT_MUNICIPIOS_IBGE.replace('{UF}', this.value)
        fetch(endPoint)
            .then(resp => resp.json())
            .then(municipios => populateOptionsCidades(municipios))
    }
}

/**
 * Função para popular os options do select
 * de municípios de acordo com a UF ou país selecionado
*/
function populateOptionsCidades(options)
{
    const optionsCidades = document.querySelectorAll(`#${inputCidade.id} option`)
    optionsCidades.forEach(opcoes => opcoes.value ? opcoes.remove() : '');

    options.forEach(cidade => {
        const option = document.createElement('option');

        option.value = cidade.nome
        option.innerHTML = cidade.nome

        inputCidade.appendChild(option)
    })
}

/**
 * Função que preenche o campo de inscrição estadual
 * como ISENTO caso seja CPF e bloqueia o mesmo
*/
function updateInscricaoEstadual()
{
    if(inputTipoCliente.value == CPF)
    {
        inputInscricaoEstadual.value = 'ISENTO'
        inputInscricaoEstadual.readOnly = true
        inputFlgIsento.checked = true
    } else {
        inputInscricaoEstadual.value = ''
        inputInscricaoEstadual.readOnly = false
        inputFlgIsento.checked = false
    }
}

/**
 * Função para adicionar e-mails ao clicar
 * no botão para adicionar e-mails alternativos
*/
function addAlternativeEmails()
{
    const contador = Array.from(document.querySelectorAll('[data-email-alternativo]'));
    const totalEmails = contador.filter(email => (!email.id.includes('copy')));
    const idLinha = totalEmails.length;

    /** Pegamos a linha utilizada para cópia */
    const divCopy = document.getElementById('row-emailsAlternativos_copy');

    const copy = divCopy.outerHTML.replace(/copy/g, `${idLinha}`);

    /** Linha onde iremos realizar o append */
    const divEmails = document.getElementById('row_emails');

    divEmails.insertAdjacentHTML('beforeend', copy);

    /** Removemos o hidden da linha e o disabled do input */
    document.getElementById(`row-emailsAlternativos_${idLinha}`).removeAttribute('hidden');
    document.getElementById(`des_email_alternativo_${idLinha}`).disabled = false
}

/** Função para remover a linha do e-mail */
function removeEmail(idLinha)
{
    let idLinhaEmail = idLinha.split('_')
    idLinhaEmail = idLinhaEmail[idLinhaEmail.length - 1]

    // Removemos a linha do email adicional na posição idLinhaEmail
    document.getElementById(`row-emailsAlternativos_${idLinhaEmail}`).remove();
}

/** Função para preencher os campos do cliente após a busca ajax do CPF/CNPJ digitados */
function preencheCamposCliente(dadosCliente)
{
    if(Object.keys(dadosCliente.cliente).length !== 0 && !dadosCliente.cliente.erro) {
        // Se não foi necessária a consulta na API, informamos no toast
        if(dadosCliente.hasCliente)
            showToastSuccess('Não foi necessária a consulta na API pois o cliente já está cadastrado no banco de dados.');

        inputInscricaoEstadual.value = dadosCliente.cliente.des_inscricao_estadual ? dadosCliente.cliente.des_inscricao_estadual : 'ISENTO';
        inputNome.value = dadosCliente.cliente.des_nome ? dadosCliente.cliente.des_nome : '';
        inputNomeFantasia.value = dadosCliente.cliente.des_nome_fantasia ? dadosCliente.cliente.des_nome_fantasia : '';
        inputDivisao.value = dadosCliente.cliente.des_divisao ? dadosCliente.cliente.des_divisao : '';
        inputTelefone.value = dadosCliente.cliente.des_telefone ? dadosCliente.cliente.des_telefone : '';
        inputEmail.value = dadosCliente.cliente.des_email ? dadosCliente.cliente.des_email : '';
        inputTipoAtividade.value = dadosCliente.cliente.id_tipo_atividade ? dadosCliente.cliente.id_tipo_atividade : inputTipoAtividade.value;
        inputCEP.value = dadosCliente.cliente.des_cep ? dadosCliente.cliente.des_cep : '';

        // Montamos o JSON de endereço e chamamos a função
        const jsonEndereco = {
            cep: dadosCliente.cliente.des_cep ? dadosCliente.cliente.des_cep : '',
            logradouro: dadosCliente.cliente.des_logradouro ? dadosCliente.cliente.des_logradouro : '',
            complemento: dadosCliente.cliente.des_complemento ? dadosCliente.cliente.des_complemento : '',
            bairro: dadosCliente.cliente.des_bairro ? dadosCliente.cliente.des_bairro : '',
            localidade: dadosCliente.cliente.des_municipio ? dadosCliente.cliente.des_municipio : '',
            uf: dadosCliente.cliente.des_uf ? dadosCliente.cliente.des_uf : '',
            numero: dadosCliente.cliente.des_numero ? dadosCliente.cliente.des_numero : '',
            pais: dadosCliente.cliente.des_pais ? dadosCliente.cliente.des_pais : '',
        };

        preencheCamposEndereco(jsonEndereco);
    } else {
        /** Chama a função para exibição do toast com o erro da API **/
        showToastErrors('Erro na consulta do CPF/CNPJ', dadosCliente.cliente.erro);
    }
}

/**
 * Ação para criar novos registros para o campo
 * "Tipo atividade", é aberto um modal para preenchimento do form
 * 
 * Ao clicar no submit, enviamos via ajax e verificamos se está tudo certo,
 * caso sim, atualizamos o combobox com os tipos de atividade
 */
const formNewTipoAtividade = document.modalFormNewTipoAtividade
if(formNewTipoAtividade)
{
    formNewTipoAtividade.onsubmit = e => {
        e.preventDefault();
    
        /** Pegamos o formulário e os dados enviados com o FormData */
        const form = e.target
        const formData = new FormData(form);
        const inputModalTipoAtividade = document.getElementById('des_atividade');

        $.ajax({
            type: form.method,
            url: form.action,
            data: new URLSearchParams(formData),
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                // Removemos o modal com o formulário e exibimos a mensagem de sucesso
                $('#modalFormNewTipoAtividade').modal('hide');
                bootbox.alert({
                    message: data.success,
                    className: 'fadeIn',
                });

                // Limpamos o input
                inputModalTipoAtividade.value = '';

                // Chamamos a função para popular os optios do select do tipo atividade
                populateOptionsTipoAtividade(data.tipoAtividade);
            },
            error: function(data) {
                const divAlertErrors = document.getElementById('alert-errors');
                const divMessagesValidation = document.querySelector('#messages-validation > div')

                divMessagesValidation.textContent = '';
                inputModalTipoAtividade.classList.remove('is-invalid')
                    
                let messageError = ''
                for(let [key, value] of Object.entries(data.responseJSON.errors))
                {
                    divAlertErrors.classList.remove('d-none')

                    const p = document.createElement('p');
                    p.classList.add('text-danger');
                    p.innerHTML = value
                    divMessagesValidation.appendChild(p)

                    if(key === 'des_modelo') inputModalTipoAtividade.classList.add('is-invalid')

                    messageError += `<p class="text-danger">${value}</p>`
                }
    
                /** Chama a função para exibição do toast **/
                showToastErrors('', messageError);
            }

        });
    }
}

/** 
 * Após o preenchimento do novo tipo de atividade no modal,
 * recebemos a lista atualizada com todos os tipos de atividade,
 * e populamos novamente o select
 */
function populateOptionsTipoAtividade(arrTipoAtividade)
{
    // Pegamos o option que estava selecionado anteriormente para manter na seleção
    const oldOptionSelected = inputTipoAtividade.value

    const optionsTipoAtividade = document.querySelectorAll(`#${inputTipoAtividade.id} option`)
    optionsTipoAtividade.forEach(opcoes => opcoes.remove());
    
    arrTipoAtividade.forEach(tipoAtividade => {
        const option = document.createElement('option');

        option.value = tipoAtividade.id
        option.innerHTML = tipoAtividade.des_atividade

        if(tipoAtividade.id == oldOptionSelected) option.selected = true;
        inputTipoAtividade.appendChild(option)

    })
}