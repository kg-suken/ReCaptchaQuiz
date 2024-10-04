<?php
// POSTデータを取得
$selectedImages = json_decode($_POST['selectedImages'] ?? '[]');
$project = $_POST['Project'] ?? '';
$directory = "./questions/$project/";

// data.jsonの内容を取得
$jsonData = file_get_contents("$directory/data.json");
$data = json_decode($jsonData, true);
$correctImages = $data['images'];

// 正解判定
$correct = true;

// 選択された画像が正しいか確認
foreach ($selectedImages as $selectedImage) {
    if (!in_array($selectedImage, $correctImages)) {
        $correct = false;
        break;
    }
}

// 正しい画像がすべて選択されているか確認
foreach ($correctImages as $correctImage) {
    if (!in_array($correctImage, $selectedImages)) {
        $correct = false;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>結果</title>
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
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            justify-content: center;
        }
        .grid-item {
            border: 1px solid #ddd;
            padding: 5px;
            background: #fff;
        }
        .grid-item img {
            max-width: 100%;
            height: auto;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>結果</h1>
    <?php if ($correct): ?>
        <p>正解です！</p>
    <?php else: ?>
        <p>不正解です。</p>
        <h2>正解の画像</h2>
        <div class="grid-container">
            <?php foreach ($correctImages as $correctImage): ?>
                <div class="grid-item">
                    <img src="<?php echo $directory . $correctImage; ?>" alt="正解の画像">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <a href="./index.php" class="button">もう一度遊ぶ</a>
</body>
</html>
