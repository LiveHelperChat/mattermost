<?php

class erLhcoreClassModelMattermostUser
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_mm_user';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionMattermost::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'lhc_user_id' => $this->lhc_user_id,
            'mm_user_id' => $this->mm_user_id,
        );
    }

    public $id = null;

    public $lhc_user_id = null;

    public $mm_user_id = null;

}

?>
