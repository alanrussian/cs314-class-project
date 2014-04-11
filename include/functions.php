<?php

require_once('credentials.php');

define('START_YEAR', 1900);
define('END_YEAR_OFFSET', 1); // e.g., 1 = current year + 1

// Permission stuff
session_start();
check_permissions_request();

function print_year_options($selectedYear = NULL) {
    $endYear = date('Y') + END_YEAR_OFFSET;

    for ($currentYear = $endYear; $currentYear >= START_YEAR; $currentYear --) {
        $selected = isset($selectedYear) && $selectedYear == $currentYear;

        printf('<option value="%d" %s>%d</option>',
            $currentYear, $selected ? ' selected="selected"' : '', $currentYear);
    }
}

function check_permissions_request() {
    if (isset($_GET['edit'])) {
        $_SESSION['editing'] = true;
    }

    if (isset($_GET['view'])) {
        unset($_SESSION['editing']);
    }
}

function has_permissions() {
    return isset($_SESSION['editing']);
}


function list_results($args, $table) {
  
  $con=mysqli_connect(HOST, USER, PASS, DB);
  
  $query = 'select * from ' . $table;

  $filters = array();

  foreach($args as $key => $value) {  
    $filters[] = "$key = '$value'";
  }

  if(sizeof($filters) > 0) {
    $query .= ' where ' . implode(' and ', $filters);
  }

  $results = mysqli_query($con, $query) or die('Query failed: ' . mysql_error());

  mysqli_close($con);

  return $results;  
}

function add_to_table($args, $table) {
    
}

?>
