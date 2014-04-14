<?php

require 'include/functions.php';

$args = array(
    'artist' => sanitize_post_value('artist'),
    'musician' => sanitize_post_value('musician')
);

add($args, 'ArtistMusician');

// Construct output of the two relations in this many-to-many relationship
$output = array();
$output['artist'] = get_one(array('artist' => $args['artist']), 'Artist');
$output['musician'] = get_one(array('id' => $args['musician']), 'Musician');

header('Content-Type: application/json');
echo json_encode($output);
