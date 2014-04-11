<?php

require_once('include/functions.php');

$args = array();


if(isset($_GET['filterArtist']) && !empty($_GET['filterArtist'])) {
  $args['artist'] = $_GET['filterArtist'];
}

if(isset($_GET['filterName']) && !empty($_GET['filterName'])) {
  $args['musician_name'] = $_GET['filterName'];
}

if(isset($_GET['filterBirthDate']) && !empty($_GET['filterBirthDate'])) {
  $args['musician_birth_date'] = $_GET['filterBirthDate'];
}

$musicians = list_results($args, 'ArtistMusician');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Music Database</title>

    <!-- Bootstrap core CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/site.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">Music Database</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="artists.php">Artists</a></li>
              <li><a href="albums.php">Albums</a></li>
              <li><a href="songs.php">Songs</a></li>
              <li><a href="labels.php">Labels</a></li>
              <li class="active"><a href="musicians.php">Musicians</a></li>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div>
        <h1 class="page-header">Musicians</h1>
        <h2>Filter</h2>
        <form role="form">
            <div class="form-group">
                <label for="filterName">Artist</label>
                <input type="text" class="form-control" name="filterArtist" placeholder="Enter name">
            </div>

            <div class="form-group">
                <label for="filterName">Name</label>
                <input type="text" class="form-control" name="filterName" placeholder="Enter name">
            </div>

            <div class="form-group">
                <label for="filterBirthDate">Birth Date</label>
                <input type="text" class="form-control" name="filterBirthDate" placeholder="Enter birth date">
            </div>

            <input type="submit" class="btn btn-primary" value="Filter Results"> <input type="reset" class="btn btn-default" value="Clear Filters">
        </form>

        <h2>Results</h2>
        <table class="table table-striped results">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Birth Date</th>
                    <th>Artist</th>
                    <?php if (has_permissions()) { ?><th class="controls"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></th><?php } ?>
                </tr>
            </thead>

            <tbody>
              <?php

                while($musician = mysqli_fetch_array($musicians)) {

              ?>
                <tr> 
                  <td><?php echo $musician['musician_name'] ?> </td>
                  <td><?php echo $musician['musician_birth_date'] ?> </td>
                  <td><?php echo $musician['artist'] ?> </td>
                </tr>

              <?php } ?>
                <!--<tr>
                    <td><a href="musician_detail.php?name=Panda%20Bear&birthdate=19780617">Panda Bear</a></td>
                    <td>July 17, 1978</td>
                    <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button> <a href="#" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td><?php } ?>
                </tr>-->
        </table>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  </body>
</html>
