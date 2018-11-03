<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission_2-3</title>
</head>
<body>
<?php
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn,$user,$password);

	if (isset($_POST["edit"])){
		if (isset($_POST["editnum1"])){
			$edit = $_POST["editnum1"];
			
			$pass3 = $_POST["pass3"];
			$sql = 'SELECT * FROM m4tbl where id = :edit and pass = :pass3';
			$stmt = $pdo -> prepare($sql);
			$stmt -> bindParam(':edit', $edit, PDO::PARAM_INT);
			$stmt -> bindParam(':pass3', $pass3, PDO::PARAM_STR);
			$stmt -> execute();
		

			if($row = $stmt -> fetch()){
				$text0 = $row["id"];
				$text1 = $row["name"];
				$text2 = $row["comment"];
			}
		}
	}

?>
<form action="mission_4-1.php" method ="post">
	名前　　　:<input type = "text" name ="text1" placeholder = "名前" value="<?php echo $text1; ?>"><br>
	コメント　:<input type = "text" name ="text2" placeholder = "コメント" value="<?php echo $text2; ?>"><br>
	パスワード:<input type = "password" name ="pass1">
	<input type ="hidden" name = "editnum2" value=<?php echo $text0; ?>>
	<input type = "submit" name = "add" value ="送信"><br><br>
	削除　　　:<input type = "text" name ="del" placeholder = "投稿番号"><br>
	パスワード:<input type = "password" name ="pass2">
	<input type = "submit" name = "delete1" value ="削除"><br><br>
	編集　　　:<input type = "text" name ="editnum1" placeholder = "投稿番号"><br>
	パスワード:<input type = "password" name ="pass3">
	<input type = "submit" name = "edit" value ="編集">
	<br>
	<hr>
</form>

<?php

	//　編集
	if (isset($_POST["add"])){
		if ($_POST["editnum2"]){
			$date = date('Y/m/d H:i');
			$edit0 = $_POST["editnum2"];
			$edit1 = $_POST["text1"];
			$edit2 = $_POST["text2"];
			$pass1 = $_POST["pass1"];
			
			$sql = 'update m4tbl set name = :edit1,comment = :edit2 where id = :edit0 AND pass = :pass1';
			$stmt = $pdo -> prepare($sql);
			$stmt->bindParam(':edit0', $edit0, PDO::PARAM_STR);
			$stmt->bindParam(':edit1', $edit1, PDO::PARAM_STR);
			$stmt->bindParam(':edit2', $edit2, PDO::PARAM_STR);
			$stmt->bindParam(':pass1', $pass1, PDO::PARAM_STR);		
			$stmt -> execute();
		
		}else{
		//　追加
		
			date_default_timezone_set('Asia/Tokyo');

			$date = date('Y/m/d H:i');
			$name = $_POST['text1'];
			$comment = $_POST['text2'];
			$pass1 = $_POST['pass1'];

			if($_POST[text1] != "" && $_POST[text2] != ""){
				$sql = $pdo -> prepare("INSERT INTO m4tbl (name,comment,date,pass) VALUES(:name, :comment, :date, :pass)");
				$sql -> bindParam(':name', $name, PDO::PARAM_STR);
				$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
				$sql -> bindParam(':date', $date, PDO::PARAM_STR);
				$sql -> bindParam(':pass', $pass1, PDO::PARAM_STR);

				$sql -> execute();
				
				
			}
		}
	}
?>

<?php
//　削除
if (isset($_POST["delete1"])){
	if (isset($_POST["del"])){
		$delete = $_POST["del"];
		$pass2 = $_POST["pass2"];
		
		$sql = 'DELETE FROM m4tbl where id = :delete AND pass = :pass2';
		$stmt = $pdo -> prepare($sql);
		$stmt->bindParam(':delete', $delete, PDO::PARAM_STR);
		$stmt->bindParam(':pass2', $pass2, PDO::PARAM_STR);

		$stmt -> execute();
	}
	
}
?>	

<?php
	//	表示コード

	$sql = 'SELECT id,name,comment,date FROM m4tbl order by id asc';
	$result = $pdo -> query($sql);
	foreach($result as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'];
		echo $row['date'];
		echo "<br>";
		echo "<hr>";
	}


?>

</body>
</html>