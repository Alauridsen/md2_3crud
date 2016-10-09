
<?php 
	/*Variabel der finder nuværende sides filnavn. */
	  $curpage = basename($_SERVER['PHP_SELF']);
	  
?>
<!-- If clausul der echo'er class'en active i det nuværende menu link. -->

<ul id="menu">
	<li><a href="index.php" <?PHP if ($curpage == 'index.php') {echo 'class="active"';}?>>Browse Film</a></li>
    <li><a href="p2.php" <?PHP if ($curpage == 'p2.php') {echo 'class="active"';}?>>Edit Film</a></li>
</ul>