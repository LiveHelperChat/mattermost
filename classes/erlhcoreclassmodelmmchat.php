<?php

class erLhcoreClassModelMattermostChat
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_mm_chat';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionMattermost::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'ctime' => $this->ctime,
            'chat_id' => $this->chat_id,
            'mm_ch_id' => $this->mm_ch_id,
        );
    }

    public $id = null;

    public $ctime = null;

    public $chat_id = 0;

    public $mm_ch_id = '';

}

?>
