<!-- Add Actor or Director to the database -->
<?php include('functions.php'); render_header(); ?>

<?php 
function save_to_db()
{
	//connect to database
	$db_connection = connect_db();

	//$db_connection is available right now

	//insert into SQL (To be modified)
	$actor_insert_sql = 'INSERT INTO Actor(id, first, last, dob, dod, sex) VALUES (?, ?, ?, ?, ?, ?)';
	$director_insert_sql = 'INSERT INTO Director(id, first, last, dob, dod) VALUES (?, ?, ?, ?, ?)';
	
	if (!empty($_POST['identity']) && !empty($_POST['first']) && !empty($_POST['last']) && !empty($_POST['sex']) && !empty($_POST['dob']))
	{
	//The posted values are:  "identity", "first", "last", "sex", "dob", "dod"
	print "<p> saving to db! <p>";
	print $_POST['identity'] . "\n";
	print $_POST['first'] . "\n";
	print $_POST['last'] . "\n";
	print $_POST['sex'] . "\n";

	$identity = $_POST['identity'];
	$first = $_POST['first'];
	$last = $_POST['last'];
	$sex = $_POST['sex'];
	$dob = $_POST['dob'];
	$dod = $_POST['dod'];

	//sanitize input
	$identity = mysqli_real_escape_string($db_connection, $identity);
	$first = mysqli_real_escape_string($db_connection, $first);
	$last = mysqli_real_escape_string($db_connection, $last);
	$sex = mysqli_real_escape_string($db_connection, $sex);
	$dob = mysqli_real_escape_string($db_connection, $dob);
	$dod = mysqli_real_escape_string($db_connection, $dod);


	//We must first validity of these values and then perform insertion
	//we know sex and identity are guaranteed to be valid
	//first name and last name must be letters
	if (!ctype_alpha(first) || !ctype_alpha(last))
	{
		echo "Error: Name must be letters\n";
		die();
	}

	//prepare ID
	$maxID = mysqli_query($db_connection, "SELECT id FROM MaxPersonID");
	$row = mysqli_fetch_assoc($maxID);
	$newID = $row['id'] + 1;

	//prepare arguments
	     $arguments = array(
          ':id'    => $newID,
          ':first' => $first,
          ':last'  => $last,
          ':dob'   => $dob,
          ':dod'   => $dod,
          ':sex'   => $sex,
     );

	 //insert arguments

	 if ($identity == "Actor")
	 {
	 	$stmt = mysqli_prepare($db_connection, $actor_insert_sql);
	 	mysqli_stmt_bind_param($stmt, "dsssss", $arguments[':id'], $arguments[':first'], $arguments[':last'], $arguments[':dob'], $arguments[':dod'], $arguments[':sex']);
	 }
	 else if ($identity == "Director")
	 {
	 	$stmt = mysqli_prepare($db_connection, $director_insert_sql);
	 	mysqli_stmt_bind_param($stmt, "dssss", $arguments[':id'], $arguments[':first'], $arguments[':last'], $arguments[':dob'], $arguments[':dod']);
	 }

	 //execute
	 mysqli_stmt_execute($stmt);

	 printf("Add succeeds!");

	 mysqli_query($db_connection, "UPDATE MaxPersonID SET id = $newID");
	}
}
?>


<!-- Interface dispalyed -->
<body> 
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1>Add new actor/director </h1>
	<form action="addActorDirector.php" method="POST">
				Identity:	<input type="radio" name="identity" value="Actor" checked="true">Actor
						<input type="radio" name="identity" value="Director">Director<br/>
			<hr/>
			<div class="input-group">
  				<span class="input-group-addon">First Name:</span>
  				<input type="text" class="form-control" placeholder="First Name" name = "first">
			</div>

			<hr/>

			<div class="input-group">
  				<span class="input-group-addon">Last Name:</span>
  				<input type="text" class="form-control" placeholder="Last Name" name = "last">
			</div>

			<hr/>

			Sex:		<input type="radio" name="sex" value="Male" checked="true">Male
						<input type="radio" name="sex" value="Female">Female<br/>
				
			<hr/>

			<div class="input-group">
  				<span class="input-group-addon">Date of Birth:</span>
  				<input type="text" class="form-control" placeholder="Date of Birth" name = "dob">
			</div>

			<hr/>

			<div class="input-group">
  				<span class="input-group-addon">Date of Death:</span>
  				<input type="text" class="form-control" placeholder="Date of Death" name = "dod">
			</div>

			<hr/>

			<input type="submit" class="btn btn-default" value="add it!!"/>
	</form>
		<?php save_to_db(); ?>
	</div>
	<hr/>

<?php render_footer(); ?>




