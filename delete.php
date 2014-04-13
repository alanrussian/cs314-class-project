<?php

require 'include/functions.php';

if (! has_permissions()) {
    header('HTTP/1.0 401 Unauthorized');
    die('You need to be editing to access this page.');
}

// Make sure they are deleting a valid table
$validTables = array('Artist', 'Album', 'Song', 'Label', 'Musician', 'ArtistMusician');
if (! in_array($_POST['table'], $validTables)) {
    die('Invalid table specified.');
}

delete($_POST['args'], $_POST['table']);

// Success message
echo '1';
