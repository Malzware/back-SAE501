<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Proposal Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 0;
}

.form-container {
    max-width: 800px;
    margin: 0 auto;
    border: 1px solid black;
    padding: 20px;
}

header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.header-left h2 {
    font-size: 1.5em;
    margin-bottom: 0;
}

.header-right h3 {
    font-size: 1.5em;
    margin: 0;
    text-align: right;
}

.academic-year {
    text-align: center;
    font-size: 1.5em;
    font-weight: bold;
    margin-bottom: 20px;
}

.proposal-section h2 {
    text-align: center;
    font-size: 1.3em;
    margin: 10px 0;
}

.details-section, .candidature-section {
    margin-bottom: 20px;
}

.module-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.module-table th, .module-table td {
    border: 1px solid black;
    padding: 10px;
    text-align: left;
}

.module-table th {
    background-color: #f2f2f2;
}

.footer-section {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

.footer-left, .footer-right {
    width: 45%;
}
</style>
</head>
<body>
    <div class="form-container">
        <header>
            <div class="header-left">
                <h2>IUT Béziers</h2>
                <p>Place du 14 Juillet – BP 50438<br>
                    34 505 BEZIERS<br>
                    Service financier: 04 67 11 60 14</p>
            </div>
            <div class="header-right">
                <h3>Université de Montpellier</h3>
            </div>
        </header>

        <h1 class="academic-year">Année Universitaire 2024/2025</h1>

        <div class="proposal-section">
            <h2>PROPOSITION DE RECRUTEMENT AUX FONCTIONS DE CHARGES DE COURS</h2>
            <p>POUR AVIS DU CONSEIL EN FORMATION RESTREINTE<br>
                (document à retourner par mail à : iutb-ose-service@umontpellier.fr)</p>
        </div>

        <div class="details-section">
            <div class="department">
                <p><strong>DEPARTEMENT D'ENSEIGNEMENT :</strong> RT ☐ MMI ☐ TC ☐ LP ROB & IA ☐</p>
                <p>Nom de l'enseignant responsable du module ou Directeur des Etudes qui sollicite le recrutement : <u>Caroline SURRIBAS</u></p>
            </div>
        </div>

        <div class="candidature-section">
            <!-- @foreach ($users as $user) -->
            <h3>PROPOSITION DE CANDIDATURE VACATAIRE</h3>
            <p>
                Doctorant ☐ Retraité ☐ ou Autre ☑ (salarié-chef entreprise-auto-entrepreneur)
            </p>
            <p>Vacataire en N-1 : OUI ☐ NON ☑ Si non, joindre un CV à la proposition de candidature</p>
            <p><strong>NOM :</strong> {{$lastname}} <strong>PRENOM :</strong> {{$firstname}}</p>
            <p><strong>Dernier diplôme obtenu :</strong></p>
            <p><strong>Adresse mail :</strong> {{$email}} <strong>Téléphone :</strong></p>
            <p><strong>Date de début des cours :</strong></p>
        </div>

        <!--<table class="module-table">
            <thead>
                <tr>
                    <th>N° Module</th>
                    <th>NOM DU MODULE</th>
                    <th>VOLUME HORAIRE (intégrant le nombre de groupe TD-TP)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($resources as $resource)
                    <td>test</td>
                    <td>Développement front avancé</td>
                    <td>CM: 15, TD: 24</td>
                </tr>
                <tr>
                    <td>R5.D06</td>
                    <td>Développement back avancé</td>
                    <td>CM: 18, TD: 24</td>
                </tr>
            </tbody>
        </table>

        <div class="footer-section">
            <div class="footer-left">
                <p>Date : 27/08/2024</p>
                <p>Visa du Responsable de module, de la formation ou directeur des Etudes</p>
            </div>
            <div class="footer-right">
                <p>Date :</p>
                <p>Visa de l'intéressé</p>
                <p>Date :</p>
                <p>Visa du chef de département</p> -->
            </div>
        </div>
    </div>
</body>
</html>