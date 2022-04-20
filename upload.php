<?php

try {
  $pdo = new PDO('mysql:host=<<===>>;dbname=<<===>>', "<<USER>>", "<<===>>");
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

function randomString($n)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $str = '';
  for ($i = 0; $i < $n; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $str .= $characters[$index];
  }
  return $str;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $image = $_FILES["image"] ?? null;
  $imagePath = "";
  if (!is_dir("images")) {
    mkdir("images");
  }

  if ($image) {
    $imagePath = "images/" . randomString(8) . "/" . $image["name"];
    mkdir((dirname($imagePath)));
    move_uploaded_file($image["tmp_name"], $imagePath);
  }
  $statement = $pdo->prepare("INSERT INTO products (image) VALUES (:image) ");
  $statement->bindValue(":image", $imagePath);
  $statement->execute();
}
?>

<html>

<head>
</head>

<body>
  <form method="post" enctype="multipart/form-data">
    <div>
      <input type="file" name="image">
    </div>
    <button type="submit">Send File</button>
  </form>
</body>

</html>