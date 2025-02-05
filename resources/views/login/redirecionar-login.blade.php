@extends('layouts.layout-index') <!-- Referencia o layout 'app.blade.php' -->

@section('content')

  <!doctype html>
    <html lang="en">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>LOGIN - REDIRECIONAMENTO</title>

        <style>

            #selecao {
                text-align: center;
            }
            
            #selecao p {
                font-size: 1.2rem;
                font-weight: bold;
                margin-bottom: 20px;
            }
            .choice-btn {
                width: 200px;
                height: 100px;
                font-size: 1.2rem;
                font-weight: bold;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
            }
            .choice-btn i {
                margin-right: 10px;
            }
        </style>
      </head>
      <body>

        <!-- Modal para escolher Cliente ou Clínica -->
        <div class="container mt-5">
          <h2 class="text-center">Login</h2>

          <!-- Janela de Seleção -->
          <div id="selecao" class="mb-4">
              <p>Por favor, escolha uma opção:</p>
              <div class="d-flex justify-content-center gap-3">

                  <a href="login-paciente" class="btn btn-outline-primary choice-btn", id="btnPaciente>
                    <i class="bi bi-person-circle"></i> Paciente
                  </a>

                  <a href="login-clinica" class="btn btn-outline-success choice-btn">
                    <i class="bi bi-hospital"></i> Clínica Médica
                  </a>
              </div>
          </div>

            <!-- Bootstrap Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- Script para abrir o modal e as acoes subsequentes-->
        <script>
          // Para abrir o modal assim que a página carrega
          $(document).ready(function() {
            $('#clienteClinicaModal').modal('show');
          });

          // Ações após escolher Cliente ou Clínica
          $('#btnPaciente').on('click', function() {

            // Redirecionar para login-cliente.html
            window.location.href = 'login-cliente.html';
            
            //alert('Você escolheu Cliente!');
            //$('#clienteClinicaModal').modal('hide');

          });

          $('#btnClinica').on('click', function() {
            window.location.href = 'login-clinica.html';
            //$('#clienteClinicaModal').modal('hide');
          });
        </script>
      </body>
    </html>

@endsection
