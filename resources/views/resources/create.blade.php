<!-- resources/views/resources/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Resource</title>
</head>
<body>
    <h1>Ajouter une nouvelle ressource</h1>

    <!-- Formulaire pour ajouter une ressource -->
    <form action="{{ url('/resources') }}" method="POST">
        @csrf
        <label for="name">Nom de la ressource:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="resource_code">Code de la ressource:</label>
        <input type="text" id="resource_code" name="resource_code" required><br><br>

        <label for="title">Titre de la ressource:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="id_semester">Semestre:</label>
        <select id="id_semester" name="id_semester" required>
            @foreach($semesters as $semester)
                <option value="{{ $semester->id }}">{{ $semester->name }}</option>
            @endforeach
        </select><br><br>

        <label for="cm">CM (heures):</label>
        <input type="number" id="cm" name="cm"><br><br>

        <label for="td">TD (heures):</label>
        <input type="number" id="td" name="td"><br><br>

        <label for="tp">TP (heures):</label>
        <input type="number" id="tp" name="tp"><br><br>

        <label for="national_total">Total national:</label>
        <input type="number" id="national_total" name="national_total"><br><br>

        <label for="national_tp">TP national:</label>
        <input type="number" id="national_tp" name="national_tp"><br><br>

        <label for="adapt">Adapt:</label>
        <input type="number" id="adapt" name="adapt"><br><br>

        <label for="adapt_tp">TP adapté:</label>
        <input type="number" id="adapt_tp" name="adapt_tp"><br><br>

        <label for="projet_ne">Projet NE:</label>
        <input type="number" id="projet_ne" name="projet_ne"><br><br>

        <label for="projet_e">Projet E:</label>
        <input type="number" id="projet_e" name="projet_e"><br><br>

        <label for="comment">Commentaire:</label>
        <textarea id="comment" name="comment"></textarea><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
