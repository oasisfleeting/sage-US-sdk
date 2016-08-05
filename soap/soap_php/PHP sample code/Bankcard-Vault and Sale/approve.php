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
            'C_EMAIL' => 'jlp@example.com',
            'GUID' => $_POST['GUID'],
            'T_AMT' => $_POST['Amount'],
            'T_ORDERNUM' => $_POST['Group'] . time()
            
            );

    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsVault/wsVaultBankcard.asmx?WSDL');
    $response = $SOAP->VAULT_BANKCARD_SALE($transaction);
    $result = $response->VAULT_BANKCARD_SALEResult->any;
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
            echo '<pre>';
            echo 'Your transaction was ' . $result->NewDataSet->Table1->MESSAGE . '<br />';
            echo 'Your order number is ' . $result->NewDataSet->Table1->ORDER_NUMBER . '<br />';
            echo '</pre>';
        ?>

    </body>
</html>