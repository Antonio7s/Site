@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

    <!--botao de adicionar-->
    <a href="">adicionar prof</a>
    
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
                @foreach($professionals as $professional)
                    <tr>
                        <td>{{ $professional->nome }}</td>
                        <td>{{ $professional->funcao }}</td>
                        <td>{{ $professional->email }}</td>
                        <td>{{ $professional->telefone }}</td>
                        <td>{{ $professional->conselho }}</td>
                        <td>
                            <a href="{{ route('professionals.edit', $professional->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('professionals.destroy', $professional->id) }}" method="POST" style="display:inline">
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


