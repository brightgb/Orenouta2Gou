@extends('layout.common')

@include('layout.header')

@section('content')
<div class="question">Ｑ．追加してほしい機能があるのですが</div>
<div class="answer">
    Ａ．私とサイト開発者の間で協議して必要そうなら追加を検討いたします。<br>
    が、なにぶん仕事の合間を縫っての自主制作サイトですので、即時実装は難しいことを御了承ください。
</div>

<div class="question">Ｑ．自分のコメントが消えました</div>
<div class="answer">
    Ａ．他の視聴者が発したコメントで下にズレた可能性もございます。<br>
    スクロールや画面リロード等で再度お確かめください。<br>
    当然ではありますが、アドバイスと関係ない<span style="color: red;">いたずらコメントは削除させていただいております</span>のでご注意を。
</div>

<div class="question">Ｑ．エラーの起きる画面があります</div>
<div class="answer">
    Ａ．メニュー名に開発中とある画面は未完成のためご利用になれません。<br>
    既にリリースしてある画面の場合は、なるべく急務で修正いたします。
</div>

<div class="question">Ｑ．デザインに違和感があるような</div>
<div class="answer">
    Ａ．当サイトはスマホ閲覧も対象に制作しておりますが、多少見栄えに差があるかもしれません。<br>
    機能の利用に影響があるようでしたら修正いたしますが、それ以外の場合は恐縮ですが御寛恕ください。
</div>

<div class="question">Ｑ．挑戦してほしい曲があります</div>
<div class="answer" style="margin-bottom: 100px;">
    Ａ．ご要望、ありがとうございます。<br>
    もちろん頑張らせていただきますが、なにぶん仕事の合間を（略
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