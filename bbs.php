<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

</head>
<body>
    <form action="bbs.php" method="post">
      <input type="text" name="nickname" placeholder="nickname" required>
      <textarea type="text" name="comment" placeholder="comment" required></textarea>
      <button type="submit" >つぶやく</button>
    </form>

    <h2><a href="#">nickname Hiroshi</a><span>2015-12-02 10:10:20</span></h2>
    <p>つぶやきコメント</p>

    <h2><a href="#">nickname Hiroshi</a> <span>2015-12-02 10:10:10</span></h2>
    <p>つぶやきコメント2</p>

    <?php

	//POST送信が行われたら、下記の処理を実行
	if(isset($_POST['nickname'],$_POST['comment'])){
		
	//データベースに接続
	$dsn = 'mysql:dbname=oneline_bbs;host=localhost';
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');	

	$nickname=htmlspecialchars($_POST['nickname']);
	$comment=htmlspecialchars($_POST['comment']);
	//sql文作成（insert文）
	$sql ='INSERT INTO `posts` (`nickname`,`comment`,`created`)VALUES("'.$nickname.'","'.$comment.'",now())';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$sql='SELECT * FROM posts WHERE 1';
	$stmt = $dbh->prepare($sql);	
	//insert文実行
	$stmt->execute();
	while(1)
		{
			$rec=$stmt->fetch(PDO::FETCH_ASSOC);
			if($rec==false)
			{
				break;
			}
			echo $rec['id'];
			echo '&nbsp;';
			echo $rec['nickname'];
			echo ' ';
			echo $rec['comment'];
			echo ' ';
			echo '<br />';
		}

	//データベースから切断
	$dbh = null;
	}
    ?>
</body>
</html>