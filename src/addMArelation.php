
<?php include('functions.php'); render_header(); ?>

<?php
	$db_connection = connect_db();

	//get options for Movie and Actor

	$movie_option = mysqli_query($db_connection, "SELECT DISTINCT * from Movie order by title;");
	$actor_option = mysqli_query($db_connection, "SELECT DISTINCT * from Actor order by first;");


?>

<?php function update_MA(){
	$db_connection = connect_db();
	//update_MA with provided Role

	$role = $_POST['role'];
	$mid = $_POST['movie'];
	$aid = $_POST['actor'];

	//sanitize input
	$role = mysqli_real_escape_string($db_connection, $role);
	$mid = mysqli_real_escape_string($db_connection, $mid);
	$aid = mysqli_real_escape_string($db_connection, $aid);

  if(!empty($role) && !empty($mid) && !empty($aid))
  {

	//role must be letter

	if (!is_string($role))
	{
		printf("ERROR: ROLE MUST BE A WORD!");
		die();
	}

	$update_query = "INSERT INTO MovieActor(mid, aid, role) VALUES('$mid', '$aid', '$role');";
	mysqli_query($db_connection, $update_query);

	printf("Affected rows: ". mysqli_affected_rows($db_connection));

   }

}

?>

<body>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1>Add new actor in a movie</h1> <br/>
		<form action="./addMArelation.php" method="POST">			
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
			Actor : <select name="actor">
		<?php
			while($row = mysqli_fetch_assoc($actor_option)){
				$first = $row['first'];
				$last = $row['last'];
				$aid = $row['id'];

				print "<option value='".$aid."'>$first $last </option>\n";
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

			<div class="input-group">
  				<span class="input-group-addon">Role:</span>
  				<input type="text" class="form-control" placeholder="Role" name = "role">
			</div>
			
			<br/>
			<input type="submit" class="btn btn-default" value="Add it!!"/>
		</form>
	<hr/>
	<?php update_MA() ?>
</div>


<?php render_footer(); ?>



  