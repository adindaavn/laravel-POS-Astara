<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }

        thead th {
            background-color:rgb(220, 233, 247);
            /* Biru muda */
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">{{ $title }}</h2>
    <p style="text-align: center;">Tanggal: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengaju</th>
                <th>Nama Buku</th>
                <th>Tanggal Pengajuan</th>
                <th>Qty</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuan as $index => $data)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $data->member->nama }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->tgl }}</td>
                <td style="text-align: center;">{{ $data->qty }}</td>
                <td style="text-align: center;">
                    {{ $data->status == 0 ? 'Proses' : 'Terpenuhi' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>