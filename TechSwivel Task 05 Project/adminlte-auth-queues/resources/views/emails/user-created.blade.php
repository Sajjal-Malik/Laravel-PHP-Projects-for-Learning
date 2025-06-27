<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New User Registered</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            margin: 0;
        }

        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 30px;
            box-shadow: 0 0 8px rgba(0,0,0,0.05);
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 12px;
            font-size: 15px;
        }

        .info span {
            font-weight: 600;
            color: #343a40;
            display: inline-block;
            min-width: 120px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="email-wrapper">
        <h2>New User Registered</h2>

        <div class="info"><span>Name:</span> {{ $user->name }}</div>
        <div class="info"><span>Email:</span> {{ $user->email }}</div>
        <div class="info"><span>Role:</span>
            @if ($user->role == 1)
                Admin
            @elseif ($user->role == 2)
                Employee
            @else
                Unknown
            @endif
        </div>
        <div class="info"><span>Status:</span> {{ $user->status }}</div>
        <div class="info"><span>Joined:</span> {{ $user->createdAt->format('F j, Y, g:i A') }}</div>

        <div class="footer">
            Thank you for using our system.<br>
            Laravel Admin Panel Team
        </div>
    </div>

</body>
</html>
