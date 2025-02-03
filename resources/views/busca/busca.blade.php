@extends('layouts.app')
@section('content')
    <style>
        /* Estilos principais do layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 10px;
        }

        /* Estilos para a caixa de busca */
        .search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .search-bar input[type="text"] {
            padding: 12px 20px;
            font-size: 18px;
            width: 60%;
            border: 2px solid #007bff;
            border-radius: 30px;
            transition: border-color 0.3s ease;
            outline: none;
        }
        .search-bar input[type="text"]:focus {
            border-color: #0056b3;
        }
        .search-bar button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 18px;
            margin-left: 15px;
        }
        .search-bar button:hover {
            background-color: #0056b3;
        }

        /* Estilos para a caixa de informações da pessoa */
        .person-box {
            background-color: #ffffff;
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .person-info {
            max-width: 60%;
        }
        .person-info h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .person-info p {
            margin: 5px 0;
            color: #666;
        }
        .person-info .clinic-name {
            font-weight: bold;
            color: #007bff;
        }
        .person-info .address {
            color: #555;
            font-size: 14px;
        }

        /* Estilos para a foto do médico */
        .person-photo {
            width: 120px;
            height: 120px;
            margin:10px;
            object-fit: cover;
            
        }

        /* Informações extras */
        .location, .price, .specialty, .rating {
            margin-top: 10px;
        }

        /* Estilos para o botão "Ver no mapa" */
        .location a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .location a:hover {
            text-decoration: underline;
        }

        
    </style>

    <style>
        /* Estilização geral */
        .agenda h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .agenda p {
            font-size: 16px;
            margin: 5px 0;
        }

        /* Estilo para o layout dos horários */
        .schedule {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .column {
            width: 23%; /* Para dividir igualmente a largura da área */
        }

        /* Estilo para cada horário */
        .hour {
            background-color:rgb(145, 222, 245);
            padding: 12px;
            text-align: center;
            margin-bottom: 8px;
            border-radius: 4px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        /* Efeito ao passar o mouse sobre os horários */
        .hour:hover {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transform: scale(1.05); /* Aumenta o tamanho ao passar o mouse */
        }


        /* Efeito de hover em cada horário */
        .hour:hover {
            background-color:rgb(58, 119, 177);
            transform: scale(1.05);
        }
    </style>

    <body>
        <div class="container">
            <!-- Formulário de busca -->
            <div class="search-bar">
                <input type="text" placeholder="Digite o nome da pessoa...">
                <button type="button">Buscar</button>
            </div>

            <h1>Resultados da Busca</h1>
            <p>Buscando por: <strong>Dermatologista</strong></p>

            <!-- Exemplo 1 -->
            <div class="person-box">
                <img src="{{ asset('images/medico-1.jpg') }}" alt="Foto do Médico" class="person-photo">
                <div class="person-info">
                    <h2>Dr. João Silva</h2>
                    <p class="specialty"><strong>Especialidade:</strong> Cardiologia</p>
                    <p class="clinic-name"><strong>Clínica:</strong> Saúde Total</p>
                    <p class="address"><strong>Endereço:</strong> Rua das Flores, 123 - São Paulo, SP</p>
                    <p class="location"><strong>Localização:</strong> <a href="https://www.google.com/maps?q=-23.55052,-46.633308" target="_blank">Ver no Mapa</a></p>
                    <p class="price"><strong>Valor:</strong> R$ 200</p>
                    <p class="rating"><strong>Avaliação:</strong> ⭐⭐⭐⭐ (4.5/5)</p>
                </div>

                <div class="agenda">
                    <h3>Horário</h3>                    
                    <div class="date-picker">
                        <p>a</p>
                        <p id="date-display"><strong>Data:</strong> 03/02/2025</p>
                    </div>

                    <div class="schedule">
                        <div class="column">
                            <div class="hour">08:00</div>
                            <div class="hour">09:00</div>
                            <div class="hour">10:00</div>
                            <div class="hour">11:00</div>
                            <div class="hour">12:00</div>
                        </div>
                        <div class="column">
                            <div class="hour">10:00</div>
                            <div class="hour">11:00</div>
                            <div class="hour">12:00</div>
                            <div class="hour">13:00</div>
                            <div class="hour">14:00</div>
                        </div>
                        <div class="column">
                            <div class="hour">11:00</div>
                            <div class="hour">12:00</div>
                            <div class="hour">13:00</div>
                            <div class="hour">14:00</div>
                            <div class="hour">15:00</div>
                        </div>
                        <div class="column">
                            <div class="hour">13:00</div>
                            <div class="hour">14:00</div>
                            <div class="hour">15:00</div>
                            <div class="hour">16:00</div>
                            <div class="hour">17:00</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Exemplo 2 -->
            <div class="person-box">
                <img src="{{ asset('images/medico-2.jpg') }}" alt="Foto do Médico" class="person-photo">
                <div class="person-info">
                    <h2>Maria Oliveira</h2>
                    <p class="specialty"><strong>Especialidade:</strong> Dermatologia</p>
                    <p class="clinic-name"><strong>Clínica:</strong> Pele Saudável</p>
                    <p class="address"><strong>Endereço:</strong> Av. Brasil, 456 - Rio de Janeiro, RJ</p>
                    <p class="location"><strong>Localização:</strong> <a href="https://www.google.com/maps?q=-22.906847,-43.172896" target="_blank">Ver no Mapa</a></p>
                    <p class="price"><strong>Valor:</strong> R$ 150</p>
                    <p class="rating"><strong>Avaliação:</strong> ⭐⭐⭐⭐ (4.2/5)</p>
                </div>
                <div class="agenda">
                    <table>
                        <thead>
                            <tr>
                                <th>Horário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>08:00 - 09:00</td></tr>
                            <tr><td>10:00 - 11:00</td></tr>
                            <tr><td class="booked">11:00 - 12:00 (Indisponível)</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Exemplo 3 -->
            <div class="person-box">
                <img src="{{ asset('images/medico-3.jpg') }}" alt="Foto do Médico" class="person-photo">
                <div class="person-info">
                    <h2>Pedro Santos</h2>
                    <p class="specialty"><strong>Especialidade:</strong> Ortopedia</p>
                    <p class="clinic-name"><strong>Clínica:</strong> Ossos Fortes</p>
                    <p class="address"><strong>Endereço:</strong> Rua das Palmeiras, 789 - Brasília, DF</p>
                    <p class="location"><strong>Localização:</strong> <a href="https://www.google.com/maps?q=-15.794229,-47.882166" target="_blank">Ver no Mapa</a></p>
                    <p class="price"><strong>Valor:</strong> R$ 180</p>
                    <p class="rating"><strong>Avaliação:</strong> ⭐⭐⭐⭐ (4.0/5)</p>
                </div>
                <div class="agenda">
                    <table>
                        <thead>
                            <tr>
                                <th>Horário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>08:00 - 09:00</td></tr>
                            <tr><td>09:00 - 10:00</td></tr>
                            <tr><td>10:00 - 11:00</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Exemplo 4 -->
            <div class="person-box">
                <img src="{{ asset('images/medico-4.jpg') }}" alt="Foto do Médico" class="person-photo">
                <div class="person-info">
                    <h2>Carla Souza</h2>
                    <p class="specialty"><strong>Especialidade:</strong> Pediatria</p>
                    <p class="clinic-name"><strong>Clínica:</strong> Criança Feliz</p>
                    <p class="address"><strong>Endereço:</strong> Av. Paulista, 1010 - São Paulo, SP</p>
                    <p class="location"><strong>Localização:</strong> <a href="https://www.google.com/maps?q=-19.916681,-43.934493" target="_blank">Ver no Mapa</a></p>
                    <p class="price"><strong>Valor:</strong> R$ 220</p>
                    <p class="rating"><strong>Avaliação:</strong> ⭐⭐⭐⭐⭐ (5.0/5)</p>
                </div>
                <div class="agenda">
                    <table>
                        <thead>
                            <tr>
                                <th>Horário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>09:00 - 10:00</td></tr>
                            <tr><td>11:00 - 12:00</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Exemplo 5 -->
            <div class="person-box">
                <img src="{{ asset('images/medico-5.jpg') }}" alt="Foto do Médico" class="person-photo">
                <div class="person-info">
                    <h2>Ana Lima</h2>
                    <p class="specialty"><strong>Especialidade:</strong> Ginecologia</p>
                    <p class="clinic-name"><strong>Clínica:</strong> Saúde da Mulher</p>
                    <p class="address"><strong>Endereço:</strong> Rua das Acácias, 567 - Curitiba, PR</p>
                    <p class="location"><strong>Localização:</strong> <a href="https://www.google.com/maps?q=-25.428954,-49.267137" target="_blank">Ver no Mapa</a></p>
                    <p class="price"><strong>Valor:</strong> R$ 130</p>
                    <p class="rating"><strong>Avaliação:</strong> ⭐⭐⭐⭐ (4.3/5)</p>
                </div>
                <div class="agenda">
                    <table>
                        <thead>
                            <tr>
                                <th>Horário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>08:00 - 09:00</td></tr>
                            <tr><td>09:00 - 10:00</td></tr>
                            <tr><td>10:00 - 11:00</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    </html>
@endsection