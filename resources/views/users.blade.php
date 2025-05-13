<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List with Redis Cache</title>
    <style>
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }
        body { font-family: Arial, sans-serif; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">User List</h2>

    <div style="text-align: center; margin-bottom: 10px;">
        <a href="/clear-users-cache">Clear Cache</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td> 
                <td>{{ $user->email }}</td> 
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
