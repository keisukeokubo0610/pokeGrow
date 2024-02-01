@extends('bootstrap_layout.base_layout')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">育成論</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">育成論詳細</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg my-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Arrange Detail</h3>
                        </div>
                        <div class="card-body">
                            <img src="{{ $arrange->pokemons->img_path }}" class="card-img-top img-shadow" alt="image_cap">
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-center">
                            <div class="card-body">
                                <p class="card-text text-center">図鑑No.{{ $arrange->pokemons->p_id }}</p>
                                <h5 class="card-title text-center">{{ $arrange->pokemons->jp_name }}</h5>
                                <p class="card-text text-center">
                                    @if (!empty($pokemon->type2))
                                        {{ $arrange->pokemons->type1 . ' / ' . $arrange->pokemons->type2 }}
                                    @else
                                        {{ $arrange->pokemons->type1 }}
                                    @endif
                                </p>

                                <p class="card-text text-center">{{ $arrange->nature }}</p>
                                <p class="card-text text-center">{{ $arrange->held_item }}</p>

                                <p class="card-text text-center">
                                    {{ $arrange->pokemons->hp .
                                        '(' .
                                        $arrange->effort_hp .
                                        ')' .
                                        '-' .
                                        $arrange->pokemons->attack .
                                        '(' .
                                        $arrange->effort_attack .
                                        ')' .
                                        '-' .
                                        $arrange->pokemons->defense .
                                        '-' .
                                        '(' .
                                        $arrange->effort_defense .
                                        ')' .
                                        $arrange->pokemons->special_attack .
                                        '-' .
                                        '(' .
                                        $arrange->effort_special_attack .
                                        ')' .
                                        $arrange->pokemons->special_defense .
                                        '-' .
                                        '(' .
                                        $arrange->effort_special_defense .
                                        ')' .
                                        $arrange->pokemons->speed .
                                        '(' .
                                        $arrange->effort_speed .
                                        ')' }}
                                </p>
                                <p class="card-text text-center">
                                    {{ $arrange->ability }}
                                </p>
                                <p class="card-text text-center">
                                    {{ $arrange->move1 . ' / ' . $arrange->move2 }}
                                    <br>
                                    {{ $arrange->move3 . ' / ' . $arrange->move4 }}
                                </p>
                                <p class="card-text text-center">
                                    {{ $arrange->note }}
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
