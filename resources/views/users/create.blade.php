<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Utilisateur</title>
</head>
<body>
    <h1>Ajouter un Nouvel Utilisateur</h1>

    <form action="{{ route('users.store') }}" method="post">
        @csrf
        <label for="lastname">Nom:</label>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <label for="firstname">Prénom:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
