<?php

    // First, we're going to gather all our data from the previous page into a single array.
    // This is a minimalistic example; please refer to the documentation/WSDLs for more details.
    $transaction = array(

        // The MerchantID and MerchantKey here are a test account of mine. They will work, and you are welcome to use them. However,
        // I strongly suggest you replace it with your own test credentials so you have access to the Virtual Terminal.
        'M_ID' => '111111111111',
        'M_KEY' => 'X1X1X1X1X1X1',
        
        // The ApplicationID here is 'DEMO'; when you're done with development we will certify your integration (it's quick & easy)
        // and provide a production value.
        'T_APPLICATION_ID' => 'DEMO',
        
        // Customer information.
        'C_FIRST_NAME' => $_POST['FirstName'],
        'C_MIDDLE_NAME' => $_POST['MiddleName'],
        'C_LAST_NAME' => $_POST['LastName'],
        'C_SUFFIX' => $_POST['Suffix'],
        'C_ADDRESS' => $_POST['AddressLine1'] . ' ' . $_POST['AddressLine2'],
        'C_CITY' => $_POST['City'],
        'C_STATE' => $_POST['State'],
        'C_ZIP' => $_POST['Zip'],
        
        // Transaction information.
        'T_AMT' => '1',
        'C_RTE' => $_POST['RTE'],
        'C_ACCT' => $_POST['ACCT'],
        'C_ACCT_TYPE' => 'DDA',
        'C_ORIGINATOR_ID' => '000000000',
        'T_ORDERNUM' => time()

    );

    // PHP has a built-in class for SOAP requests. It will create a SoapClient object with
    // methods that correspond to the web service operations described in the WSDL.
    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsvtextensions/transaction_processing.asmx?WSDL');
    
    // This makes the request:
    $response = $SOAP->VIRTUAL_CHECK_PPD_SALE($transaction);
    // Dig in to the response object a little:
    $result = $response->VIRTUAL_CHECK_PPD_SALEResult->any;
    // Casting the response to an XML object makes handling the data much easier:
    $result = new SimpleXMLElement($result);

    // [Some database calls and/or logging here, probably.]

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SPS Web Services Sample</title>
    </head>
    
    <body>
        <h3>Payment Results:</h3>
        <!-- We're done! Give your user a result: -->
        <?php
            echo '<pre>';
            echo 'Thank you for shopping with us! <br />';
            echo 'Your transaction was ' . $result->NewDataSet->Table1->MESSAGE . '<br />';
            echo 'Your order number is ' . $result->NewDataSet->Table1->ORDER_NUMBER . '<br />';
            echo '</pre>';
        ?>
        <!--
            FOR SUPPORT: sdksupport@sage.com

        -->
    </body>
</html>