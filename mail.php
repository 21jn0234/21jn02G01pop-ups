<?php
// PHPでメールを送信するサンプルプログラムです。
// PHPMailerというライブラリを使用します。
// ★の部分を適宜変更して下さい。
//
// 参考：PHPMailerでメールをSTMP送信する： https://qiita.com/e__ri/items/857b12e73080019e00b5
$cipher_userId=$_GET['userId'];
//$pass=$_GET['pass'];
require_once './helpers/db_helper.php';
//require_once './helpers/db_helper_baba.php';
$cipher_userId_retarn=urlencode($cipher_userId);
$cipher_userId=urlencode($cipher_userId);

$dbh=get_db_connect();
$pass_and_time=select_forgetURL($dbh,$cipher_userId);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if(isset($pass_and_time[0]["respassword"])){
    $pass=$pass_and_time[0]["respassword"];

    //$time=$pass_and_time[0]["forwardDate"];

    
    $cipher_userId=urldecode($cipher_userId);
    $userId = openssl_decrypt($cipher_userId, 'AES-128-ECB', $pass);#複合化
    $cipher_userId=urlencode($cipher_userId);
    //$user_pass=pass_get($dbh,$userId);
    //print($user_pass);
    //print_r($user_pass);
    //$user_pass=$user_pass['pw'];

        

    // PHPMailerの読み込みパス
    require('PHPMailer/src/PHPMailer.php');
    require('PHPMailer/src/Exception.php');
    require('PHPMailer/src/SMTP.php');

    // 文字エンコードを指定
    mb_language('uni');
    mb_internal_encoding('UTF-8');

    // インスタンスを生成（true指定で例外を有効化）
    $mail = new PHPMailer(true);

    // 文字エンコードを指定
    $mail->CharSet = 'utf-8';

    try {
        // SMTPサーバの設定
        $mail->isSMTP();                          // SMTPの使用宣言
        $mail->Host       = 'smtp.gmail.com';     // SMTPサーバーを指定
        $mail->SMTPAuth   = true;                 // SMTP authenticationを有効化
        $mail->Username   = '21jn0237@jec.ac.jp';   // 自分の学校メールアドレス★
        $mail->Password   = 'hP6PJjEFbXeD';        // Gmailパスワード★
        $mail->SMTPSecure = 'ssl';                // 暗号化を有効（tls or ssl）無効の場合はfalse
        $mail->Port       = 465;                  // TCPポートを指定（tlsの場合は465や587）

        // 送受信先設定（第2引数は省略可）
        $mail->setFrom('21jn0237@jec.ac.jp', "POPUP’s");              // 送信者（省略可）★
        $mail->addAddress($userId, '受信者名');         // 宛先1★
        // $mail->addAddress('XXXXXX@example.com', '受信者名');      // 宛先2
        // $mail->addReplyTo('replay@example.com', 'お問い合わせ');  // 返信先
        // $mail->addCC('cc@example.com', '受信者名');               // CC宛先
        // $mail->addBCC('bcc@example.com');                        // BCC宛先

        // 送信内容設定（プレーンテキスト用）
        $mail->Subject = 'パスワード忘れ';
        $mail->Body    = "いつもPOPUP’sをご利用いただきありがとうございます。"."\r\n"."\r\n"."パスワードの再設定を承りました。"."\r\n"."下記のURLから本日中に、ご変更手続きを完了してください。"."\r\n".
                        "http://10.42.96.1/2JN2/group1/passreissue.php?userId=$userId&cipher=$cipher_userId"; #"http://localhost/%E5%8D%92%E6%A5%AD%E5%88%B6%E4%BD%9C/passchange.php?userId=$userId&pw=$user_pass";#

        // HTMLメール用
        // $mail->isHTML(true);                 // HTMLメール
        // $mail->Subject = '件名';
        // $mail->Body    = ' HTML形式の本文 <b>太字</b>';

        // 添付ファイル
        #$mail->addAttachment('子猫.jpg');

        // 送信
        $mail->send();
        #echo 'メールを送信しました。';
        ?>
        <body>
            <?php if(isset($_GET['retarn'])){?>
            <tr>
                <h1>
                    再送信完了<br>
            </h1>               
            </tr>
            <?php }else{ ?>
            <tr>
                <h1>
                    メール送信完了<br>
                </h1>               
            </tr>
            <?php } ?>
            <h3>登録されたメールアドレスに送信完了しました。</h3>

            <p>届かない場合</br>
            ・1分ほどお待ちください。</br>
            ・再送信ボタンを押してください。</br>
            ・迷惑メールに登録されていないか確認してください。</br>
            ・入力されたメールアドレスが正しいか確認してください。</br>
            <span style="color:red">・ブラウザの戻るは使用しないでください。</span></p> 
            <?php 
                // $cipher_userId=urldecode($cipher_userId);
                // print($cipher_userId.'</br>');
                // $cipher_userId=urlencode($cipher_userId);
                // print($cipher_userId);
            ?>
                    
            <div id="fogetbtn">
                <tr>
                <?php //$user_pass='';?>
                <?php 
                    $cipher_userId=urldecode($cipher_userId);
                    $cipher_userId= openssl_encrypt($cipher_userId, 'AES-128-ECB', $pass);
                    urlencode($cipher_userId);
                ?>
                <a href="mail.php?userId=<?=$cipher_userId_retarn?>&retarn=retarn"> 
                    <input type="submit" value="再送信"/><br>
                        
                </a>
            </tr>
            </div>
        </body>
        <?php
        
        }
        catch (Exception $e) {
            // エラーの場合
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            //var_dump($userId);
            //var_dump($pass);
        }
}else{
    print("データがありません");
    var_dump($cipher_userId);
   ?>
   </br>
    <a href="passforget.php"> 
        入力画面に戻る
    </a>
    </a>
    <?php
};
?>