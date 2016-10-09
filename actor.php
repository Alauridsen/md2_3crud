<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<?PHP include 'menu.php'; ?>
<?php
$actor_id = filter_input(INPUT_GET, 'actor_id', FILTER_VALIDATE_INT) or die('missing parameter');
?>
<h1>
<?PHP
require_once 'dbconfig.php';
$sql = 'SELECT a.first_name, a.last_name
FROM md2_actor a
WHERE actor_id = ?';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $actor_id);
$stmt->execute();
$stmt->bind_result($a_f_name, $a_l_name);
while($stmt->fetch()){ 
echo ''.$a_f_name." ".$a_l_name.''; 
}
?>
</h1>
<ul>
<?PHP
$sql1 = 'SELECT f.film_id, f.title, f.release_year
FROM md2_film f, md2_film_actor fa, md2_actor a
WHERE a.actor_id = ?
AND f.film_id = fa.film_id
AND a.actor_id = fa.actor_id';
$stmt1 = $link->prepare($sql1);
$stmt1->bind_param('i', $actor_id);
$stmt1->execute();
$stmt1->bind_result($film_id, $film_title, $film_year);
while($stmt1->fetch()){ 
echo '<li><a href="fdetails.php?film_id='.$film_id.'">'.$film_title.'</a></li><p>('.$film_year.')</p>'.PHP_EOL; 
}
?>
</ul>
</body>
</html>
