@extends('layout.common')

@include('layout.song.header')

@section('content')
<div class="question">Ｑ．俺の歌を育てろ とは？</div>
<div class="answer">
    Ａ．サイトの利用者同士が自身の歌を投稿し、助言しあう場です。<br>
    歌唱力を競う大会で優勝を狙う人はもちろんのこと、単純に歌が上手くなりたい人も対象にしております。<br>
    投稿は義務ではないので、アドバイス役に徹することも可能です。<br><br>
    若い方たちは特にでしょうが、カラオケなど人前で歌う機会が少なからずあるもの。<br>
    やはり歌が上手いに越したことはありません。<br>
    そんなとき、どんな練習方法があるでしょうか。<br><br>

    一人カラオケ？・・・その手もありますね。<br>
    しかし、独学になる以上、どこかで手詰まりな状況を感じるかもしれません。<br><br>

    歌唱教室に通う？・・・確かに上達しそうです。<br>
    でも誰かに知られたくはないし、そもそも受講料を払う余裕もない人はどうすればよいでしょう。<br><br>

    当サイトは、そのような悩みを抱える方たちに、交流と研鑽の場を提供する目的で開設されました。<br>
    利用には会員登録が必要となりますが、上記の運営理念により、サイト内における<span style="color: red;">全てのコンテンツは無料</span>となっております。<br><br>

    また、先ほどアドバイス専門の活動も可能と記載しましたが、このサイトは未来の歌唱講師を目指す方にも、うってつけかと。<br>
    歌の投稿者は自身の歌へのアドバイスの中で、特に役立ったアドバイスに対して評価をすることが出来ます。<br>
    アドバイザーは自らの貢献度を数値として確認することで、更なる意欲と指導技術の向上に結び付くことでしょう。
</div>

<div class="question">Ｑ．曲の投稿って、どうやるの？</div>
<div class="answer">
    Ａ．YouTubeのアカウントをお持ちの方でしたら、ご自身で歌唱された曲動画のリンクを投稿画面から送信ください。<br>
    アカウントをお持ちでない方にも、運営が代理投稿できる体制を考案中ですが、いたずら防止の観点で難しく、現在は実装されておりません。
</div>

<div class="question">Ｑ．本当に無料？</div>
<div class="answer" style="margin-bottom: 100px;">
    Ａ．完全無料です。<br>
    　　歌の投稿や他の会員様の歌を聴くことで料金が発生することはございません。<br>
    　　ニックネームでの活動になりますので、プライバシーに関しても安心してご利用ください。
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