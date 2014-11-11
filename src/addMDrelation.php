
<?php include('functions.php'); render_header(); ?>

<?php
	$db_connection = connect_db();

	//get options for Movie and Actor

	$movie_option = mysqli_query($db_connection, "SELECT DISTINCT * from Movie order by title;");
	$director_option = mysqli_query($db_connection, "SELECT DISTINCT * from Director order by first;");


?>

<?php function update_MD(){
	$db_connection = connect_db();
	//update_MA with provided Role

	$mid = $_POST['movie'];
	$did = $_POST['director'];

	//sanitize input
	$mid = mysqli_real_escape_string($db_connection, $mid);
	$did = mysqli_real_escape_string($db_connection, $did);


  if(!empty($mid) && !empty($did))
  {


	$update_query = "INSERT INTO MovieDirector(mid, did) VALUES('$mid', '$did');";
	mysqli_query($db_connection, $update_query);

	printf("Relation Added!");

   }

}

?>

<body>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1>Add new director of a movie</h1> <br/>
		<form action="./addMDrelation.php" method="POST">			
			Movie : <select name="movie">
		<?php
			while($row = mysqli_fetch_assoc($movie_option)){
				$title = $row['title'];
				$mid = $row['id'];

				print "<option value='".$mid."'>$title</option>\n";
			} ?>
					<!-- <option value="G">G</option>
					<option value="NC-17">NC-17</option>
					<option value="PG">PG</option>
					<option value="PG-13">PG-13</option>
					<option value="R">R</option>
					<option value="surrendere">surrendere</option> -->
					</select>	
					<br/>
			Director : <select name="director">
		<?php
			while($row = mysqli_fetch_assoc($director_option)){
				$first = $row['first'];
				$last = $row['last'];
				$did = $row['id'];

				print "<option value='".$did."'>$first $last </option>\n";
			}
			?>
<!-- 					<option value="G">G</option>
					<option value="NC-17">NC-17</option>
					<option value="PG">PG</option>
					<option value="PG-13">PG-13</option>
					<option value="R">R</option>
					<option value="surrendere">surrendere</option> -->
					</select>
			<br/>
			
			<br/>
			<input type="submit" class="btn btn-default" value="Add it!!"/>
		</form>
	<hr/>
	<?php update_MD() ?>
</div>


<?php render_footer(); ?>



  