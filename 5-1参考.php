<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission5-1</title>
</head>
<body>
    <span style="font-size:20px;">就活終わったらやりたいことはなんですか？
    </span>
    <form action=""method="post">
    名前:
        <input type="text"name="name"placeholder="名前">
    編集:
        <input type="text"name="editnum"placeholder=
        "編集対象番号"><br/>
    
        <input type="text"name="comment"placeholder="コメント"
         ><br/>
        
        <input type="text"name="pass"placeholder=
        "パスワード">
        
        <input type="submit" name="submit" ><br>
        
         投稿削除:</br>
        <input type="text"name="delete"placeholder="削除対象番号"><br/>
        <input type="text"name="delpass"placeholder="パスワード">
        <input type="submit"value="削除"><br/>
    
    </form>
<?php
    echo "__________________掲示板欄______________________<br>"
?>
     <?php

	// DB接続設定
	$dsn ='データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	
	$pdo = new PDO($dsn, $user, $password, 
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
        //定義づけ
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $date=date("Y/m/d H:i:s");
        $pass=$_POST["pass"];
        $editnum=$_POST["editnum"];
        
	    
            //投稿削除
        if(!empty($_POST["delete"])&&!empty($_POST["delpass"]))
        {
        $delete=$_POST["delete"];
         $delpass=$_POST["delpass"];
         $sql='delete from tbtest1234 where id=:id AND pass=:pass';
         $stmt=$pdo->prepare($sql);
         $stmt->bindParam(':id',$delete,PDO::PARAM_INT);
         $stmt->bindParam(':pass',$delpass,PDO::PARAM_INT);
         $stmt->execute();
        }
    //編集機能
        if(!empty($editnum)&&!empty($name)&&
        !empty($comment)&&!empty($pass)){
        $id = $editnum; //変更する投稿番号
    	$name2 = $name;
	    $comment2 = $comment; 
	    $pass2 = $pass;
	    //変更したい名前、変更したいコメントは自分で決めること
	    $sql = 'UPDATE tbtest1234 SET name=:name,
	    comment=:comment WHERE id=:id AND pass=:pass';
    	$stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':name', $name2, PDO::PARAM_STR);
	    $stmt->bindParam(':comment', $comment2, PDO::PARAM_STR);
	    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt->bindParam(':pass',$pass2,PDO::PARAM_INT);
	    $stmt->execute();
        }else{
        //テキスト入力(新規投稿)
       if(!empty($name&&$comment&&$pass)&&empty($editnum)){
            $sql = $pdo -> prepare("INSERT INTO tbtest1234
           (name, comment,dt,pass) VALUES (:name, :comment,:dt,:pass)");
	       $sql -> bindParam(':name', $name1, PDO::PARAM_STR);
	       $sql -> bindParam(':comment', $comment1, 
	       PDO::PARAM_STR);
	       $sql -> bindParam(':dt', $dt1, PDO::PARAM_STR);
	       $sql -> bindParam(':pass', $pass1, PDO::PARAM_STR);
           $name1 = $name;
	       $comment1 =$comment; //好きな名前、好きな言葉は自分で決めること
	       $dt1=$date;
	       $pass1=$pass;
	       $sql -> execute();
       }
            
        }
            
        //データ抽出・出力
        $sql = 'SELECT * FROM tbtest1234';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'';
		echo $row['dt'].'<br>';
	echo "<hr>";
	}
    ?>