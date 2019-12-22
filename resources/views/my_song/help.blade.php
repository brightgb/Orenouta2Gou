@extends('layout.common')

@include('layout.header')

@section('content')
<div class="question">Ｑ．俺の歌を育てろ とは？</div>
<div class="answer">
    Ａ．皆様はよく某動画投稿サイトなどで、「～を歌ってみた」といったフレーズを一度は目にしたことがあるかと思います。<br>
    動画の投稿者がモチーフとなる曲に挑戦し、自身の歌を披露するというものですね。<br>
    実際に聞いてみると、得てして大体そういう投稿をする人はある程度のスキルがあり、少なからず応援者がいるものです。<br>
    当サイトも管理人自身が歌をアップロードするという趣旨では共通ですが、決定的に違うのは、「<span style="color: red;">素人丸出しの歌唱力</span>」であることです。<br>
    人によっては聞くに堪えないレベルかもしれませんが、本人は至って真面目です。<br>
    上手くなりたい願望は人一倍持っています。<br>
    よって当サイトは管理人の歌を育て上げ、上達させるという目的で立ち上げられました。
</div>
<div class="question">Ｑ．具体的には、どうすればいいの？</div>
<div class="answer">
    Ａ．不定期ですが、管理人が自身の歌を投稿します。ジャンルは多岐に渡ります。<br>
    皆様にはその歌い方に対して、アドバイスを送っていただきたく思います。<br>
    どんな些細なことでも構いません。<br>
    「息継ぎのタイミング」や「アクセントの強弱」など、皆様が気付いた点をどんどん書き込んでいってください。<br>
    管理人はその助言を真摯に受け止め努力していく所存です。
</div>
<div class="question">Ｑ．それって、いわゆる他力本願では？^^；</div>
<div class="answer" style="margin-bottom: 100px;">
    Ａ．否定はしません。そんなメリットもないことしたくもないでしょう。<br>
    しかし、自分のアドバイスで管理人のスキルが上がり、見違える、もとい聞き違えるほどの歌唱力を身に付けたとき、あなたはこう思うはずです。<br>
    <span style="color: red;">この歌手は、俺(私)が育て上げたのだ</span>、と。<br>
    気が向いたときで構いません。<br>
    どうか、皆様の厳しいご指導ご鞭撻をよろしくお願いいたします。
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