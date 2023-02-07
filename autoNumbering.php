<?php
// require_once './helpers/db_helper_baba.php';
// $dbh=get_db_connect();

// $sql="SELECT wantingId FROM wanting ORDER BY wantingId DESC";
// $stmt = $dbh->prepare($sql);
// $stmt->execute();

// $data=$stmt->fetch(PDO::FETCH_ASSOC);

// $code_kari = $data['wantingId'];
// print($code_kari);
// $code = "S";
// $code_kari=substr($code_kari,2);
// #print($code_kari);
// // 分解した数字(文字列)をintに変換し、+1する。
// $codeNumber = (int)$code_kari+ 1;
// #print($codeNumber);
// //S0000000001～などの、0を埋めていくif文。
// //最新の番号が～
// if (1 < $codeNumber && $codeNumber < 10)
// {
//     //1桁のとき
//     $code .= "000000000".(string)$codeNumber;

// }
// else if (9 < $codeNumber && $codeNumber < 100)
// {
//     //2桁のとき
//     $code .= "00000000".(string)$codeNumber;
// }
// else if (99 < $codeNumber && $codeNumber < 1000)
// {
//     //3桁のとき
//     $code .= "0000000".(string)$codeNumber;
// }
// else if (999 < $codeNumber && $codeNumber < 10000)
// {
//     //4桁のとき
//     $code .= "000000".(string)$codeNumber;

// }
// else if (9999 < $codeNumber && $codeNumber < 100000)
// {
//     //5桁のとき
//     $code .= "00000".(string)$codeNumber;

// }
// else if (99999 < $codeNumber && $codeNumber < 1000000)
// {
//     //6桁のとき
//     $code .= "0000".(string)$codeNumber;

// }
// else if (999999 < $codeNumber && $codeNumber < 10000000)
// {
//     //7桁のとき
//     $code .= "000".(string)$codeNumber;

// }
// else if (9999999 < $codeNumber && $codeNumber < 100000000)
// {
//     //8桁のとき
//     $code .= "00".(string)$codeNumber;
// }
// else
// {
//     //9桁のとき
//     $code .= "0".(string)$codeNumber;

// }

// ($dbh,$code);


?>