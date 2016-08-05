<?php
    
    $schedule = array(
            
            'M_ID' => '111111111111',
            'M_KEY' => 'X1X1X1X1X1X1',
            'SCHEDULE_DESCRIPTION' => $_POST['SchedlDesc'],
            'MONTHLY_INTERVAL' => $_POST['MonthlyIntvl'],
            'DAY_OF_MONTH' => $_POST['DayofMth'],
            'NON_BUSINESS_DAYS' => $_POST['NonBusday'],
            'START_OFFSET' => $_POST['StartOffset'],
                        
            );

    $SOAP = new SoapClient('https://gateway.sagepayments.net/web_services/wsvtextensions/recurring.asmx?WSDL');
    
    $response = $SOAP->CREATE_RECURRING_MONTHLY_SCHEDULE($schedule);
    $result = $response->CREATE_RECURRING_MONTHLY_SCHEDULEResult->any;
    $result = new SimpleXMLElement($result);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SPS Web Services Sample</title>
    </head>
    
    <body>
        <h3>Recurring Schedule Results:</h3>
        <?php
            echo '<pre>';
            echo 'Your Schedule ID is ' . $result->NewDataSet->Table1->SCHEDULE_ID . '<br />';
            echo '</pre>';

        ?>
    </body>
</html>