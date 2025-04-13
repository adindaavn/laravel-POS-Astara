<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 10px;
        }

        thead th {
            background-color: rgb(220, 233, 247);
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">{{ $title }}</h3>
    <p style="text-align: center;">Tanggal Cetak: {{ $date }}</p>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    @foreach ($headings as $heading)
                    <th>{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    @foreach ($item as $value)
                    <td>{{ $value }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>