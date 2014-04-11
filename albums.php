<?php

require_once('include/functions.php');

$args = array();


if(isset($_GET['name1']) && !empty($_GET['name1'])) {
  $args['name'] = $_GET['name1'];
}

if(isset($_GET['artist']) && !empty($_GET['artist'])) {
  $args['artist'] = $_GET['artist'];
}

if(isset($_GET['type']) && !empty($_GET['type'])) {
  $args['type'] = $_GET['type'];
}

if(isset($_GET['genre']) && !empty($_GET['genre'])) {
  $args['genre'] = $_GET['genre'];
}

if(isset($_GET['releaseDate']) && !empty($_GET['releaseDate'])) {
  $args['release_date'] = $_GET['releaseDate'];
}

if(isset($_GET['label']) && !empty($_GET['label'])) {
  $args['label'] = $_GET['label'];
}

$albums = list_results($args, 'Album');

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
                <input type="text" class="form-control" id="filterName" name="name1" placeholder="Enter name" value="<?= get_value('name') ?>">
            </div>

            <div class="form-group">
                <label for="filterArtist">Artist</label>
                <input type="text" class="form-control" id="filterArtist" name="artist" placeholder="Enter artist" value="<?= get_value('artist') ?>">
            </div>

            <div class="form-group">
                <label for="filterType">Type</label>
                <select class="form-control" id="filterType" name="type">
                    <option></option>
                    <option value="LP"<?= selected_if_get('type', 'LP') ?>>LP</option>
                    <option value="EP"<?= selected_if_get('type', 'EP') ?>>EP</option>
                    <option value="Single"<?= selected_if_get('type', 'Single') ?>>Single</option>
                </select>
            </div>

            <div class="form-group">
                <label for="filterGenre">Genre</label>
                <select class="form-control" id="filterGenre" name="genre">
                    <option></option>
                    <!-- Todo: Get from database -->
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

                while($album = mysqli_fetch_array($albums)) {

                ?>
                  <tr> 
                    <td><?php echo $album['name'] ?> </td>
                    <td><?php echo $album['artist'] ?> </td>
                    <td><?php echo $album['type'] ?> </td>
                    <td><?php echo $album['genre'] ?> </td>
                    <td><?php echo $album['release_date'] ?> </td>
                    <td><?php echo $album['label'] ?> </td>
                  </tr>

                <?php } ?>
                <!--<tr>
                    <td><a href="album_detail.php?name=In%20The%20Aeroplane%20over%20the%20Sea">In the Aeroplane over the Sea</a></td>
                    <td><a href="artist_detail.php?name=Neutral%20Milk%20Hotel">Neutral Milk Hotel</a></td>
                    <td>LP</td>
                    <td>Indie Rock</td>
                    <td>May 10, 1998</td>
                    <td><a href="labels.php?name=Merge%20Records">Merge Records</a></td>
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
