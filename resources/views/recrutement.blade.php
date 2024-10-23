<!-- resources/views/recruitment.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Form</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .container {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .header-left {
            width: 50%;
        }

        .header-left img {
            width: 100px;
        }

        .header-right {
            text-align: right;
            font-size: 11px;
        }

        .title {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .title h1 {
            font-size: 16px;
            margin: 0;
            text-transform: uppercase;
        }

        .title h2 {
            font-size: 14px;
            margin: 5px 0;
        }

        .title p {
            font-size: 12px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section label {
            font-weight: bold;
            width: 220px;
            display: inline-block;
        }

        .section .value {
            font-weight: bold;
        }

        .checkbox-group {
            display: inline-block;
            margin-right: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .signature-section td {
            height: 60px;
        }

        .signature-section {
            margin-top: 20px;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="header-left">
            <img src="{{ asset('iut-logo.png') }}" alt="IUT Béziers">
        </div>
        <div class="header-right">
            <p>Place du 14 Juillet – BP 50438<br>
            34505 BÉZIERS<br>
            Service financier: 04 67 11 60 14</p>
        </div>
    </div>

    <div class="title">
        <h1>Proposition de Recrutement aux Fonctions de Charges de Cours</h1>
        <h2>Année Universitaire 2024/2025</h2>
        <p>Document à retourner par mail à: <strong>iut-ose-service@umontpellier.fr</strong></p>
    </div>

    <div class="section">
        <label for="department">Département d'Enseignement :</label>
        <span class="checkbox-group">RT ☐ MMI ☐ TC ☐ LP ROB & IA ☐</span>
    </div>

    <div class="section">
        <label for="module-responsible">Nom de l'enseignant responsable du module :</label>
        <span class="value">Caroline Surribas</span>
    </div>

    <div class="section">
        <label for="candidate-name">Nom :</label>
        <span class="value">{{ $user->lastname }}</span>
        <label for="candidate-prenom" style="margin-left: 30px;">Prénom :</label>
        <span class="value">{{ $user->firstname }}</span>
    </div>

    <div class="section">
        <label for="diploma">Dernier diplôme obtenu :</label>
        <span></span>
    </div>

    <div class="section">
        <label for="address">Adresse mail :</label>
        <span>{{ $user->email }}</span>
        <label for="telephone" style="margin-left: 30px;">Téléphone :</label>
        <span></span>
    </div>
    
    <div class="section">
        <label for="start-date">Date de début des cours :</label>
        <span></span>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° Module</th>
                <th>Nom du Module</th>
                <th>Volume Horaire</th>
            </tr>
        </thead>
        <tbody>
        @foreach($givenHours as $resource)
            <tr>
                <td>{{$resource->code}}</td>
                <td>{{$resource->name}}</td>
                <td>CM: {{ $resourceHours['total_cm'] }} | TD: {{ $resourceHours['total_td'] }} | TP: {{ $resourceHours['total_tp'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-section">
        <table>
            <tr>
                <td>Date: {{ $generated_at->format('d-m-Y') }}</td>
                <td>Visa du Responsable de Module:</td>
                <td>Visa de l’intéressé:</td>
                <td>Visa du Chef de Département:</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>IUT Béziers, Université de Montpellier</p>
    </div>
</div>

</body>
</html>
