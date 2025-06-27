<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品出品</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<form action="sellresult.php" method="post" enctype="multipart/form-data">
  <div class="image-row">
    <label class="image-input">
      <input type="file" name="image1" accept="image/*">
    </label>
    <label class="image-input">
      <input type="file" name="image2" accept="image/*">
    </label>
    <label class="image-input">
      <input type="file" name="image3" accept="image/*">
    </label>
  </div>

  <input type="text" name="bookname" placeholder="商品名" required>
  <input type="number" name="price" placeholder="値段" required>
  <label>説明文</label>
  <textarea name="descript" placeholder="商品の説明をご記入ください" required></textarea>

  <div class="button-row">
    <a href="javascript:history.back()" class="detail-btn">戻る</a>
    <button type="submit" class="detail-btn">出品する</button>
  </div>
</form>
</body>
</html>
