const txtEmpresa = document.getElementById('txtEmpresa')
const txtClienteId = document.getElementById('txtClienteId')
const tbFiliais = document.getElementById('tbFiliais')
const btnEdit = document.getElementById('btnEdit')
const customModal = document.getElementById('customModal')
const btnSaveCnpj = document.getElementById('btnSaveCnpj')
const btnSaveCliente = document.getElementById('btnSaveCliente')
const btnDelCliente = document.getElementById('btnDelCliente')
const btnClose = document.getElementById('btnClose')
const btnNovo = document.getElementById('btnNovo')
const divCnpjs = document.getElementById('divCnpjs')

const modalTitle = document.getElementById('modalTitle')
const cnpjId = document.getElementById('cnpjId')
const txtCnpj = document.getElementById('txtCnpj')
const txtFilial = document.getElementById('txtFilial')
const selStatusCnpj = document.getElementById('selStatusCnpj')

fillTable()

btnSaveCliente.addEventListener('click', evt => {
    if(! checkEmpresaFields()) return

    const cliente = {
        _token : document.getElementsByName('_token')[1].value.trim(),
        razao_social : txtEmpresa.value.trim(),
        ativo : selStatus.value.trim()
    }

    // document.getElementById('frmCliente').submit()

    if(txtClienteId.value == ''){ //Novo cliente
        fetch(`http://localhost:8000/adm/clientes`, {
            method: 'POST',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            },
            body: JSON.stringify(cliente)
        })
        .then(res => res.json())
        .then(res => {
            if(res.message === undefined){ //salvo no banco
                alert('Nova Empresa cadastrada com sucesso!')
                txtClienteId.value = res.id
                showComponents()
            }
            else{
                txtClienteId.value = ''
                alert('Erro ao salvar: ' + res.message)
            }
        })
        
    } else { //Editar cliente
        fetch(`http://localhost:8000/adm/clientes/${txtClienteId.value}`, {
            method: 'PUT',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            },
            body: JSON.stringify(cliente)
        })
        .then(res => res.json())
        .then(res => {
            if(res.message === undefined){ //salvo no banco
                alert('Empresa alterada com sucesso!')
            }
            else
                alert('Erro ao salvar: ' + res.message)
        })
    }
})

btnClose.addEventListener('click', evt => {
    customModal.classList.add('hide')
})

btnNovo.addEventListener('click', evt => {
    customModal.classList.remove('hide')
    document.getElementById('modalTitle').innerHTML = 'Novo CNPJ'
    cnpjId.value = ''
    txtCnpj.value = ''
    txtFilial.value = ''
    selStatusCnpj.value = '1'
})

btnSaveCnpj.addEventListener('click', evt => {
    if(! checkCnpjfields()) return false

    const cnpj = {
        _token : document.getElementsByName('_token')[0].value.trim(),
        cnpj : txtCnpj.value.trim(),
        filial : txtFilial.value.trim(),
        ativo : selStatusCnpj.value.trim()
    }

    if(cnpjId.value == ''){ //Novo Cnpj
        fetch(`http://localhost:8000/adm/filiais/cliente/${txtClienteId.value}`, {
            method: 'POST',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            },
            body: JSON.stringify(cnpj)
        })
        .then(res => res.json())
        .then(res => {
            if(res.message === undefined){ //salvo no banco
                cnpjId.value = res.id
                customModal.classList.add('hide')
                fillTable()
            }
            else{
                cnpjId.value = ''
                alert('Erro ao salvar: ' + res.message)
            }
        })
        
    } else { // Editar cnpj
        fetch(`http://localhost:8000/adm/filiais/cliente/${cnpjId.value}`, {
            method: 'PUT',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            },
            body: JSON.stringify(cnpj)
        })
        .then(res => res.json())
        .then(res => {
            if(res.message === undefined){ //salvo no banco
                alert('CNPJ alterado com sucesso!')
                customModal.classList.add('hide')
                fillTable()
            }
            else
                alert('Erro ao salvar: ' + res.message)
            
        })
    }
})

btnDelCliente.addEventListener('click', evt => {
    if(! confirm('Deseja excluir esse cliente?')){
        return
    }
    fetch(`http://localhost:8000/adm/clientes/${txtClienteId.value}`, {
        method: 'DELETE',
        headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        },
        body: JSON.stringify({_token: document.getElementsByName('_token')[1].value.trim()})
    })
    .then(res => res.json())
    .then(res => {
        console.log(res)
        if(res.message === undefined){ //salvo no banco
            alert('Empresa removida com sucesso!')
            window.location.href = 'http://localhost:8000/adm/clientes/'
        }
        else
            alert('Erro ao excluir: ' + res.message)
        
    })
})

function fillTable(){
    showComponents()
    tbFiliais.innerHTML = ''
    if(txtClienteId.value != ''){
        fetch(`http://localhost:8000/adm/filiais/cliente/${txtClienteId.value}`)
        .then(res => res.json())
        .then(res => {
            res.forEach(el => {
                const tr = document.createElement('tr')
                tr.setAttribute('class', 'bg-white border-b dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between')
                const td1 = document.createElement('td')
                const td2 = document.createElement('td')
                const td3 = document.createElement('td')
                td1.setAttribute('class', 'px-6 py-2')
                td2.setAttribute('clss', 'px-6 py-2')
                td2.innerHTML = el.filial
                td3.setAttribute('class', 'px-6 py-2 flex items-center justify-between')
                td1.innerHTML = el.cnpj
                tr.appendChild(td1)
                const spn = document.createElement('span')
                if(el.ativo){
                    spn.setAttribute('class', 'bg-green-600 text-white text-xs font-medium mx-8 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 rounded-xl')
                    spn.innerHTML = 'Ativo'
                } else {
                    spn.setAttribute('class', 'bg-slate-500 text-white text-xs font-medium mx-8 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 rounded-xl')
                    spn.innerHTML = 'Inativo'
                }
                td3.appendChild(spn)
                const btn = document.createElement('button')
                btn.setAttribute('class', 'text-blue-500 bg-white hover:bg-gray-100 border border-blue-500 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-md text-sm px-2 py-1 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700')
                const icon = document.createElement('img')
                icon.setAttribute('src', '/images/edit.svg')
                const btnSpn = document.createElement('span')
                btnSpn.innerHTML = 'Editar'
                btn.appendChild(icon)
                btn.appendChild(btnSpn)
                btn.addEventListener('click', evt => {
                    customModal.classList.remove('hide')
                    modalTitle.innerHTML = 'Editando CNPJ'
                    cnpjId.value = el.id
                    txtCnpj.value = el.cnpj
                    txtFilial.value = el.filial
                    selStatusCnpj.value = el.ativo
                })
                td3.appendChild(btn)
                tr.appendChild(td2)
                tr.appendChild(td3)
                tbFiliais.appendChild(tr)
            });
            
        })
    }
}
function checkEmpresaFields(){
    if(txtEmpresa.value == '') {
        txtEmpresa.focus()
        alert("O campo 'Empresa' é obrigatório")
        return false
    }
    return true
}

function checkCnpjfields(){
    if(txtCnpj.value == ''){
        txtCnpj.focus()
        alert("O campo 'CNPJ' é obrigatório")
        return false
    }
    if(txtFilial.value == ''){
        txtFilial.focus()
        alert("O campo 'Nome' é obrigatório")
        return false
    }
    return true
}

function showComponents() {
    if(txtClienteId.value != ''){
        btnDelCliente.classList.remove('hidden')
        divCnpjs.classList.remove('hidden')
    }
}

txtCnpj.addEventListener('keyup', evt => {
    var x = evt.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
    evt.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
});