<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReCaptchaゲーム</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #007BFF;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            margin: 20px 0;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #007BFF;
            font-size: 18px;
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>ReCaptchaゲーム</h1>
    <h2>遊ぶ</h2>
    <?php
    // ディレクトリパス
    $dirPath = './questions/';

    // ディレクトリが存在するかチェック
    if (is_dir($dirPath)) {
        // ディレクトリハンドルを開く
        if ($handle = opendir($dirPath)) {
            echo '<ul>';
            // ディレクトリ内をループ
            while (false !== ($entry = readdir($handle))) {
                // '.' や '..' を除外し、ディレクトリのみを対象とする
                if ($entry != "." && $entry != ".." && is_dir($dirPath . $entry)) {
                    // リンクを生成
                    echo '<li><a href="./question.php?Project=' . urlencode($entry) . '">' . htmlspecialchars($entry) . '</a></li>';
                }
            }
            echo '</ul>';
            // ハンドルを閉じる
            closedir($handle);
        }
    } else {
        echo "<p>ディレクトリが存在しません。</p>";
    }
    ?>
    <h2><a href="./create1.php" class="button">問題を作成する</a></h2>
</body>
</html>
