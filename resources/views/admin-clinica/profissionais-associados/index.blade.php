@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

    <!--botao de adicionar-->
    <a href="{{ route('admin-clinica.profissionais.create') }}">Adicionar Profissional</a>
    
    <hr>

    <div id="lista-profissionais">
        <h3>Lista de Profissionais Associados</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Função</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Conselho</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profissionais as $profissional)
                    <tr>
                        <td>{{ $profissional->nome }}</td>
                        <td>{{ $profissional->funcao }}</td>
                        <td>{{ $profissional->email }}</td>
                        <td>{{ $profissional->telefone }}</td>
                        <td>{{ $profissional->conselho }}</td>
                        <td>
                            <a href="{{ route('profissionais.edit', $profissional->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('profissionais.destroy', $profissional->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este profissional?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection


