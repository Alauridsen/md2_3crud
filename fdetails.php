<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<?PHP include 'menu.php'; ?>


<h1>
<?PHP 
require_once 'dbconfig.php';
$film_id = filter_input(INPUT_GET, 'film_id', FILTER_VALIDATE_INT) or die('missing parameter'); 
$sql = 'SELECT f.title, f.description 
FROM md2_film f
WHERE f.film_id = ?';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $film_id);
$stmt->execute();
$stmt->bind_result($film_name, $film_desc);
while($stmt->fetch()){
	echo $film_name;

?>
</h1>
<p>
<?PHP
	echo $film_desc;
}
?>
</p>
<?PHP
require_once 'dbconfig.php';

$sql1 = 'SELECT c.name, f.release_year
FROM md2_film f, md2_film_category fc, md2_category c
WHERE f.film_id = ?
AND f.film_id = fc.film_id
AND c.category_id = fc.category_id';
$stmt1 = $link->prepare($sql1);
$stmt1->bind_param('i', $film_id);
$stmt1->execute();
$stmt1->bind_result($category_name, $film_year);
while($stmt1->fetch()){ 
echo '<p>'.$category_name.' '.$film_year.'</p>'; 
}
?>
<ul>
<?PHP
$sql2 = 'SELECT a.actor_id, a.first_name, a.last_name 
FROM md2_film f, md2_film_actor fa, md2_actor a
WHERE f.film_id = ?
AND f.film_id = fa.film_id
AND a.actor_id = fa.actor_id';
$stmt2 = $link->prepare($sql2);
$stmt2->bind_param('i', $film_id);
$stmt2->execute();
$stmt2->bind_result($actor_id, $a_f_name, $a_l_name);
while($stmt2->fetch()){ 
	echo '<li><a href="actor.php?actor_id='.$actor_id.'">'.$a_f_name.' '.$a_l_name.'</a></li>'.PHP_EOL;
}
?>

</ul>

</body>
</html>