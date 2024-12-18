<?php

require_once('funcs.php');

//1.  DB接続します
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

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM kadai_php2_table;");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status === false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<p>';
        $view .= $result['indate'] . '/ ' . h($result['name']) . '/ ' . h($result['birthday']);
        $view .= '</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>受付患者一覧</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">データ登録</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron"><?= $view ?></div>
    </div>
    <!-- Main[End] -->

</body>

</html>