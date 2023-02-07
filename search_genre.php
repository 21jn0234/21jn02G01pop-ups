<?php
    require_once './helpers/db_helper.php';
    $dbh=get_db_connect();
    
    
    $genre='';
    if(isset($_GET['genre'])){
        $genre = $_GET['genre'];
    }    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/search_results.css" rel="stylesheet" />
    <title>ジャンル検索</title> 
    <script src="./jquery-3.6.0.min.js"></script>
    <body style="background-color:#e0ccab;">
</head>
<body>

<?php include "header.php" ?>

<h1>ジャンルから探す</h1>

<form id="form1" action="">
            <input id="sbox" name="genre" type="text" style="width: 420px; height: 50px;" value="<?= $genre ?>" />
            <input id="sbtn" type="submit" style="width: 60px; height: 55px;" value="🔎"/>
</form>

<select name="select" onChange="location.href=value;">
        <option value="search_tenpo.php">お店から探す</option>
        <option value="#" selected>ジャンルから探す</option>
        <option value="search_results.php">商品名で探す</option>
</select>
<?php
    if($genre!=""){
        $search_genre=select_genre_search($dbh,$genre);
    }
    else{
        
        $search_genre=select_genre_aiueo($dbh);
    }
?>
<h2>ジャンル一覧</h2>

<?php foreach($search_genre as $genre): ?>
    <div class="goodsgroup">
    <table>
        <tr>        
            <td class="name">
                <a href="search_results.php?genreCode=<?= $genre['genreCode'] ?>">
                <img src="images/<?php print $genre['photo'] ?>"width='100' height="100"/>
            </td>
            <td>
                <a href="search_results.php? genreCode=<?= $genre['genreCode'] ?>">
                <?= mb_strimwidth($genre['genreName'] , 0, 20, '…', 'UTF-8')?></a>
                
            </td>
        </tr>
    </table>
    </div>
<?php endforeach ?>

    <?php if($search_genre==Array ( )){ ?>
        <h2>検索結果</h2>
        <p>該当するジャンルはありません。</p>
    <?php } ?>

