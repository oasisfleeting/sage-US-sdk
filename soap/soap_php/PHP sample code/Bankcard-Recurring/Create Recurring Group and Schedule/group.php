<?php

    $toCreateGrp = array(
        'M_ID' => '111111111111',
        'M_KEY' => 'X1X1X1X1X1X1',
        'GROUP_DESCRIPTION' => $_POST['GroupDesc'],
   );

    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsvtextensions/recurring.asmx?WSDL');
    
    $response = $SOAP->CREATE_RECURRING_GROUP($toCreateGrp);
    $result = $response->CREATE_RECURRING_GROUPResult->any;
    $result = new SimpleXMLElement($result);
    
    if(isset($result->NewDataSet->Table1->GROUP_ID)){
        $GROUP_ID = $result->NewDataSet->Table1->GROUP_ID;    

    };

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SPS Web Services Sample</title>
    </head>
    
    <body>
        <h3>Recurring Group Results:</h3>
        <?php
            echo '<pre>';
            //echo 'Response message: ' . $result->NewDataSet->Table1->GROUP_ID . '<br />';

            if($GROUP_ID){echo 'Group ID: ' . $GROUP_ID. '<br />';};
            echo '<br /><br /><br />';
            
            if($GROUP_ID){
                echo "<form method='POST' action='schedule.php'>
<label>Schedule Description: <input type='text' name='SchedlDesc' value='Monthly on the first'></label>
<label>Montly Interval: <input type='text' name='MonthlyIntvl' value='1'></label>
<label>Day of Month: <input type='text' name='DayofMth' value='1'></label>
<label>Non Business Days: <input type='text' name='NonBusday' value='1'></label>
<label>Start Offset: <input type='text' name='StartOffset' value='0'></label>
<input type='hidden' name='GROUP_ID' value='" . $GROUP_ID . "' />
<input type='submit' value='Success' />
</form>";
            };
            
            echo '</pre>';
            
        ?>

    </body>
</html>