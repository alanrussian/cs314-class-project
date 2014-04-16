<?php

require_once('include/functions.php');

$args = array(
    'title' => sanitize_get_value('title'),
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
            'title' => sanitize_post_value('title'),
            'artist' => sanitize_post_value('artist'),
            'duration_seconds' => sanitize_post_value('duration_seconds')
        );

        // Add the object and go to the detail page
        add($object, 'Song');
        redirect('song_detail.php?title='. urlencode($object['title']) .'&artist='. urlencode($object['artist']));
    }

    // Not attempting to save. Display create page
    $new = true;

    // Create an array with attributes and given parameters (if any)
    $details = array(
        'title' => request_value('title'),
        'artist' => request_value('artist'),
        'duration_seconds' => request_value('duration_seconds')
    );
} else {
    // See if attempting to update 
    if (isset($_POST['save'])) {
        $object = array(
            'title' => sanitize_post_value('title'),
            'artist' => sanitize_post_value('artist'),
            'duration_seconds' => sanitize_post_value('duration_seconds')
        );

        // Update the object and go to the detail page
        update($args, $object, 'Song');
        redirect('song_detail.php?title='. urlencode($object['title']) .'&artist='. urlencode($object['artist']));
    }
    
    $details = get_one($args, 'Song');
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
              <li><a href="albums.php">Albums</a></li>
              <li class="active"><a href="songs.php">Songs</a></li>
              <li><a href="labels.php">Labels</a></li>
              <li><a href="musicians.php">Musicians</a></li>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div>
        <h1 class="page-header"><?= $new ? 'New Song' : 'Song: '. htmlentities($details['title']) ?></h1>
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
                <label for="editTitle">Title</label>
                <input type="text" class="form-control" id="editTitle" name="title" placeholder="Enter title" value="<?= htmlentities($details['title']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
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
                <label for="editDurationSeconds">Duration (Seconds)</label>
                <input type="text" class="form-control" id="editDurationSeconds" name="duration_seconds" placeholder="Enter duration in seconds" value="<?= htmlentities($details['duration_seconds']) ?>"<?php if (! has_permissions()) { ?> readonly="readonly"<?php } ?>>
            </div>

            <?php if (has_permissions()) { ?><input type="submit" class="btn btn-primary" name="save" value="<?= $new ? 'Create Song' : 'Save Changes' ?>"> <input type="reset" class="btn btn-default" value="Reset Values"><?php } ?>
        </form>
        
        <?php
            if (! $new) {
        ?>
                <h2>Albums</h2>
                <table class="table table-striped results">
                    <thead>
                        <tr>
                            <th>Track Number</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Genre</th>
                            <th>Release Date</th>
                            <th>Label</th>
                            <?php if (has_permissions()) { ?><th class="controls"><button class="btn btn-success" data-toggle="modal" data-target="#addAlbumSong"><span class="glyphicon glyphicon-plus"></span></button></th><?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            // Set up filter
                            $filter = array(
                                'song' => $details['title'],
                                'artist' => $details['artist']
                            );
                            
                            // Loop through albums
                            $albumSongs = list_results($filter, 'AlbumSong');

                            foreach ($albumSongs as $albumSong) {
                                // Now get the album 
                                $album = get_one(array(
                                    'name' => $albumSong['album'],
                                    'artist' => $albumSong['artist']
                                ), 'Album');

                        ?>
                            <tr>
                                <td><?= htmlentities($albumSong['track_number']) ?></td>
                                <td data-pk="album"><a href="album_detail.php?name=<?= urlencode($album['name']) ?>&artist=<?= urlencode($album['artist']) ?>"><?= htmlentities($album['name']) ?></a></td>
                                <td><?= htmlentities($album['type']) ?></td>
                                <td><?= htmlentities($album['genre']) ?></td>
                                <td><?= htmlentities($album['release_date']) ?></td>
                                <td><a href="labels.php?name=<?= urlencode($album['label']) ?>"><?= htmlentities($album['label']) ?></a></td>
                                <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-danger delete" data-table="AlbumSong" data-pk-artist="<?= htmlentities($album['artist']) ?>" data-pk-song="<?= htmlentities($albumSong['song']) ?>"><span class="glyphicon glyphicon-trash"></span></button></td><?php } ?>
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

    <div class="modal fade" id="addAlbumSong">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Add Song</h4>
          </div>
          <div class="modal-body">
            <form role="form">
              <input type="hidden" name="song" value="<?= htmlentities($details['title']) ?>">
              <input type="hidden" name="artist" value="<?= htmlentities($details['artist']) ?>">
              <div class="form-group">
                <label for="track_number">Track Number</label>
                <input type="number" min="1" class="form-control" id="track_number" name="track_number">
              </div>

              <div class="form-group">
                <label for="album">Album</label>
                <select class="form-control" id="album" name="album">
                    <?php
                        $albums = list_results(array('artist' => $details['artist']), 'Album');
                        
                        foreach ($albums as $album) {
                            ?>
                                <option value="<?= htmlentities($album['name']) ?>"><?= htmlentities($album['name']) ?></option>
                            <?php
                        }
                    ?>
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary save">Add Song</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    
    <script src="js/main.js"></script>
  </body>
</html>
