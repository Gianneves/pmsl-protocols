<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=h1, initial-scale=1.0">
    <title>Protocolos</title>
</head>

<body>
    <h2 style="text-align: center;">Protocolos</h2>

    <table style="border-collapse: collapse; width: 100%">
        <thead>
            <tr style="background-color: #adb5db;">
                <th style="border: 1px solid #ccc;">Nome</th>
                <th style="border: 1px solid #ccc;">Data</th>
                <th style="border: 1px solid #ccc;">Descrição</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($protocols as $protocol)
                <tr>
                    <td style="border: 1px solid #ccc; border-top: none;">{{ $protocol->person->name }}</td>
                    <td style="border: 1px solid #ccc; border-top: none;">{{ $protocol->created_at->format('d/m/Y') }}</td>
                    <td style="border: 1px solid #ccc; border-top: none;">{{ $protocol->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nenhum protocolo encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
