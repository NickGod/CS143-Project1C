
<?php include('functions.php'); render_header(); ?>



<?php
//provided with the parameter in url,
//we expect to get all info about this actor
//plus in which movie he acts in
//and links to them

function Movie_info()
{
	$db_connection = connect_db();
//first get the provided value
 	$id = $_GET['id'];

	if(!empty($id))
	{
 		$query = "SELECT * FROM Movie WHERE id = '$id';";
 		$genre_query = "SELECT genre FROM MovieGenre WHERE mid = '$id';";
 		$director_query = "SELECT did FROM MovieDirector WHERE mid = '$id'";

 		$result = mysqli_query($db_connection, $query);
 		$genre_result = mysqli_query($db_connection, $genre_query);
 		$did_result = mysqli_query($db_connection, $director_query);

 		$row_genre = mysqli_fetch_assoc($genre_result);
 		$row_did = mysqli_fetch_assoc($did_result);

 		$genre = $row_genre['genre'];
 		$did = $row_did['did'];

 		$director = "SELECT * FROM Director WHERE id = '$did'";

 		$second_result = mysqli_query($db_connection, $director);
		$row2 = mysqli_fetch_assoc($second_result);

		while($row = mysqli_fetch_assoc($result)){
			$title = $row['title'];
			$company = $row['company'];
			$year = $row['year'];
			$rating = $row['rating'];

			$last = $row2['last'];
			$first = $row2['first'];

			print "Title: ".$title." </br> Company: ".$company." </br> Rating: ".$rating." </br> Genre: ".$genre." </br> Director : ".$first." ".$last." (If this is blank, it means that director is NOT FOUND) </br>";
		}

		print "<hr/>";

	}
}

function Actor_in_movie()
{
	$db_connection = connect_db();

	$id = $_GET['id'];

	if(!empty($id))
	{
		print "<h2>Actor in this movie: </h2>";
		//Get the corresponding actor id
		$query = "SELECT * FROM MovieActor WHERE mid = '$id';";

		$result = mysqli_query($db_connection, $query);

		while($row_actor = mysqli_fetch_assoc($result)){
			if(sizeOf($row_actor) == 0)
			{
				print "None! </br>";
			}
			$aid = $row_actor['aid'];
			$role = $row_actor['role'];

			//continue searching for actor's specific info

			$actor_query = "SELECT * FROM Actor WHERE id = '$aid';";

			$actor = mysqli_query($db_connection, $actor_query);
			$row_actor_info = mysqli_fetch_assoc($actor);
			$first = $row_actor_info['first'];
			$last = $row_actor_info['last'];

		
			print "<p> <a href = 'showActorInfo.php?id=".$aid."'> ".$first." ".$last." </a> act as ".$role." </p> \n";

		}
		print "<hr/>";

	}
}

function show_reviews()
{
	$db_connection = connect_db();

	$id = $_GET['id'];
	if(!empty($id))
	{
		//Get Average Rating
		$average_rating = mysqli_query($db_connection, "SELECT AVG(rating) AS rating from Review where mid = $id;");
		$average_result = mysqli_fetch_assoc($average_rating);
		$avg_rate = $average_result['rating'];
		print "<p> This movie has a average rating of $avg_rate </p>";
		print "<p> <a href = 'addComment.php?id=".$id."'> Add a review here! </a> </p>";

		//demonstrate the comments for this movive

		$comment_query = "SELECT * from Review WHERE mid = $id";

		$result = mysqli_query($db_connection, $comment_query);

		//print out comment
		while($row_comment = mysqli_fetch_assoc($result))
		{
			$name = $row_comment['name'];
			$time = $row_comment['time'];
			$mid = $row_comment['mid'];
			$rating = $row_comment['rating'];
			$comment = $row_comment['comment'];

			print "<p> ".$name." at ".$time." gives a rating of ".$rating.", with a comment: ".$comment." </p>";


		}
	}
}
 ?>

	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1>Movie Information </h1>
		<p> To find a specific information about a movie, please use search </p>

		<hr/>

	<?php Movie_info(); ?>
	<?php Actor_in_movie(); ?>
	<?php show_reviews(); ?>
	</div>
	<hr/>
<?php render_footer(); ?>



  