@extends('layouts.painel-clinica')
@section('header_title', 'Agendamento')
@section('content')


  <div class="container my-5">
    <h2>Tabela de Agendamentos</h2>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Data</th>
          <th>Horário</th>
          <th>Médico</th>
          <th>Procedimento</th>
          <th>Cliente</th>
          <th>Valor</th>
          <th>Status</th>
          <th> Ações </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>21/02/2025</td>
          <td>10:00</td>
          <td>Dr. João Silva</td>
          <td>Consulta de Rotina</td>
          <td>Ana Costa</td>
          <td>R$ 200,00</td>
          <td>Agendado</td>
          <td>
            <a href="#" class="btn btn-info btn-sm">Visualizar</a>
            <a href="#" class="btn btn-warning btn-sm">Editar</a>
            <a href="#" class="btn btn-danger btn-sm">Cancelar</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>




@endsection