<?php
//データベースに接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
$sql = "CREATE TABLE IF NOT EXISTS tbtest"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY,"
. "name char(32),"
. "comment TEXT,"
. "date datetime,"
. "password char(32)"
.");";
$stmt = $pdo->query($sql);


//編集機能１
if(!empty($_POST["edit"])){
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
	if(($row["id"]) == ($_POST["edit"]) && ($_POST["pass3"]) == ("****")){
	$edit_number = $row["id"];
	$edit_name = $row["name"];
	$edit_comment = $row["comment"];
		}
	}
}
?>


<html>
<head>
<meta charset = "utf-8">
</head>
<form method = "POST" action = "mission_5-1.php">
名前　　　　
<!-- 編集フォームが空でないとき、入力された番号に該当するデータを出力 -->
<input type = "text" name = "name" value = "<?php if (!empty($_POST["edit"])){ echo $edit_name; } ?>">
<br>
コメント　　
<input type = "text" name = "comment" value = "<?php if (!empty($_POST["edit"])){ echo $edit_comment; } ?>">
<br>
パスワード　
<input type = "password" name = "pass1">
<input type = "submit" value = "送信">
<br>
<!--  編集したい投稿番号 -->
<input type = "hidden" name = "number" value = "<?php if (empty($_POST["edit"]) == FALSE){ echo $edit_number; }?>">
<br>
<br>
削除対象番号
<input type = "text" name = "delete">
<br>
パスワード　
<input type = "password" name = "pass2">
<input type = "submit" value = "削除">
<br>
<br>
編集対象番号
<input type = "text" name = "edit">
<br>
パスワード　
<input type = "password" name = "pass3">
<input type = "submit" value ="編集">
<br>
</html>


<?php
//新規投稿
if (!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["number"]) && ($_POST["pass1"]) == ("****")){
$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':date', $date, PDO::PARAM_STR);
$sql -> bindParam(':password', $password, PDO::PARAM_STR);;
$name = $_POST["name"];
$comment = $_POST["comment"];
$date = date("Y/m/d H:i:s");
$password = $_POST["pass1"];
$sql -> execute();


//新規投稿の表示
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
	foreach ($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
	echo "<hr>";
	}
}


//編集機能
else if (!empty($_POST["number"]) && ($_POST["pass1"]) == ("****")){
$id = $_POST["number"];
$name = $_POST["name"];
$comment = $_POST["comment"];
$date = date("Y/m/d H:i:s");
$password = $_POST["pass1"];
$sql = 'update tbtest set name=:name, comment=:comment, date=:date, password=:password where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':date', $date, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

//編集の表示
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
	echo "<hr>";
	}
}

//削除機能
if (!empty($_POST["delete"]) && ($_POST["pass2"]) == ("****")){
$id = $_POST["delete"];
$sql = 'delete from tbtest where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

//削除の表示
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
	foreach ($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
echo "<hr>";
	}
}
?>