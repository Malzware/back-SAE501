@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des ressources</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Code de Ressource</th>
                <th>Titre</th>
                <th>Semestre</th>
                <th>CM</th>
                <th>TD</th>
                <th>TP</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $resource)
            <tr id="resource-{{ $resource->id }}">
                <td>{{ $resource->id }}</td>
                <td><input type="text" class="form-control" value="{{ $resource->name }}" data-field="name"></td>
                <td><input type="text" class="form-control" value="{{ $resource->resource_code }}" data-field="resource_code"></td>
                <td><input type="text" class="form-control" value="{{ $resource->title }}" data-field="title"></td>
                <td>
                    <select class="form-control" data-field="id_semester">
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ $semester->id == $resource->id_semester ? 'selected' : '' }}>{{ $semester->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" class="form-control" value="{{ $resource->cm }}" data-field="cm"></td>
                <td><input type="number" class="form-control" value="{{ $resource->td }}" data-field="td"></td>
                <td><input type="number" class="form-control" value="{{ $resource->tp }}" data-field="tp"></td>
                <td>
                    <button class="btn btn-primary modify-btn" data-id="{{ $resource->id }}">Modifier</button>
                    <button class="btn btn-success save-btn" data-id="{{ $resource->id }}">Sauvegarder</button>
                    <button class="btn btn-danger delete-btn" data-id="{{ $resource->id }}">Supprimer</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Code de sauvegarde
        const saveButtons = document.querySelectorAll('.save-btn');
        saveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const resourceId = this.getAttribute('data-id');
                const row = document.getElementById('resource-' + resourceId);
                
                // Récupération des valeurs du formulaire
                const data = {
                    name: row.querySelector('[data-field="name"]').value,
                    resource_code: row.querySelector('[data-field="resource_code"]').value,
                    title: row.querySelector('[data-field="title"]').value,
                    id_semester: row.querySelector('[data-field="id_semester"]').value,
                    cm: row.querySelector('[data-field="cm"]').value || null,
                    td: row.querySelector('[data-field="td"]').value || null,
                    tp: row.querySelector('[data-field="tp"]').value || null,
                };

                console.log('Données à sauvegarder:', data);
                
                fetch(`/resources/${resourceId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Ressource mise à jour avec succès.');
                    } else {
                        alert('Erreur lors de la mise à jour de la ressource.');
                    }
                })
                .catch((error) => {
                    console.error('Erreur:', error);
                });
            });
        });

        // Code de suppression
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const resourceId = this.getAttribute('data-id');
                const row = document.getElementById('resource-' + resourceId);

                // Confirmation avant de supprimer
                if (confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?')) {
                    fetch(`/resources/${resourceId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => {
    if (response.ok) {
        return response.json();
    } else {
        throw new Error('Erreur lors de la mise à jour de la ressource.');
    }
})
.then(data => {
    if (data.success) {
        alert('Ressource mise à jour avec succès.');
    } else {
        alert('Erreur lors de la mise à jour de la ressource.');
    }
})
.catch((error) => {
    console.error('Erreur:', error);
    alert('Une erreur est survenue : ' + error.message);
});

                }
            });
        });
    });
</script>
@endsection
