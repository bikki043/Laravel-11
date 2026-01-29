<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/thsarabunnew.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew';
            font-size: 20px;
            line-height: 1.2;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">{{ $title }}</div>
    <div class="text-right">Date: {{ $date }}</div>

    <table>
        <thead>
            <tr>
                <th width="10%">ID</th>
                <th width="45%">Name</th>
                <th width="45%">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td style="text-align: center;">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
