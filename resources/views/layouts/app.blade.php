<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Application</title>
    <!-- Ajoutez vos styles ici -->
</head>
<body>
    <header>
        <h1>Bienvenue sur mon application</h1>
    </header>

    <main>
        @yield('content') <!-- Contenu des vues qui étendent ce layout -->
    </main>

    <footer>
        <p>&copy; 2024 Mon Application</p>
    </footer>
</body>
</html>
