<?php

    // The gateway credentials that I use correspond to test account of mine. They will work, and you are
    // welcome to use them. However, I strongly suggest you replace it with your own test credentials so 
    // you have access to the Virtual Terminal.
    $M_ID = '111111111111';

    // First, we're going to gather all our data from the previous page and plug it into an XML template.
    // You can also send/receive JSON by setting the appropriate headers. (Content-Type & Accept)
    // This is a minimalistic example; please refer to the documentation/WSDLs for more details.
    
    // The ApplicationID here is 'DEMO'; when you're done with development we will certify your integration
    // (it's quick & easy)and provide a production value.
    $vault = '<VaultCreditCardTokenRequest xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/wapiGateway.Models">
        <ApplicationId>DEMO</ApplicationId>
        <CardExpirationDate>' . $_POST['Exp'] . '</CardExpirationDate>
        <CardNumber>' . $_POST['CC'] . '</CardNumber>
    </VaultCreditCardTokenRequest>';
    
    // This request will be authenticated via an HMAC.
    // Please see hmac.php to view the calculation.
    require("hmac.php");
    $HMAC = makeHmac($vault);
    
    // Now we're going to make the request:
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://gateway.sagepayments.net/web_services/gateway/api/vaultcreditcardtokens');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vault);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/xml; charset=utf-8',
            'Accept: application/xml',
            'Authentication: '. $M_ID . ':' . $HMAC
        ));
    $response = curl_exec($ch);
    curl_close($ch);   

    // Casting the response to an XML object makes handling the data much easier:
    $result = new SimpleXMLElement($response);


    // [Some database calls and/or logging here, probably.]

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SPS REST API Sample</title>
    </head>
    
    <body>
        <h3>Payment Results:</h3>
        <!-- We're done! Give your user a result: -->
        <?php
            echo '<pre>';
            echo 'Thank you for shopping with us! <br />';
            echo 'Your request was ' . $result->Result . '<br />';
            echo 'Your GUID is ' . $result->Token . '<br />';
            echo '</pre>';
        ?>
    </body>
</html>