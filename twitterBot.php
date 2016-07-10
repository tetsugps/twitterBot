<?php
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

define(CONSUMER_KEY, '');
define(CONSUMER_SECRET, '');
$access_token = '';
$access_token_secret = '';

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");

$tweet = $connection->get("search/tweets", array("q" => "薬 -RT -to:@* -#* -filter:links", 'count' => 1));
$id = $tweet->statuses[0]->user->id;
$rep = $tweet->statuses[0]->text;
$name = $tweet->statuses[0]->user->name;
$pos = strpos($rep,"@");
if($pos == 0) $rep = mb_substr($rep, strpos($rep," "));
if(empty($rep)) $rep = "No tweets found";
$statues = $connection->post("statuses/update", ["status" => $rep]);

$params = array(
    'user_id' => $id,
    //'screen_name'=>"",
    'follow'=> 'true',
);
$addFriend = $connection->post("friendships/create", $params);
