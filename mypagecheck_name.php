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


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登録内容の確認・変更</title>
    <script src="./jquery-3.6.0.min.js"></script>
    <script src="./jquery.validate.min.js"></script>
</head>
<body>
    
    <h1>ユーザー名変更</h1>
    <form id="name" method="POST" action="mypagecheck_name_update.php"> 
        <input type="text" name=nameup placeholder=<?= $select_puser_all['userName'] ?>></p>
        <input type="hidden" name="userId" value=<?=$member['userId']?>>
        <input type="submit" value="名前の変更">
    <?//php endforeach ?>

    <script>
        $(function(){
            $("#name").validate({
                rules:{
                    nameup:{
                        //required:true
                        maxlength:20,
                    },
                },
                messages:{
                    nameup:{
                        maxlength:"ユーザー名は20文字以内です。",
                    },
                },
            });
            $("#name").css('color','red');
        });
    </script>

</body>