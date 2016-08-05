<?php

    $toTokenize = array(
        'M_ID' => '111111111111',
        'M_KEY' => 'X1X1X1X1X1X1',
        'ROUTING_NUMBER' => $_POST['RTE'],
        'ACCOUNT_NUMBER' => $_POST['ACCT'],
        'C_ACCT_TYPE' => $_POST['ACCTTYP']
        );

    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsVault/wsVault.asmx?WSDL');
    
    $response = $SOAP->INSERT_VIRTUAL_CHECK_DATA($toTokenize);
    $result = $response->INSERT_VIRTUAL_CHECK_DATAResult->any;
    $result = new SimpleXMLElement($result);
    
    if(isset($result->NewDataSet->Table1->GUID)){
        $GUID = $result->NewDataSet->Table1->GUID;    

    };

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SPS Web Services Sample</title>
    </head>
    
    <body>
        <h3>Tokenization Results:</h3>
        <?php
            echo '<pre>';
            echo 'Response message: ' . $result->NewDataSet->Table1->MESSAGE . '<br />';
            echo 'Card tokenized: ' . $result->NewDataSet->Table1->SUCCESS . '<br />';
            
            if($GUID){echo 'Card token: ' . $GUID. '<br />';};
            echo '<br /><br /><br />';
            
            if($GUID){
                echo "<form method='POST' action='approve.php'>
<label>Amount: <input type='text' name='Amount' value='1.00'></label>
<label>Order ID: <input type='text' name='OrderNum' value='" .rand(1,1000). "'></label>
<input type='hidden' name='GUID' value='" . $GUID . "' />

<label>First Name: <input type='text' name='FirstName' value='Joe'></label>
<label>Last Name: <input type='text' name='LastName' value='Cuervo'></label>
<label>Address Line 1: <input type='text' name='AddressLine1' value='123 Main St.'></label>
<label>Address Line 2: <input type='text' name='AddressLine2' value='Suite 1'></label>
<label>City: <input type='text' name='City' value='Paterson'></label>
<label>State: <input type='text' name='State' value='NJ'></label>
<label>Zip: <input type='text' name='Zip' value='07524'></label>
<label>Email: <input type='email' name='Email' value='test@example.com'></label>
<label>Telephone: <input type='tel' name='Telephone' value='999-555-1234'></label>

<input type='submit' value='Approve' />
</form>";
            };
            
            echo '</pre>';
            
        ?>

    </body>
</html>