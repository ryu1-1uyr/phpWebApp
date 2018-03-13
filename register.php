<?php

$name = $_POST['YourName'];
$pw = $_POST["pw"] ;

$user = 'ryu1';
$password = 'ryuryu1207';

$dbname = 'test';
$host = 'localhost:3306';

$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";

//$sql = 'select body from log where name = "hello"';
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

<form action="register.php" method="post">
    <p><label>ユーザー名<input name="YourName"></label></p>
    <p><label>パスワード<input type="password" name="pw"></label></p>
    <p><button>送信</button></p>
</form>
<?php

echo "<p>". $name . " " . $pw . "</p>";


try {
    $sql = 'SELECT * FROM user';
    $stm = $pdo->prepare($sql);//SQLの文書をセットする感じ
    $stm->execute();//SQLここで実行されてる
    $resulut = $stm->fetchAll(PDO::FETCH_ASSOC);

    echo "<br>";
    echo "データベース{$dbname}に接続しました";
    echo "<br>"."<br>";
    foreach ($resulut as $row){
        echo $row['id']."\n";
        echo $row['name']."\n";
        echo $row['pw']."<br>";
    };
    //$pdo =null;
} catch (Exception $e){
    echo 'エラーが有りました';
    echo $e->getMessage();
    exit();
}

?>

<?php

echo "<p>//////////////////////////////////</p>";

if ($name != "" && $pw != "") {
    try {

        $sql = 'SELECT count(id) FROM user';
        $stm = $pdo->prepare($sql);//SQLの文書をセットする感じ
        $stm->execute();//SQLここで実行されてる
        $resulut = $stm->fetchAll(PDO::FETCH_ASSOC);

        $nums = ($resulut[0]["count(id)"]) + 1 ;

        $hashPW = password_hash("$pw", PASSWORD_DEFAULT);

        $sql = 'insert into user VALUE (:id,:name ,:pw)';
        $sth = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array('id' =>$nums ,':name' => $name, ':pw' => $hashPW));//値をbindしてSQLの実行

//        $sql = "insert into user VALUE ($nums,'$name','$pw')";
//        $stm = $pdo->prepare($sql);//SQLの文書をセットする感じ
//       $stm->execute();//SQLここで実行されてる
        $resulut = $sth->fetchAll(PDO::FETCH_ASSOC);


        echo "<br>";
        echo "user登録が完了しました";
        //$pdo =null;
    } catch (Exception $e) {
        echo 'エラーが有りました';
        echo $e->getMessage();
        exit();
    }
}
?>

</body>
</html>