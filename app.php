<?php
/**
 * AA Thank Twitter APP
 * @since 1.0
 */


/**
 * Including Twitter API PHP Interface
 * @package  Twitter-API-PHP
 * @author   James Mallison <me@j7mbo.co.uk>
 * @license  MIT License
 * @link     http://github.com/j7mbo/twitter-api-php
 * @since    1.0
 */

if (file_exists(dirname(__FILE__).'/TwitterAPIExchange.php')) {
    require_once( dirname(__FILE__).'/TwitterAPIExchange.php' );
}


/**
 * Set access tokens here - see: https://dev.twitter.com/apps/
 * @var $aa_setthings array
 */
$settings = array(
					'oauth_access_token'        => "add_here",
					'oauth_access_token_secret' => "add_here",
					'consumer_key'              => "add_here",
					'consumer_secret'           => "add_here"
);

/**
 * URL and Method
 * @var string
 */
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";

//defaults
if (isset($_GET['user'])) {$user = $_GET['user'];} else {$user = "mrahmadawais";}
if (isset($_GET['count'])) {$user = $_GET['count'];} else {$count = 20;}

//Call for getfield
$getfield = "?screen_name=$user&count=$count";

//Initialize the API
$aa_tt_twitter = new TwitterAPIExchange($settings);

//Get associated array from json-decode and $assoc = TRUE
$aa_tt_string = json_decode(	$aa_tt_twitter  ->setGetfield($getfield)
												->buildOauth($url, $requestMethod)
												->performRequest(),$assoc = TRUE);

//address the errors if any, and exit
if( $aa_tt_string["errors"][0]["message"] != "" ) {
	echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
	exit();
}

/**
 * Building the structure
 */
foreach($aa_tt_string as $items)
    {
		echo "Time and Date of Tweet: ". $items['created_at']."<br />";
		echo "Tweet                 : ". $items['text']."<br />";
		echo "Tweeted by            : ". $items['user']['name']."<br />";
		echo "Screen name           : ". $items['user']['screen_name']."<br />";
		echo "Followers             : ". $items['user']['followers_count']."<br />";
		echo "Friends               : ". $items['user']['friends_count']."<br />";
		echo "Listed                : ". $items['user']['listed_count']."<br /><hr />";
    }
?>
