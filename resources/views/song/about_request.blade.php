@extends('layout.common')

@include('layout.song.header')

@section('content')
<div class="question">Ｑ．追加してほしい機能があります</div>
<div class="answer">
    Ａ．運営とサイト開発者の間で協議して、必要そうなら追加を検討いたします。<br>
    が、なにぶん仕事の合間を縫っての自主制作サイトですので、即時実装は難しいことを御了承ください。
</div>

<div class="question">Ｑ．自分のアドバイスが消えました</div>
<div class="answer">
    Ａ．他の視聴者が発したアドバイスで下にズレた可能性もございます。<br>
    スクロールや画面リロード等で再度お確かめください。<br>
    当然ではありますが、アドバイスと関係ない<span style="color: red;">いたずらコメントは削除させていただいております</span>のでご注意を。
</div>

<div class="question">Ｑ．デザインに違和感があるような</div>
<div class="answer">
    Ａ．当サイトはスマホ閲覧も対象に制作しておりますので、見え方に差があるかもしれません。<br>
    ブラウザのキャッシュ消去等もお試しください。<br>
    機能の利用に影響があるようでしたら修正いたしますが、それ以外の場合は恐縮ですが御寛恕ください。
</div>

<div class="question">Ｑ．アカウントに称号のような文字が表示される</div>
<div class="answer">
    Ａ．特に意味はありません。<br>
    会員様ごとの活動実績により選出されるランキングのようなもので、指標として目指す程度でよいかと思われます。
</div>

<div class="question">Ｑ．他の会員の歌が聴けず、アドバイスも出来なくなった</div>
<div class="answer">
    Ａ．退会されたユーザーの歌唱曲はリストから除外され、アドバイスも送信できなくなります。<br>
    申し訳ありませんが、再度リロードしてご利用ください。
</div>

<div class="question">Ｑ．役に立った認定をしようと思ったら通信エラーが起きた</div>
<div class="answer" style="margin-bottom: 100px;">
    Ａ．管理側は定期的にアドバイス等を監視しており、いたずらコメントと見られる内容を削除しています。<br>
    他にもアドバイスを消去するケースもありますが、それとブッキングしてしまったケースが考えられます。<br>
    申し訳ありませんが、再度リロードしてご利用ください。
</div>

<style>
    body {
        padding-top: 5px;
        text-align: center;
        box-sizing: border-box;
    }
    .question {
        color: blue;
    }
    .answer {
        margin-top: 10px;
        margin-bottom: 30px;
    }
</style>
@endsection