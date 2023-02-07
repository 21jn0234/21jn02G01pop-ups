<?php
    require_once './helpers/db_helper.php';
    $dbh=get_db_connect();
    
    
    $tenpo='';
    if(isset($_GET['tenpo'])){
        $tenpo = $_GET['tenpo'];
    }    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/search_results.css" rel="stylesheet" />
    <title>店舗検索</title> 
    <script src="./jquery-3.6.0.min.js"></script>
    <body style="background-color:#e0ccab;">
</head>
<body>

<?php include "header.php" ?>

<h1>お店から探す</h1>



<form id="form1" action="">
            <input id="sbox" name="tenpo" type="text" style="width: 420px; height: 50px;" value="<?= $tenpo ?>" />
            <input id="sbtn" type="submit" style="width: 60px; height: 55px;" value="🔎"/>
</form>

    <select name="select" onChange="location.href=value;">
        <option value="" selected>お店から探す</option>
        <option value="search_genre.php">ジャンルから探す</option>
        <option value="search_results.php">商品名で探す</option>
    </select>
    
<?php
    if($tenpo!=""){
        $search_tenpo=select_tenpo_search($dbh,$tenpo);
        //header('Location:search_results.php');
    }
    else{
        
        $search_tenpo=select_tenpo_aiueo($dbh);
    }
?>

<h2>店舗一覧</h2>
    
    <?php foreach($search_tenpo as $tenpo): ?>
        <div class="goodsgroup">
        <table>
            <tr>
                <td class="name">
                    <a href="search_results.php?tenpoCode=<?= $tenpo['tenpoCode'] ?>">
                    <img src="images/<?php print $tenpo['photo'] ?>"width='100' height="100"/>
                </td>
                <td>
                    <a href="search_results.php?tenpoCode=<?= $tenpo['tenpoCode'] ?>">
                    
                    <?= $tenpo['tenpoName'] ?></a>
                </td>
            </tr>
        </table>
        </div>
    <?php endforeach; ?>
    <?php if($search_tenpo==Array ( )){ ?>
        <h2>検索結果</h2>
        <p>該当する店舗はありません。</p>
    <?php } ?>
    

    
</table>
