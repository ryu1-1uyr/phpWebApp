<?php

$name = $_POST['YourName'];
$pw = $_POST["pw"] ;

$user = 'ryu1';
$password = 'ryuryu1207';

$dbname = 'test';
$host = 'localhost:3306';

$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";

$pdo = new PDO($dsn, $user, $password);//MySQLに接続てきな！

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);//おまじない
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//おまじない

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="nav.css">
</head>
<body>

<ui id="nav">
    <li><a href="index.php">index</a></li>
    <li><a href="register.php">register</a></li>
    <li><a href="login.php">login</a></li>
</ui>

<h1>hoge</h1>

<form action="login.php" method="post">
    <p><label>ユーザー名<input name="YourName"></label></p>
    <p><label>パスワード<input type="password" name="pw"></label></p>
    <p><button>送信</button></p>
</form>

<?php
$name    = $_POST['YourName'];
$message = $_POST["pw"] ;

echo $name;
echo $message;
if ($_POST){
if ($name != "" && $message != "") {


    try {


        $sql = 'SELECT id,name,pw FROM user WHERE name = :name';
        $stm = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stm->execute(array(':name' => $name)); //値をbindして実行!

        $resulut = $stm->fetch(PDO::FETCH_ASSOC); //1つの要素をもらう ここふんわりとしか理解してない

        $verifySuccess = (empty($resulut)) ? false : password_verify($pw,$resulut['pw']); // すごいこの文 ? はif文の代わり
        //:の前後でTF
        echo "<br>";
        echo "データベース{$dbname}に接続しました";
        echo "<br>" . "<br>";
        if ($verifySuccess){
            echo "ログイン成功";
            session_start();
            $_SESSION['user']['username'] = "$name"; //セッションにはいる瞬間なう　ここに情報を追加したらセッションで取り扱える情報が増える
        }else{
                echo "ログインに失敗しました";
        }
        //$pdo =null;
    } catch (Exception $e) {
        echo 'エラーが有りました';
        echo $e->getMessage();
        exit();
    }
}else {
    echo "ログインに失敗しました";
}
}
?>

</body>
</html>
