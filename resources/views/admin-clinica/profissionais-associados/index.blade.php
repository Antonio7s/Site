@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')

    <!--botao de adicionar-->
    <a class="btn btn-success"href="{{ route('admin-clinica.profissionais-associados.create') }}">Adicionar Profissional</a>
    
    <hr>

    <div id="lista-profissionais">
        <h3>Lista de Profissionais Associados</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Especialidades</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Conselho</th>
                    <th>Conselho identificação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profissionais as $profissional)
                    <tr>
                        <td>{{ $profissional->profissional_nome }}</td>
                        <td>{{ $profissional->profissional_sobrenome }}</td>
                        <td>
                        @if($profissional->especialidades && $profissional->especialidades->count())
                            @foreach($profissional->especialidades as $especialidade)
                                {{ $especialidade->nome }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        @else
                            Nenhuma especialidade cadastrada.
                        @endif
                        </td>
                        <td>{{ $profissional->email }}</td>
                        <td>{{ $profissional->telefone }}</td>
                        <td>{{ $profissional->conselho_nome }}</td>
                        <td>{{ $profissional->conselho_numero }}</td>
                        <td>
                            <a href="{{ route('admin-clinica.profissionais-associados.edit', $profissional->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('admin-clinica.profissionais-associados.destroy', $profissional->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este profissional?')">Excluir</button>
                            </form>
                            <a href="{{ route('admin-clinica.profissionais-associados.show', $profissional->id) }}" class="btn btn-success btn-sm">Visualizar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection


