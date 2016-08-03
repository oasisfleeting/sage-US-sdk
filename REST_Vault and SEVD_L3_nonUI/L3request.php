<?php

    /*
    
        This is a confirmation page from the user's perspective, but it's doing some important work in the background.
        
        A confirmation page isn't necessary, strictly speaking -- eg, you could tokenize on a single page with an AJAX call 
        and some JavaScript -- but this is certainly the most common type of implementation, and it's nice to give your users 
        a confirmation page to double-check what they entered.
        
    */

    /*
    
        This is piecing together the XML request. Some things to note:
            The ApplicationID here is 'DEMO'; when you're done with development we will certify your integration (it's quick & easy)
                and provide a production value.
            The MerchantID and MerchantKey here are a test account of mine. They will work, and you are welcome to use them. However,
                I strongly suggest you replace it with your own test credentials so you have access to the Virtual Terminal.
            I use a random number for the TransactionID. Don't do this in production; make sure your Transaction IDs are unique.
                TransactionIDs are not exposed to the user, and can be used as a fallback mechanism to query transaction statuses.
            For Reference1, I'm using a timestamp. This, however, is where you'd want to put whatever kind of Order Number you're
                providing to the customer for their reference.
            The <Customer> node is being populated with the form data we received from the previous page.
            Refer to the 'XML Messaging' and 'User Guide' pdfs for more detail on the XML requests.
            
    */
    $raw_xml = '<Request_v1 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <Application>
    <ApplicationID>DEMO</ApplicationID>
    <LanguageID>EN</LanguageID>
  </Application>
  <Payments>
    <PaymentType>
      <Merchant>
        <MerchantID>111111111111</MerchantID>
        <MerchantKey>1X1X1X1X1X1X</MerchantKey>
      </Merchant>
      <TransactionBase>
        <TransactionID>' . time() . '</TransactionID>
        <TransactionType>01</TransactionType>
        <Reference1>' . time() . '</Reference1>
        <Amount>' . $_POST['Amt'] . '</Amount>
      </TransactionBase>
      <Customer>
        <Name>
          <FirstName>' . $_POST['Name'] . '</FirstName>
        </Name>
        <Address>
          <AddressLine1>' . $_POST['AddressLine1'] . '</AddressLine1>
          <AddressLine2>' . $_POST['AddressLine2'] . '</AddressLine2>
          <City>' . $_POST['City'] . '</City>
          <State>' . $_POST['State'] . '</State>
          <ZipCode>' . $_POST['Zip'] . '</ZipCode>
          <Country>USA</Country>
          <EmailAddress>' . $_POST['Email'] . '</EmailAddress>
          <Telephone>' . $_POST['Telephone'] . '</Telephone>
        </Address>
      </Customer>
      <Level3>
        <Level2>
          <CustomerNumber>' . $_POST['CustomerNumber'] . '</CustomerNumber>
          <TaxAmount>' . $_POST['TaxAmount'] . '</TaxAmount>
        </Level2>
        <ShippingAmount>' . $_POST['ShippingAmount'] . '</ShippingAmount>
        <DestinationZipCode>' . $_POST['DestinationZipCode'] . '</DestinationZipCode>
        <DestinationCountryCode>' . $_POST['DestinationCountryCode'] . '</DestinationCountryCode>
        <VATNumber>' . $_POST['VATNumber'] . '</VATNumber>
        <DiscountAmount>' . $_POST['DiscountAmount'] . '</DiscountAmount>
        <DutyAmount>' . $_POST['DutyAmount'] . '</DutyAmount>
        <NationalTaxAmount>' . $_POST['NationalTaxAmount'] . '</NationalTaxAmount>
        <VATInvoiceNumber>' . $_POST['VATInvoiceNumber'] . '</VATInvoiceNumber>
        <VATTaxAmount>' . $_POST['VATTaxAmount'] . '</VATTaxAmount>
        <VATTaxRate>' . $_POST['VATTaxRate'] . '</VATTaxRate>
        <LineItems>
          <Level3LineItemType>
            <CommodityCode>' . $_POST['CommodityCode'] . '</CommodityCode>
            <Description>' . $_POST['Description'] . '</Description>
            <ProductCode>' . $_POST['ProductCode'] . '</ProductCode>
            <Quantity>' . $_POST['Quantity'] . '</Quantity>
            <UnitOfMeasure>' . $_POST['UnitOfMeasure'] . '</UnitOfMeasure>
            <UnitCost>' . $_POST['UnitCost'] . '</UnitCost>
            <TaxAmount>' . $_POST['TaxAmount'] . '</TaxAmount>
            <TaxRate>' . $_POST['TaxRate'] . '</TaxRate>
            <DiscountAmount>' . $_POST['DiscountAmount'] . '</DiscountAmount>
            <AlternateTaxIdentifier>' . $_POST['AlternateTaxIdentifier'] . '</AlternateTaxIdentifier>
            <TaxTypeApplied>' . $_POST['TaxTypeApplied'] . '</TaxTypeApplied>
            <DiscountIndicator>' . $_POST['DiscountIndicator'] . '</DiscountIndicator>
            <NetGrossIndicator>' . $_POST['NetGrossIndicator'] . '</NetGrossIndicator>
            <ExtendedItemAmount>' . $_POST['ExtendedItemAmount'] . '</ExtendedItemAmount>
            <DebitCreditIndicator>' . $_POST['DebitCreditIndicator'] . '</DebitCreditIndicator>
          </Level3LineItemType>
          <Level3LineItemType>
            <CommodityCode>' . $_POST['CommodityCode2'] . '</CommodityCode>
            <Description>' . $_POST['Description2'] . '</Description>
            <ProductCode>' . $_POST['ProductCode2'] . '</ProductCode>
            <Quantity>' . $_POST['Quantity2'] . '</Quantity>
            <UnitOfMeasure>' . $_POST['UnitOfMeasure2'] . '</UnitOfMeasure>
            <UnitCost>' . $_POST['UnitCost2'] . '</UnitCost>
            <TaxAmount>' . $_POST['TaxAmount2'] . '</TaxAmount>
            <TaxRate>' . $_POST['TaxRate2'] . '</TaxRate>
            <DiscountAmount>' . $_POST['DiscountAmount2'] . '</DiscountAmount>
            <AlternateTaxIdentifier>' . $_POST['AlternateTaxIdentifier2'] . '</AlternateTaxIdentifier>
            <TaxTypeApplied>' . $_POST['TaxTypeApplied2'] . '</TaxTypeApplied>
            <DiscountIndicator>' . $_POST['DiscountIndicator2'] . '</DiscountIndicator>
            <NetGrossIndicator>' . $_POST['NetGrossIndicator2'] . '</NetGrossIndicator>
            <ExtendedItemAmount>' . $_POST['ExtendedItemAmount2'] . '</ExtendedItemAmount>
            <DebitCreditIndicator>' . $_POST['DebitCreditIndicator2'] . '</DebitCreditIndicator>
          </Level3LineItemType>
        </LineItems>
      </Level3>
      <VaultStorage>
        <GUID>' . $_POST['GUID'] . '</GUID>
        <Service>RETRIEVE</Service>
      </VaultStorage>
    </PaymentType>
  </Payments>
  <UI>
    <UIStyle>
      <Wizard>
        <BackgroundColor>fff</BackgroundColor>
        <BorderStyle>
          <BorderBottom>2</BorderBottom>
          <BorderColor>fff</BorderColor>
          <BorderLeft>2</BorderLeft>
          <BorderRight>2</BorderRight>
          <BorderTop>2</BorderTop>
        </BorderStyle>
        <FieldStyle>
          <Color>000</Color>
          <Family>Arial</Family>
          <Size>14</Size>
        </FieldStyle>
        <LabelStyle>
          <Color>000</Color>
          <Family>Arial</Family>
          <Size>14</Size>
        </LabelStyle>
      </Wizard>
      <WizardSupport>
        <Visible>false</Visible>
      </WizardSupport>
      <WizardStepLeft>
        <BackgroundColor>fff</BackgroundColor>
        <BorderStyle>
          <BorderBottom>2</BorderBottom>
          <BorderColor>BDBDBD</BorderColor>
          <BorderLeft>2</BorderLeft>
          <BorderRight>2</BorderRight>
          <BorderTop>2</BorderTop>
        </BorderStyle>
        <FieldStyle>
          <Color>000</Color>
          <Family>Arial</Family>
          <Size>14</Size>
        </FieldStyle>
        <LabelStyle>
          <Color>000</Color>
          <Family>Arial</Family>
          <Size>14</Size>
        </LabelStyle>
      </WizardStepLeft>
      <WizardStepRight>
        <BackgroundColor>fff</BackgroundColor>
        <BorderStyle>
          <BorderBottom>2</BorderBottom>
          <BorderColor>BDBDBD</BorderColor>
          <BorderLeft>2</BorderLeft>
          <BorderRight>2</BorderRight>
          <BorderTop>2</BorderTop>
        </BorderStyle>
        <FieldStyle>
          <Color>000</Color>
          <Family>Arial</Family>
          <Size>14</Size>
        </FieldStyle>
        <LabelStyle>
          <Color>000</Color>
          <Family>Arial</Family>
          <Size>14</Size>
        </LabelStyle>
      </WizardStepRight>
    </UIStyle>
    <SinglePayment>
      <TransactionBase>
        <Reference1>
          <Enabled>false</Enabled>
          <Visible>true</Visible>
        </Reference1>
        <Amount>
          <Enabled>false</Enabled>
          <Visible>false</Visible>
        </Amount>
        <TaxAmount>
          <Enabled>false</Enabled>
          <Visible>false</Visible>
        </TaxAmount>
        <ShippingAmount>
          <Enabled>false</Enabled>
          <Visible>false</Visible>
        </ShippingAmount>
      </TransactionBase>
      <Customer>
        <Name>
          <FirstName>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </FirstName>
          <MI>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </MI>
          <LastName>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </LastName>
        </Name>
        <Address>
          <AddressLine1>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </AddressLine1>
          <AddressLine2>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </AddressLine2>
          <City>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </City>
          <State>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </State>
          <ZipCode>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </ZipCode>
          <Country>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </Country>
          <EmailAddress>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </EmailAddress>
          <Telephone>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </Telephone>
          <Fax>
            <Enabled>false</Enabled>
            <Visible>true</Visible>
          </Fax>
        </Address>
      </Customer>
    </SinglePayment>
  </UI>
</Request_v1>';
    
    // The XML needs to be tokenized before it's sent to the user. The reason for this becomes apparent
    // in the HTML section of this file, below. Here's the endpoint for the tokenization service:
    $tokenization_url = 'https://www.sageexchange.com/virtualpaymentterminal/frmenvelope.aspx';
    
    // We're URL-encoding it as sending it with the name 'request'.
    $request = 'request=' . urlencode($raw_xml);
    
    // A pretty standard cURL request: 
    $ch = curl_init($tokenization_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    // Here's our result.
    $tokenized_xml = stripcslashes(curl_exec($ch));
    curl_close($ch);
    
    // Now let's look at the HTML side of things --
?>

<!DOCTYPE html>
<html>
    <head>
    <title>pg 2 - SEVD Sample</title>
    </head>
    
    <body>
        <h3>Please confirm your information:</h3>
        <?php
            echo '<pre>';
            // For the user to confirm what they entered.
            foreach ($_POST as $key=>$value)
            {
                echo $key . ': ' . $value;
                echo '<br />';
            }    
            echo '</pre>';
        ?>

        <!-- This form is what actually calls the SEVD UI. -->
            <form method="POST" action="https://www.sageexchange.com/virtualpaymentterminal/frmpayment.aspx">

            <!--
                This is why we had to tokenize the XML request; if we were to expose the XML "as is", then 
                anyone who knows how to view a page's source or use their browser's dev console would have 
                access to our Merchant ID and Merchant Key.
            -->
            <input type="hidden" name="request" value="<?php echo htmlentities($tokenized_xml); ?>" />
            
            <!--
                The user is sent to the redirect_url when they're done with their payment. This page also parses the
                transaction response, which we'll see in the next file. Relative paths will not work; you must pass a 
                complete URL.
            -->
            
            
            <input type="hidden" name="redirect_url" value="https://robertf-demo-sagesdksupport.c9.io/REST_Vault-SEVD_L3_nonUI/response.php" />
            
            <!--
            <input type="hidden" name="redirect_url" value="http://requestb.in/xxxxxx" />
            -->
            
            <input type="submit" value="Pay Now" /><br />
        </form>
    
    <br />
    <a href="index.htm">Go Back to Make Changes</a>
    
    </body>
</html>
