<?PHP session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Categories</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<?PHP include 'menu.php'; ?>

<h1>Categories</h1>
<ul>
<?PHP 
require_once 'dbconfig.php';
$sql = 'SELECT category_id, name FROM md2_category';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($category_id, $category_name);
while($stmt->fetch()){
	echo '<li><a href="flist.php?category_id='.$category_id.'">'.$category_name.'</a></li>'.PHP_EOL;
}
?>
</ul>
</body>
</html>
