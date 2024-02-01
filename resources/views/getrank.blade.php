<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>



<body>
    <div class="content">
        <div class="title m-b-md">
            ポケモンバトル<br>
            採用率ランキング
        </div>
        <?php
        $fp = fopen('../with_poke_lists.json', 'r');
        $json = fgets($fp);
        $with_poke_lists = json_decode($json, true);
        fclose($fp);
        
        foreach (array_keys($with_poke_lists) as $index) {
            echo '<br>';
            if ($index <= 895) {
                $img_num = $index;
                if (preg_match('/_/', $img_num)) {
                    $img_num = substr($index, 0, -2);
                    if (in_array($img_num, ['641', '642', '645'], true)) {
                        $img_num = $img_num . '-therian';
                    }
                }
                $fp = fopen("../sprites/sprites/pokemon/$img_num.png", 'rb');
                $img = fread($fp, 4000);
                fclose($fp);
                $enc_img = base64_encode($img);
                $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
                echo '<img src="data:' . $imginfo['mime'] . ';base64,' . $enc_img . '" style="width: 200px">';
            }
        
            foreach ($with_poke_lists[$index] as $pokemon) {
                if ($pokemon['id'] <= 895) {
                    $img_num = $pokemon['id'];
                    // フォーム違い対応
                    if ($pokemon['form'] != 0) {
                        if (in_array($img_num, [641, 642, 645], true)) {
                            $img_num = $img_num . '-therian';
                        }
                    }
                    $fp = fopen('../sprites/sprites/pokemon/' . $img_num . '.png', 'rb');
                    $img = fread($fp, 4000);
                    fclose($fp);
                    $enc_img = base64_encode($img);
                    $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
                    echo '<img src="data:' . $imginfo['mime'] . ';base64,' . $enc_img . '">';
                }
            }
            echo '<br>';
        }
        ?>
    </div>
</body>

</html>
