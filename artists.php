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
        <h1 class="page-header">Artists</h1>
        <h2>Filter</h2>
        <form role="form" method="get">
            <div class="form-group">
                <label for="filterName">Name</label>
                <input type="text" class="form-control" id="filterName" name="name" placeholder="Enter name" value="<?= get_value('name') ?>">
            </div>

            <div class="form-group">
                <label for="filterYearFounded">Year Founded</label>
                <select class="form-control" id="filterYearFounded" name="yearFounded">
                    <option value="">-----</option>
                    <?php print_year_options(sanitize_get_value('yearFounded')); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="filterLocation">Location Founded</label>
                <input type="text" class="form-control" id="filterLocation" name="locationFounded" placeholder="Enter location" value="<?= get_value('locationFounded') ?>">
            </div>

            <div class="form-group">
                <label for="filterYearDisbanded">Year Disbanded</label>
                <select class="form-control" id="filterYearDisbanded" name="yearDisbanded">
                    <option value="">-----</option>
                    <option value="NULL">Still Together</option>
                    <?php print_year_options(sanitize_get_value('yearDisbanded')); ?>
                </select>
            </div>


            <div class="form-group">
                <label for="filterWebsite">Website</label>
                <input type="text" class="form-control" id="filterWebsite" name="website" placeholder="Enter website" value="<?= get_value('website') ?>">
            </div>

            <input type="submit" class="btn btn-primary" value="Filter Results"> <input type="reset" class="btn btn-default" value="Clear Filters">
        </form>

        <h2>Results</h2>
        <table class="table table-striped results">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Year Founded</th>
                    <th>Location Founded</th>
                    <th>Year Disbanded</th>
                    <th>Website</th>
                    <?php if (has_permissions()) { ?><th class="controls"><a class="btn btn-success" href="artist_detail.php"><span class="glyphicon glyphicon-plus"></span></a></th> <?php } ?>
                </tr>
            </thead>

            <tbody>
                <?php
                    // Set up filter
                    $filter = array(
                        'name' => sanitize_get_value('name'),
                        'founded_year' => sanitize_get_value('yearFounded'),
                        'founded_location' => sanitize_get_value('locationFounded'),
                        'disbanded_year' => sanitize_get_value('yearDisbanded'),
                        'website' => sanitize_get_value('website')
                    );
                    
                    // Print Results
                    $results = list_results($filter, 'Artist');

                    foreach ($results as $result) {
                ?>
                    <tr>
                        <td data-pk="name"><a href="artist_detail.php?name=<?= urlencode($result['name']) ?>"><?= htmlentities($result['name']) ?></a></td>
                        <td><?= htmlentities($result['founded_year']) ?></td>
                        <td><?= htmlentities($result['founded_location']) ?></td>
                        <td><?= htmlentities($result['disbanded_year']) ?></td>
                        <td><a href="<?= htmlentities($result['website']) ?>"><?= htmlentities($result['website']) ?></a></td>
                        <?php if (has_permissions()) { ?><td class="controls"><button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button> <button class="btn btn-danger delete" data-table="Artist"><span class="glyphicon glyphicon-trash"></span></button></td> <?php } ?>
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
  </body>
</html>
