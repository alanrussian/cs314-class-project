<?php

require_once('credentials.php');

define('START_YEAR', 1900);
define('END_YEAR_OFFSET', 0); // e.g., 1 = current year + 1

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

function list_results($args, $table, $sort = '') {
  $con = mysqli_connect(HOST, USER, PASS, DB);
  
  $query = 'select * from ' . $table;

  $filters = array();

  foreach($args as $key => $value) {  
    if ($value !== NULL) {
      if ($value === 'NULL') {
          $filters[] = "$key is NULL";
      } else {
          $filters[] = "$key = '". mysqli_real_escape_string($con, $value) ."'";
      }
    }
  }

  if(sizeof($filters) > 0) {
    $query .= ' where ' . implode(' and ', $filters);
  }

  if (! empty($sort)) {
      $query .= ' ORDER BY '. $sort;
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
  
  $con = mysqli_connect(HOST, USER, PASS, DB);
  
  $query = 'select * from ' . $table;

  $filters = array();

  foreach($args as $key => $value) {  
      if ($value === 'NULL') {
          $filters[] = "$key is NULL";
      } else {
          $filters[] = "$key = '". mysqli_real_escape_string($con, $value) ."'";
      }
  }

  if(sizeof($filters) > 0) {
    $query .= ' where ' . implode(' and ', $filters) . ' limit 1';
  }

  $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_error($con));

  mysqli_close($con);

  return mysqli_fetch_array($result);  
}

function get_distinct($attr, $table) {
    $con = mysqli_connect(HOST, USER, PASS, DB);

    $query = 'select distinct ' . $attr . ' from ' . $table; 

    $results = mysqli_query($con, $query) or die('Query failed: ' . mysqli_error($con));
    
    mysqli_close($con);

    $retval = array();

    foreach($results as $result) {
        $retval[] = $result[$attr];
    }

    return $retval;
}

function get_autocomplete($query, $attr, $table) {
    $con = mysqli_connect(HOST, USER, PASS, DB);

    $attr = mysqli_real_escape_string($con, $attr);
    $query = 'select distinct ' . $attr . ' from ' . $table .' where '. $attr .' LIKE \''. mysqli_real_escape_string($con, $query) .'%\''; 

    $results = mysqli_query($con, $query) or die('Query failed: ' . mysqli_error($con));
    
    mysqli_close($con);

    $retval = array();

    foreach($results as $result) {
        $retval[] = $result[$attr];
    }

    return $retval;
}

function add($args, $table) {
    $con = mysqli_connect(HOST, USER, PASS, DB);

    $values = array();

    foreach(array_values($args) as $value) {
    	if($value == NULL || $value === 'NULL') {
            $values[] = 'NULL';
        } else {
            $values[] = "'". mysqli_real_escape_string($con, $value) ."'";
        }
    }

    $query = 'insert into ' . $table . ' (' . implode(', ', array_keys($args)) . ') values (' . implode(', ', $values) . ')';

    mysqli_query($con, $query) or die('Query failed: ' . mysqli_error($con));
    
    $id = mysqli_insert_id($con);

    mysqli_close($con);   

    return $id;
}

function update($args, $objects, $table) {
    $con = mysqli_connect(HOST, USER, PASS, DB);

    $new_values = [];

    foreach($objects as $key => $value) {
      if($value !== null && $value !== 'NULL') {
          $new_values[] = "$key = '". mysqli_real_escape_string($con, $value) ."'";
      } else {
          $new_values[] = "$key = NULL";
      }
    }

    $new_args = [];

    foreach($args as $key => $value) {
      if($value !== null) {
          if ($value === 'NULL') {
              $new_args[] = "$key is NULL";
          } else {
              $new_args[] = "$key = '". mysqli_real_escape_string($con, $value) ."'";
          }
      }
    }

    $query = 'update ' . $table . ' set ' . implode(', ', $new_values) . ' where ' . implode(' and ', $new_args);

    mysqli_query($con, $query) or die('Query failed: ' . mysqli_error($con));
    
    mysqli_close($con);   
}

function delete($args, $table) {
  $con = mysqli_connect(HOST, USER, PASS, DB);
  
  $query = 'delete from ' . $table;

  $filters = array();

  foreach($args as $key => $value) {  
    if ($value !== NULL) {
      if ($value === 'NULL') {
          $filters[] = "$key is NULL";
      } else {
          $filters[] = "$key = '". mysqli_real_escape_string($con, $value) ."'";
      }
    }
  }

  if(sizeof($filters) > 0) {
    $query .= ' where ' . implode(' and ', $filters);
  } else {
      die('No filters!?');
  }

  mysqli_query($con, $query) or die('Query failed: ' . mysqli_error($con));

  return true;
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
        return $value;
    }
}

function post_value($parameter) {
    $value = sanitize_post_value($parameter);

    if ($value === NULL) {
        return '';
    } else {
        return $value;
    }
}

// This tries get then post
function request_value($parameter) {
    $getValue = get_value($parameter);

    if ($getValue === '') {
        return post_value($parameter);
    }

    return $getValue;
}

function sanitize_get_value($parameter) {
    return _value('get', $parameter);
}

function sanitize_post_value($parameter) {
    return _value('post', $parameter);
}

function _value($method, $parameter) {
    $array = array();
    if ($method === 'get') {
        $array = $_GET;
    } else if ($method === 'post') {
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

function redirect($url) {
    header('Location: '. $url);
    exit;
}

function parse_date($text) {
    if ($text === NULL) {
        return NULL;
    }

    $date = strtotime($text);

    if ($date === false) {
        return NULL;
    }

    return date('Y-m-d', $date);
}

?>
