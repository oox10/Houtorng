<?php //@skip-indexing ?>
<?php

include_once(dirname(__FILE__) . '/settings.php');
require_once(dirname(__FILE__) . '/mailchimp/MCAPI.class.php');

try {
    if (array_key_exists('email', $_POST)) {
        if (empty($mailchimp_api_key)) {
            throw new Exception('The MailChimp API key is not specified.');
        }
        if (empty($mailchimp_list_id)) {
            throw new Exception('The MailChimp List ID is not specified.');
        }
        $email = $_POST['email'];
        $mailchimp_api = new MailChimp($mailchimp_api_key);
        $result = $mailchimp_api->call('lists/subscribe', array(
            'id' => $mailchimp_list_id,
            'email' => array('email' => $email),
            'merge_vars' => array(),
            'double_optin' => false,
            'update_existing' => false,
            'replace_interests' => false,
            'send_welcome' => true,
        ));
        $unknown_error = new Exception('An unknown error occurred processing your request. Please try again later.');
        if ($result && is_array($result)) {
            if (array_key_exists('status', $result) && strtolower($result['status']) == 'error') {
                if (array_key_exists('error', $result)) {
                    throw new Exception($result['error']);
                } else {
                    throw $unknown_error;
                }
            }
        } else {
            throw $unknown_error;
        }
    } else {
        throw new Exception('The email address is not specified.');
    }
    header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
} catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
    echo $e->getMessage();
}
die();