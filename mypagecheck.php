<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登録内容の確認・変更</title>
    <link href="css/mypage.css" rel="stylesheet" />
    <script src="./jquery-3.6.0.min.js"></script> 
</head>
<?php
        require_once './helpers/db_helper.php';
        include "header.php";
        $dbh=get_db_connect();
        
        $userId = '';
        $errs = '';

        if(isset($member['userId'])){
            $userId=$member['userId'];
            $select_puser_all=select_puser_all($dbh,$userId);
            //print_r($select_puser_all);
        }
        else{
            $userId=null;
            print 'sgsfgsgs';
        }

        //$puser_pass=withdrawal_puser_pass($dbh,$pw);

?>

<body>
    
    <h1>登録内容の確認・変更</h1>
    <table>
        <tr>
            <td>
                <p class="title">ユーザー名<br>
                <div class="namae"><?= $select_puser_all['userName'] ?></div>
                    <input type="button" class="button" onclick="location.href='mypagecheck_name.php'" value="ユーザー名変更"></p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="title">メールアドレス(ユーザーID)<br>
                <div class="namae1">
                    <?= $select_puser_all['userId'] ?></p><br>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <a href="passchange.php" class="title">パスワードの変更</a><br>
            </td>
        </tr>
    </table>

    <hr><br>
    <div class="my">
    ・<a href="mypage.php">マイページ</a><br>
    ・<a href="mypagecheck.php">登録内容の確認・変更</a><br>
    ・<a href="mypagewithdrawal.php">退会</a><br><br>

    <a href="./logout.php">ログアウト</a>
    </div>
</body>