<?php

//1. POSTデータ取得
$name = $_POST['name'];
$birthday = $_POST['birthday'];

//2. DB接続します
// ！！Githubに上げる前に、このセクションは削除！！
// ローカルのデータベースにアクセスするための必要な情報を変数に渡す
$db_name = '';               // データベース名
$db_host = '';     // DBホスト
$db_id   = '';               // ユーザー名(さくらサーバはDB名と同一)
$db_pw   = '';                   // パスワード

// try catch構文でデータベースの情報取得を実施
try {
    $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
    $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
    // エラーだった場合の情報を返す処理
    // exitした時点でそれ以降の処理は行われません
    exit('DB Connection Error:' . $e->getMessage());
}

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO kadai_php2_table(id, indate, name, birthday) VALUES (NULL,now(), :name, :birthday)");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if ($status === false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit('ErrorMessage:' . $error[2]);
} else {
    //５．index.phpへリダイレクト
    header('Location: index.php');
}
