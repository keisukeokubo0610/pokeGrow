<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokeapiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ポケモン一覧
Route::get('/', [PokeapiController::class, 'index'])->name('arrange.index');
// ポケモン詳細表示
Route::get('/pokemon/{id}', [PokeapiController::class, 'pokemonDetail'])->name('pokemon.detail');
// 育成論詳細
Route::get('/arrange/{id}', [PokeapiController::class, 'arrangeDetail'])->name('arrange.detail');

Route::get('/getrank', function () {
    return view('getrank');
});

Route::get('/register', [PokeapiController::class, 'register'])->name('arrange.register');
Route::post('/register/store', [PokeapiController::class, 'store'])->name('arrange.store');


// 取得テスト
// Route::get('/list', [PokeapiController::class, 'index'])->name('show.index');

// Route::get('/', [PokeapiController::class, 'index'])->name('show.index');

// ポケモンの図鑑番号を非同期で取得
Route::get('/pokemon/{name}', [PokeapiController::class, 'getPokemon']);
