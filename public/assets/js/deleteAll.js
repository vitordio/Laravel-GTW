/**
 * Ao clicar no checkbox de selecionar tudo,
 * marca todas as opções do checkbox da grid
*/
const selectAll = document.getElementById('select-all');
selectAll.onclick = function()
{
    const allInputs = document.querySelectorAll('.delete-checkbox');
    Array.from(allInputs).forEach(input =>
        this.checked ? input.checked = true : input.checked = false
    );
}

/**
 * Ao clicar no botão de excluir, deleta todos
 * os registros selecionados
*/
const buttonDeleteAll = document.getElementById('button-deleteAll');
buttonDeleteAll.onclick = function()
{
    const allInputsChecked = document.querySelectorAll('input.delete-checkbox[type="checkbox"]:checked');

    if(allInputsChecked.length > 0)
    {
        const idsClientesSelecionados = Array.from(allInputsChecked).reduce((arrInputs, inputChecked) => {
            if(inputChecked.value)
                arrInputs.push(inputChecked.value)

            return arrInputs;
        }, [])

        const url = $(this).attr('href');
        const _method = $(this).attr('data-method');
        const name = $(this).attr('data-name');

        bootbox.confirm({
            title: `${name}`,
            message: "Deseja realmente excluir o(s) cliente(s) selecionado(s) ?",
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
                        data: { data: idsClientesSelecionados, _method: _method},
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
    } else {
        bootbox.alert('Selecione ao menos um cliente para realizar a exclusão');
    }

    return false;
}