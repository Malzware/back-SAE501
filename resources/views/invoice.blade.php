<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>List of users</h1>
    <table>
        <thead>
            <th>#</th>
            <th>firstname</th>
            <!-- <th>lastname</th> -->
            <th>email</th>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td>{{$user->name}}</td>
                <!-- <td>{{$user->lastname}}</td> -->
                <td>{{$user->email}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>