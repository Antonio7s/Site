@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')     
            

    <!-- Serviços -->
    <!-- Deve puxar do banco de dados os procedimentos padrões ou -->
    <!-- os serviços diferenciados associados a essa clínica e listar todos.-->
    <div>
        <h3>Lista de Serviços</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome do Serviço</th>
                    <th>Especialidade</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $servico->name }}</td>
                        <td>{{ $servico->specialty }}</td>
                        <td>{{ $servico->price }}</td>
                        <td>
                            <!-- Exemplo de botões de ação: editar e excluir -->
                            <a href="#" class="btn btn-sm btn-warning">Editar</a>
                            <form action="#" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Nenhum serviço cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


@endsection