<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<?PHP include 'menu.php';?>
<h1>
<?PHP 
require_once 'dbconfig.php';
$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT) or die('missing parameter'); 

$sql = 'SELECT c.name 
FROM md2_category c
WHERE c.category_id = ?';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $category_id);
$stmt->execute();
$stmt->bind_result($category_name);
while($stmt->fetch()){
	echo $category_name. ' Films';
}
?>
</h1>
<ul>
<?php
$sql1 = 'SELECT c.name, f.film_id, f.title, f.release_year 
FROM md2_film f, md2_film_category fc, md2_category c
WHERE c.category_id = ?
AND f.film_id = fc.film_id 
AND fc.category_id = c.category_id';
$stmt1 = $link->prepare($sql1);
$stmt1->bind_param('i', $category_id);
$stmt1->execute();
$stmt1->bind_result($category_name, $film_id, $film_title, $film_year);
while($stmt1->fetch()){
	echo '<li><a href="fdetails.php?film_id='.$film_id.'">'.$film_title.'</a></li>'.PHP_EOL;
}
?>
</ul>




</body>
</html>