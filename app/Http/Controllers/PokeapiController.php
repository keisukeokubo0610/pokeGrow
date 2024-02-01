<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use \Carbon\Carbon;
use App\Models\Pokemon;
use App\Models\Arrange;
use App\Consts\NatureConst;
use App\Consts\TypeConst;

class PokeapiController extends Controller
{

    protected $natures;
    protected $types;

    public function __construct()
    {
        $this->natures = NatureConst::NATURE_LIST;
        $this->types = TypeConst::TYPE_LIST;
    }


    // 非同期処理で図鑑No.から名前取得
    public function getPokemon($name)
    {
        $client = new Client();
        $response = $client->get("https://pokeapi.co/api/v2/pokemon-species/{$name}");
        $data = json_decode($response->getBody(), true);

        $japaneseName = null;
        foreach ($data['names'] as $name) {
            if ($name['language']['name'] == 'ja') {
                $japaneseName = $name['name'];
                break;
            }
        }

        return response()->json([
            'id' => $data['id'],
            'japanese_name' => $japaneseName
        ]);
    }


    //* 一覧取得
    public function index()
    {
        $arranges = Arrange::all();
        $pokemons = Pokemon::withCount('arranges')->orderBy('p_id')->get();

        //* 育成論新しい日付
        //!全部のレコードを参照にしているので、これを一つのレコード対象に変えたい
        // $rowLatestArrangeRecord = Arrange::select('created_at')->orderBy('created_at', 'desc')->pluck('created_at')->first();

        // Carbonを使ってフォーマット変更
        // $latestArrangeRecord = Carbon::parse($rowLatestArrangeRecord)->format('Y/m/d');
        return view('bootstrap_layout.index', compact('pokemons', 'arranges'));
    }

    public function pokemonDetail($id)
    {
        $pokemon = Pokemon::where('p_id', $id)->first();
        // dd($pokemon);
        $arranges = Arrange::with('pokemons')->where('poke_id', $pokemon->id)->get();

        // dd($arranges);
        return view('bootstrap_layout.pokemon_detail', compact('pokemon', 'arranges'));
    }

    public function arrangeDetail($id)
    {
        $arrange = Arrange::with('pokemons')->where('id', $id)->first();

        // dd($arrange);
        return view('bootstrap_layout.arrange_detail', compact('arrange'));
    }

    public function register()
    {
        $natureList = $this->natures;
        $typeList = $this->types;

        // session()->flash('error_message', '登録に失敗しました。');

        return view('bootstrap_layout/register', compact('natureList', 'typeList'));
    }


    // 育成論登録
    public function store(Request $request)
    {
        //* 小文字に変換
        $name = strtolower($request->name);

        //* api接続
        $client = new Client();

        try {
            //* 各ポケモンの詳細情報を取得
            $detailResponse = $client->request('GET', "https://pokeapi.co/api/v2/pokemon/{$name}");
            $detailData = json_decode($detailResponse->getBody(), true);
        } catch (\Exception $e) {
            dd($e);
            session()->flash('error_message', 'API通信に失敗しました。');
            return redirect(route('arrange.register'));
        }

        //* 日本語名を探す
        $speciesResponse = $client->request('GET', $detailData['species']['url']);
        $speciesData = json_decode($speciesResponse->getBody(), true);
        $japaneseName = '';
        foreach ($speciesData['names'] as $name) {
            if ($name['language']['name'] == 'ja') {
                $japaneseName = $name['name'];
                break;
            }
        }

        //* 図鑑番号を取得
        $pokemonNumber = $speciesData['pokedex_numbers'][0]['entry_number'];


        //* ポケモン画像URL取得
        $imageUrl = $detailData['sprites']['other']['official-artwork']['front_default'];
        if ($imageUrl) {
            $imageContent = file_get_contents($imageUrl);
            $path = 'public/images/pokemon_img/' . $japaneseName . '.png';
            Storage::put($path, $imageContent);
        }
        //* 種族値を取得
        $stats = [];
        if (isset($detailData['stats'])) {
            foreach ($detailData['stats'] as $stat) {
                $stats[$stat['stat']['name']] = $stat['base_stat'];
            }
        }
        //* 合計種族値計算
        $total_stats = $stats['hp'] + $stats['attack'] + $stats['defense'] + $stats['special-attack'] +
            $stats['special-defense'] + $stats['speed'];


        //* 日本語のタイプ取得
        $types = $detailData['types'];
        foreach ($types as $type) {
            $typeUrl = $type['type']['url'];
            $curl = curl_init($typeUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $typeResponse = curl_exec($curl);
            curl_close($curl);

            if ($typeResponse) {
                $typeData = json_decode($typeResponse, true);
                foreach ($typeData['names'] as $name) {
                    if ($name['language']['name'] == 'ja') {
                        $typesInJapanese[] = $name['name'];
                    }
                }
            }
        }

        //* 日本語の特性取得
        $abilities = $detailData['abilities'];
        foreach ($abilities as $ability) {
            $typeUrl = $ability['ability']['url'];
            $curl = curl_init($typeUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $abilityResponse = curl_exec($curl);
            curl_close($curl);

            if ($abilityResponse) {
                $abilityData = json_decode($abilityResponse, true);
                foreach ($abilityData['names'] as $name) {
                    if ($name['language']['name'] == 'ja') {
                        $abilityInJapanese[] = $name['name'];
                    }
                }
            }
        }

        $abilityInJapanese = array_unique($abilityInJapanese); // 重複を削除

        //* モデルのインスタンス生成
        $pokemon = new Pokemon();
        $arrange = new Arrange();

        //* DB登録
        try {
            $newPokemon = $pokemon::firstOrCreate(
                ['p_id' => $pokemonNumber], // 検索条件
                [
                    // 作成される新しいポケモンの属性
                    'jp_name' => $japaneseName,
                    'type1' => $typesInJapanese['0'],
                    'type2' => $typesInJapanese['1'] ?? '',
                    'img_path' => $imageUrl,
                    'ability1' => $abilityInJapanese['0'],
                    'ability2' => $abilityInJapanese['1'] ?? '',
                    'hp' => $stats['hp'],
                    'attack' => $stats['attack'],
                    'defense' => $stats['defense'],
                    'special_attack' => $stats['special-attack'],
                    'special_defense' => $stats['special-defense'],
                    'speed' => $stats['speed'],
                    'total_stats' => $total_stats,
                ]
            );

            $poke_id = $newPokemon->id;

            $arrange->create([
                'poke_id' => $poke_id,
                'title' => $request->title,
                'ability' => $request->ability,
                'nature' => $request->nature,
                'held_item' => $request->held_item,
                // 技
                'move1' => $request->move1,
                'move2' => $request->move2,
                'move3' => $request->move3,
                'move4' => $request->move4,
                // 努力値
                'effort_hp' => $request->effort_hp,
                'effort_attack' => $request->effort_attack,
                'effort_defense' => $request->effort_defense,
                'effort_special_attack' => $request->effort_special_attack,
                'effort_special_defense' => $request->effort_special_defense,
                'effort_speed' => $request->effort_speed,
                'note' => $request->note,
            ]);




            session()->flash('info_message', '登録が完了しました。');
        } catch (\Exception $e) {
            dd($e);
            // エラー処理（ログ記録、エラーメッセージのセットなど）
            session()->flash('error_message', '登録に失敗しました。' . $e);
        }



        return redirect(route('arrange.register'));
    }
}
