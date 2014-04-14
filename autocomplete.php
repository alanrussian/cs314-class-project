<?php

require 'include/functions.php';

$attribute = sanitize_get_value('attr');
$table = sanitize_get_value('table');
$query = sanitize_get_value('query');

// Make sure it is a valid table
$validTables = array('Artist', 'Album', 'Song', 'Label', 'Musician', 'ArtistMusician', 'AlbumSong');
if (! in_array($table, $validTables)) {
    die('Invalid table specified.');
}

$list = get_autocomplete($query, $attribute, $table);

header('Content-Type: application/json');
echo json_encode($list);
