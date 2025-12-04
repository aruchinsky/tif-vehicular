<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informe del Operativo</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 20px; margin-bottom: 10px; }
        h2 { font-size: 16px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

    <h1>Informe del Operativo – {{ $control->fecha }}</h1>
    <p><strong>Lugar:</strong> {{ $control->lugar }}</p>
    <p><strong>Ruta:</strong> {{ $control->ruta }}</p>
    <p><strong>Móvil:</strong> {{ $control->movil_asignado }}</p>
    <p><strong>Operador:</strong> {{ $personal->nombre_apellido }}</p>

    <h2>Conductores Registrados</h2>
    <table>
        <thead>
            <tr>
                <th>Nombre</th><th>DNI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($conductores as $c)
                <tr>
                    <td>{{ $c->nombre_apellido }}</td>
                    <td>{{ $c->dni_conductor }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Vehículos Requisados</h2>
    <table>
        <thead>
            <tr>
                <th>Marca/Modelo</th><th>Dominio</th><th>Color</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehiculos as $v)
                <tr>
                    <td>{{ $v->marca_modelo }}</td>
                    <td>{{ $v->dominio }}</td>
                    <td>{{ $v->color }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Novedades</h2>
    @if ($novedades->isEmpty())
        <p>No se registraron novedades.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tipo</th><th>Aplica</th><th>Observación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($novedades as $n)
                    <tr>
                        <td>{{ $n->tipo_novedad }}</td>
                        <td>{{ $n->aplica }}</td>
                        <td>{{ $n->observaciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
