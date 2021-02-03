<?php

use \Gnello\Mattermost\Driver;

try {
    $chat = erLhcoreClassModelChat::fetch((int)$Params['user_parameters']['id']);
    $hash = $Params['user_parameters']['hash'];

    if ($hash == $chat->hash && $chat->status != erLhcoreClassModelChat::STATUS_CLOSED_CHAT) {

        $driver = erLhcoreClassMattermostValidator::getDriver();

        $resp = $driver->getFileModel()->getMetadataForFile($Params['user_parameters']['file_id']);

        if ($resp->getStatusCode() == 200) {

            $linkData = json_decode($resp->getBody(), true);
            header('Content-type: '. $linkData['mime_type']);
            header('Content-Disposition: attachment; filename="'.$linkData['name'].'"');

            $resp = $driver->getFileModel()->getFile($Params['user_parameters']['file_id']);
            echo $resp->getBody();
        }
    }

} catch (Exception $e) {
    header('Location: /');
    exit;
}
exit;


?>