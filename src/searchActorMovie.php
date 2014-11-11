
<?php include('functions.php'); render_header(); ?>

<?php function search($value, $identity)
{
	$db_connection = connect_db();

	//sanitize input
	$value = mysqli_real_escape_string($db_connection, $value);

	//searching for person
	if($identity == "Person")
	{

		$names = preg_split('/ /', $value);

		if (sizeOf($names) == 1)
		{
			$actor_query = "SELECT * FROM Actor WHERE first LIKE '%{$names[0]}%' or last LIKE '%{$names[0]}%';";
		}
		else if (sizeOf($names) == 2)
		{
			$actor_query = "SELECT * FROM Actor WHERE first LIKE '%{$names[0]}%' and last LIKE '%{$names[1]}%';";
		}
		else if (sizeOf($names) == 3)
		{
			printf("ERROR: AT MOST TWO WORDS WHEN SEARCHING FOR PERSON");
			die();
		}  

		$result = mysqli_query($db_connection, $actor_query);

		while($row = mysqli_fetch_assoc($result)){
				$first = $row['first'];
				$last = $row['last'];
				$dob = $row['dob'];
				$id = $row['id'];

				print "<p>Actor: <a href='showActorInfo.php?id=".$id."'> ".$first." ".$last."(".$dob.") </a></p>\n";
			}

	}
	//searching for movie
	else if($identity == "Movie")
	{
		$movie_query = "SELECT * FROM Movie WHERE title LIKE '%{$value}%';";
		$result = mysqli_query($db_connection, $movie_query);

		while($row = mysqli_fetch_assoc($result)){
				$title = $row['title'];
				$year = $row['year'];
				$id = $row['id'];

				print "<p>movie: <a href='showMovieInfo.php?id=".$id."'> ".$title."(".$year.") </a></p>\n";
			}
	}



}
?>


<body>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1> Search For Actor/Movie </h1> <br/>

			<hr/>
		<form action="./searchActorMovie.php" method="POST">	
			<div class="input-group">
  				<span class="input-group-addon">Search for:</span>
  				<input type="text" class="form-control" placeholder="Search" name = "search" maxlength = "20">
			</div>
				</br>
			  	<input type="radio" name="identity" value="Person" checked="true"> Person
  				<input type="radio" name="identity" value="Movie"> Movie <br/> 
  			</br>
			<input type="submit" class="btn btn-default" value="Search!"/>
		</form>
	<?php 
	$value = $_POST['search'];
	$identity = $_POST['identity'];
	if(!empty($value))
		search($value, $identity);
	?>
</div>

<?php render_footer(); ?>



  