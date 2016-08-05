<?php

    $toCreateCust = array(
        'M_ID' => '111111111111',
        'M_KEY' => 'X1X1X1X1X1X1',
        'CUSTOMER_TYPE' => $_POST['CustType'],
        'FIRST_NAME' => $_POST['FirstName'],
        'LAST_NAME' => $_POST['LastName'],
        'ADDRESS' => $_POST['AddressLine1'] . ' ' . $_POST['AddressLine2'],
        'CITY' => $_POST['City'],
        'STATE' => $_POST['State'],
        'ZIP' => $_POST['Zip'],
        'COUNTRY' => $_POST['Country'],
        'EMAIL_ADDRESS' => $_POST['Email'],
        'TELEPHONE' => $_POST['Telephone'],
        'HOLD' => $_POST['Hold'],
        'REFERNCE' => $_POST['Reference'],
        );

    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsvtextensions/recurring.asmx?WSDL');
    
    $response = $SOAP->CREATE_RECURRING_CUSTOMER($toCreateCust);
    $result = $response->CREATE_RECURRING_CUSTOMERResult->any;
    $result = new SimpleXMLElement($result);
    
    if(isset($result->NewDataSet->Table1->CUSTOMER_ID)){
        $CUSTOMER_ID = $result->NewDataSet->Table1->CUSTOMER_ID;    

    };

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SPS Web Services Sample</title>
    </head>
    
    <body>
        <h3>Customer ID Results and Create Bankcard Payre and Transaction Request:</h3>
        <?php
            echo '<pre>';
            //echo 'Response message: ' . $result->NewDataSet->Table1->CUSTOMER_ID . '<br />';

            if($CUSTOMER_ID){echo 'Customer ID: ' . $CUSTOMER_ID. '<br />';};
            echo '<br /><br /><br />';
            
            if($CUSTOMER_ID){
                echo "<form method='POST' action='approve.php'>
<label>Amount: <input type='text' name='Amount' value='19.99'></label>
<label>Active (01=Active / 02=Inactive): <input type='text' name='Active' value='01'></label>
<input type='hidden' name='CUSTOMER_ID' value='" . $CUSTOMER_ID . "' />

<label>First Name: <input type='text' name='FirstName' value='Juan'></label>
<label>Last Name: <input type='text' name='LastName' value='Doe'></label>
<label>Address Line 1: <input type='text' name='AddressLine1' value='Starfleet Academy'></label>
<label>Address Line 2: <input type='text' name='AddressLine2' value='Room 1'></label>
<label>City: <input type='text' name='City' value='San Francisco'></label>
<label>State: <input type='text' name='State' value='CA'></label>
<label>Zip: <input type='text' name='Zip' value='94952'></label>
<label>Email: <input type='email' name='Email' value='jlpicard@example.com'></label>
<label>Telephone: <input type='tel' name='Telephone' value='999-555-1234'></label>
<label>Cardnumber: <input type='text' name='CC' value='4111111111111111'></label>
<label>Expiration Month: <input type='text' name='ExpMonth' value='01'></label>
<label>Expiration Year: <input type='text' name='ExpYear' value='20'></label>
<label>Group ID: <input type='text' name='GrpID' value='38667'></label>
<label>Schedule ID: <input type='text' name='SchID' value='50421'></label>
<label>Start Date: <input type='text' name='StrtDate' value=''></label>
<label>Transaction Code (01=Sale / 02=Auth Only): <input type='text' name='TrxCode' value='01'></label>
<label>Times to Process (If '0' the Indefinite field must be set to '1'): <input type='text' name='TmstoPrcs' value='1'></label>
<label>Indefinite (0=Not Indefinite / 1=Yes Indefinite): <input type='text' name='Indefinite' value='0'></label>
<label>Third Party Reference: <input type='text' name='Reference' value='SOAP-BC-Recurring Test'></label>
<input type='submit' value='Approve' />
</form>";
            };
            
            echo '</pre>';
            
        ?>

    </body>
</html>