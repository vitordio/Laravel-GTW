window.onload = function () {
    // Seleciona todos os inputs da linha ao clicar no checkbox 'todos'
    const inputTodos = document.querySelectorAll('input[data-id="selecionar_todos"]')

    for(const input of inputTodos) {
        input.onchange = e => checkAll(e);
    }
};

// Adiciona o checked em todas as opções da linha
function checkAll(inputTodos) {
    const infoInput = inputTodos.target.id.split('_')
    const idLinha = infoInput[infoInput.length - 1]

    const inputsLinha = document.querySelectorAll(`input[data-id=flg_submenu_${idLinha}]`)
    for(const inputs of inputsLinha) inputs.checked = inputTodos.target.checked;
}