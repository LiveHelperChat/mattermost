<?php

use \Gnello\Mattermost\Driver;

/**
 * php cron.php -s site_admin -e mattermost -c cron/archive
 * */

$osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
$data = (array) $osTicketOptions->data;

if (isset($data['delete_after']) && is_numeric($data['delete_after']) && $data['delete_after'] > 0) {
    include_once 'extension/mattermost/vendor/autoload.php';

    $container = new \Pimple\Container([
        "driver" => [
            'scheme' => (strpos($data['host'],'http://') !== false ? 'http' : 'https'),
            "url" => str_replace(array('http://','https://'),'',$data['host']),
            "login_id" => $data['username'],
            "password" => $data['password'],
        ]
    ]);

    $driver = new Driver($container);
    $driver->authenticate();

    foreach (erLhcoreClassModelMattermostChat::getList(array('filterlt' => array('ctime' => time() - ($data['delete_after'] * 24 *3600)))) as $mmChat) {

        $resp = $driver->getChannelModel()->deleteChannel($mmChat->mm_ch_id .'?permanent=true');

        if ($resp->getStatusCode() == 200) {
            $mmChat->removeThis();
        }
    }
}

?>