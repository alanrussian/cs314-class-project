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
        <h1 class="page-header">Album: Funeral</h1>
        <h2>Attributes</h2>
        <form role="form">
            <div class="form-group">
                <label for="editName">Name</label>
                <input type="text" class="form-control" id="editName" placeholder="Enter name" value="Funeral">
            </div>

            <div class="form-group">
                <label for="editArtist">Artist</label>
                <select class="form-control" id="editArtist">
                    <option>-----</option>
                    <option selected="selected">Arcade Fire</option>
                </select>
            </div>

            <div class="form-group">
                <label for="editType">Type</label>
                <select class="form-control" id="editType">
                    <option value="LP">LP</option>
                    <option value="EP">EP</option>
                    <option value="Single">Single</option>
                </select>
            </div>

            <div class="form-group">
                <label for="editGenre">Genre</label>
                <select class="form-control" id="editGenre">
                    <option selected="selected">Indie Rock</option>
                    <!-- Todo: Get from database -->
                </select>
            </div>

            <div class="form-group">
                <label for="editReleaseDate">Relase Date</label>
                <input type="text" class="form-control" id="editReleaseDate" placeholder="Enter release date" value="January 1, 2004">
            </div>

            <div class="form-group">
                <label for="editLabel">Label</label>
                <select class="form-control" id="editLabel">
                    <option selected="selected">Merge Records</option>
                    <!-- Todo: Get from database -->
                </select>
            </div>

            <input type="submit" class="btn btn-primary" value="Save Changes"> <input type="reset" class="btn btn-default" value="Reset Values">
        </form>
        
        <h2>Songs</h2>
        <table class="table table-striped results">
            <thead>
                <tr>
                    <th>Track Number</th>
                    <th>Title</th>
                    <th>Duration</th>
                    <th><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Neighborhood #1 (Tunnels)</td>
                    <td>4:48</td>
                    <td><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button> <a href="#" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
                </tr>
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