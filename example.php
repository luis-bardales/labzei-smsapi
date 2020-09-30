// Feel free to modify this file at your own convenience

require 'CloudsmsClient.php';

$apiKey       = 'Place your string Api Key here'; // the api key is provided by the company
$phoneNumber  = 'xxxxxxxxx'; // phone number to rich out
$message      = 'Hi, sending new sms ...'; // the sms message

$ws = new CloudsmsClient($apiKey);
$ws->send($phoneNumber. $message);

// that's it! piece of cake!
