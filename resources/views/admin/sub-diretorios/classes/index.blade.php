@extends('layouts.painel-admin')
@section('header_title', 'Classes') <!-- Alterando o h1 -->
@section('content')
        
      <!-- Botão "Adicionar" -->
  <div class="mb-3">
    <a href="classes2" class="btn btn-primary mb-3">Adicionar</a>
  </div>

      <div class="row mt-4">
            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th scope="col">Código</th>
                      <th scope="col">Classe</th>
                      <th scope="col">Ações</th>
                  </tr>
              </thead>
              <tbody>
                  <!-- Registro 1 -->
                  <tr>
                      <td>1</td>
                      <td>CONSULTAS</td>
                      <td>
                          <button class="btn btn-warning btn-sm">Editar</button>
                          <button class="btn btn-danger btn-sm">Deletar</button>
                          <button class="btn btn-info btn-sm">Detalhes</button>
                      </td>
                  </tr>
                  <!-- Registro 2 -->
                  <tr>
                      <td>2</td>
                      <td>Exames</td>
                      <td>
                          <button class="btn btn-warning btn-sm">Editar</button>
                          <button class="btn btn-danger btn-sm">Deletar</button>
                          <button class="btn btn-info btn-sm">Inspecionar</button>
                      </td>
                  </tr>
                  <!-- Registro 3 -->
                  <tr>
                      <td>3</td>
                      <td>Vacinas</td>
                      <td>
                          <button class="btn btn-warning btn-sm">Editar</button>
                          <button class="btn btn-danger btn-sm">Deletar</button>
                          <button class="btn btn-info btn-sm">Inspecionar</button>
                      </td>
                  </tr>
                  <!-- Registro 4 -->
                  <tr>
                      <td>4</td>
                      <td>Odontologia</td>
                      <td>
                          <button class="btn btn-warning btn-sm">Editar</button>
                          <button class="btn btn-danger btn-sm">Deletar</button>
                          <button class="btn btn-info btn-sm">Inspecionar</button>
                      </td>
                  </tr>
                  <!-- Registro 5 -->
                  <tr>
                      <td>5</td>
                      <td>Pronto Atendimento</td>
                      <td>
                          <button class="btn btn-warning btn-sm">Editar</button>
                          <button class="btn btn-danger btn-sm">Deletar</button>
                          <button class="btn btn-info btn-sm">Inspecionar</button>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>
  @endsection