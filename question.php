<?php
// Projectのクエリパラメータを取得
$project = $_GET['Project'] ?? '';
$directory = "./questions/$project/";

// data.jsonの内容を取得
$jsonData = file_get_contents("$directory/data.json");
$data = json_decode($jsonData, true);
$question = $data['question'];
$correctImages = $data['images'];

// ディレクトリから画像ファイルを取得
$images = array_diff(scandir($directory), array('..', '.', 'data.json'));

// 画像をランダムにシャッフルし、16枚を選択
shuffle($images);
$randomImages = array_slice($images, 0, 16);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像選択</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }
        .header {
            width: 400px;
            background-color: #4285f4;
            color: white;
            text-align: left;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 1.2em;
            border-radius: 5px 5px 0 0;
        }
        .header p {
            margin: 0;
        }
        .skip-btn {
            display: block;
            width: 400px;
            text-align: right;
            padding: 10px;
            font-size: 1em;
            background-color: white;
            border-top: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .grid-item {
            position: relative;
            width: 100px;
            height: 100px;
            border: 2px solid transparent;
            transition: border 0.3s, transform 0.3s;
        }
        .grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }
        .grid-item.selected {
            border: 2px solid #4285f4;
            transform: scale(1.05);
        }
        .grid-item:hover {
            border: 2px solid #ddd;
        }
        button {
            background-color: #4285f4;
            color: white;
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        button:hover {
            background-color: #357ae8;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .skip-btn button {
            background-color: #f9f9f9;
            color: #333;
            border: 1px solid #ddd;
        }
    </style>
    <script>
        function toggleSelect(img) {
            img.classList.toggle('selected');
        }

        function submitSelection() {
            const selectedImages = [];
            document.querySelectorAll('.grid-item.selected img').forEach(img => {
                selectedImages.push(img.dataset.filename);
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'ansor.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selectedImages';
            input.value = JSON.stringify(selectedImages);

            const projectInput = document.createElement('input');
            projectInput.type = 'hidden';
            projectInput.name = 'Project';
            projectInput.value = '<?php echo $project; ?>';

            form.appendChild(input);
            form.appendChild(projectInput);
            document.body.appendChild(form);

            form.submit();
        }
    </script>
</head>
<body>

    <div class="header">
        <p>質問: <?php echo htmlspecialchars($question); ?></p>
        <p>全ての対象を選択してください</p>
    </div>

    <div class="grid-container">
        <?php foreach ($randomImages as $image): ?>
            <div class="grid-item" onclick="toggleSelect(this)">
                <img src="<?php echo $directory . $image; ?>" data-filename="<?php echo $image; ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <button onclick="submitSelection()">送信</button>

</body>
</html>
