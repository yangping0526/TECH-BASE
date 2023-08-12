<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <?php
    // DB接続設定
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザ名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //編集フォーム準備1
    if(!empty($_POST["enumber1"])){
        $id =$_POST["enumber1"]; 
        $sql = 'SELECT * FROM m5 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute();                            
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            $enum=$row['id'];
            $ename=$row['name'];
            $ecomment=$row['comment'];
        }
    }
    ?>
    
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前" value=
        "<?php 
        if(!empty($ename)){
            echo $ename;
        }
        ?>"
        ><br>
        <input type="text" name="comment" placeholder="コメント" value=
        "<?php 
        if(!empty($ecomment)){
            echo $ecomment;
        }
        ?>"
        ><br>
        <input type="hidden" name="enumber2" placeholder="編集番号" value=
        "<?php 
        if(!empty($enum)){
            echo $enum;
        }
        ?>"
        >
        <input type="submit" name="submit"><br><br>
        <input type="number" name="dnumber"><br>
        <input type="submit" name="submit" value="削除"><br><br>
        <input type="number" name="enumber1"><br>
        <input type="submit" name="submit" value="編集">
    </form>
    
    <?php
    //初期表示
    if(empty($_POST["name"]) && empty($_POST["comment"]) && empty($_POST["dnumber"]) && empty($_POST["enumber1"])){
        $sql = 'SELECT * FROM m5';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].'<br>';
            echo "<hr>";
            }
    }
    
    //投稿フォーム準備
    if(!empty($_POST["name"]) && !empty($_POST["comment"])){
        
        //編集モード
        if(!empty($_POST["enumber2"])){
            //編集
            $id = $_POST["enumber2"];
            $name = $_POST["name"];
            $comment = $_POST["comment"]; 
            $sql = 'UPDATE m5 SET name=:name,comment=:comment WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();   
            
            //表示
            $sql = 'SELECT * FROM m5';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].'<br>';
            echo "<hr>";
            }
        }
        
        //新規投稿モード
        else{
            //投稿
            $pname=$_POST["name"];
            $pcomment=$_POST["comment"];
            $sql = $pdo -> prepare("INSERT INTO m5 (name, comment) VALUES (:name, :comment)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $name = $pname;
            $comment = $pcomment;
            $sql -> execute();
            
            //表示
            $sql = 'SELECT * FROM m5';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].'<br>';
            echo "<hr>";
            }
        }
    }
        
    //削除フォーム準備
    if(!empty($_POST["dnumber"])){
        $dnumber=$_POST["dnumber"];
        
        //削除
        $id = $dnumber;
        $sql = 'delete from m5 where id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        //表示
        $sql = 'SELECT * FROM m5';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].'<br>';
        echo "<hr>";
        }
    }
    
    //編集フォーム投稿時表示
    if(!empty($_POST["enumber1"])){
        $sql = 'SELECT * FROM m5';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].'<br>';
        echo "<hr>";
        }   
    }
    ?>
</body>