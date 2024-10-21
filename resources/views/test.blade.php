<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recruitment Information</title>
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
        .content {
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Recruitment Information</h1>
    </div>

    <div class="content">
        <div class="info-item">
            <strong>First Name:</strong> {{ $firstname }}
        </div>
        <div class="info-item">
            <strong>Last Name:</strong> {{ $lastname }}
        </div>
        <div class="info-item">
            <strong>Email:</strong> {{ $email }}
        </div>
    </div>

    <div class="footer">
        <p>Generated on {{ date('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>