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
    if ($value !== NULL) {
      $filters[] = "$key = '$value'";
    }
  }

  if(sizeof($filters) > 0) {
    $query .= ' where ' . implode(' and ', $filters);
  }

  $results = mysqli_query($con, $query) or die('Query failed: ' . mysqli_error($con));

  // Convert to array of results
  $resultsArray = array();
  while ($row = mysqli_fetch_array($results)) {
      $resultsArray[] = $row;
  }

  mysqli_close($con);

  return $resultsArray;  
}

function get_one($args, $table) {
    $results = list_results($args, $table);

    return $results[0];
}

function add_to_table($args, $table) {
    
}

function selected_if_get($parameter, $value) {
    return sanitize_get_value($parameter) == $value ? ' selected="selected"' : '';
}

function selected_if_post($parameter, $value) {
    return sanitize_post_value($parameter) == $value ? ' selected="selected"' : '';
}

function get_value($parameter) {
    $value = sanitize_get_value($parameter);

    if ($value === NULL) {
        return '';
    } else {
        return htmlentities($_GET[$parameter]);
    }
}

function post_value($parameter) {
    $value = sanitize_post_value($parameter);

    if ($value === NULL) {
        return '';
    } else {
        return htmlentities($_GET[$paramete]);
    }
}

function sanitize_get_value($parameter) {
    return _value('get', $parameter);
}

function sanitize_post_value($parameter) {
    return _value('post', $paremter);
}

function _value($method, $parameter) {
    $array = array();
    if ($method === 'get') {
        $array = $_GET;
    } else if ($method == 'post') {
        $array = $_POST;
    }

    if (isset($array[$parameter])) {
        $value = trim($array[$parameter]);

        if (empty($value)) {
            return NULL;
        } else {
            return $value;
        }
    } else {
        return NULL;
    }
}

?>
