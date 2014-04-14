<?php

require_once('include/functions.php');

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
                <input type="text" class="form-control" id="filterTitle" name="title" placeholder="Enter title" value="<?= get_value('title') ?>">
            </div>

            <div class="form-group">
                <label for="filterArtist">Artist</label>
                <input type="text" class="form-control" id="filterArtist" name="artist" placeholder="Enter artist" value="<?= get_value('artist') ?>">
            </div>

            <div class="form-group">
                <label for="filterDuration">Duration (Seconds)</label>
                <input type="text" class="form-control" id="filterDuration" name="durationSeconds" placeholder="Enter duration in seconds" value="<?= get_value('durationSeconds') ?>">
            </div>

            <input type="submit" class="btn btn-primary" value="Filter Results"> <input type="reset" class="btn btn-default" value="Clear Filters">
        </form>

        <h2>Results</h2>
        <table class="table table-striped results">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Duration</th>
                    <?php if (has_permissions()) { ?><th class="controls"><a href="song_detail.php?new" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a></th><?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php
                    // Set up filter
                    $filter = array(
                        'artist' => sanitize_get_value('artist'),
                        'title' => sanitize_get_value('title'),
                        'duration_seconds' => sanitize_get_value('durationSeconds')
                    );
                    
                    // Print Results
                    $results = list_results($filter, 'Song');

                    foreach ($results as $result) {
                ?>
                    <tr>
                        <td data-pk="title"><a href="song_detail.php?title=<?= urlencode($result['title']) ?>&artist=<?= urlencode($result['artist']) ?>"><?= htmlentities($result['title']) ?></td>
                        <td data-pk="artist"><a href="artist_detail.php?name=<?= urlencode($result['artist']) ?>"><?= htmlentities($result['artist']) ?></a></td>
                        <td><?= $result['duration_seconds'] ?></td>
                        <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-danger delete" data-table="Song"><span class="glyphicon glyphicon-trash"></span></button></td><?php } ?>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    
    <script src="js/main.js"></script>
    <script src="js/typeahead.bundle.js"></script>
    <script src="js/bootstrap3-typeahead.js"></script>
    <script>
        add_typeahead('#filterTitle', 'title', 'Song');
        add_typeahead('#filterArtist', 'name', 'Artist');
    </script>
  </body>
</html>
