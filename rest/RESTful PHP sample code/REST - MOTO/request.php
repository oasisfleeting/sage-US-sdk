<?php

    // The gateway credentials that I use correspond to test account of mine. They will work, and you are
    // welcome to use them. However, I strongly suggest you replace it with your own test credentials so 
    // you have access to the Virtual Terminal.
    $M_ID = '111111111111';

    // First, we're going to gather all our data from the previous page and plug it into an XML template.
    // You can also send/receive JSON by setting the appropriate headers. (Content-Type & Accept)
    // This is a minimalistic example; please refer to the documentation/WSDLs for more details.
    $transaction = '<ECommTransactionRequest xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/wapiGateway.Models">
        <C_ADDRESS>' . $_POST['AddressLine1'] . ' ' . $_POST['AddressLine2'] . '</C_ADDRESS>
        <C_CARDNUMBER>' . $_POST['CC'] . '</C_CARDNUMBER>
        <C_CITY>' . $_POST['City'] . '</C_CITY>
        <C_COUNTRY>' . $_POST['Country'] . '</C_COUNTRY>
        <C_CVV>' . $_POST['CVV'] . '</C_CVV>
        <C_EMAIL>' . $_POST['Email'] . '</C_EMAIL>
        <C_EXP>' . $_POST['Exp'] . '</C_EXP>
        <C_NAME>' . $_POST['FirstName'] . ' ' . $_POST['LastName'] . '</C_NAME>
        <C_STATE>' . $_POST['State'] . '</C_STATE>
        <C_TELEPHONE>' . $_POST['Telephone'] . '</C_TELEPHONE>
        <C_ZIP>' . $_POST['Zip'] . '</C_ZIP>
        <T_AMT>' . $_POST['Amt'] . '</T_AMT>'
        // The ApplicationID here is 'DEMO'; when you're done with development we will certify your integration 
        // (it's quick & easy)and provide a production value.
        .'<T_APPLICATION_ID>DEMO</T_APPLICATION_ID>
        <T_CODE>1</T_CODE>
        <T_ORDERNUM>' . time() . '</T_ORDERNUM>
        <VaultTransactionRequest>
            <RequestType>CREATE</RequestType>
        </VaultTransactionRequest>
    </ECommTransactionRequest>';
    
    // This request will be authenticated via an HMAC.
    // Please see hmac.php to view the calculation.
    require("hmac.php");
    $HMAC = makeHmac($transaction);
    
    // Now we're going to make the request:
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://gateway.sagepayments.net/web_services/gateway/api/ecommercetransactions');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $transaction);
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
            echo 'Your transaction was ' . $result->Message . '<br />';
            echo 'Your order number is ' . $result->OrderNumber . '<br />';
            echo 'Your GUID is ' . $result->VaultTransactionResponse->Token . '<br />';
            echo '</pre>';
        ?>
    </body>
</html>