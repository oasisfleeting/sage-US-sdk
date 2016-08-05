<?php
    
    $transaction = array(
            
            'M_ID' => '111111111111',
            'M_KEY' => 'X1X1X1X1X1X1',
            'C_NAME' => $_POST['FirstName'] . ' ' . $_POST['LastName'],
            'C_ADDRESS' => $_POST['AddressLine1'] . ' ' . $_POST['AddressLine2'],
            'C_CITY' => $_POST['City'],
            'C_STATE' => $_POST['State'],
            'C_ZIP' => $_POST['Zip'],
            'C_COUNTRY' => 'USA',
            'C_EMAIL' => $_POST['Email'],
            'C_CARDNUMBER' => $_POST['CC'],
            'C_EXP' => $_POST['Exp'],
            'T_AMT' => $_POST['Amt'],
            'T_ORDERNUM' => $_POST['Ordernum'] . time()
            
            );

    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsvtextensions/transaction_processing.asmx?WSDL');
    $response = $SOAP->BANKCARD_SALE($transaction);
    $result = $response->BANKCARD_SALEResult->any;
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