<!DOCTYPE html>
<html lang="Ja">
<head>
    <meta charset="utf-8">
    <!--<link href="css/    .css" rel="stylesheet" /> -->
    <title>条件検索</title> 
    <!-- jQueryファイルの読み込み -->
    <script src="./jquery-3.6.0.min.js"></script>
    

</head>

<body style="background-color:#e0ccab;">

    <?php include "header.php" ?>

    
    <h1>詳しい条件で探す</h1>
    <input type="button" onclick="location.href='search_tenpo.php'" value="お店から探す" >
    <input type="button" onclick="location.href='search_genre.php'" value="ジャンルから探す"　>
    <input type="button" onclick="location.href='search_results.php'" value="商品名で探す"　>
    