<?php


    function makeHmac($xml)
    {
        $M_KEY ='1X1X1X1X1X1X';
        $verb = 'POST';
        $url = 'https://gateway.sagepayments.net/web_services/gateway/api/transactions';
        $HASHSUBJECT = $verb . $url . $xml;
        return base64_encode(hash_hmac('sha1', $HASHSUBJECT, $M_KEY, true));
    }

?>