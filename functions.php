<?php
session_start();

include 'fullcourt.php';

function user_generate_token($username, $phoneNum){
    global $accountsid, $authtoken, $fromNumber;

    // Create a new password
    $password = substr(md5(time().rand(0, 10^10)), 0, 5);
    // Store the username and password.
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    /* Set our AccountSid and AuthToken */
    $accountsid= "FC20f8676ba75a63ba452784ca5858d217";
    $authtoken= "ocYw1LU8A9w64uztN5dKPzwrNH9ynmuXtx";
    $fromNumber="FullCourt";

    $client = new RestAPI($accountsid, $authtoken);
    // Prepare the message with the password embedded
    $content = "Your newly generated password is ".$password;
    $params = array(
          'To' => $phoneNum,
          'From' => $fromNumber,
          'Body' => $content
    );
    // Send the message via SMS or Voice
    $item = $client->send_message($params);
    $message = "A new password has been generated and sent to your phone number.";

    return $message;
}

function user_login($username, $submitted) {

    // Retrieve the stored password
    $stored = $_SESSION['password'];
    // Compare the retrieved vs the stored password
    if ($stored == $submitted) {
        $message = "Hello and welcome back $username";
    } else {
        $message = "Sorry, that's an invalid username and password combination.";
    }
    // Clean up after ourselves
    unset($_SESSION['username']);
    unset($_SESSION['password']);

    return $message;
}
