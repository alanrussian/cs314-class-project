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
              <li class="active"><a href="albums.php">Albums</a></li>
              <li><a href="songs.php">Songs</a></li>
              <li><a href="labels.php">Labels</a></li>
              <li><a href="musicians.php">Musicians</a></li>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div>
        <h1 class="page-header">Albums</h1>
        <h2>Filter</h2>
        <form role="form" method="get">
            <div class="form-group">
                <label for="filterName">Name</label>
                <input type="text" class="form-control" id="filterName" name="name" placeholder="Enter name" value="<?= get_value('name') ?>">
            </div>

            <div class="form-group">
                <label for="filterArtist">Artist</label>
                <input type="text" class="form-control" id="filterArtist" name="artist" placeholder="Enter artist" value="<?= get_value('artist') ?>">
            </div>

            <div class="form-group">
                <label for="filterType">Type</label>
                <select class="form-control" id="filterType" name="type">
                    <option value="">-----</option>
                    <option value="LP"<?= selected_if_get('type', 'LP') ?>>LP</option>
                    <option value="EP"<?= selected_if_get('type', 'EP') ?>>EP</option>
                    <option value="Single"<?= selected_if_get('type', 'Single') ?>>Single</option>
                </select>
            </div>

            <div class="form-group">
                <label for="filterGenre">Genre</label>
                <select class="form-control" id="filterGenre" name="genre">
                    <option value="">-----</option>
                    <!-- Todo: Get from database -->

                    <?php
                        $genres = get_distinct('genre', 'Album');

                        foreach($genres as $genre) {
                    ?> 
                        <option value="<?= $genre ?>"<?= selected_if_get('genre', $genre) ?>><?= $genre ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="filterReleaseDate">Relase Date</label>
                <input type="text" class="form-control" id="filterReleaseDate" name="releaseDate" placeholder="Enter release date" value="<?= get_value('releaseDate') ?>">
            </div>

            <div class="form-group">
                <label for="filterLabel">Label</label>
                <input type="text" class="form-control" id="filterLabel" name="label" placeholder="Enter label" value="<?= get_value('label') ?>">
            </div>

            <input type="submit" class="btn btn-primary" value="Filter Results"> <input type="reset" class="btn btn-default" value="Clear Filters">
        </form>

        <h2>Results</h2>
        <table class="table table-striped results">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Artist</th>
                    <th>Type</th>
                    <th>Genre</th>
                    <th>Release Date</th>
                    <th>Label</th>
                    <?php if (has_permissions()) { ?><th class="controls"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></th><?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php
                    // Set up filter
                    $filter = array(
                        'name' => sanitize_get_value('name'),
                        'artist' => sanitize_get_value('artist'),
                        'type' => sanitize_get_value('type'),
                        'genre' => sanitize_get_value('genre'),
                        'release_date' => sanitize_get_value('releaseDate'),
                        'label' => sanitize_get_value('label')
                    );
                    
                    // Print Results
                    $results = list_results($filter, 'Album');

                    foreach ($results as $result) {
                ?>
                    <tr>
                        <td><a href="album_detail.php?name=<?= urlencode($result['name']) ?>"><?= htmlentities($result['name']) ?></a></td>
                        <td><a href="artist_detail.php?name=<?= urlencode($result['artist']) ?>"><?= htmlentities($result['artist']) ?></a></td>
                        <td><?= htmlentities($result['type']) ?></td>
                        <td><?= htmlentities($result['genre']) ?></td>
                        <td><?= htmlentities($result['release_date']) ?></td>
                        <td><a href="labels.php?name=<?= urlencode($result['label']) ?>"><?= htmlentities($result['label']) ?></a></td>
                        <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button> <a href="#" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td><?php } ?>
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
  </body>
</html>
