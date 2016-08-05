<?php
    
    $transaction = array(
            
            'M_ID' => '111111111111',
            'M_KEY' => 'X1X1X1X1X1X1',
            'T_AMT' => $_POST['Amt'],
            'T_ENCRYPTED_TYPE' => $_POST['EncType'],
            'T_TRACKDATA' => $_POST['Trackdata'],
            'T_APPLICATION_ID' => 'DEMO',
            'T_DEVICE_ID' => $_POST['DvcID'],

            );

    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsvtextensions/transaction_processing.asmx?WSDL');
    $response = $SOAP->BANKCARD_RETAIL_ENCRYPTED_SWIPED_SALE($transaction);
    $result = $response->BANKCARD_RETAIL_ENCRYPTED_SWIPED_SALEResult->any;
    $result = new SimpleXMLElement($result);

?>


<!DOCTYPE html>
<html>
    <head>
        <title>SPS Web Services Sample</title>
    </head>
    
    <body>
        <h3>Payment Results:</h3>
        <?php
            $resultvalue = $result->NewDataSet->Table1->MESSAGE;
            $arr = explode(' ',trim($resultvalue));
            echo $arr[0]; // will print Approved

        ?>

    </body>
</html>