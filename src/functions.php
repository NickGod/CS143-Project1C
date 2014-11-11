<?php function render_header(){

  ?>
    <head>

     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>CS143 Project 1C</title>

    <!-- Bootstrap core CSS -->
    <link href="./bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="template.css" rel="stylesheet">
    
    </head>

    <body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">CS143 Project 1C</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Home page</a></li>

          </ul>

        </div>
      </div>
    </nav>

      <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="addActorDirector.php">Add Actor/Director</a></li>
            <li><a href="addMovieInfo.php">Add Movie Information</a></li>
            <li><a href="addMArelation.php">Add Movie / Actor Relation</a></li>
            <li><a href="addMDrelation.php">Add Movie / Director Relation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="showActorInfo.php">Show Actor Information</a></li>
            <li><a href="showMovieInfo.php">Show Movie Information</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="searchActorMovie.php">Search Actor/Movie</a></li>
          </ul>
        </div>
<?php }
?>

<?php function render_footer(){
  ?>
      <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  </body>
</html>

<?php
  }
?>

<?php function connect_db(){
  global $db_connection;

   $db_connection = mysqli_connect('localhost', 'cs143', '');
   mysqli_select_db($db_connection, 'CS143');

   if(!$db_connection)
   {
     printf("ERROR: FAIL TO CONNECT");
   }

   return $db_connection;

}