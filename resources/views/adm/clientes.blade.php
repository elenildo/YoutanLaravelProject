@extends('adm.layout')
@section('title', 'Clientes')

@section('content')
    <div class="flex justify-end my-4">
        <a href="{{ route('adm.cliente.form') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Novo</a>
    </div>
    <div class="relative overflow-x-auto shadow-xl p-6 bg-white border">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 table-auto">
            @forelse ($clientes as $cliente)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 flex items-center justify-between">
                <td class="px-6 py-2">{{ $cliente->razao_social }}</td>
                <td class="px-6 py-2 flex items-center justify-around">
                    @if ($cliente->ativo)
                    <span class="bg-green-600 text-white text-xs font-medium mx-8 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 rounded-xl">Ativo</span>    
                    @else
                    <span class="bg-slate-500 text-white text-xs font-medium mx-8 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 rounded-xl">Inativo</span>
                    @endif 
                    <a href="{{ route('adm.cliente.findBySlug', $cliente->slug) }}" class="text-blue-500 bg-white hover:bg-gray-100 border border-blue-500 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-md text-sm px-2 py-1 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700">
                        <img src="/images/edit.svg" alt="Edit"> Editar
                    </a>
                </td>
            </tr> 
            @empty
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">Nenhum cliente encontrado</td>
            </tr>
            @endforelse
        </table>
    </div>
    <div class="flex justify-end my-4">
        {{ $clientes->links() }}
    </div>

@endsection


{{-- @push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
@endpush
--}}

{{-- @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
@endpush  --}}