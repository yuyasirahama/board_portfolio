<!DOCTYPE html>
<html lang="ja">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <style type="text/css">
    /*ページネーション用css */
    nav{
        text-align: center;
    }
    nav ul{
        margin: 0 ;
        padding: 0 ;
    }
    nav ul li{
        list-style: none;
        display: inline-block;
        min-width: 20px;
    }
    nav ul li a{
        text-decoration: none;
        color: #333;
    }
    nav ul li.current a{
        color: #F33135;
    }

    nav ul li a:hover{
        color: #E7DA66;
    }

    /*上部ナビ用css */
    nav.nav{
        text-align: center;
    }
    nav.nav ul{
        margin: 0 ;
        padding: 0 ;
    }
    nav.nav ul li{
        list-style: none;
        display: inline-block;
        width: 18%;
        min-width: 90px;
    }
    nav.nav ul li a{
        text-decoration: none;
        color: black;
        font-weight: bold;
    }

    nav.nav ul li a.current{
        background-color: yellow;
    }

    nav.nav ul li a:hover{
        color: #E7DA66;
    }

    table td {/*table内のtdに対して*/
        padding: 3px 10px;/*上下3pxで左右10px*/
    }

    table td.name {/*table内のtdに対して*/
        border: 2px #2b2b2b solid;
        border-color: grey;
    }

    table td.email {/*table内のtdに対して*/
        color: grey;
    }

    a.button001 {
        background: #555;
        color: #fff;
        text-decoration:none;
        border-radius: 5px;
        padding:2px 4px;
    }

    a.button001:hover {
        opacity: .7;
    }
    </style>
</head>
<body>

<!-- ▼▼▼▼共通ヘッダー▼▼▼▼　-->
<header>
    <nav class="nav">
        <ul>
            @yield('header')
        </ul>
    </nav>
</header>
<!-- ▲▲▲▲共通ヘッダー▲▲▲▲　-->

<!-- ▼▼▼▼ページ毎の個別内容▼▼▼▼　-->
<main>
@yield('content')
</main>
<!-- ▲▲▲▲ページ毎の個別内容▲▲▲▲　-->

<!-- ▼▼▼▼共通フッター▼▼▼▼　-->
<footer>
</footer>
<!-- ▲▲▲▲共通フッター▲▲▲▲　-->
</body>
</html>