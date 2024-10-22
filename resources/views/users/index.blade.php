<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
</head>
<body>
    <h1>Liste des Utilisateurs</h1>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('users.create') }}">Ajouter un Nouvel Utilisateur</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr id="user-{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td><input type="text" class="form-control" value="{{ $user->lastname }}" data-field="lastname"></td>
                    <td><input type="text" class="form-control" value="{{ $user->firstname }}" data-field="firstname"></td>
                    <td><input type="text" class="form-control" value="{{ $user->email }}" data-field="email"></td>
                    <td>
                        <button class="btn btn-primary save-btn" data-id="{{ $user->id }}">Sauvegarder</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saveButtons = document.querySelectorAll('.save-btn');
            saveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const row = document.getElementById('user-' + userId);
                    const data = {
                        lastname: row.querySelector('[data-field="lastname"]').value,
                        firstname: row.querySelector('[data-field="firstname"]').value,
                        email: row.querySelector('[data-field="email"]').value,
                        // Ajouté si un champ de mot de passe est nécessaire
                        // password: row.querySelector('[data-field="password"]').value,
                    };

                    fetch(`/users/${userId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Une erreur est survenue lors de la mise à jour');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Utilisateur mis à jour avec succès');
                        } else {
                            alert('Erreur lors de la mise à jour de l\'utilisateur');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de la mise à jour de l\'utilisateur.');
                    });
                });
            });
        });
    </script>
</body>
</html>
