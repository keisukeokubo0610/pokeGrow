@extends('bootstrap_layout.base_layout')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">育成論</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">育成論一覧</li>
            </ol>
            <div class="row">

                {{-- {{ $pokemons }} --}}
                @foreach ($pokemons as $pokemon)
                    <div class="col-xl-3 col-md-6">
                        <div class="card  mb-4">
                            <a href="{{ route('pokemon.detail', $pokemon->p_id) }}" class="card__link small stretched-link">

                                <div class="card-body">
                                    <img src="{{ $pokemon->img_path }}" class="card-img-top img-shadow" alt="image_cap">
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-center">
                                    <div class="card-body">
                                        <p class="card-text text-center">図鑑No.{{ $pokemon->p_id }}</p>
                                        <h5 class="card-title text-center">{{ $pokemon->jp_name }}</h5>
                                        <p class="card-text text-center">
                                            {{ $pokemon->hp . '-' . $pokemon->attack . '-' . $pokemon->defense . '-' . $pokemon->special_attack . '-' . $pokemon->special_defense . '-' . $pokemon->speed }}
                                        </p>
                                        <p class="card-text text-center">
                                            @if (!empty($pokemon->ability2))
                                                {{ $pokemon->ability1 . ' / ' . $pokemon->ability2 }}
                                            @else
                                                {{ $pokemon->ability1 }}
                                            @endif
                                        </p>
                                        <p class="card-text text-center">投稿数：{{ $pokemon->arranges_count }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
