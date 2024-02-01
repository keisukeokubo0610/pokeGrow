@extends('bootstrap_layout.base_layout')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">育成論</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">育成論作成</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg my-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Create Pokemon Grow</h3>
                        </div>
                        <div class="card-body">

                            <form class="mt-3" action="{{ route('arrange.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">記事タイトル</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="いじっぱりHA">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">名前または図鑑番号</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="flutter-mane">
                                </div>
                                <div class="mb-3">
                                    <label for="ability" class="form-label">特性</label>
                                    <input type="text" class="form-control" id="ability" name="ability">
                                </div>
                                <div class="mb-3">
                                    <label for="nature" class="form-label">性格</label>
                                    <select class="form-select" name="nature">
                                        <option selected value="0">性格を選択してください</option>
                                        @foreach ($natureList as $nature)
                                            <option value="{{ $nature }}">{{ $nature }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2">
                                        <label for="effort_hp" class="form-label">努力値（H）</label>
                                        <input type="text" class="form-control" id="effort_hp" name="effort_hp">
                                    </div>
                                    <div class="col-2">
                                        <label for="effort_attack" class="form-label">努力値（A）</label>
                                        <input type="text" class="form-control" id="effort_attack" name="effort_attack">
                                    </div>

                                    <div class="col-2">
                                        <label for="effort_defense" class="form-label">努力値（B）</label>
                                        <input type="text" class="form-control" id="effort_defense"
                                            name="effort_defense">
                                    </div>
                                    <div class="col-2">
                                        <label for="effort_special_attack" class="form-label">努力値（C）</label>
                                        <input type="text" class="form-control" id="effort_special_attack"
                                            name="effort_special_attack">
                                    </div>
                                    <div class="col-2">
                                        <label for="effort_special_defense" class="form-label">努力値（D）</label>
                                        <input type="text" class="form-control" id="effort_special_defense"
                                            name="effort_special_defense">
                                    </div>
                                    <div class="col-2">
                                        <label for="effort_speed" class="form-label">努力値（S）</label>
                                        <input type="text" class="form-control" id="effort_speed" name="effort_speed">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="move1" class="form-label">技1</label>
                                        <input type="text" class="form-control" id="move1" name="move1">
                                    </div>
                                    <div class="col-6">
                                        <label for="move2" class="form-label">技2</label>
                                        <input type="text" class="form-control" id="move2" name="move2">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="move3" class="form-label">技3</label>
                                        <input type="text" class="form-control" id="move3" name="move3">
                                    </div>
                                    <div class="col-6">
                                        <label for="move4" class="form-label">技4</label>
                                        <input type="text" class="form-control" id="move4" name="move4">
                                    </div>
                                </div>
                                <div class="row  mb-3">
                                    <div class="col-6">
                                        <label for="held_item" class="form-label">持ち物</label>
                                        <input type="text" class="form-control" id="held_item" name="held_item">
                                    </div>
                                    <div class="col-6">
                                        <label for="teraType" class="form-label">テラスタイプ</label>
                                        <select name="teraType" class="form-select" aria-label="Default select example">
                                            <option selected>タイプを選択してください</option>
                                            @foreach ($typeList as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <textarea class="form-control" name="note" id="" cols="30" rows="6">
参考元：
参考URL：

                                                </textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="form-control btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
