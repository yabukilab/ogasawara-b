<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>取引中止画面</title>
  <link rel="stylesheet" href="common_style.css">
  <style>
    .container {
      background: #fff;
      padding: 40px;
      width: 360px;
      margin: auto;
      border: 1px solid #ccc;
    }

    textarea {
      width: 100%;
      height: 150px;
      padding: 10px;
      resize: none;
    }

    .button-pair {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 10px;
    }

    .button-pair .send-button,
    .button-pair .return-button {
      width: 40%;
    }

    .send-button {
      background-color: #336699;
      color: white;
      padding: 12px 0;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .return-button {
      background-color: #336699;
      color: white;
      padding: 12px 0;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .page-id {
      margin-top: 20px;
      font-size: 14px;
      color: #333;
    }
  </style>
</head>
<body>

  <div class="container">
    <p>この取引を中止します。<br>中止する理由を入力してください</p>
    <textarea placeholder="コメント"></textarea>

    <div class="button-pair">
      <button class="send-button">送信</button>
      <a href="chat.php" class="return-button">戻る</a>
    </div>
  </div>

</body>
</html>