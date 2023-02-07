<?php
require_once 'config.php';

// DBに接続する
function get_db_connect() 
{
    try{
        $dbh=new PDO(DSN,DB_USER,DB_PASSWORD);
    }
    catch (PDOException $e){
        echo $e->getMessage();
        die();
    }

    return $dbh;  
}

// DBから全ジャンルを取得する
function select_genre_all($dbh)
{
    $sql = "SELECT * FROM genre";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

// DBから全ジャンルを50音順に取得する
function select_genre_aiueo($dbh)
{
    $sql = "SELECT * FROM genre ORDER BY kana ASC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

// DBから全店舗を取得する
function select_tenpo_all($dbh)
{
    $sql = "SELECT * FROM tenpo";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

//DBから全店舗を50音順に取得する
function select_tenpo_aiueo($dbh)
{
    $sql = "SELECT * FROM tenpo ORDER BY kana ASC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

// DBから全商品を取得する
function select_syohin_all($dbh)
{
    $sql = "SELECT * FROM syohin";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

// DBから全ジャンルを検索して取得する
function select_genre_search($dbh,$genreName)
{
    $sql = "SELECT * FROM genre 
                WHERE genreName LIKE :genreName ORDER BY genreName ASC";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":genreName",'%'.$genreName.'%',PDO::PARAM_STR);
    $stmt->execute();

    $search_genre=$stmt->fetchALL();
    return $search_genre;
}

// DBから全店舗を検索して取得する
function select_tenpo_search($dbh,$tenpoName)
{
    $sql = "SELECT * FROM tenpo 
                WHERE tenpoName LIKE :tenpoName ORDER BY tenpoName ASC";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":tenpoName",'%'.$tenpoName.'%',PDO::PARAM_STR);
    $stmt->execute();

    $search_tenpo=$stmt->fetchALL();
    return $search_tenpo;
}

//店舗コードと一致する店舗名を取得する
function select_tenpo_db($dbh,$tenpoCode)
{
    $sql = "SELECT * FROM tenpo 
            WHERE tenpoCode = :tenpoCode ";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":tenpoCode",$tenpoCode,PDO::PARAM_STR);
    $stmt->execute();

$tenpoCode=$stmt->fetch(PDO::FETCH_ASSOC);
return $tenpoCode;
}

//ジャンルコードと一致するジャンル名を取得する
function select_genre_db($dbh,$genreCode)
{
    $sql = "SELECT * FROM genre 
            WHERE genreCode = :genreCode ";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":genreCode",$genreCode,PDO::PARAM_STR);
    $stmt->execute();

$genreCode=$stmt->fetch(PDO::FETCH_ASSOC);
return $genreCode;
}

// DBから全商品をキーワード検索して取得する
function select_syohin_search($dbh,$syohinName)
{
    $sql = "SELECT * FROM syohin 
                WHERE syohinName LIKE :syohinName ORDER BY syohinId DESC";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":syohinName",'%'.$syohinName.'%',PDO::PARAM_STR);
    $stmt->execute();

    $search_syohin=$stmt->fetchALL();
    return $search_syohin;
}


// DBから店舗を検索して商品を取得する
function select_tenpo_by_tenpocode($dbh,$tenpoCode)
{
    $sql = "SELECT * FROM syohin 
                    WHERE tenpoCode = :tenpoCode ORDER BY syohinId DESC";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":tenpoCode",$tenpoCode,PDO::PARAM_STR);
    $stmt->execute();

    $data=[];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }

    return $data;
}

// DBからジャンルを検索して商品を取得する
function select_genre_by_genrecode($dbh,$genreCode)
{
    $sql = "SELECT * FROM syohin 
                    WHERE genreCode = :genreCode ORDER BY syohinId DESC";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":genreCode",$genreCode,PDO::PARAM_STR);
    $stmt->execute();

    $data=[];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }

    return $data;
}

//商品IDと一致する商品テーブルの情報を取得する
function select_syohin_db($dbh,$syohinId)
{
    $sql = "SELECT * FROM syohin 
            WHERE syohinId = :syohinId ";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":syohinId",$syohinId,PDO::PARAM_STR);
    $stmt->execute();

$syohinId=$stmt->fetch(PDO::FETCH_ASSOC);
return $syohinId;
}

// ユーザーID(メールアドレス), パスワードが一致するかつ、入会中の会員データを取得する
function select_puser($dbh,$userId,$pw)
{
    $sql = "SELECT * FROM puser
                WHERE userId = :userId AND pw = :pw AND tFlag=0";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->bindValue(":pw",$pw,PDO::PARAM_STR);
    $stmt->execute();

    $puser=$stmt->fetch(PDO::FETCH_ASSOC);
    return $puser;

}


//商品テーブルとジャンルをつなげる
function select_syohin_genre($dbh,$syohinId)
{
    $sql = "SELECT * FROM syohin AS S 
            RIGHT OUTER JOIN genre AS G ON S.genreCode = G.genreCode 
            WHERE syohinId = :syohinId";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":syohinId",$syohinId,PDO::PARAM_STR);
    $stmt->execute();
        
    $genre=$stmt->fetch(PDO::FETCH_ASSOC);
    return $genre;
}


//商品テーブルと店舗をつなげる
function select_syohin_tenpo($dbh,$syohinId)
{
    $sql = "SELECT * FROM syohin AS S 
            RIGHT OUTER JOIN tenpo AS T ON S.tenpoCode = T.tenpoCode  
            WHERE syohinId = :syohinId";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":syohinId",$syohinId,PDO::PARAM_STR);
    $stmt->execute();
        
    $tenpo=$stmt->fetch(PDO::FETCH_ASSOC);
    return $tenpo;
}



//商品IDからレビューテーブルを取得する
function select_syohin_review($dbh,$syohinId)
{
    $sql = "SELECT TOP 5 * FROM review 
            WHERE syohinId = :syohinId 
	        ORDER BY reviewId DESC " ;

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":syohinId",$syohinId,PDO::PARAM_STR);
    $stmt->execute();

    $syohinId=$stmt->fetchall();
    return $syohinId;
}

//ユーザーIDを基(引数)に、欲しリス内の現在販売中の商品(一覧)を取得する
//
function select_wantList_now($dbh,$userId)
{
    $sql = "SELECT  S.syohinId,S.photo,S.syohinName,S.price,W.wantingId
    FROM puser AS U
    LEFT OUTER JOIN wanting AS W ON U.userId = W.userId
    LEFT OUTER JOIN syohin AS S ON W.syohinId = S.syohinId
    WHERE U.userId = :userId AND endDate > CONVERT(DATE,getdate())
    union
    SELECT S.syohinId,S.photo,S.syohinName,S.price,W.wantingId
    FROM puser AS U
    LEFT OUTER JOIN wanting AS W ON U.userId = W.userId
    LEFT OUTER JOIN syohin AS S ON W.syohinId = S.syohinId 
    WHERE U.userId = :userId2 AND endDate is null 
    and (DATEDIFF(day,startDate,CAST(GETDATE() as date)) < 14)";
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->bindValue(":userId2",$userId,PDO::PARAM_STR);

    $stmt->execute();

    $data=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;

}

//ユーザーIDを基(引数)に、欲しリス内の販売終了済の商品(一覧)を取得する
function select_wantList_end($dbh,$userId)
{
    $sql = "SELECT  S.syohinId,S.photo,S.syohinName,S.price,W.wantingId
    FROM puser AS U
    LEFT OUTER JOIN wanting AS W ON U.userId = W.userId
    LEFT OUTER JOIN syohin AS S ON W.syohinId = S.syohinId
    WHERE U.userId = :userId AND endDate < CONVERT(DATE,getdate())
    union
    SELECT S.syohinId,S.photo,S.syohinName,S.price,W.wantingId
    FROM puser AS U
    LEFT OUTER JOIN wanting AS W ON U.userId = W.userId
    LEFT OUTER JOIN syohin AS S ON W.syohinId = S.syohinId 
    WHERE U.userId = :userId2 AND endDate is null 
    and (DATEDIFF(day,startDate,CAST(GETDATE() as date)) >= 14)";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->bindValue(":userId2",$userId,PDO::PARAM_STR);

    $stmt->execute();

    $data=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;

}


//ユーザーの新規登録
function insert_puser($dbh,$pusers)
{
    $sql = "INSERT INTO puser VALUES(:pusers)";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":pusers",$pusers,PDO::PARAM_STR);
    $stmt->execute();

    $puser=$stmt->fetch(PDO::FETCH_ASSOC);
    return $puser;

}

function solt_syohin_new($dbh){#新規登録順
    $sql = "SELECT * FROM syohin ORDER BY startDate DESC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

function solt_syohin_wanting($dbh){#欲しリス順　
    $sql = "SELECT * from syohin as s left outer join v_wanting as v on s.syohinId=v.syohinId order by syohinIdCount desc";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

function solt_syohin_cheap($dbh){#価格安い順　
    $sql = "SELECT * FROM syohin ORDER BY price ASC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

function solt_syohin_high($dbh){    #価格高い順　
    $sql = "SELECT * FROM syohin ORDER BY price DESC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

function solt_syohin_review_count($dbh){    #レビュー数 
    $sql ="SELECT * from syohin as s left outer join v_review_count as v on s.syohinId=v.syohinId order by reviewCount desc";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}

function solt_syohin_review_evaluation($dbh){    #レビュー高評価 
    $sql = "SELECT * from syohin as s left outer join v_review_evaluation as e on s.syohinId=e.syohinId order by evaluationSum desc";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}


//ユーザーテーブルにユーザーID、パスワード、ユーザー名追加する
function insert_into_puser($dbh, $userId, $un, $pw)
    {
        //$password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO puser(userId, userName, pw, tFlag) 
                  VALUES (:userId, :un, :pw, 0)";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
        $stmt->bindValue(':un',    $un,    PDO::PARAM_STR);
        $stmt->bindValue(':pw',    $pw,    PDO::PARAM_STR);

        $stmt->execute();
    }

//新規登録しようとしてるメールアドレスが重複してないか調べる
function email_exists($dbh,$userId)
{
    $sql = "SELECT COUNT(*) AS count FROM puser WHERE userId = :userId";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
    $stmt->execute();

    $puser=$stmt->fetch(PDO::FETCH_ASSOC);

    if($puser['count']>0){
        return TRUE;
    }else{
        return FALSE;
    }
}



//パスワード再発行する
function password_reissue($dbh,$userId,$pw)
{
    $sql = "UPDATE puser SET pw = :pw WHERE userId = :userId";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
    $stmt->bindValue(':pw',    $pw,    PDO::PARAM_STR);

    $stmt->execute();
}

function user_bought($dbh,$userId)#ユーザーの購入済み情報
{
    $sql = "SELECT * FROM bought WHERE userId = :userId";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
    $stmt->execute();

    $bought=$stmt->fetchALL();
    return $bought;
}

function user_reprint($dbh,$userId)#ユーザーの復刻情報
{
    $sql = "SELECT * FROM reprint WHERE userId = :userId";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
    $stmt->execute();
    
    $reprint=$stmt->fetchALL();
    return $reprint;
}

function user_review($dbh,$userId)#ユーザーのレビュー情報
{
    $sql = "SELECT * FROM review WHERE userId = :userId";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
    $stmt->execute();
    
    $review=$stmt->fetchALL();
    return $review;
}

function user_wanting($dbh,$userId)#ユーザーの欲しリス情報
{
    $sql = "SELECT * FROM wanting WHERE userId = :userId";

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
    $stmt->execute();

    
    $bought=$stmt->fetchALL();
    return $bought;
}

function wanting_change($dbh,$wanting,$userId,$syohinId){#欲しリス登録
    $wantingId=wanting_numbering($dbh);
    
    $sql ="INSERT INTO wanting VALUES(:wantingId,:userId,:syohinId)";#inset into

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':wantingId',$wantingId,PDO::PARAM_STR);
    $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
    $stmt->bindValue(':syohinId',$syohinId,PDO::PARAM_STR);
    
    $stmt->execute();

    $change=$stmt->fetch(PDO::FETCH_ASSOC);
    return $change;
}

function wanting_numbering($dbh){#欲しリスコード作成
    $sql="SELECT wantingId FROM wanting ORDER BY wantingId DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=$stmt->fetch(PDO::FETCH_ASSOC);

    $code_kari = $data['wantingId'];
    print($code_kari);
    $code = "W";
    $code_kari=substr($code_kari,2);
    #print($code_kari);
	// 分解した数字(文字列)をintに変換し、+1する。
    $codeNumber = (int)$code_kari+ 1;
    #print($codeNumber);
	//S0000000001～などの、0を埋めていくif文。
    //最新の番号が～
    if (1 < $codeNumber && $codeNumber < 10)
    {
        //1桁のとき
        $code .= "000000000".(string)$codeNumber;

    }
    else if (9 < $codeNumber && $codeNumber < 100)
    {
        //2桁のとき
        $code .= "00000000".(string)$codeNumber;
    }
    else if (99 < $codeNumber && $codeNumber < 1000)
    {
        //3桁のとき
        $code .= "0000000".(string)$codeNumber;
    }
    else if (999 < $codeNumber && $codeNumber < 10000)
    {
        //4桁のとき
        $code .= "000000".(string)$codeNumber;

    }
    else if (9999 < $codeNumber && $codeNumber < 100000)
    {
        //5桁のとき
        $code .= "00000".(string)$codeNumber;

    }
    else if (99999 < $codeNumber && $codeNumber < 1000000)
    {
        //6桁のとき
        $code .= "0000".(string)$codeNumber;

    }
    else if (999999 < $codeNumber && $codeNumber < 10000000)
    {
        //7桁のとき
        $code .= "000".(string)$codeNumber;

    }
    else if (9999999 < $codeNumber && $codeNumber < 100000000)
    {
        //8桁のとき
        $code .= "00".(string)$codeNumber;
    }
    else
    {
        //9桁のとき
        $code .= "0".(string)$codeNumber;

    }
    return $code;
}

//ランキングを抽出する
function ranking_get($dbh)
{
    $sql = "SELECT DISTINCT top 20 S.syohinId,syohinName,AVG(evaluation) AS eva,photo ,endDate,startDate
    FROM syohin AS S 
    LEFT OUTER JOIN review AS R ON S.syohinId = R.syohinId
    GROUP BY S.syohinId,syohinName,photo,endDate,startDate
    HAVING AVG(evaluation) IS NOT NULL AND endDate > CONVERT(DATE,getdate())
    union
    SELECT DISTINCT top 20 S.syohinId,syohinName,AVG(evaluation) AS eva,photo ,endDate,startDate
    FROM syohin AS S 
    LEFT OUTER JOIN review AS R ON S.syohinId = R.syohinId
    GROUP BY S.syohinId,syohinName,photo,endDate,startDate
    HAVING AVG(evaluation) IS NOT NULL AND endDate is null 
    and (DATEDIFF(day,startDate,CAST(GETDATE() as date)) < 14)
    ORDER BY AVG(evaluation) DESC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row;
    }
    return $data;
}

//ユーザーIDと商品IDを基に、復刻リクエストをしているかどうかを見る
//欲しリスに入っていてなおかつ復刻リクエストしているか、がしたいSQL
function select_reprintID_flag($dbh,$userId,$syohinId)
{
    $sql = "SELECT * FROM reprint
                WHERE userId=:userId AND syohinId=:syohinId";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->bindValue(":syohinId",$syohinId,PDO::PARAM_STR);
    $stmt->execute();

    $data=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;

}

//ユーザーIDと商品IDを基に、レビューをしているかどうかを見る
//欲しリスに入っていてなおかつレビューしているか、がしたいSQL
function select_reviewID_flag($dbh,$userId,$syohinId)
{
    $sql = "SELECT * FROM review
                WHERE userId=:userId AND syohinId=:syohinId";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->bindValue(":syohinId",$syohinId,PDO::PARAM_STR);
    $stmt->execute();

    $data=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;

}

//ユーザーIDと商品IDを基に、購入をしているかどうかを見る
//欲しリスに入っていてなおかつその商品を購入しているか、がしたいSQL
function select_boughtID_flag($dbh,$userId,$syohinId)
{
    $sql = "SELECT * FROM bought
                WHERE userId=:userId AND syohinId=:syohinId";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->bindValue(":syohinId",$syohinId,PDO::PARAM_STR);
    $stmt->execute();

    $data=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;

}

function reprint_numbering($dbh){#復刻コード作成
    $sql="SELECT reprintId FROM reprint ORDER BY reprintId DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=$stmt->fetch(PDO::FETCH_ASSOC);

    $code_kari = $data['reprintId'];
    #print($code_kari);
    $code = "R";
    $code_kari=substr($code_kari,2);
    #print($code_kari);
	// 分解した数字(文字列)をintに変換し、+1する。
    $codeNumber = (int)$code_kari+ 1;
    #print($codeNumber);
	//S0000000001～などの、0を埋めていくif文。
    //最新の番号が～
    if (1 < $codeNumber && $codeNumber < 10)
    {
        //1桁のとき
        $code .= "000000000".(string)$codeNumber;

    }
    else if (9 < $codeNumber && $codeNumber < 100)
    {
        //2桁のとき
        $code .= "00000000".(string)$codeNumber;
    }
    else if (99 < $codeNumber && $codeNumber < 1000)
    {
        //3桁のとき
        $code .= "0000000".(string)$codeNumber;
    }
    else if (999 < $codeNumber && $codeNumber < 10000)
    {
        //4桁のとき
        $code .= "000000".(string)$codeNumber;

    }
    else if (9999 < $codeNumber && $codeNumber < 100000)
    {
        //5桁のとき
        $code .= "00000".(string)$codeNumber;

    }
    else if (99999 < $codeNumber && $codeNumber < 1000000)
    {
        //6桁のとき
        $code .= "0000".(string)$codeNumber;

    }
    else if (999999 < $codeNumber && $codeNumber < 10000000)
    {
        //7桁のとき
        $code .= "000".(string)$codeNumber;

    }
    else if (9999999 < $codeNumber && $codeNumber < 100000000)
    {
        //8桁のとき
        $code .= "00".(string)$codeNumber;
    }
    else
    {
        //9桁のとき
        $code .= "0".(string)$codeNumber;

    }
    #print $code;
    return $code;
}

//レビューIdの作成
function review_numbering($dbh){
    $sql="SELECT reviewId FROM review ORDER BY reviewId DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=$stmt->fetch(PDO::FETCH_ASSOC);

    $code_kari = $data['reviewId'];
    print($code_kari);
    $code = "V";
    $code_kari=substr($code_kari,2);
    #print($code_kari);
	// 分解した数字(文字列)をintに変換し、+1する。
    $codeNumber = (int)$code_kari+ 1;
    #print($codeNumber);
	//S0000000001～などの、0を埋めていくif文。
    //最新の番号が～
    if (1 < $codeNumber && $codeNumber < 10)
    {
        //1桁のとき
        $code .= "000000000".(string)$codeNumber;

    }
    else if (9 < $codeNumber && $codeNumber < 100)
    {
        //2桁のとき
        $code .= "00000000".(string)$codeNumber;
    }
    else if (99 < $codeNumber && $codeNumber < 1000)
    {
        //3桁のとき
        $code .= "0000000".(string)$codeNumber;
    }
    else if (999 < $codeNumber && $codeNumber < 10000)
    {
        //4桁のとき
        $code .= "000000".(string)$codeNumber;

    }
    else if (9999 < $codeNumber && $codeNumber < 100000)
    {
        //5桁のとき
        $code .= "00000".(string)$codeNumber;

    }
    else if (99999 < $codeNumber && $codeNumber < 1000000)
    {
        //6桁のとき
        $code .= "0000".(string)$codeNumber;

    }
    else if (999999 < $codeNumber && $codeNumber < 10000000)
    {
        //7桁のとき
        $code .= "000".(string)$codeNumber;

    }
    else if (9999999 < $codeNumber && $codeNumber < 100000000)
    {
        //8桁のとき
        $code .= "00".(string)$codeNumber;
    }
    else
    {
        //9桁のとき
        $code .= "0".(string)$codeNumber;

    }
    return $code;
}


//ほしりすの数を数える
function wanting_kazu($dbh,$syohin){
    $sql = "SELECT COUNT(*) FROM wanting WHERE syohinId = :syohinId ";
    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":syohinId",$syohin,PDO::PARAM_STR);
    $stmt->execute();

    $count=$stmt->fetch(PDO::FETCH_ASSOC);
    return $count;
}

//復刻リクエストの数を数える
function reprint_kazu($dbh,$syohin)
{
    $sql = "SELECT COUNT(*) FROM reprint WHERE syohinId = :syohinId ";
    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":syohinId",$syohin,PDO::PARAM_STR);
    $stmt->execute();

    $count=$stmt->fetch(PDO::FETCH_ASSOC);
    return $count;
}


//店舗商品新着順2位
function tenpo_new($dbh,$tenpoCode)
{
    $sql = "SELECT TOP 2  * FROM syohin 
            WHERE tenpoCode = :tenpoCode 
            ORDER BY syohinId DESC ";
            
     $stmt = $dbh->prepare($sql);

     $stmt->bindValue(":tenpoCode",$tenpoCode,PDO::PARAM_STR);
     $stmt->execute();
 
     $syohinId=$stmt->fetchall();
     return $syohinId;
}

//ジャンル商品新着順3位
function genre_new($dbh,$genreCode)
{
    $sql = "SELECT TOP 3 * FROM syohin 
            WHERE genreCode = :genreCode 
            ORDER BY syohinId DESC ";
            
     $stmt = $dbh->prepare($sql);

     $stmt->bindValue(":genreCode",$genreCode,PDO::PARAM_STR);
     $stmt->execute();
 
     $syohinId=$stmt->fetchall();
     return $syohinId;
}

//ランキング、ユーザーログイン時の購入済み判断
function ranking_bought($dbh,$userId){
    $sql = "SELECT ranking_view.syohinId FROM ranking_view
    LEFT OUTER JOIN bought AS B ON ranking_view.syohinId = B.syohinId
    LEFT OUTER JOIN puser AS U ON B.userId = U.userId
    WHERE B.userId = :userId 
    ORDER BY eva DESC";
    $stmt = $dbh->prepare($sql);
   
    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row;
    }
    return $data;
}

//ユーザー情報取得
function puser($dbh,$userId)
{
    $sql = "SELECT * FROM puser 
            WHERE userId = :userId";
    
    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->execute();

    $puser=$stmt->fetch(PDO::FETCH_ASSOC);
    return $puser;
}

//ユーザー情報(パスワード)の確認
function withdrawal_puser_pass($dbh,$pw){
    $sql1="SELECT * FROM puser WHERE pw=:pw";
    $stmt1 = $dbh->prepare($sql1);
    $stmt1->bindValue(':pw',$pw,PDO::PARAM_STR);
    $stmt1->execute();
    $puser=$stmt1->fetch(PDO::FETCH_ASSOC);
    
    if($puser==TRUE){
        return "TRUE";
    }else{
        return "FALSE";
    }
}
function pass_get($dbh,$userId){ #パスワード取得
    $sql="SELECT pw FROM puser WHERE userId=:userId";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->execute();

    $data=$stmt->fetch(PDO::FETCH_ASSOC);
    
    return $data;
}

//購入済みIDの作成
function bought_numbering($dbh)
{
    $sql="SELECT buyId FROM bought ORDER BY buyId DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=$stmt->fetch(PDO::FETCH_ASSOC);

    $code_kari = $data['buyId'];
    #print($code_kari);
    $code = "B";
    $code_kari=substr($code_kari,2);
    #print($code_kari);
	// 分解した数字(文字列)をintに変換し、+1する。
    $codeNumber = (int)$code_kari+ 1;
    #print($codeNumber);
	//S0000000001～などの、0を埋めていくif文。
    //最新の番号が～
    if (1 < $codeNumber && $codeNumber < 10)
    {
        //1桁のとき
        $code .= "000000000".(string)$codeNumber;

    }
    else if (9 < $codeNumber && $codeNumber < 100)
    {
        //2桁のとき
        $code .= "00000000".(string)$codeNumber;
    }
    else if (99 < $codeNumber && $codeNumber < 1000)
    {
        //3桁のとき
        $code .= "0000000".(string)$codeNumber;
    }
    else if (999 < $codeNumber && $codeNumber < 10000)
    {
        //4桁のとき
        $code .= "000000".(string)$codeNumber;

    }
    else if (9999 < $codeNumber && $codeNumber < 100000)
    {
        //5桁のとき
        $code .= "00000".(string)$codeNumber;

    }
    else if (99999 < $codeNumber && $codeNumber < 1000000)
    {
        //6桁のとき
        $code .= "0000".(string)$codeNumber;

    }
    else if (999999 < $codeNumber && $codeNumber < 10000000)
    {
        //7桁のとき
        $code .= "000".(string)$codeNumber;

    }
    else if (9999999 < $codeNumber && $codeNumber < 100000000)
    {
        //8桁のとき
        $code .= "00".(string)$codeNumber;
    }
    else
    {
        //9桁のとき
        $code .= "0".(string)$codeNumber;

    }
    #print $code;
    return $code;
}

//DBからユーザーIDが一致するユーザーの情報を取得する
function select_puser_all($dbh,$userId)
{
    $sql = "SELECT * FROM puser
                WHERE userId = :userId";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->execute();

    $puser=$stmt->fetch(PDO::FETCH_ASSOC);
    //$puser=$stmt->fetchAll();
    return $puser;
}


function solt_syohin_new_top5($dbh){#新規登録順top5
    $sql = "SELECT TOP 5 * FROM syohin ORDER BY startDate DESC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}


// DBから全ジャンル新着5件を取得する
function select_genre_all_new_top5($dbh)
{
    $sql = "SELECT TOP 5 * FROM genre ORDER BY genreCode DESC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}


// DBから全店舗新着5件を取得する
function select_tenpo_all_new_top5($dbh)
{
    $sql = "SELECT TOP 5 * FROM tenpo ORDER BY tenpoCode DESC";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;
}


//未登録商品に商品を登録
function insert_misyohin($dbh,$ID,$sName,$tName,$sDate,$con,$photo)
{
    $ID=misyohinID_numbering($dbh);

    $sql = "INSERT INTO miSyohin VALUES(:ID,:sName,:tName,:sDate,:con,:photo)";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":ID",$ID,PDO::PARAM_STR);
    $stmt->bindValue(":sName",$sName,PDO::PARAM_STR);
    $stmt->bindValue(":tName",$tName,PDO::PARAM_STR);
    $stmt->bindValue(":sDate",date("Y-m-d", strtotime($sDate)), PDO::PARAM_STR);
    $stmt->bindValue(":con",$con,PDO::PARAM_STR);
    $stmt->bindValue(":photo",$photo,PDO::PARAM_STR);
    $stmt->execute();

    $puser=$stmt->fetch(PDO::FETCH_ASSOC);
    return $puser;

}

//未商品ID自動附番
function misyohinID_numbering($dbh)
{
    $sql="SELECT * FROM miSyohin ORDER BY miSyohinId DESC";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=$stmt->fetch(PDO::FETCH_ASSOC);

    $code_kari = $data['miSyohinId'];
    #print($code_kari);
    $code = "M";
    $code_kari=substr($code_kari,2);
    #print($code_kari);
	// 分解した数字(文字列)をintに変換し、+1する。
    $codeNumber = (int)$code_kari+ 1;
    #print($codeNumber);
	//S0000000001～などの、0を埋めていくif文。
    //最新の番号が～
    if (1 < $codeNumber && $codeNumber < 10)
    {
        //1桁のとき
        $code .= "000000000".(string)$codeNumber;

    }
    else if (9 < $codeNumber && $codeNumber < 100)
    {
        //2桁のとき
        $code .= "00000000".(string)$codeNumber;
    }
    else if (99 < $codeNumber && $codeNumber < 1000)
    {
        //3桁のとき
        $code .= "0000000".(string)$codeNumber;
    }
    else if (999 < $codeNumber && $codeNumber < 10000)
    {
        //4桁のとき
        $code .= "000000".(string)$codeNumber;

    }
    else if (9999 < $codeNumber && $codeNumber < 100000)
    {
        //5桁のとき
        $code .= "00000".(string)$codeNumber;

    }
    else if (99999 < $codeNumber && $codeNumber < 1000000)
    {
        //6桁のとき
        $code .= "0000".(string)$codeNumber;

    }
    else if (999999 < $codeNumber && $codeNumber < 10000000)
    {
        //7桁のとき
        $code .= "000".(string)$codeNumber;

    }
    else if (9999999 < $codeNumber && $codeNumber < 100000000)
    {
        //8桁のとき
        $code .= "00".(string)$codeNumber;
    }
    else
    {
        //9桁のとき
        $code .= "0".(string)$codeNumber;

    }
    #print $code;
    return $code;
}

function insert_forgetURL($dbh,$forwardid,$userId,$respassword,$forwardDate)#URL制限時間
{
    $sql = "INSERT INTO forgetURL(forwardid,userId,respassword,forwardDate) 
            VALUES(:forwardid,:userId,:respassword,:forwardDate)";

    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":forwardid",$forwardid,PDO::PARAM_STR);
    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->bindValue(":respassword",$respassword,PDO::PARAM_STR);
    $stmt->bindValue(":forwardDate",$forwardDate,PDO::PARAM_STR);
    $stmt->execute();

}

function select_forgetURL($dbh,$forwardid){ #パスワード忘れ処理のパスワードと締め切り日時
    //var_dump($forwardid);
    $sql = "SELECT respassword,forwardDate  FROM forgetURL
            WHERE forwardid=:forwardid";
    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(":forwardid",$forwardid,PDO::PARAM_STR);
    $stmt->execute();
    $forward=$stmt->fetchALL();
    //var_dump($forward);
    return $forward;
}


//欲しいものリストに入っていてnewsテーブルに入っている商品を取得する(本日テーブルに追加されたもののみを取得)追加分
function osirase_get($dbh,$userId)
{
    $sql = "SELECT newsId,newsflag,S.syohinName,newsDate,S.endDate
    FROM puser AS U
    LEFT OUTER JOIN wanting AS W ON U.userId = W.userId
    LEFT OUTER JOIN syohin AS S ON W.syohinId = S.syohinId 
	LEFT OUTER JOIN news AS N ON N.syohinId = S.syohinId
    WHERE U.userId = :userId 
    and (DATEDIFF(day,startDate,CAST(GETDATE() as date)) < 14) 
    AND newsId IS NOT NULL 

	union

	SELECT newsId,newsflag,S.syohinName,newsDate,S.endDate
    FROM puser AS U
    LEFT OUTER JOIN wanting AS W ON U.userId = W.userId
    LEFT OUTER JOIN syohin AS S ON W.syohinId = S.syohinId
	LEFT OUTER JOIN news AS N ON N.syohinId = S.syohinId
	WHERE U.userId = :userId2 
	AND ((S.endDate <= CONVERT(DATE,getdate()+7) AND N.newsFlag = 7)
	OR ((S.endDate <= CONVERT(DATE,getdate()+3) )AND N.newsFlag = 3)
	OR (((S.startDate < CONVERT(DATE,getdate()+15)) AND (S.endDate is NULL)) AND N.newsFlag = 0 )) ORDER BY newsId DESC";
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":userId",$userId,PDO::PARAM_STR);
    $stmt->bindValue(":userId2",$userId,PDO::PARAM_STR);

    $stmt->execute();

    $data=[];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $data[]=$row;
    }
    return $data;

}

function delete_forgetURL($dbh,$pass){ #パスワード忘れ処理の使用済みの情報の削除

    $sql ="DELETE FROM forgetURL WHERE respassword=:respassword";
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':respassword',$pass,PDO::PARAM_STR);
        
    $stmt->execute();
}
function ranking_get_4($dbh)
{
    $sql = "SELECT DISTINCT top 20 S.syohinId,syohinName,AVG(evaluation) AS eva,photo ,endDate,startDate
    FROM syohin AS S 
    LEFT OUTER JOIN review AS R ON S.syohinId = R.syohinId
    GROUP BY S.syohinId,syohinName,photo,endDate,startDate
    HAVING AVG(evaluation) IS NOT NULL AND endDate > CONVERT(DATE,getdate())
    union
    SELECT DISTINCT top 20 S.syohinId,syohinName,AVG(evaluation) AS eva,photo ,endDate,startDate
    FROM syohin AS S 
    LEFT OUTER JOIN review AS R ON S.syohinId = R.syohinId
    GROUP BY S.syohinId,syohinName,photo,endDate,startDate
    HAVING AVG(evaluation) IS NOT NULL AND endDate is null 
    and (DATEDIFF(day,startDate,CAST(GETDATE() as date)) < 14)
    ORDER BY AVG(evaluation) DESC
    OFFSET 3 ROWS
    FETCH FIRST 17 ROWS ONLY";

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $data=[];

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $data[]=$row;
    }
    return $data;
}