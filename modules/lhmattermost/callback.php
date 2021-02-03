<?php

header('Content-type: application/json; charset=utf-8');

$payload = json_decode(file_get_contents('php://input'),true);

$chat = erLhcoreClassModelChat::fetch((int)$Params['user_parameters']['id']);

if ($chat instanceof erLhcoreClassModelChat) {
    $chatVariables = $chat->chat_variables_array;
    if (isset($chatVariables['mm_ch_id']) && $payload['channel_id'] == $chatVariables['mm_ch_id']) {
        erLhcoreClassMattermostValidator::processMattermostMessage($chat, $payload);
    }
}

echo json_encode(array("text" => null));
exit();

?>