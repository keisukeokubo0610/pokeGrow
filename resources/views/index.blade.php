<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    @foreach ($pokemonDetails as $pokemon)
        <table>
            <tbody>
                <tr>
                    <td>
                        <p>{{ $pokemon['pokemon_number'] }}</p>
                    </td>
                    <td>
                        <h2>{{ $pokemon['japanese_name'] }}</h2>
                    </td>
                    <td>
                        <p>{{ $pokemon['stats']['hp'] .
                            '-' .
                            $pokemon['stats']['attack'] .
                            '-' .
                            $pokemon['stats']['defense'] .
                            '-' .
                            $pokemon['stats']['special-attack'] .
                            '-' .
                            $pokemon['stats']['special-defense'] .
                            '-' .
                            $pokemon['stats']['speed'] }}
                        </p>
                    </td>

                    <td><img src="{{ $pokemon['image_url'] }}" alt="{{ $pokemon['japanese_name'] }}"></td>
                </tr>
            </tbody>
        </table>
    @endforeach

</body>

</html>
