<?php
    require_once 'helpers/db_helper.php';
    require_once 'helpers/extra_helper.php';

    $errs = [];
    $userId=$_GET['userId'];
    $cipher_userId=$_GET['cipher'];
    $cipher_userId=urlencode($cipher_userId);
    #print($userId); 
    // $cipher_userId=urlencode($cipher_userId);
    $dbh=get_db_connect();
    
    $pass_and_time=select_forgetURL($dbh,$cipher_userId);
    if(isset($pass_and_time)){
        
        if(isset($pass_and_time[0]["respassword"]) && $pass_and_time[0]["forwardDate"]){
            $pass=$pass_and_time[0]["respassword"];
            $time=$pass_and_time[0]["forwardDate"];
        }else{ ?>
            <h1>データが見つかりません。</h1>
            <p>こちらのURLで、パスワードを変更しています。</p>
            <p>下記のリンクからパスワード忘れ画面に移動しメールアドレスを入力し直してください。</p>
            <?php 
                // var_dump($cipher_userId);
            ?>
            <a href="passforget.php">
               <p>パスワード忘れ</p>
            </a>
        <?php exit;
        }
    }
    if($time>=date('Y-m-d H:i:s')){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $pw=$_POST['password'];
            $pw2=$_POST['password2'];
           
        
            if($pw!="" && $pw2!="" &&$pw != $pw2){
                $errs['password']="入力と再入力のパスワードが一致しません。";
            }
            if($pw==""){
                $errs['password']="入力項目にパスワードが入力されていません";
            }
            elseif(! check_words($pw,6,20)){
                $errs['password']="パスワードは6～20文字で入力してください。";
            }
            if($pw2==""){
                $errs['password2']="再入力項目にパスワードが入力されていません";
            }
            elseif(! check_words($pw2,6,20)){
                $errs['password2']="パスワードは6～20文字で入力してください。";
            }
            if (empty($errs)) {
                // ユーザーのパスワードの再発行
                password_reissue($dbh,$userId,$pw);
                delete_forgetURL($dbh,$pass);
                header('Location:passreissue_cop.php');
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
    <?php include "header.php"?>
</head>
<body>
    <form action="" method="POST">
        <tr>
            <h1>
                パスワード再発行<br>
            </h1>               
            
            <p>
                パスワードは半角英数字6～20文字にしてください。<br>
                <span style="color:red">ブラウザの戻るボタンは使用しないでください。</sapn>
            </p>
        </tr>

        <div id="newpass">
                <tr>
                    新しいパスワード<br>
              
                    <input type="password" id="textPassword" name="password">
                    <td><span style="color:red"><?= @$errs['password'] ?></span></td>
                </tr>
        </div>

        <div id="newpass2">
            <tr>
                 パスワード再入力<br>
              
                 <form id="fieldPassword2">
                    <input type="password" id="textPassword2" name="password2">
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
                <td><span style="color:red"><?= @$errs['password2'] ?></span></td><br>
            </tr>
            <tr>
              
                <input type="submit" value="保存"/><br>
               
            </tr>
        </div>
        <?php $cnt=true ?>
    </form>
</body>
</html>
    <?php 
        }else{ ?>
            <h1>制限時間を過ぎました。メールアドレス入力からやり直してください。</h1>
            <a href="passforget.php">
               <h2>パスワード忘れ</h2>
            </a>
            
    <?php }
    ?>