<?php
if(empty($_SESSION['user']['username'])){//関数化すると良いかもしれない
    header("Location: http://localhost:8080/login.php");
}