<?php

require 'include/functions.php';

$args = array(
    'album' => sanitize_post_value('album'),
    'artist' => sanitize_post_value('artist'),
    'song' => sanitize_post_value('song'),
    'track_number' => sanitize_post_value('track_number')
);

add($args, 'AlbumSong');

// Construct output of the two relations in this many-to-many relationship
$output = array();
$output['album'] = get_one(array('name' => $args['album'], 'artist' => $args['artist']), 'Album');
$output['song'] = get_one(array('title' => $args['song'], 'artist' => $args['artist']), 'Song');

header('Content-Type: application/json');
echo json_encode($output);
