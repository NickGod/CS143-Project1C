
<?php include('functions.php'); render_header(); ?>

<?php
/* 
 * insert a moive
 * be aware that inserting a movie not only affects movie table.
 * it also changes MArelation and MDrelation
 */

function save_to_movie()
{
		$db_connection = connect_db();

		// $ratings = mysqli_query($db_connection, "SELECT DISTINCT rating from Movie ORDER BY rating");
		// 		while ($row = mysqli_fetch_assoc($ratings)) {
		// 			$rating = $row['rating'];
		// 			print "<p>" . $rating . "</p>";
		// 		}
		$title = $_POST["title"];
		$year = $_POST["year"];
		$rating = $_POST["rating"];
		$company = $_POST["company"];
		// $director = $_POST["director"];
		$genre = $_POST["genre"];

	if(!empty($title) && !empty($year) && !empty($company))
	{
		printf("Inputs are valid!");

		// Sanitize Input

		$title = mysqli_real_escape_string($db_connection, $title);
		$year = mysqli_real_escape_string($db_connection, $year);
		$rating = mysqli_real_escape_string($db_connection, $rating);
		$company = mysqli_real_escape_string($db_connection, $company);

		//check if inputs are valid
		//note that except year, other variables are sort of guaranteed to be valid after being sanitized.

		//$year must be numeric
		if (!is_numeric($year))
		{
			echo "ERROR: year must be numeric";
			die();
		}

		// get MaxMovieID
		$ID = mysqli_query($db_connection, "SELECT id from MaxMovieID");
		$row = mysqli_fetch_assoc($ID);
		$newID = $row['id'] + 1;

		$movie_insert = "INSERT INTO Movie(id, title, year, rating, company) VALUES (?, ?, ?, ? ,?)";


		//prepare argument
		$arguments = array(
			':id' => $newID,
			':title' => $title,
			':year' => $year,
			':rating' => $rating,
			':company' => $company,
			);
		foreach ($arguments as $v)
		{
			printf($v);
			print "\n";
		}
		$stmt = mysqli_prepare($db_connection, $movie_insert);
		mysqli_stmt_bind_param($stmt, "dssss", $arguments[':id'], $arguments[':title'], $arguments[':year'], $arguments[':rating'], $arguments[':company']);

		//argument prepared. Execute.
		mysqli_stmt_execute($stmt);

		printf("%d Row inserted.\n", mysqli_stmt_affected_rows($stmt));

		mysqli_query($db_connection, "UPDATE MaxMovieID SET id = $newID"); //Update Max Movie ID
		mysqli_query($db_connection, "INSERT INTO MovieGenre VALUES($newID, $genre"); // Update Movie Genre 

			printf("Movie Added!");


	}

}

?>

<!--
	 Notice that I have stated the valid options in rating and genre.
	 I didn't use queries to find out valid rating and genre options,
	 because in the database itself, there are invalid inputs, which 
	 could not been ruled out by CHECK in the current version of mysql
	 used 
-->

<body>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1> Add new movie </h1> <br/>

			<hr/>
		<form action="./addMovieInfo.php" method="POST">	
			<div class="input-group">
  				<span class="input-group-addon">Title:</span>
  				<input type="text" class="form-control" placeholder="Title" name = "title" maxlength = "20">
			</div>

			<hr/>

			<div class="input-group">
  				<span class="input-group-addon">Company:</span>
  				<input type="text" class="form-control" placeholder="Company" name = "company" maxlength = "50">
			</div>

			<hr/>

			<div class="input-group">
  				<span class="input-group-addon">Year:</span>
  				<input type="text" class="form-control" placeholder="Year" name = "year" maxlength="4">
			</div>

			<hr/>

			MPAA Rating : <select name="rating">
<!-- 			<?php $ratings = mysqli_query("SELECT DISTINCT rating from Movie ORDER BY rating");
				while ($row = mysql_fetch_assoc($ratings)) {
					$rating = $row['rating'];
					print "<option value = '".$rating."'> $rating </option>";
				}
			?> -->
					<option value="G">G</option>
			<option value="NC-17">NC-17</option>
			<option value="PG">PG</option>
			<option value="PG-13">PG-13</option>
			<option value="R">R</option>
			<option value="surrendere">surrendere</option>
					</select>
			<br/>
			Genre : 
				<select name="genre">
<!-- 				<?php $genres = mysqli_query("SELECT DISTINCT genre from MovieGenre ORDER BY genre");
				while ($row = mysql_fetch_assoc($genres)) {
					$genre = $row['genre'];
					print "<option value = ".$genre."> $genre </option>";
				}
			?> -->
			<option value="Action">Action</option>
			<option value="Adult">Adult</option>
			<option value="Adventure">Adventure</option>
			<option value="Animation">Animation</option>
			<option value="Comedy">Comedy</option>
			<option value="Crime">Crime</option>
			<option value="Crime">Crime</option>
			<option value="Documentary">Documentary</option>
			<option value="Drama">Drama</option>
			<option value="Family">Family</option>
			<option value="Fantasy">Fantasy</option>
			<option value="Horror">Horror</option>
			<option value="Musical">Musical</option>
			<option value="Mystery">Mystery</option>
			<option value="Romance">Romance</option>
			<option value="Sci-Fi">Sci-Fi</option>
			<option value="Short">Short</option>
			<option value="Thriller">Thriller</option>
			<option value="War">War</option>
			<option value="Western">Western</option>
					</select>
					
			<br/>
			
			<hr/>
			<input type="submit" class="btn btn-default" value="Add it!!"/>
		</form>
		<?php save_to_movie(); ?> 
</div>

<?php render_footer(); ?>



  