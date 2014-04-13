<?php

require 'include/functions.php';

// Make sure they are deleting a valid table
$validTables = array('Artist', 'Album', 'Song', 'Label', 'Musician', 'ArtistMusician');
if (! in_array($_POST['table'], $validTables)) {
    die('Invalid table specified.');
}

delete($_POST['args'], $_POST['table']);

// Success message
echo '1';
