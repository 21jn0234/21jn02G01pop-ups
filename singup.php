<?php
    require_once 'helpers/db_helper.php';
    require_once 'helpers/extra_helper.php';
                                            
    $useId = '';
    $errs = [];


    if($_SERVER['REQUEST_METHOD']==='POST'){
        $userId=$_POST['email'];
        $un=$_POST['username'];
        $pw=$_POST['password'];
        $pw2=$_POST['password2'];
        $dbh=get_db_connect();

        if($userId===""){
            $errs['userId']="メールアドレス（ユーザーID）を入力して下さい。";
        }
        elseif(!filter_var($userId,FILTER_VALIDATE_EMAIL)){
            $errs['userId']="ユーザーID(メールアドレス)の形式に誤りがあります。";
        }
        elseif(email_exists($dbh,$userId)) {
            $errs['userId'] = 'このメールアドレスはすでに登録されています';
        }

        if($un===""){
            $errs['un']="ユーザー名を入力して下さい。";
        }

        if($pw===""){
            $errs['pw']="パスワードを入力して下さい。";
        }

        elseif(!check_words($pw,6,20)){
            $errs['pw']="パスワードは6～20文字で入力してください。";
        }

        elseif($pw!=$pw2){
            $errs['pw']="パスワードが一致しません。";
        }
        if (empty($errs)) {
            // DBに会員データを追加
            insert_into_puser($dbh, $userId, $un, $pw);
            header('Location:singup_cop.php');
            exit;
        }
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script src="./jquery-3.6.0.min.js"></script>
    <title>新規登録</title>
    <?php include "header.php"?>
</head>
<body>
<form action="" method="POST">
    <table id="LoginTable" class="box">
        <tr>
            <h1>
               新規会員登録<br>
            </h1>               
        </tr>
    
        <div id="id">
            <tr>
                メールアドレス（ユーザーID）*メールアドレス変更不可<br>
               
                   <input type="text"name="email"/>
                   <span style="color:red"><?= @$errs['userId'] ?></span>
             </tr>
        </div>

        <div id="username">
            <tr>
                  ユーザー名<br>
   
                <input type="text"name="username"/>
                <span style="color:red"><?= @$errs['un'] ?></span>
            </tr>
        </div>

        <div id="password">
            <tr>
                 パスワード(半角英数字6~20文字)<br>
              
                <input type="password" name="password" >
                <span style="color:red"><?= @$errs['pw'] ?></span>
            </tr>
        </div>
        
        <div id="pass2">
                <tr>
                 パスワード再入力<br>
              
                 <form id="fieldPassword2">
                    <input type="password" id="textPassword2" name="password2" >
                    <span id="buttonEye2" class="fa fa-eye" onclick="pushHideButton2()"></span>
                </form>
                <script language="javascript">
                    function pushHideButton2() {
                    var txtPass2 = document.getElementById("textPassword2");
                    var btnEye2 = document.getElementById("buttonEye2");
                    if (txtPass2.type === "text") {
                        txtPass2.type = "password";
                        btnEye2.className = "fa fa-eye";
                    } else {
                        txtPass2.type = "text";
                        btnEye2.className = "fa fa-eye-slash";
                        }
                     } 
                </script>
                </tr>
        </div>    
                 
        <div id="userbtn">
            <tr>
                   
                <input type="submit" value="ユーザー登録"/><br>
               
            </tr>
        </div>
    </table>
</form>
</body>
</html>
