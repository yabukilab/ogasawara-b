<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ホーム</title>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <div class="container">
    <form action="sell.php" method="get">
      <button class="dekabota-btn">出品</button>
    </form>
    <form action="search.php" method="get">
      <button class="dekabota-btn">購入</button>
    </form>
    <form action="mypage.php" method="get">
      <button style="border: none; background: none; position: absolute; bottom: 50px; right: 50px;">
        <img src="user_icon.png" alt="マイページ" width="100">
      </button>
    </form>
  </div>
</body>
</html>