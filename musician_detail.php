<?php

require_once('include/functions.php');

$args = array(
    'name' => sanitize_get_value('name'),
    'birth_date' => sanitize_get_value('birth_date')
);

$details = get_one($args, 'Musician');

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
        <h1 class="page-header">Musician: Panda Bear</h1>
        <h2>Attributes</h2>
        <form role="form">
            <div class="form-group">
                <label for="editName">Name</label>
                <input type="text" class="form-control" id="editName" placeholder="Enter name" value="<?= htmlentities($details['name']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <div class="form-group">
                <label for="editBirthDate">Birth Date</label>
                <input type="text" class="form-control" id="editBirthDate" placeholder="Enter birth date" value="<?= htmlentities($details['birth_date']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <?php if (has_permissions()) { ?><input type="submit" class="btn btn-primary" value="Save Changes"> <input type="reset" class="btn btn-default" value="Reset Values"><?php } ?>
        </form>

        <h2>Artists</h2>
        <table class="table table-striped results">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Year Founded</th>
                    <th>Location Founded</th>
                    <th>Year Disbanded</th>
                    <th>Website</th>
                    <?php if (has_permissions()) { ?><th class="controls"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></th><?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php
                    // Set up filter
                    $filter = array(
                        'musician_name' => $details['name'],
                        'musician_birth_date' => $details['birth_date']
                    );
                    
                    // Print Results
                    $results = list_results($filter, 'ArtistMusician');

                    // Get artist names
                    foreach ($results as $artistMusician) {
                        // Get artist
                        $result = get_one(array('name' => $artistMusician['artist']), 'Artist');
                ?>
                    <tr>
                        <td><a href="artist_detail.php?name=<?= urlencode($result['name']) ?>"><?= htmlentities($result['name']) ?></a></td>
                        <td><?= htmlentities($result['founded_year']) ?></td>
                        <td><?= htmlentities($result['founded_location']) ?></td>
                        <td><?= htmlentities($result['disbanded_year']) ?></td>
                        <td><a href="<?= htmlentities($result['website']) ?>"><?= htmlentities($result['website']) ?></a></td>
                        <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button> <a href="#" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td> <?php } ?>
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
