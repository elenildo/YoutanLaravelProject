@extends('adm.layout')
@section('title', 'Cliente')

@section('content')
    <div id="customModal" class="custom-modal hide">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="modalTitle" class="text-xl font-semibold text-gray-900 dark:text-white">
                        Static modal
                    </h3>
                    <button id="btnClose" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    
                    <form method="post">
                        @csrf
                    <div class="max-w-sm mx-auto">
                        <input type="hidden" id="cnpjId">
                        <div class="mb-5">
                            <label for="selStatusCnpj" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select id="selStatusCnpj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="txtCnpj" class="block mb-2 w-100 text-sm font-medium text-gray-900 dark:text-white">Cnpj</label>
                            <input type="text" id="txtCnpj" maxlength="18" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CNPJ" required />
                        </div>
                        <div class="mb-5">
                            <label for="txtFilial" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                            <input type="text" id="txtFilial" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nome" required />
                          </div>
                    </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
                    <button id="btnSaveCnpj" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-between my-8 py-4">
        <div class="w-3/12">
            <h3>Dados Cadastrais</h3>
        </div>
        <div class="relative overflow-x-auto shadow-xl p-6 bg-white border w-full">
            <form action="{{ route('adm.cliente.store') }}" id="frmCliente">
                @csrf
                <input type="hidden" id="txtClienteId" value="{{ $cliente->id ?? ''}}">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 mb-5 group w-full">
                        <label for="txtEmpresa" class="block mb-2 w-100 text-sm font-medium text-gray-900 dark:text-white">Empresa</label>
                        <input type="text" id="txtEmpresa" name="razao_social" value="{{ $cliente->razao_social ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Empresa" required />
                    </div>
                    <div class="relative z-0 mb-5 group w-2/4">
                        <label for="selStatus" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select id="selStatus" name="ativo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1" @if(isset($cliente) && $cliente->ativo == 1) selected @endif>Ativo</option>
                            <option value="0" @if(isset($cliente) && $cliente->ativo == 0) selected @endif>Inativo</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id='divCnpjs' class="flex justify-between my-4 py-4 hidden">
        <div class="w-3/12">
            <h3>CNPJs<h3>
        </div>
        <div class="relative overflow-x-auto shadow-xl bg-white border w-full">
            <div class="flex w-full bg-slate-200 justify-end p-2 border">
                <button id="btnNovo" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 inline-flex">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                      </svg>Novo
                </button>
            </div>

            <div class="flex p-6 overflow-y-auto max-h-60">
                <table id="tbFiliais" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 table-auto"></table>
            </div>
        </div>
    </div>
    <div class="flex justify-between my-4">
        <div class="w-3/12"></div>
        <div class="flex justify-between w-full">
            <button type="button" id='btnDelCliente' class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 hidden">Excluir</button>
            <button type="button" id="btnSaveCliente" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Salvar</button>
        </div>
    </div>
@endsection


@push('style')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@push('script')
    <script src="{{ asset('js/cliente.js') }}"></script>
@endpush 