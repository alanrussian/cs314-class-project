<?php

require_once('include/functions.php');

$args = array();


if(isset($_GET['filterTitle']) && !empty($_GET['filterTitle'])) {
  $args['title'] = $_GET['filterTitle'];
}

if(isset($_GET['filterAlbum']) && !empty($_GET['filterAlbum'])) {
  $args['album'] = $_GET['filterAlbum'];
}

if(isset($_GET['filterArtist']) && !empty($_GET['filterArtist'])) {
  $args['artist'] = $_GET['filterArtist'];
}

if(isset($_GET['filterTrackNumber']) && !empty($_GET['filterTrackNumber'])) {
  $args['track_number'] = $_GET['filterTrackNumber'];
}

if(isset($_GET['filterDuration']) && !empty($_GET['filterDuration'])) {
  $args['duration_seconds'] = $_GET['filterDuration'];
}


$songs = list_results($args, 'Song');

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
              <li class="active"><a href="songs.php">Songs</a></li>
              <li><a href="labels.php">Labels</a></li>
              <li><a href="musicians.php">Musicians</a></li>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div>
        <h1 class="page-header">Songs</h1>
        <h2>Filter</h2>
        <form role="form">
            <div class="form-group">
                <label for="filterTitle">Title</label>
                <input type="text" class="form-control" name="filterTitle" placeholder="Enter title">
            </div>

            <div class="form-group">
                <label for="filterAlbum">Album</label>
                <input type="text" class="form-control" name="filterAlbum" placeholder="Enter album">
            </div>

            <div class="form-group">
                <label for="filterArtist">Artist</label>
                <input type="text" class="form-control" name="filterArtist" placeholder="Enter artist">
            </div>

            <div class="form-group">
                <label for="filterTrackNumber">Track Number</label>
                <input type="number" class="form-control" name="filterTrackNumber" placeholder="Enter track number" min="0">
            </div>

            <div class="form-group">
                <label for="filterDuration">Duration (Seconds)</label>
                <input type="text" class="form-control" name="filterDuration" placeholder="Enter duration in seconds">
            </div>

            <input type="submit" class="btn btn-primary" value="Filter Results"> <input type="reset" class="btn btn-default" value="Clear Filters">
        </form>

        <h2>Results</h2>
        <table class="table table-striped results">
            <thead>
                <tr>
                    <th>Track Number</th>
                    <th>Title</th>
                    <th>Album</th>
                    <th>Artist</th>
                    <th>Duration</th>
                    <?php if (has_permissions()) { ?><th class="controls"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></th><?php } ?>
                </tr>
            </thead>

            <tbody>
              <?php

                while($song = mysqli_fetch_array($songs)) {

              ?>
                <tr> 
                  <td><?php echo $song['track_number'] ?> </td>
                  <td><?php echo $song['title'] ?> </td>
                  <td><?php echo $song['album'] ?> </td>
                  <td><?php echo $song['artist'] ?> </td>
                  <td><?php echo $song['duration_seconds'] ?></td>
                </tr>

              <?php } ?>
                <!--<tr>
                    <td>1</td>
                    <td>Neighborhood #1 (Tunnels)</td>
                    <td><a href="album_detail.php?name=Funeral">Funeral</a></td>
                    <td><a href="artist_detail.php?name=Arcade%20Fire">Arcade Fire</a></td>
                    <td>4:48</td>
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
