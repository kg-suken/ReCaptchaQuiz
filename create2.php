<?php
// create2.php

// フォームからのデータを取得
$project_name = $_POST['project_name'];
$images = $_FILES['images'];

// プロジェクトディレクトリを作成
$project_dir = "./questions/" . basename($project_name);
if (!is_dir($project_dir)) {
    mkdir($project_dir, 0777, true);
}

// 画像をアップロード
$uploaded_images = [];
for ($i = 0; $i < count($images['name']); $i++) {
    $tmp_name = $images['tmp_name'][$i];
    $name = basename($images['name'][$i]);
    $target_file = $project_dir . "/" . $name;

    // 画像ファイルかどうかチェック
    $check = getimagesize($tmp_name);
    if ($check !== false) {
        if (move_uploaded_file($tmp_name, $target_file)) {
            $uploaded_images[] = $name;
        }
    }
}

// アップロードされた画像を表示して選択させる
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像選択と質問入力</title>
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
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            max-width: 800px;
            width: 100%;
            text-align: left;
        }
        .image-container {
            display: inline-block;
            position: relative;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .image-container input[type="checkbox"] {
            display: none;
        }
        .image-container label {
            cursor: pointer;
            display: block;
        }
        .image-container img {
            display: block;
            width: 200px;
            height: auto;
            transition: opacity 0.3s;
            opacity: 0.6; /* 初期状態はグレーアウト */
        }
        .image-container.selected img {
            opacity: 1; /* 選択された場合は通常表示 */
        }
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function toggleSelection(checkbox, container) {
            if (checkbox.checked) {
                container.classList.add('selected');
            } else {
                container.classList.remove('selected');
            }
        }
    </script>
</head>
<body>
    <h1>画像選択と質問入力</h1>
    <form action="create3.php" method="POST">
        <input type="hidden" name="project_name" value="<?php echo htmlspecialchars($project_name); ?>">
        <div>
            <?php foreach ($uploaded_images as $image): ?>
                <div class="image-container" id="container_<?php echo $image; ?>">
                    <input type="checkbox" id="image_<?php echo $image; ?>" name="selected_images[]" value="<?php echo $image; ?>" onclick="toggleSelection(this, document.getElementById('container_<?php echo $image; ?>'))">
                    <label for="image_<?php echo $image; ?>">
                        <img src="<?php echo $project_dir . "/" . $image; ?>" alt="<?php echo $image; ?>">
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <br>
        <label for="question">質問:</label><br>
        <textarea id="question" name="question" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="作成">
    </form>
</body>
</html>
