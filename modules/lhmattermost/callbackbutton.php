<?php

header('Content-type: application/json; charset=utf-8');

$payload = json_decode(file_get_contents('php://input'),true);

$chat = erLhcoreClassModelChat::fetch((int)$Params['user_parameters']['id']);

if ($chat instanceof erLhcoreClassModelChat) {
    $chatVariables = $chat->chat_variables_array;
    if (isset($chatVariables['mm_ch_id'])) {
        $response = erLhcoreClassMattermostValidator::processAcceptChat($chat, $payload);
        echo json_encode([
            "update" => [
                "message" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'Chat was accepted by the') . ' ' . $response['operator'],
                "props" => []
            ],
            "ephemeral_text" => erTranslationClassLhTranslation::getInstance()->getTranslation('module/mattermost', 'You were assigned to the chat! [Open a chat]')."(" . $response['url'] . ")"
        ], JSON_FORCE_OBJECT);
    }
}

exit();