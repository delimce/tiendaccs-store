<?php

$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://www.tiendaccs.com/index.php?route=api/order/expireOrders&api_token=GtULQW9ZMhhHLi3ooobDukIqTmqOZ1fJ',
    CURLOPT_USERAGENT => 'expire orders Request'
]);
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

echo "success!";

?>