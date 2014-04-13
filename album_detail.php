<?php

require_once('include/functions.php');

$args = array(
    'name' => sanitize_get_value('name'),
    'artist' => sanitize_get_value('artist')
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
            'artist' => sanitize_post_value('artist'),
            'type' => sanitize_post_value('type'),
            'genre' => sanitize_post_value('genre'),
            'release_date' => parse_date(sanitize_post_value('release_date')),
            'label' => sanitize_post_value('label')
        );

        // Add the object and go to the detail page
        add($object, 'Album');
        redirect('album_detail.php?name='. urlencode($object['name']) .'&artist='. urlencode($object['artist']));
    }

    // Not attempting to save. Display create page
    $new = true;

    // Create an array with attributes and given parameters (if any)
    $details = array(
        'name' => request_value('name'),
        'artist' => request_value('artist'),
        'type' => request_value('type'),
        'genre' => request_value('genre'),
        'release_date' => request_value('release_date'),
        'label' => request_value('label')
    );
} else {
    // See if attempting to update 
    if (isset($_POST['save'])) {
        $object = array(
            'name' => sanitize_post_value('name'),
            'artist' => sanitize_post_value('artist'),
            'type' => sanitize_post_value('type'),
            'genre' => sanitize_post_value('genre'),
            'release_date' => parse_date(sanitize_post_value('release_date')),
            'label' => sanitize_post_value('label')
        );

        // Add the object and go to the detail page
        update($args, $object, 'Album');
    }
    
    $details = get_one($args, 'Album');
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
        <h1 class="page-header"><?= $new ? 'New Album' : 'Album: '. htmlentities($details['name']) ?></h1>
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
                <label for="editArtist">Artist</label>
                <select class="form-control" id="editArtist" name="artist"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
                    <?php
                        $artists = get_distinct('name', 'Artist');

                        foreach($artists as $artist) {
                    ?> 
                        <option value="<?= htmlentities($artist) ?>"<?= $details['artist'] === $artist ? ' selected="selected"' : '' ?>><?= htmlentities($artist) ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="editType">Type</label>
                <select class="form-control" id="editType" name="type"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
                    <option value="LP" <?= $details['type'] === 'LP' ? ' selected="selected"' : '' ?>>LP</option>
                    <option value="EP" <?= $details['type'] === 'EP' ? ' selected="selected"' : '' ?>>EP</option>
                    <option value="Single" <?= $details['type'] === 'Single' ? ' selected="selected"' : '' ?>>Single</option>
                </select>
            </div>

            <div class="form-group">
                <label for="editGenre">Genre</label>
                <input type="text" class="form-control" id="editGenre" name="genre" value="<?= $details['genre'] ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <div class="form-group">
                <label for="editReleaseDate">Relase Date</label>
                <input type="text" class="form-control" id="editReleaseDate" name="release_date" placeholder="Enter release date" value="<?= htmlentities($details['release_date']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <div class="form-group">
                <label for="editLabel">Label</label>
                <select class="form-control" id="editLabel" name="label"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
                    <?php
                        $labels = get_distinct('name', 'Label');

                        foreach($labels as $label) {
                    ?> 
                        <option value="<?= htmlentities($label) ?>"<?= $details['label'] === $label ? ' selected="selected"' : '' ?>><?= htmlentities($label) ?></option>
                    <?php } ?>
                </select>
            </div>

            <?php if (has_permissions()) { ?><input type="submit" class="btn btn-primary" name="save" value="<?= $new ? 'Create Album' : 'Save Changes' ?>"> <input type="reset" class="btn btn-default" value="Reset Values"><?php } ?>
        </form>
        
        <?php
            if (! $new) {
        ?>
                <h2>Songs</h2>
                <table class="table table-striped results">
                    <thead>
                        <tr>
                            <th>Track Number</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <?php if (has_permissions()) { ?><th class="controls"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></th><?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            // Set up filter
                            $filter = array(
                                'album' => $details['name'],
                                'artist' => $details['artist']
                            );
                            
                            // Print Results
                            $results = list_results($filter, 'Song');

                            foreach ($results as $result) {
                        ?>
                            <tr>
                                <td data-pk="track_number"><?= $result['track_number'] ?></td>
                                <td><?= htmlentities($result['title']) ?></td>
                                <td><?= $result['duration_seconds'] ?></td>
                                <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button> <button class="btn btn-danger delete" data-table="Song" data-pk-artist="<?= htmlentities($result['artist']) ?>" data-pk-album="<?= htmlentities($result['album']) ?>"><span class="glyphicon glyphicon-trash"></span></button></td><?php } ?>
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
