<?PHP session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Film</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<?PHP include 'menu.php'; ?>
<?PHP require_once 'dbconfig.php';
// Create Film
if(isset($_POST['add'])) {
	$title = ltrim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
	// Checker om $title er tom.
	if (empty($title)) die('Please fill in a title');
	$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
	$year = filter_input(INPUT_POST, 'release_year', FILTER_VALIDATE_INT) or die('Fill in a release year');
	$sqla1 = "INSERT INTO md2_film (title, description, release_year) VALUES (?,?,?)";
	$stmta1 = $link->prepare($sqla1);
	// definerer datatyperne. her er det en "string" "string" "integer" "string" vi binder. 
	$stmta1->bind_param('ssi', $title, $description, $year) or die('Wrong data');
	$stmta1->execute();
	
	
	/* Jeg Forsøgte at tilføje værdier til composite key tabellen md2_film_category
		men havde problemer med at hente den nye værdi for film_id, og kan derfor ikke tilfredsstille composite key'en.
	
	$add_category = filter_input(INPUT_POST, 'addcategory', FILTER_VALIDATE_INT);
	$sqla2 = "INSERT INTO md2_film_category (film_id, category_id) VALUES (?,?)";
	$stmta2 = $link->prepare($sqla2);
	$stmta2->bind_param('ii', $film_id, $category_id);
	*/
	//$stmta2->execute();
	
	/*
	$category_id = filter_input(INPUT_POST, 'addcategory', FILTER_VALIDATE_INT) or die('No category selected');
	$sqlc = "INSERT INTO md2_film_category (film_id, category_id) VALUES (".$film_id.",?)";
	$stmtc = $link->prepare($sqlc);
	$stmtc->bind_param('ii', $film_id1, $category_id1) or die('wrong data');
	$stmtc->execute();
	*/
	}
	
// Delete Film
	if(isset($_POST['delete'])) {
	$film_id_d = filter_input(INPUT_POST, 'film_id_d', FILTER_VALIDATE_INT) or die('Ooops.. something is wrong');
	$sqld1 = "DELETE FROM md2_film WHERE film_id = ?";
	$stmtd1 = $link->prepare($sqld1);
	$stmtd1->bind_param('i', $film_id_d);
	$stmtd1->execute();
		echo 'DELETED!!';
	}
	
// Update Film
	if(isset($_POST['update'])) {
	$film_id_u = filter_input(INPUT_POST, 'film_id_u', FILTER_VALIDATE_INT) or die('Ooops.. something is wrong');
	$updateto = filter_input(INPUT_POST, 'updateto', FILTER_SANITIZE_SPECIAL_CHARS) or die('no title');
	$sqlu1 = "UPDATE md2_film SET title = ? WHERE film_id = ?";
	$stmtu1 = $link->prepare($sqlu1);
	$stmtu1->bind_param('si', $updateto, $film_id_u);
	$stmtu1->execute();
		echo 'UPDATED!!';
	}

// Read Film
?>

<!-- ADD FORM-->
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
	<legend>Add a film</legend>
    	<!-- <input name="film_id" type="hidden" value="  <?PHP // echo ?>"> -->
		<input name="title" type="text" placeholder="Title">
		<input name="description" type="text" placeholder="Description">
		<input name="release_year" type="number" placeholder="Release Year">
		<!-- 
        	<select name="addcategory">
			<?PHP /* $sqla = 'SELECT category_id, name FROM md2_category';
			$stmta = $link->prepare($sqla);
			$stmta->execute();
			$stmta->bind_result($category_id, $category_name);
			while($stmta->fetch()){
				echo '<option value="'.$category_id.'">'.$category_name.'</option>'.PHP_EOL;
			} */
			?>
            
		</select> -->
		<input name="add" type="submit">
	</fieldset>
</form>

<!-- DELETE FORM-->
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
	<legend>Delete a film</legend>
		<select name="film_id_d">
			<?PHP $sqld = 'SELECT film_id, title FROM md2_film';
			$stmtd = $link->prepare($sqld);
			$stmtd->execute();
			$stmtd->bind_result($film_id, $film_title);
			while($stmtd->fetch()){
				echo '<option value="'.$film_id.'">'.$film_title.'</option>'.PHP_EOL;
			}
			?>
		</select>
		<input name="delete" type="submit">
	</fieldset>
</form>

<!-- UPDATE FORM-->
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
		<legend>Update a film</legend>
		<select name="film_id_u">
			<?PHP $sqlu = 'SELECT film_id, title FROM md2_film';
			$stmtu = $link->prepare($sqlu);
			$stmtu->execute();
			$stmtu->bind_result($film_id, $film_title);
			while($stmtu->fetch()){
				echo '<option value="'.$film_id.'">'.$film_title.'</option>'.PHP_EOL;
			}
			?>
		</select>
		<input name="updateto" type="text" placeholder="Update to..">
		<input name="update" type="submit">
	</fieldset>
</form>
<h1>Film List</h1>
<ul>
<?php
$sqlr = 'SELECT film_id, title FROM md2_film';
$stmtr = $link->prepare($sqlr);
$stmtr->execute();
$stmtr->bind_result($film_idr, $titler);
while($stmtr->fetch()){
	echo '<li><a href="fdetails.php?film_id='.$film_idr.'">'.$titler.'</a></li>'.PHP_EOL;
}
?>
</ul>

</body>
</html>
