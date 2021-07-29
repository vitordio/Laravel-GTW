$(document).ready(function(){
    /**
     * Na tela de clientes e motoristas, exibe o dropdown para
     * seleção do novo padrão das colunas da tabela
     * e geraçao do xls
     */
    const isViews = ['clientes', 'motoristas'];
    const pathname = window.location.pathname;

    // Verificamos se a tela é a de clientes ou motoristas
    if(isViews.some(viewName => pathname.includes(viewName)))
    {
        setTimeout(() => {
            const dropdownPadrao = document.getElementById('padrao-grid');
            const divPaste = document.getElementById('ajax-data-table_length')
            const label = document.querySelector('#ajax-data-table_length > label')
    
            if(dropdownPadrao) dropdownPadrao.removeAttribute('hidden');
            if(divPaste) divPaste.insertBefore(dropdownPadrao, label);
            
        }, 500);
    }

    /* Atribui o select 2 aos inputs com a classe select2 */
    $(".select2").select2({
        width: '100%',
    });

    /** Adiciona a classe loaded para remover o loading */
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 500);
});

/** 
 * Inputs e botões do formulário para adicionar o modelo
*/
const routeCreateModelo = document.getElementById('routeCreateModelo');
const inputNomeModelo = document.getElementById('des_modelo');
const checkboxColunas = document.querySelectorAll('[data-colunas]');
const inputMethod = document.getElementsByName('_method');
const buttonDeleteModelo = document.getElementById('button-delete-modelo')

/**
 * Ao clicar no botão de adicionar novo modelo,
 * limpa os campos do formulário no modal, para caso
 * tenha aberto o editar e não finalizado a edição
*/
const addNewModeloButton = document.getElementById('add-new-modelo');
if(addNewModeloButton)
{
    addNewModeloButton.onclick = function()
    {
        inputNomeModelo.value = '';
        checkboxColunas.forEach(coluna => coluna.checked = false)
        inputMethod[0].value = 'POST'
        gridExcelModeloForm.action = routeCreateModelo.value;

        // Altera as informações do botão de deletar e oculta o mesmo
        buttonDeleteModelo.hidden = true;
        buttonDeleteModelo.setAttribute('data-name', '{MODELO}')
        buttonDeleteModelo.setAttribute('data-id', '{MODELO_ID}')
        buttonDeleteModelo.href = '#'
    }
}

/**
 * Para as funcionaliadades que conseguem personalizar a grid,
 * usamos o ajax para fazer o envio do formulário no Modal
*/
const gridExcelModeloForm = document.gridExcelModelo;
if(gridExcelModeloForm)
{
    gridExcelModeloForm.onsubmit = e => {
        e.preventDefault();
    
        /** Pegamos o formulário e os dados enviados com o FormData */
        const form = e.target
        const formData = new FormData(form);
    
        /** Enviamos os options para o fetch */
        const options = {
            method: form.method,
            body: new URLSearchParams(formData),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }
    
        /** Realizamos a requisição com o fetch */
        fetch(form.action, options)
            .then(resp => resp.json())
            .then(jsonRetorno => {
                /* Recebemos o json com os erros caso não passe no request */
                if(jsonRetorno.success)
                {
                    // Removemos o modal com o formulário e exibimos a mensagem de sucesso
                    $('#modeloGridExcel').modal('hide');
                    bootbox.alert({
                        message: jsonRetorno.success,
                        className: 'fadeIn',
                        callback: function(){
                            location.reload();
                        }
                    });
                } else {
                    const divAlertErrors = document.getElementById('alert-errors');
                    const divMessagesValidation = document.querySelector('#messages-validation > div')
                    
                    divMessagesValidation.textContent = '';
                    inputNomeModelo.classList.remove('is-invalid')
                    
                    let messageError = ''
                    for(let [key, value] of Object.entries(jsonRetorno.errors))
                    {
                        divAlertErrors.classList.remove('d-none')
    
                        const p = document.createElement('p');
                        p.classList.add('text-danger');
                        p.innerHTML = value
                        divMessagesValidation.appendChild(p)
    
                        if(key === 'des_modelo') inputNomeModelo.classList.add('is-invalid')
    
                        messageError += `<p class="text-danger">${value}</p>`
                    }
    
                    /** Chama a função para exibição do toast **/
                    showToastErrors('', messageError);
                }
            })
            .catch(erro => {
                console.log(erro);
            })
    }
}

/**
 * Ao clicar no ícone de engrenagem do modelo,
 * abre o modal para edição
*/
const iconEditModelo = document.getElementById('editModelo')
if(iconEditModelo)
{
    iconEditModelo.onclick = function()
    {
        // Abre o modal
        $('#modeloGridExcel').modal('show');

        const idModelo = this.getAttribute('data-modelo-id');
        const nomeModelo = this.getAttribute('data-modelo-nome')
        const routeGetModelo = this.getAttribute('data-modelo-route');
        const routeUpdateModelo = this.getAttribute('data-modelo-route-update');
        const routeDeleteModelo = this.getAttribute('data-modelo-route-delete');

        /**
         * Alteramos o valor do input do nome do modelo
         * O input hidden com o método do form
         * A action do formulário passando o ID
         */
        inputNomeModelo.value = nomeModelo
        inputMethod[0].value = 'PUT'
        gridExcelModeloForm.action = routeUpdateModelo;

        /** Altero as informações do botão de excluir para esse modelo */
        const dataNameButton = buttonDeleteModelo.getAttribute('data-name').replace('{MODELO}', nomeModelo);
        const dataIdButton = buttonDeleteModelo.getAttribute('data-id').replace('{MODELO_ID}', idModelo);

        buttonDeleteModelo.hidden = false;
        buttonDeleteModelo.setAttribute('data-name', dataNameButton)
        buttonDeleteModelo.setAttribute('data-id', dataIdButton)
        buttonDeleteModelo.href = routeDeleteModelo

        /**
         * Faz um fetch para a funcao da controller que retorna
         * o array de colunas do modelo selecionado
         */
        fetch(routeGetModelo)
            .then(modeloResp => modeloResp.json())
            .then(colunasArray => {
                /** Fazemos um foreach nos inputs das colunas, qual tiver sido selecionada no modelo, adicionamos o checked */
                checkboxColunas.forEach(coluna => {
                    if(colunasArray.indexOf(coluna.id) > -1)
                        coluna.checked = true
                })
            })
    }
}

/**
 * Toast com a mensagem dos erros de
 * validação no formulário
 * 
 * @param messageErrors
 */
function showToastErrors(titleToast, messageErrors) {
    const toastHTML = `<div class="toast fade hide" data-delay="5000">
        <div class="toast-header">
            <i class="anticon anticon-close-circle text-danger m-r-5"></i>
            <strong class="mr-auto">${(titleToast != '') ? titleToast : 'Houveram erros de validação'}</strong>
            <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            ${messageErrors}
        </div>
    </div>`

    $('#notification-toast').append(toastHTML)
    $('#notification-toast .toast').toast('show');
    setTimeout(function(){ 
        $('#notification-toast .toast:first-child').remove();
    }, 5000);
}

/**
 * Toast com a mensagem de successo
 * 
 * @param messageSuccess
 */
 function showToastSuccess(messageSuccess) {
    const toastHTML = `<div class="toast fade hide" data-delay="5000">
        <div class="toast-header">
            <i class="anticon anticon-close-circle text-success m-r-5"></i>
            <strong class="mr-auto text-success">${messageSuccess}</strong>
            <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>`

    $('#notification-toast').append(toastHTML)
    $('#notification-toast .toast').toast('show');
    setTimeout(function(){ 
        $('#notification-toast .toast:first-child').remove();
    }, 5000);
}

// **************** LOGOUT BUTTON ********************//
document.getElementById('btn-logout').onclick = function() {
    const url = this.getAttribute('date-route');
    bootbox.confirm({
        title: 'Sair',
        message: "Deseja realmente sair do sistema?",
        className: 'fadeIn',
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i> Sim',
            },
            cancel: {
                label: '<i class="fa fa-times"></i> Não',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if(result)
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url,
                    type: 'POST',
                    data: { _method: 'POST' },
                    success: function(data){
                        if(data && data.urlLogin)
                        {
                            location.href = data.urlLogin
                        }
                    },
                    error:function(error){
                        console.log(error);
                    },
                });
            }
        }
    });
    return false;
}

// **************** DELETE BUTTONS ********************//
function deleteRegister(button) {
    const codigo = button.getAttribute('data-id');
    const url = button.getAttribute('data-href');
    const _method = button.getAttribute('data-method');
    const item = button.getAttribute('data-item');
    const name = button.getAttribute('data-name');

    /**
     * No caso dos modelos de grid que excluímos pelo botão no modal,
     * ao clicar no botão de delete, retiramos o modal
    */
    if(item === 'Modelo da grid') $('#modeloGridExcel').modal('hide');

    bootbox.confirm({
        title: `Excluir ${item} ${name}`,
        message: "Deseja realmente excluir este item ?",
        className: 'fadeIn',
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i> Sim',
            },
            cancel: {
                label: '<i class="fa fa-times"></i> Não',
                className: 'btn-default'
            }
        },
        callback: function (result) {
            if(result)
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { data: codigo, _method: _method},
                    success: function(data){
                        bootbox.alert({
                            message: data.message,
                            className: 'fadeIn',
                            callback: function(){
                                if(data.urlRedirect) window.location.href = data.urlRedirect;
                                else location.reload();
                            }
                        });
                    },
                    error:function(error){
                        console.log(error);
                    },
                });
            }
        }
    });

    return false;
}