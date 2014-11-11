<?php include("functions.php"); render_header(); ?>

<?php
	$db_connection = connect_db();
	$query = "SELECT DISTINCT * from Movie order by title;";
	$movie_options = mysqli_query($db_connection, $query);
	$id = $_GET['id'];
?>

<?php
function comment(){
	$db_connection = connect_db();



	$comment = $_POST["comment"];
	$title = $_POST["title"];
	$name = $_POST["name"];
	$rating = $_POST["rating"];

	//sanitize inputs
	$comment = mysqli_real_escape_string($db_connection, $comment);
	$title = mysqli_real_escape_string($db_connection, $title);
	$name = mysqli_real_escape_string($db_connection, $name);
	// $rating = mysqli_real_escape_string($db_connection, $rating);


	if(!empty($name) && !empty($comment) && !empty($rating) && !empty($title))
	{
		// find the id of the movie
		$new_query = "SELECT * from Movie where title='$title';";
		$result = mysqli_query($db_connection, $new_query);
		$row = mysqli_fetch_assoc($result);
		$id = $row['id'];

		$insert_query = "INSERT INTO Review(name, time, mid, rating, comment) VALUES('$name', CURRENT_TIMESTAMP(), '$id', '$rating', '$comment');";
		$result2 = mysqli_query($db_connection, $insert_query);

		
			
		printf("Comment Added");

	}
}

?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<form action="addComment.php" method="POST">
					</select><br/>
			Movie:
			<select name="title">
			<?php
				while($row = mysqli_fetch_assoc($movie_options)) {
					$title = $row['title'];
					$row_id = $row['id'];

					if($id == $row_id) {
						print "<option value='".$title."' selected='selected'>$title</option>";
					} else {
						print "<option value='".$title."' id='".$r_id."'>$title</option>";
					}
				}
			?>
			</select><br/>
			<br/> 


			<div class="input-group">
  				<span class="input-group-addon">Name</span>
  				<input type="text" class="form-control" placeholder="Name" name = "name" maxlength="100">
			</div>

			</br>

			<div class="input-group">
  				<span class="input-group-addon">Comment</span>
  				<textarea rows="5" type="text" class="form-control" placeholder="Put your comment here" name = "comment"></textarea>
			</div>
				</br>



			Rating:
			<select name="rating">
			<option value="5">5</option>
			<option value="4">4</option>
			<option value="3">3</option>
			<option value="2">2</option>
			<option value="1">1</option>
			</select><br/>
			<br/>

			<input type="submit" class="btn btn-default" value="Comment"/>
			</form>
			<hr/>
			<?php comment(); ?>
		</div>


<?php render_footer(); ?>
