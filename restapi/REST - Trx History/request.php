<?php

    // The gateway credentials that I use correspond to test account of mine. They will work, and you are
    // welcome to use them. However, I strongly suggest you replace it with your own test credentials so 
    // you have access to the Virtual Terminal.
    $M_ID = '111111111111';

    // First, we're going to gather all our data from the previous page and plug it into an XML template.
    // You can also send/receive JSON by setting the appropriate headers. (Content-Type & Accept)
    // This is a minimalistic example; please refer to the documentation/WSDLs for more details.
    $transaction = '<TransactionSearchRequest 
    xmlns:i="http://www.w3.org/2001/XMLSchema-instance" 
    xmlns="http://schemas.datacontract.org/2004/07/SPS.Gateway.API.Common">
        <Criteria>
        <Amount>' . $_POST['Amt'] . '</Amount>
        <CustomerName>' . $_POST['CustName'] . '</CustomerName>
        <EndDate>' . $_POST['EndDt'] . '</EndDate>
        <IncludeDetails>' . $_POST['InclDetails'] . '</IncludeDetails>
        <OrderNumber>' . $_POST['OrdNum'] . '</OrderNumber>
        <Reference>' . $_POST['Ref'] . '</Reference>
        <StartDate>' . $_POST['StrtDt'] . '</StartDate>
        <StatusChanged>' . $_POST['StatChng'] . '</StatusChanged>
        </Criteria>
        <PageNumber>' . $_POST['PgNum'] . '</PageNumber>
        <PageSize>' . $_POST['PgSize'] . '</PageSize>        
    </TransactionSearchRequest>';
    
    // This request will be authenticated via an HMAC.
    // Please see hmac.php to view the calculation.
    require("hmac.php");
    $HMAC = makeHmac($transaction);
    
    // Now we're going to make the request:
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://gateway.sagepayments.net/web_services/gateway/api/transactions');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $transaction);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/xml; charset=utf-8',
            'Accept: application/json',
            'Authentication: '. $M_ID . ':' . $HMAC
        ));
    $response = curl_exec($ch);
    curl_close($ch);   

    // Casting the response to an XML object makes handling the data much easier:
    $jsonresult = json_decode($response);

    // [Some database calls and/or logging here, probably.]

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SPS REST API Sample</title>
    </head>
    
    <body>
        <h3>Search Results:</h3>
        <!-- We're done! Give your user a result: -->
        <?php
            echo '<pre>';
            echo 'Your search results: <br />';
            print_r($jsonresult->Items);
            echo '</pre>';
        ?>
    </body>
</html>