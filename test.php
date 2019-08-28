<?php

require_once "vendor/autoload.php";

$client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic('d5c1a793', 'YQq4er0GmEgLPhIa'));     

$message = $client->message()->send([
    'to' => '+8801912885974',
    'from' => "Hostel",
    'text' => 'Test message from the Nexmo PHP Client'
]);

?>