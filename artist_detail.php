<?php

require_once('include/functions.php');

$args = array(
    'name' => sanitize_get_value('name')
);

// Determine whether new record
$new = false;
if (isset($_GET['new']) || isset($_POST['new'])) {
    // Ensure they have permissions
    if (! has_permissions()) {
        header('HTTP/1.0 401 Unauthorized');
        die('You need to be editing to access this page.');
    }

    // See if attempting to save
    if (isset($_POST['save'])) {
        $object = array(
            'name' => sanitize_post_value('name'),
            'founded_year' => sanitize_post_value('founded_year'),
            'founded_location' => sanitize_post_value('founded_location'),
            'disbanded_year' => sanitize_post_value('disbanded_year'),
            'website' => sanitize_post_value('website')
        );

        // Add the object and go to the detail page
        add($object, 'Artist');
        redirect('artist_detail.php?name='. urlencode($object['name']));
    }

    // Not attempting to save. Display create page
    $new = true;

    // Create an array with attributes and given parameters (if any)
    $details = array(
        'name' => request_value('name'),
        'founded_year' => request_value('founded_year'),
        'founded_location' => request_value('founded_location'),
        'disbanded_year' => request_value('disbanded_year'),
        'website' => request_value('website')
    );
} else {
    // See if attempting to update 
    if (isset($_POST['save'])) {
        $object = array(
            'name' => sanitize_post_value('name'),
            'founded_year' => sanitize_post_value('founded_year'),
            'founded_location' => sanitize_post_value('founded_location'),
            'disbanded_year' => sanitize_post_value('disbanded_year'),
            'website' => sanitize_post_value('website')
        );

        // Add the object and go to the detail page
        update($args, $object, 'Artist');
    }
    
    $details = get_one($args, 'Artist');
}

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
              <li class="active"><a href="artists.php">Artists</a></li>
              <li><a href="albums.php">Albums</a></li>
              <li><a href="songs.php">Songs</a></li>
              <li><a href="labels.php">Labels</a></li>
              <li><a href="musicians.php">Musicians</a></li>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div>
        <h1 class="page-header"><?= $new ? 'New Artist' : 'Artist: '. htmlentities($details['name']) ?></h1>
        <h2>Attributes</h2>
        <form role="form" method="post">
            <?php
                if ($new) {
            ?>
                    <input type="hidden" name="new" value="new">
            <?php
                }
            ?>

            <div class="form-group">
                <label for="editName">Name</label>
                <input type="text" class="form-control" id="editName" name="name" placeholder="Enter name" value="<?= htmlentities($details['name']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <div class="form-group">
                <label for="editYearFounded">Year Founded</label>
                <select class="form-control" id="editYearFounded" name="founded_year"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
                    <option value="">-----</option>
                    <?php print_year_options($details['founded_year']); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="editLocation">Location Founded</label>
                <input type="text" class="form-control" id="editLocation" name="founded_location" placeholder="Enter location" value="<?= htmlentities($details['founded_location']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <div class="form-group">
                <label for="editYearDisbanded">Year Disbanded</label>
                <select class="form-control" id="editYearDisbanded" name="disbanded_year"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
                <option value="NULL"<? $details['disbanded_year'] === NULL ? ' selected="selected"' : '' ?>>Still Together</option>
                    <?php print_year_options($details['disbanded_year']); ?>
                </select>
            </div>


            <div class="form-group">
                <label for="editWebsite">Website</label>
                <input type="text" class="form-control" id="editWebsite" name="website" placeholder="Enter website" value="<?= htmlentities($details['website']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <?php if (has_permissions()) { ?><input type="submit" class="btn btn-primary" name="save" value="<?= $new ? 'Create Artist' : 'Save Changes' ?>"> <input type="reset" class="btn btn-default" value="Reset Values"><?php } ?>
        </form>
        
        <?php
            if (! $new) {
        ?>
                <h2>Albums</h2>
                <table class="table table-striped results">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Genre</th>
                            <th>Release Date</th>
                            <th>Label</th>
                            <?php if (has_permissions()) { ?><th class="controls"><a href="album_detail.php?new&artist=<?= urlencode($details['name']) ?>" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a></th><?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            // Set up filter
                            $filter = array(
                                'artist' => $details['name']
                            );
                            
                            // Print Results
                            $results = list_results($filter, 'Album');

                            foreach ($results as $result) {
                        ?>
                            <tr>
                                <td data-pk="name"><a href="album_detail.php?name=<?= urlencode($result['name']) ?>&artist=<?= urlencode($result['artist']) ?>"><?= htmlentities($result['name']) ?></a></td>
                                <td><?= htmlentities($result['type']) ?></td>
                                <td><?= htmlentities($result['genre']) ?></td>
                                <td><?= htmlentities($result['release_date']) ?></td>
                                <td><a href="labels.php?name=<?= urlencode($result['label']) ?>"><?= htmlentities($result['label']) ?></a></td>
                                <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button> <button class="btn btn-danger delete" data-table="Album"><span class="glyphicon glyphicon-trash"></span></button></td><?php } ?>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>

                <h2>Musicians</h2>
                <table class="table table-striped results">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Birth Date</th>
                            <?php if (has_permissions()) { ?><th class="controls"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></th><?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            // Set up filter
                            $filter = array(
                                'artist' => $details['name']
                            );
                            
                            // Print Results
                            $results = list_results($filter, 'ArtistMusician');

                            // Get artist names
                            foreach ($results as $artistMusician) {
                                // Get artist
                                $result = get_one(array(
                                    'name' => $artistMusician['musician_name'],
                                    'birth_date' => $artistMusician['musician_birth_date']), 'Musician');
                        ?>
                            <tr>
                            <td data-pk="musician_name"><a href="musician_detail.php?name=<?= urlencode($result['name']) ?>&birth_date=<?= urlencode($result['birth_date']) ?>"><?= htmlentities($result['name']) ?></a></td>
                            <td data-pk="musician_birth_date"><?= urlencode($result['birth_date']) ?></td>
                                <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button> <button class="btn btn-danger delete" data-table="ArtistMusician" data-pk-artist="<?= htmlentities($details['name']) ?>"><span class="glyphicon glyphicon-trash"></span></button></td><?php } ?>
                            </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
        <?php
            }
        ?>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    
    <script src="js/main.js"></script>
  </body>
</html>
