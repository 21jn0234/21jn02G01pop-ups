<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!--<link href="css/LoginStyle.css" rel="stylesheet" /> -->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script src="./jquery-3.6.0.min.js"></script>
    <title>パスワードの変更</title> 
    
</head>
<?php
    require_once 'helpers/db_helper.php';
    require_once 'helpers/extra_helper.php';
    require_once 'header.php';
                                            
    $userId = $member['userId'];
    $errs = [];
    

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $pw=$_POST['pass'];
        $newpw=$_POST['newpass'];
        $newpw2=$_POST['textPassword'];
        $dbh=get_db_connect();
        $puser=select_puser($dbh,$userId,$pw);
        if(isset($puser['pw'])){
            $puser=$puser['pw'];
        }
        if($pw===""){
            $errs['password']="現在のパスワードを入力して下さい。";
        }elseif($pw!=$puser){
            $errs['password']="登録されているパスワードと一致していません。";
        }
        elseif(! check_words($pw,6,20)){
            $errs['password']="パスワードは6～20文字で入力してください。";
        }

        if($newpw==""){
            $errs['newpassword01']="新しいパスワードを入力して下さい。";
        }elseif(! check_words($newpw,6,20)){
            $errs['newpassword01']="パスワードは6～20文字で入力してください。";
        }

        if($newpw2==""){
            $errs['newpassword02']="新しいパスワードを入力して下さい。";
        }elseif(! check_words($newpw2,6,20)){
            $errs['newpassword02']="パスワードは6～20文字で入力してください。";
        }

        if($newpw != $newpw2){
            $errs['newpassword01']="パスワードが一致しません。";
        }
        if (empty($errs)) {
            // DBに会員データを追加
            password_reissue($dbh,$userId,$newpw);
            header('Location:passchange_cop.php');
            exit;
        }
    }
    ?>

<body>
    <h1>パスワードの変更</h1>
    
    
    <!--?php include "header2.php" ?>-->
    
    <form action="" method="POST">
        <p>現在のパスワード</p>
        <input type="password" name="pass" />
        <td><span style="color:red"><?= @$errs['password'] ?></span></td>

        <p>新しいパスワード</p>
        <input type="password" name="newpass" />
        <td><span style="color:red"><?= @$errs['newpassword01'] ?></span></td>

        <p>新しいパスワード再入力</p>
        <div id="fieldPassword">
            <input type="password" id="textPass" name="textPassword">
            <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
            <td><span style="color:red"><?= @$errs['newpassword02'] ?></span></td><br>
        </div>
        <input type="submit" value="保存"/><br>
        
    </form>
            <script language="javascript">
                function pushHideButton() {
                    var txtPass = document.getElementById("textPass");
                    var btnEye = document.getElementById("buttonEye");
                    if (txtPass.type === "text") {
                        txtPass.type = "password";
                        btnEye.className = "fa fa-eye";
                    } else {
                        txtPass.type = "text";
                        btnEye.className = "fa fa-eye-slash";
                    }
                }
            </script>
             
        
        <!--<a href="mypagecheck.php">保存</a>-->
        
    





</body>
</html>