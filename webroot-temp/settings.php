<?php //@skip-indexing ?>
<?php

define('USE_SSL', false);
define('SITE_PATH', dirname(__FILE__));

//--------------------------------------------------- Debug Settings ---------------------------------------------------
define('DEBUG', false);
$debug_mode = DEBUG;
if(array_key_exists('debug', $_REQUEST) && $_REQUEST['debug'] == 'on'){
    $debug_mode = true;
}
if($debug_mode){
    error_reporting(~0);
    ini_set('display_errors', 1);
}

//--------------------------------------------------- Search Settings --------------------------------------------------
define('LOCALE', 'en_US');
define('HTTP_CALL_METHOD', 'curl'); //curl or default
$indexable_folders = array(SITE_PATH);

//------------------------------------------------- ReCaptcha Settings -------------------------------------------------
define('ENABLE_CAPTCHA', false);
//to generate the public and the private keys go here: https://www.google.com/recaptcha/admin/list
$captcha_public_key = "your_public_key";
$captcha_private_key = "your_private_key";

//------------------------------------------------- MailChimp Settings -------------------------------------------------
$mailchimp_api_key = "your_mailchimp_api_key";
$mailchimp_list_id = "your_mailchimp_list_id";

//------------------------------------------------- Twitter Settings -------------------------------------------------
$twitter_config = array(
    'api_url' => 'https://api.twitter.com/1.1/',
    'username' => 'YOUR TWITTER USERNAME', //this name must be also added in the custom.js file
    'consumer_key' => '',
    'consumer_secret' => '',
    'access_token' => '',
    'access_token_secret' => ''
);
$twitter_white_list_active = true;
$twitter_white_list = array(
    'statuses/user_timeline.json?screen_name='.$twitter_config['username'],
    'favorites.json?screen_name='.$twitter_config['username'],
    $twitter_config['username'].'/lists/'
);

//-------------------------------------------------- Database Settings -------------------------------------------------
$db_type = "sqlite"; //mysql or sqlite

//MySQL settings
$db_host = '';
$db_name = '';
$db_user = '';
$db_pass = '';

//------------------------------------------------ Admin Settings ------------------------------------------------------
$my_email = 'abc@xyz.com'; // insert your email address here
$private_key = '';
$server_path = '';

//------------------------------------------------ Custom Settings -----------------------------------------------------