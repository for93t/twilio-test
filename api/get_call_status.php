<?php

if (empty($_REQUEST['provider_id']) || ! is_numeric($_REQUEST['provider_id'])) {
    die("The correct provider ID must be sent in the 'provider_id' request field.");
}
$providerId = (int) $_REQUEST['provider_id'];

$redis = new \Redis();
$redis->connect('/var/run/redis/redis.sock');
$redis->select(1);
$status = $redis->get('tc24_call_status_' . $providerId);

// in case of failed status lookup, return null
if (false === $status) {
    $status = null;
}

$redis->close();

echo json_encode($status);
