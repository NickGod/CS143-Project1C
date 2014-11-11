
<?php include('functions.php'); render_header(); ?>
<?php
//provided with the parameter in url,
//we expect to get all info about this actor
//plus in which movie he acts in
//and links to them

function Actor_info()
{
	$db_connection = connect_db();
//first get the provided value
 	$id = $_GET['id'];

	if(!empty($id))
	{
 		$query = "SELECT * FROM Actor WHERE id = '$id';";

 		$result = mysqli_query($db_connection, $query);

		while($row = mysqli_fetch_assoc($result)){
			$first = $row['first'];
			$last = $row['last'];
			$sex = $row['sex'];
			$dob = $row['dob'];
			$dod = $row['dod'];

			print "Name: ".$first." ".$last." </br> Sex: ".$sex." </br> Date of Birth: ".$dob." </br> Date of Death: ".$dod." </hr>";
		}

		print "<hr/>";

	}
}

function Act_in()
{
	$db_connection = connect_db();

	$id = $_GET['id'];

	if (!empty($id))
	{
		print "<h2> Movies that this Actor acted in </h2>";
		// Find the mid that the actor has played in
		$query = "SELECT * FROM MovieActor WHERE aid = '$id'";

		// Using mid, find the corresponding name.
		$result = mysqli_query($db_connection, $query);


		while($row = mysqli_fetch_assoc($result)){
				if(sizeOf($row) == 0)
				{
				print "<p> The Actor/Actress has not played in any Movie! </p>";
				}
				$mid = $row['mid'];
				$role = $row['role'];
				$second_result = mysqli_query($db_connection, "SELECT title From Movie WHERE id = '$mid'");
				$row2 = mysqli_fetch_assoc($second_result);
				$title = $row2['title'];

				print "<p>Act ".$role." in <a href='showMovieInfo.php?id=".$mid."'> ".$title." </a></p>\n";
			}

		print "<hr/>";

	}
}

 ?>

	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1>Actor Information </h1>
		<p> To find a specific information about an actor/actress, please use search </p>

		<hr/>

	<?php Actor_info() ?>
	<?php Act_in() ?>
	</div>
	<hr/>
<?php render_footer(); ?>



  