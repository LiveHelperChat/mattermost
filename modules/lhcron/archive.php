<?php

use \Gnello\Mattermost\Driver;

/**
 * php cron.php -s site_admin -e mattermost -c cron/archive
 * */

$osTicketOptions = erLhcoreClassModelChatConfig::fetch('mattermost_options');
$data = (array) $osTicketOptions->data;

if (isset($data['delete_after']) && is_numeric($data['delete_after']) && $data['delete_after'] > 0) {

    $driver = erLhcoreClassMattermostValidator::getDriver();

    $counter = 0;

    foreach (erLhcoreClassModelMattermostChat::getList(array('filterlt' => array('ctime' => time() - ($data['delete_after'] * 3600)))) as $mmChat) {

        $resp = $driver->getChannelModel()->deleteChannel($mmChat->mm_ch_id .'?permanent=true');

        if ($resp->getStatusCode() == 200) {
            $mmChat->removeThis();
            $counter++;
            echo "Deleted chat - " . $mmChat->mm_ch_id,"\n";
        } else {
            echo "Could not delete chat - " . $mmChat->mm_ch_id,"\n";
        }
    }

    echo "Deleted - " . $counter ." chats.\n";
} else {
    echo "Not configured!\n";
}

?>
