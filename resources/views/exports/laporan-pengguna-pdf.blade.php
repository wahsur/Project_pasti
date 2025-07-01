<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengguna</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            text-align: center;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h3>Laporan Pengguna</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama User</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($member as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->nama}}</td>
                    <td>{{ $item->email}}</td>
                    <td>{{ $item->telepon}}</td>
                    <td>{{ $item->alamat}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>