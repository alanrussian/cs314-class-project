<?php

require_once('include/functions.php');

$args = array(
    'name' => sanitize_get_value('name')
);

$details = get_one($args, 'Label');

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
              <li class="active"><a href="labels.php">Labels</a></li>
              <li><a href="musicians.php">Musicians</a></li>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div>
        <h1 class="page-header">Label: Merge Records</h1>
        <h2>Attributes</h2>
        <form role="form">
            <div class="form-group">
                <label for="editName">Name</label>
                <input type="text" class="form-control" id="editName" placeholder="Enter name" value="<?= htmlentities($details['name']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <div class="form-group">
                <label for="editYear">Year Founded</label>
                <select class="form-control" id="editYear"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
                    <option value="">-----</option>
                    <?php print_year_options($details['founded_year']); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="editLocation">Location</label>
                <input type="text" class="form-control" id="editLocation" placeholder="Enter location" value="<?= htmlentities($details['location']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <div class="form-group">
                <label for="editWebsite">Website</label>
                <input type="text" class="form-control" id="editWebsite" placeholder="Enter website" value="<?= htmlentities($details['website']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <?php if (has_permissions()) { ?><input type="submit" class="btn btn-primary" value="Save Changes"> <input type="reset" class="btn btn-default" value="Reset Values"><?php } ?>
        </form>

        <h2>Albums</h2>
        <table class="table table-striped results">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Artist</th>
                    <th>Type</th>
                    <th>Genre</th>
                    <th>Release Date</th>
                    <?php if (has_permissions()) { ?><th class="controls"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></th><?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php
                    // Set up filter
                    $filter = array(
                        'label' => $details['name']
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
