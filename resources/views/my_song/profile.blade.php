@extends('layout.common')

@include('layout.header')

@section('content')
<div class="tyuuou">
    <div class="prof_img">
        <img src="/storage/image/Admin/prof_img.jpg" width="25%" style="position: fixed;">
    </div>
    <div class="prof_text">
        <span style="font-size: x-large;"><strong><font face="HG行書体">
            管理人プロフィール
        </font></strong></span>
    </div>
    <div class="prof_table">
        <table rules="all" border="3">
            <tr>
                <td class="name">アーティスト名</td>
                <td class="val">今井２号</td>
            </tr>
            <tr>
                <td class="name">あいさつ</td>
                <td class="val">
                    初めまして。<br>
                    当サイトにて、自身が歌唱に挑戦した曲を投稿させていただいております、今井２号と申します。<br>
                    この度は「俺の歌を育てろ」に訪問してくださり、誠にありがとうございます。<br>
                    サイトの趣旨は紹介ページにもございますが、どうぞ何なりと気付きや感想を仰ってください。<br>
                    オブラートに包む必要はありません。<br>
                    どんな口調やバッシングでも真摯に受け止めますので、どうか皆様のご意見を頂戴できればと思いますので、よろしくお願いいたします。
                </td>
            </tr>
            <tr>
                <td class="name">音楽との関わり</td>
                <td class="val">
                    ・１６歳<br>
                    修学旅行のバスで、カラオケ企画が催される<br>
                    くじ引きの結果歌うことになり、平井堅の「おじいさんの古時計」を熱唱するが、あまりの下手さに皆が凍りつき、カラオケの盛り上げ役は無理だと悟る<br><br>

                    ・１７歳<br>
                    人生初となるエレキギターを購入<br>
                    この時は弾き語りなどが目的ではなく、単純にギターを弾いてみたいという欲求からだった<br><br>

                    ・１９歳<br>
                    スピッツやBUMP OF CHICKENに影響を受け、弾き語りを始める<br>
                    ストリートライブにもチャレンジ<br>
                    この時に録音しておいた音源を後に聞くと、ふざけてるのかと思うくらいクオリティが壊滅的であった<br><br>

                    ・２０歳<br>
                    初めて結成したロックバンドで、ギターボーカルを担当<br>
                    ライブバーで演奏した時、あまりの下手さにまたもや客席が凍りつき、二度目の氷河期を経験<br>
                    後に、バーのマスターがボーカルの交代を提案していたことを、バンド仲間から伝え聞いて、ショックを受ける<br>
                    状況を打破するためにボーカルスクールに通うも、特に芽が出ないまま、新しい職に就いたことをきっかけに、人前で歌う機会からは遠ざかっていった<br><br>

                    ・２５歳<br>
                    知人から誘いを受け、アマチュアのミュージカル劇に出演することになる<br>
                    毎日のようにカラオケボックスや通勤中の車内で歌っていたため、この時期に少しは上達したと実感<br>
                    とはいえ、独学での自主練には限界があり、やはり不安は否めなかった<br><br>

                    ・現在<br>
                    サイト「俺の歌を育てろ」を設立<br>
                    自らの目標に向けて、鋭意活動中
                </td>
            </tr>
            <tr>
                <td class="name">目標</td>
                <td class="val">カラオケ大会で過去の雪辱を晴らす</td>
            </tr>
            <tr>
                <td class="name">出身地</td>
                <td class="val">日本（山口県下松市生まれ）</td>
            </tr>
            <tr>
                <td class="name">
                    性別
                </td>
                <td class="val">
                    男（歌声聞いたら分かりますが...）
                </td>
            </tr>
            <tr>
                <td class="name">
                    性格
                </td>
                <td class="val">
                    人間不信
                </td>
            </tr>
            <tr>
                <td class="name">
                    趣味
                </td>
                <td class="val">
                    投資
                </td>
            </tr>
            <tr>
                <td class="name">
                    特技
                </td>
                <td class="val">
                    バドミントン（県大会出場経験有）
                </td>
            </tr>
            <tr>
                <td class="name">
                    座右の銘
                </td>
                <td class="val">
                    精神論よりシステム
                </td>
            </tr>
            <tr>
                <td class="name">
                    好きな食べ物<br>嫌いな食べ物
                </td>
                <td class="val">
                    ピザ<br>数の子
                </td>
            </tr>
            <tr>
                <td class="name">
                    カッコイイと思う物
                </td>
                <td class="val">
                    スーパーXシリーズ
                </td>
            </tr>
            <tr>
                <td class="name">
                    尊敬する人物
                </td>
                <td class="val">
                    過去の俺
                </td>
            </tr>
            <tr>
                <td class="name">
                    自分を動物に例えると
                </td>
                <td class="val">
                    ジャンガリアンハムスター
                </td>
            </tr>
            <tr>
                <td class="name">
                    何か一言
                </td>
                <td class="val">
                    訪問してくれてありがとうございます。<br>
                    精一杯努力いたしますので、よろしくお願いします！
                </td>
            </tr>
        </table>
    </div>
</div>

<style>
.tyuuou {
    box-sizing: border-box;
    margin-left: auto;
    margin-right: auto;
}
.prof_img {
    float: left;
    width: 25%;
    height: 400px;
    margin-left: 10px;
}
.prof_text {
    float: right;
    width: 70%;
    text-align: center;
    margin-bottom: 10px;
}
.prof_table {
    float: right;
    width: 70%;
    margin-bottom: 100px;
}
table {
    border: solid 3px black;
    border-collapse: collapse;
}
.name {
    width: 20%;
    text-align: center;
    padding: 5px;
    border: solid 3px black;
    border-collapse: collapse;
}
.val {
    width: 50%;
    text-align: left;
    padding: 5px;
    border: solid 3px black;
    border-collapse: collapse;
}
</style>
@endsection