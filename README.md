oauth2-twitter
==============

Minimal oauth2 application-only class for twitter api 1.1


This library provices simple access to the twitter oauth2 api with your ConsumerKey and ConsumerKeySecret.
The Access token returned from get_access_token can be cached, because twitter doesn't expire the access token until the consumer key is revoked

simple example provided here:

  <?php

    $consumer_key = '----';
    $consumer_key_secret = '------';

    $twit = new Twitter_API();
    $twit->get_access_token($consumer_key, $consumer_key_secret);

    $twit->get('1.1/statuses/user_timeline.json', array(
        'screen_name' => 'b4ckspace'
    ));
    
    
this library can be watched in combination with mediawiki-shoogletweet at http://hackerspace-bamberg.de
