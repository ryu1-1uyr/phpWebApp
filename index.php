<?php

$user = 'ryu1';
$password = 'ryuryu1207';
$dbname = 'test';
$host = 'localhost:3306';

$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";

session_start();
require('header.php'); //順番注意
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>cotemttest</title>
    <link rel="stylesheet" href="nav.css">
</head>
<body>

<?php
if ($_SESSION['user']['username'] != "") {
    echo "<h1>" . $_SESSION['user']['username'] . "でログインしています" . "</h1>";
}else{
    echo "<h1>"."ログインしていません"."</h1>";
}
    ?>

<ui id="nav">
    <li><a href="index.php">index</a></li>
    <li><a href="register.php">register</a></li>
    <li><a href="login.php">login</a></li>
</ui>

<form action="index.php" method="post">
    <p><label>名前：<input name="YourName"></label></p>
    <p><label>メッセージ：<input name="Message"></label></p>
    <p><button>送信</button></p>
</form>

  <div>

<?php
//$sql = 'select body from log where name = "hello"';
$pdo = new PDO($dsn, $user, $password);//MySQLに接続てきな！

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);//おまじない
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//おまじない



try{

    $name    = $_POST['YourName'];
    $message = $_POST["Message"] ;

    if ( $message != "") {
        echo $_SESSION['user']['username'] . " " . $message."<br>";
        $sql = "insert into log VALUE ('$name','$message')";

        echo $sql."<br>";

        $stm = $pdo->prepare($sql);//SQLの文書をセットする感じ

        $stm->execute();//SQLここで実行されてる

    }
    $name = "";
    $message = "";
//    $resulut = $stm->fetchAll(PDO::FETCH_ASSOC);


} catch(Exception $e){
    echo 'エラーが有りました';
    echo $e->getMessage();
}

try {
    $sql = 'SELECT * FROM log';

    $stm = $pdo->prepare($sql);//SQLの文書をセットする感じ

    $stm->execute();//SQLここで実行されてる

    $resulut = $stm->fetchAll(PDO::FETCH_ASSOC);

    echo "<br>";
    echo "データベース{$dbname}に接続しました";
    echo "<br>"."<br>";
    foreach ($resulut as $row){
        echo $row['name']."\n";
        echo $row['body']."<br>";
    };
    $pdo =null;
} catch (Exception $e){
  echo 'エラーが有りました';
  echo $e->getMessage();
  exit();
}



?>



</div>
</body>
</html>
