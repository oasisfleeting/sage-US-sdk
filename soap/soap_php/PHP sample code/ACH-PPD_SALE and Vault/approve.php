<?php
    
    $transaction = array(
            
            'M_ID' => '111111111111',
            'M_KEY' => 'X1X1X1X1X1X1',
            'C_ORIGINATOR_ID' => '000000000',
            'C_FIRST_NAME' => $_POST['FirstName'],
            'C_MIDDLE_INITIAL' => '',
            'C_LAST_NAME' => $_POST['LastName'],
            'C_SUFFIX' => '',
            'C_ADDRESS' => $_POST['AddressLine1'] . ' ' . $_POST['AddressLine2'],
            'C_CITY' => $_POST['City'],
            'C_STATE' => $_POST['State'],
            'C_ZIP' => $_POST['Zip'],
            'C_COUNTRY' => 'USA',
            'C_EMAIL' => 'jlp@example.com',
            'GUID' => $_POST['GUID'],
            'T_AMT' => $_POST['Amount'],
            'T_SHIPPING' => '0.00',
            'T_TAX' => '0.00',
            'C_TELEPHONE' => '',
            'C_FAX' => '',
            'C_SHIP_NAME' => '',
            'C_SHIP_ADDRESS' => '',
            'C_SHIP_CITY' => '',
            'C_SHIP_STATE' => '',
            'C_SHIP_ZIP' => '',
            'C_SHIP_COUNTRY' => '',
            'T_ORDERNUM' => $_POST['OrderNum'] . time()
            
            );

    $SOAP = new SoapClient('https://www.sagepayments.net/web_services/wsVault/wsVaultVirtualCheck.asmx?WSDL');
    $response = $SOAP->VIRTUAL_CHECK_PPD_SALE($transaction);
    $result = $response->VIRTUAL_CHECK_PPD_SALEResult->any;
    $result = new SimpleXMLElement($result);

?>


<!DOCTYPE html>
<html>
    <head>
        <title>SPS Web Services Sample - Vault ACH</title>
    </head>
    
    <body>
        <h3>Payment Results:</h3>
        <?php
            echo '<pre>';
            echo 'Your transaction was ' . $result->NewDataSet->Table1->MESSAGE . '<br />';
            echo 'Your order number is ' . $result->NewDataSet->Table1->ORDER_NUMBER . '<br />';
            echo '</pre>';
        ?>
        <!--
            FOR SUPPORT: sdksupport@sage.com
 
        -->
    </body>
</html>