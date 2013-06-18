<?php

$consumer_key = '----';
$consumer_key_secret = '------';

$twit = new Twitter_API();
$twit->get_access_token($consumer_key, $consumer_key_secret);

$twit->get('1.1/statuses/user_timeline.json', array(
    'screen_name' => 'b4ckspace'
));
