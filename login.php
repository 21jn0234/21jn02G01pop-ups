<?php
    require_once 'helpers/db_helper.php';
                                            
    $useId = '';
    $errs = [];

    session_start();

    if(!empty($_SESSION['puser'])){
        header('Location:top.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $userId=$_POST['email'];
        $pw=$_POST['password'];

        if($userId===""){
            $errs[]="ユーザーIDを入力して下さい。";
        }
        elseif(!filter_var($userId,FILTER_VALIDATE_EMAIL)){
            $errs[]="ユーザーID(メールアドレス)の形式に誤りがあります。";
        }

        if($pw===""){
            $errs[]="パスワードを入力して下さい。";
        }
        
        if(empty($errs)){

            $dbh=get_db_connect();
            $puser=select_puser($dbh,$userId,$pw);

            if($puser !== false){  //会員データが取り出せたとき
                session_regenerate_id(true);
                $_SESSION['puser']=$puser;
                header('Location: top.php');
                exit;
            }
            else{
                $errs[]="ユーザーIDまたはパスワードに誤りがあります。";
            }
        }
    }

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!--<link href="css/LoginStyle.css" rel="stylesheet" /> -->
    <title>ログイン</title> 
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script src="./jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include "header.php" ?>

    <form action="" method="POST">
        <h1>ログイン</h1>
        <p>会員登録されている方</p> 
        <div class="form">
            <tr>
                ユーザーID(メールアドレス)<br>
                <input type="text" name="email" /><br>    
            </tr>
            <tr>
                パスワード<br>
                <form id="fieldPassword">
                    <input type="password" id="textPassword" name="password" >
                    <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span><br>
                </form>
                <script language="javascript">
                    function pushHideButton() {
                        var txtPass = document.getElementById("textPassword");
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
                <?php foreach($errs as $e) : ?>
                        <span style="color:red"><?= $e ?></span>
                        <br>
                    <?php endforeach; ?>
                
            </tr>
            <tr>
                <td>
                    <input type="submit" value="ログイン" /><br>

                </td>
                <td><a href="passforget.php">パスワードをお忘れの方</a></td>
            </tr>
            <tr>
                <!-- <td colspan="2">
                    <?php foreach($errs as $e) : ?>
                        <span style="color:red"><?= $e ?></span>
                        <br>
                    <?php endforeach; ?> 
                </td> -->
            </tr>
        </table>
    </form>

    <hr>

        <h3>新規会員登録</h3>
    
        <tr>
            <td>初めてご利用のお客様は、こちらから会員登録を行ってください。</td><br>
        </tr>
        <tr>
            <td><a href="singup.php">新規会員登録はこちら</a></td>
        </tr>
    </table>
</body>
</html>
