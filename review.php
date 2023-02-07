<!DOCTYPE html>
<html lang="Ja">
<head>
    <meta charset="utf-8">
    <link href="css/review.css" rel="stylesheet" />
    <title>レビュー</title> 
    <!-- jQueryファイルの読み込み -->
    <script src="./jquery-3.6.0.min.js"></script>
    <script src="./jquery.validate.min.js"></script>
</head>

<?php
    require_once 'helpers/db_helper.php';
    include "header.php";
    $dbh=get_db_connect();
                                            
    $userId = '';
    $syohinName='';
    if(isset($member['userId']) && isset($_GET['syohinId'])){
        $userId=$member['userId'];
        $syohinId=$_GET['syohinId'];
        
        if(isset($syohinId)){ 
            $syohinName=select_syohin_db($dbh,$syohinId); 
        }
        
    }else{
        $userId=null;
    }
    
?>

<body>
    <h1>レビュー</h1>
    <hr>
    <table>
        <tr>        
            <td>
                <?php if($syohinName['photo']=="" || (is_null($syohinName['photo']))){ ?>
                                    <img src="images/no_image.png"width='120' height="120"/><!-- noimageの画像 -->
                                
                <?php } 
                
                else{?>
                    <img src="images/<?php print $syohinName['photo'] ?>"width='120' height="120"/>
                <?php } ?>
            </td>
            <td>
                <p class="name"><?= $syohinName["syohinName"] ?></p>
            </td>
        </tr>
    </table>
    <hr>

    <div class="title_sort">
        <div class="title"><p>レビュー入力<p></div>
        <div class="hissu"><p>*必須項目</p></div>
    </div>
        
        <form id="review" method="POST" action="review_Insert.php">  
        <div>
            <label for="evaluation" class="hyoka">評価</label>*
            <select name="evaluation"> <!--required-->
            <option value="">選択してください</option>
            <option value="5">5</option>
            <option value="4">4</option>
            <option value="3">3</option>
            <option value="2">2</option>
            <option value="1">1</option>
            </select>
        </div>
        <br>
        <p class="hyoka">コメント</p>
        <textarea id="comment" name="comment" cols="25" rows="8" placeholder="コメントは200文字以内"></textarea><br>

        <input type="hidden" name="userId" value=<?=$member['userId']?>>
        <input type="hidden" name="syohinId" value=<?=$_GET['syohinId']?>>

        <input type="submit" value="レビューする！">
        

    </form>
    
    
    <script>
        $(function(){
            $("#review").validate({
                rules:{
                    evaluation:{
                        required:true
                    },
                    comment:{
                        maxlength:200,
                        //あとで200に直してね!!!!!!!!!
                    },
                },
                messages:{
                    evaluation:{
                        required:"評価を選択してください。"
                    },
                    comment:{
                        maxlength:"コメントは200文字以内です。",
                    },
                },
            });
            $("#review").css('color','red');
        });
    </script>
    
    <br>
    <form id="review" method="POST" action="review_Insert.php">
        <input type="submit" value="キャンセル">
        <!--あとでtop.phpを商品詳細画面のリンクに変更  -->
        <input type="hidden" name="userId" value=<?=$member['userId']?>>
        <input type="hidden" name="syohinId" value=<?=$_GET['syohinId']?>>
    </form>

</body>
</html>