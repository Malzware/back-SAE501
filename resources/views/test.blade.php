<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Teaching Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 2cm;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Teaching Report</h1>
    </div>

    <div class="section">
        <h2>Teacher Information</h2>
        <p><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Roles:</strong> {{ implode(', ', $roles->toArray()) }}</p>
    </div>

    <div class="section">
        <h2>Teaching Hours by Resource</h2>
        <table>
            <thead>
                <tr>
                    <th>Resource</th>
                    <th>Semester</th>
                    <th>CM Hours</th>
                    <th>TD Hours</th>
                    <th>TP Hours</th>
                    <th>Total Hours</th>
                </tr>
            </thead>
            <tbody>
                @foreach($givenHours as $resourceHours)
                <tr>
                    <td>{{ $resourceHours['resource_name'] }}</td>
                    <td>{{ $resourceHours['semester'] }}</td>
                    <td>{{ $resourceHours['total_cm'] }}</td>
                    <td>{{ $resourceHours['total_td'] }}</td>
                    <td>{{ $resourceHours['total_tp'] }}</td>
                    <td>{{ $resourceHours['total_cm'] + $resourceHours['total_td'] + $resourceHours['total_tp'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Generated on {{ $generated_at->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>