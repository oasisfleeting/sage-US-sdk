<?php

    // The gateway credentials that I use correspond to test account of mine. They will work, and you are
    // welcome to use them. However, I strongly suggest you replace it with your own test credentials so 
    // you have access to the Virtual Terminal.
    $M_ID = '111111111111';

    // First, we're going to gather all our data from the previous page and plug it into an XML template.
    // You can also send/receive JSON by setting the appropriate headers. (Content-Type & Accept)
    // This is a minimalistic example; please refer to the documentation/WSDLs for more details.
    
    // The ApplicationID here is 'DEMO'; when you're done with development we will certify your integration
    // (it's quick & easy)and provide a production value.
    $vault = '<VaultCreditCardTokenRequest xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://schemas.datacontract.org/2004/07/wapiGateway.Models">
        <ApplicationId>DEMO</ApplicationId>
        <CardExpirationDate>' . $_POST['Exp'] . '</CardExpirationDate>
        <CardNumber>' . $_POST['CC'] . '</CardNumber>
    </VaultCreditCardTokenRequest>';
    
    // This request will be authenticated via an HMAC.
    // Please see hmac.php to view the calculation.
    require("hmac.php");
    $HMAC = makeHmac($vault);
    
    // Now we're going to make the request:
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://gateway.sagepayments.net/web_services/gateway/api/vaultcreditcardtokens');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vault);
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

        if(isset($result->Token)){
        $token = $result->Token;   

};

    // [Some database calls and/or logging here, probably.]

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SPS REST API Sample</title>
    </head>
    
    <body>
        <h3>Vault Results:</h3>
        <!-- We're done! Give your user a result: -->
        <?php
            echo '<pre>';
            echo 'Your request was ' . $result->Result . '<br />';
            if($token){echo 'Card token: ' . $token. '<br />';};
            echo '<br />';
            
            if($token){
                echo "<form method='POST' action='L3request.php'>
        <h3>Payer Information:</h3>
            <label>Payer Name or Company Name: <input type='text' name='Name' value='Acme Products Inc'></label>
            <label>Address Line 1: <input type='text' name='AddressLine1' value='123 Main St.'></label>
            <label>Address Line 2: <input type='text' name='AddressLine2' value='Suite 1'></label>
            <label>City: <input type='text' name='City' value='Fairfax'></label>
            <label>State: <input type='text' name='State' value='VA'></label>
            <label>Zip: <input type='text' name='Zip' value='22033'></label>
            <label>Email: <input type='email' name='Email' value='test@example.com'></label>
            <label>Telephone: <input type='tel' name='Telephone' value='999-555-1234'></label>
            <label>Amount: <input type='text' name='Amt' value='5300'></label>
            <label>GUID: <input type='text' name='GUID' value='" . $token . "' /></label>
        <h3>Level 2 Information:</h3>
            <label>CustomerNumber: <input type='text' name='CustomerNumber' value='1234567890'></label>
            <label>TaxAmount: <input type='text' name='TaxAmount' value='0.00'></label>
        <h3>Level 3 Information:</h3>
            <label>ShippingAmount: <input type='text' name='ShippingAmount' value='0.00'></label>
            <label>DestinationZipCode: <input type='text' name='DestinationZipCode' value='53120'></label>
            <label>DestinationCountryCode: <input type='text' name='DestinationCountryCode' value='USA'></label>
            <label>VATNumber: <input type='text' name='VATNumber' value='111222333'></label>
            <label>DiscountAmount: <input type='text' name='DiscountAmount' value='0'></label>
            <label>DutyAmount: <input type='text' name='DutyAmount' value='0.00'></label>
            <label>NationalTaxAmount: <input type='text' name='NationalTaxAmount' value='0.00'></label>
            <label>VATInvoiceNumber: <input type='text' name='VATInvoiceNumber' value='Optional'></label>
            <label>VATTaxAmount: <input type='text' name='VATTaxAmount' value='0.00'></label>
            <label>VATTaxRate: <input type='text' name='VATTaxRate' value='0'></label>
        <h3>Level 3 Line Item Details: Product 1</h3>
            <label>CommodityCode: <input type='text' name='CommodityCode' value='60000'></label>
            <label>Description: <input type='text' name='Description' value='HON 2 DRAWER LETTER FLE W/O LK'></label>
            <label>ProductCode: <input type='text' name='ProductCode' value='A123456'></label>
            <label>Quantity: <input type='text' name='Quantity' value='1'></label>
            <label>UnitOfMeasure: <input type='text' name='UnitOfMeasure' value='EACH'></label>
            <label>UnitCost: <input type='text' name='UnitCost' value='1700'></label>
            <label>TaxAmount: <input type='text' name='TaxAmount' value='0.00'></label>
            <label>TaxRate: <input type='text' name='TaxRate' value='0.00'></label>
            <label>DiscountAmount: <input type='text' name='DiscountAmount' value='0.00'></label>
            <label>AlternateTaxIdentifier: <input type='text' name='AlternateTaxIdentifier' value='Optional'></label>
            <label>TaxTypeApplied: <input type='text' name='TaxTypeApplied' value='Optional'></label>
            <label>DiscountIndicator: <input type='text' name='DiscountIndicator' value='N'></label>
            <label>NetGrossIndicator: <input type='text' name='NetGrossIndicator' value='N'></label>
            <label>ExtendedItemAmount: <input type='text' name='ExtendedItemAmount' value='1700.00'></label>
            <label>DebitCreditIndicator: <input type='text' name='DebitCreditIndicator' value='D'></label>
        <h3>Level 3 Line Item Details: Product 2</h3>
            <label>CommodityCode: <input type='text' name='CommodityCode2' value='60000'></label>
            <label>Description: <input type='text' name='Description2' value='DESK FILE 8 in. CAP 50'></label>
            <label>ProductCode: <input type='text' name='ProductCode2' value='B789456'></label>
            <label>Quantity: <input type='text' name='Quantity2' value='2'></label>
            <label>UnitOfMeasure: <input type='text' name='UnitOfMeasure2' value='EACH'></label>
            <label>UnitCost: <input type='text' name='UnitCost2' value='1800'></label>
            <label>TaxAmount: <input type='text' name='TaxAmount2' value='0'></label>
            <label>TaxRate: <input type='text' name='TaxRate2' value='0'></label>
            <label>DiscountAmount: <input type='text' name='DiscountAmount2' value='0'></label>
            <label>AlternateTaxIdentifier: <input type='text' name='AlternateTaxIdentifier2' value='Optional'></label>
            <label>TaxTypeApplied: <input type='text' name='TaxTypeApplied2' value='Optional'></label>
            <label>DiscountIndicator: <input type='text' name='DiscountIndicator2' value='N'></label>
            <label>NetGrossIndicator: <input type='text' name='NetGrossIndicator2' value='N'></label>
            <label>ExtendedItemAmount: <input type='text' name='ExtendedItemAmount2' value='3600.00'></label>
            <label>DebitCreditIndicator: <input type='text' name='DebitCreditIndicator2' value='D'></label><br />
        
            <input type='submit' value='Click to Confirm' />
</form>";
            };
            
            echo '</pre>';
            
        ?>

    </body>
</html>