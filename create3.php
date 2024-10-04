<?php
// create3.php

// フォームからのデータを取得
$project_name = $_POST['project_name'];
$selected_images = $_POST['selected_images'];
$question = $_POST['question'];

// プロジェクトディレクトリ
$project_dir = "./questions/" . basename($project_name);

// データをJSON形式で保存
$data = [
    'question' => $question,
    'images' => $selected_images
];

$json_data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
file_put_contents($project_dir . "/data.json", $json_data);

// 完了メッセージを表示
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト作成完了</title>
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
            color: #28a745;
            margin-bottom: 20px;
        }
        h2 {
            color: #007BFF;
            margin: 20px 0 10px;
        }
        p {
            margin: 0 0 20px;
        }
        img {
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>プロジェクト「<?php echo htmlspecialchars($project_name); ?>」が作成されました</h1>
    <p>選択された画像と質問が保存されました。</p>
    <h2>質問:</h2>
    <p><?php echo nl2br(htmlspecialchars($question)); ?></p>
    <h2>選択された画像:</h2>
    <?php foreach ($selected_images as $image): ?>
        <img src="<?php echo $project_dir . "/" . $image; ?>" alt="<?php echo htmlspecialchars($image); ?>" style="width:200px; margin:10px;">
    <?php endforeach; ?>
    <br>
    <a href="./index.php">戻る</a>
</body>
</html>
