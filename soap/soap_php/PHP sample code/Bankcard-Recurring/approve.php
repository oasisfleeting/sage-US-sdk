<?php
    
    $transaction = array(
            
            'M_ID' => '111111111111',
            'M_KEY' => 'X1X1X1X1X1X1',
            'ACTIVE' => $_POST['Active'],
            'CUSTOMER_ID' => $_POST['CUSTOMER_ID'],
            'FIRST_NAME' => $_POST['FirstName'],
            'LAST_NAME' => $_POST['LastName'],
            'ADDRESS' => $_POST['AddressLine1'] . ' ' . $_POST['AddressLine2'],
            'CITY' => $_POST['City'],
            'STATE' => $_POST['State'],
            'ZIP' => $_POST['Zip'],
            'COUNTRY' => 'USA',
            'EMAIL_ADDRESS' => 'jlp@example.com',
            'CARDNUMBER' => $_POST['CC'],
            'CARD_EXP_MONTH' => $_POST['ExpMonth'],
            'CARD_EXP_YEAR' => $_POST['ExpYear'],
            'GROUP_ID' => $_POST['GrpID'],
            'SCHEDULE_ID' => $_POST['SchID'],
            'AMOUNT' => $_POST['Amount'],
            'T_CODE' => $_POST['TrxCode'],
            'TIMES_TO_PROCESS' => $_POST['TmstoPrcs'],
            'INDEFINITE' => $_POST['Indefinite'],
            'START_DATE' => $_POST['StrtDate'],
            'REFERENCE' => $_POST['Reference'] . time()
            
            );

    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsvtextensions/recurring.asmx?WSDL');
    
    $response = $SOAP->CREATE_RECURRING_BANKCARD_PAYER_AND_TRANSACTION($transaction);
    $result = $response->CREATE_RECURRING_BANKCARD_PAYER_AND_TRANSACTIONResult->any;
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
            echo 'Your Payer ID is ' . $result->NewDataSet->Table1->PAYER_ID . '<br />';
            echo 'Your Recurring ID is ' . $result->NewDataSet->Table1->RECURRING_ID . '<br />';
            echo '</pre>';
        ?>
    </body>
</html>