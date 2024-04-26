<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=h1, initial-scale=1.0">
    <title>Protocolos</title>
</head>

<body>
    <h2 style="text-align: center;">Protocolo</h2>

    <table style="border-collapse: collapse; width: 100%">
        <thead>
            <tr style="background-color: #adb5db;">
                <th style="border: 1px solid #ccc;">Nome</th>
                <th style="border: 1px solid #ccc;">Prazo</th>
                <th style="border: 1px solid #ccc;">Descrição</th>
                <th style="border: 1px solid #ccc;">Departamento</th>
            </tr>
        </thead>
        <tbody>
            @if($protocols)
            <tr>
                <td style="border: 1px solid #ccc; border-top: none;">{{ optional($protocols->person)->name }}</td>
                <td style="border: 1px solid #ccc; border-top: none;">{{ $protocols->deadline }}</td>
                <td style="border: 1px solid #ccc; border-top: none;">{{ $protocols->description }}</td>
                <td style="border: 1px solid #ccc; border-top: none;">{{ optional($protocols->departaments)->name }}</td>
            </tr>
            @else
            <tr>
                <td colspan="3">Nenhum protocolo encontrado</td>
            </tr>
            @endif
        </tbody>
    </table>

    <h2 style="text-align: center;">Acompanhamento</h2>

    <table style="border-collapse: collapse; width: 100%">
        <thead>
            <tr style="background-color: #adb5db;">
                <th style="border: 1px solid #ccc;">Descrição</th>
                <th style="border: 1px solid #ccc;">Situação</th>
                <th style="border: 1px solid #ccc;">Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $att)
            <tr>
                <td style="border: 1px solid #ccc; border-top: none;">{{ $att->description }}</td>
                <td style="border: 1px solid #ccc; border-top: none;">
                    @if($att->situation === 'S')
                    Solucionado
                    @elseif($att->situation === 'A')
                    Aberto
                    @elseif($att->situation === 'E')
                    Em atendimento
                    @else
                    Valor desconhecido
                    @endif
                </td>
                <td style="border: 1px solid #ccc; border-top: none;">{{ $att->created_at->format('d/m/Y') }}</td>
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