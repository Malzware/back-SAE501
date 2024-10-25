<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
        }

        .year-box {
            border: 1px solid black;
            padding: 5px 15px;
            text-align: center;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            border: 1px solid black;
            padding: 10px;
            margin: 20px 0;
            font-size: 14px;
        }

        .department-section {
            margin: 20px 0;
        }

        .checkbox-group {
            display: flex;
            gap: 20px;
            margin: 10px 0;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .candidature-box {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
            margin: 20px 0;
            background-color: #f0f0f0;
        }

        .form-row {
            margin: 10px 0;
            display: flex;
            gap: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .module-col {
            width: 60%;
        }

        .hours-col {
            width: 13%;
            text-align: center;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .signature-box {
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="/api/placeholder/100/50" alt="IUT Logo" class="logo">
        <div class="year-box">
            <h2>Année Universitaire 2024/2025</h2>
        </div>
        <img src="/api/placeholder/100/50" alt="University Logo" class="logo">
    </div>

    <div class="title">
        PROPOSITION DE RECRUTEMENT AUX FONCTIONS DE CHARGES DE COURS<br>
        POUR AVIS DU CONSEIL EN FORMATION RESTREINTE<br>
        <small>(document à retourner par mail à : iutb-cse-service@umontpellier.fr)</small>
    </div>

    <div class="department-section">
        <div>DÉPARTEMENT D'ENSEIGNEMENT :</div>
        <div class="checkbox-group">
            <label class="checkbox-item">
                <input type="checkbox"> RT
            </label>
            <label class="checkbox-item">
                <input type="checkbox" checked> MMI
            </label>
            <label class="checkbox-item">
                <input type="checkbox"> TC
            </label>
            <label class="checkbox-item">
                <input type="checkbox"> LP ROB & IA
            </label>
        </div>
    </div>

    <div class="candidature-box">
        PROPOSITION DE CANDIDATURE VACATAIRE
    </div>

    <div class="form-row">
        <div>
            <label>NOM :</label>
            <label for="candidate-name">Nom :</label>
            <span class="value">{{ $user->lastname }}</span>
        </div>
        <div>
            <label>PRÉNOM :</label>
            <span class="value">{{ $user->firstname }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° Module</th>
                <th class="module-col">NOM DU MODULE</th>
                <th class="hours-col">CM</th>
                <th class="hours-col">TD</th>
                <th class="hours-col">TP</th>
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
        <div class="signature-box">
            <div>Date : {{ $generated_at->format('Y-m-d H:i:s') }}</div>
            <div>Visa du Responsable de module,</div>
            <div>de la formation ou directeur des Études</div>
        </div>
        <div class="signature-box">
            <div>Date : {{ $generated_at->format('Y-m-d H:i:s') }}</div>
            <div>Visa de l'intéressé
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($signaturePath)) }}" class="signature-image">
            </div>
        </div>
        <div class="signature-box">
            <div>Date : {{ $generated_at->format('Y-m-d H:i:s') }}</div>
            <div>Visa du chef de département</div>
        </div>
    </div>
</body>
</html>