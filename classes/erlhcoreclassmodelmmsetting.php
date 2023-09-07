<?php
#[\AllowDynamicProperties]
class erLhcoreClassModelMattermostSetting
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_mm_setting';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionMattermost::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'dep_id' => $this->dep_id,
            'settings' => $this->settings,
            'active' => $this->active,
        );
    }

    public function __get($var)
    {
        switch ($var) {

            case 'settings_array':
                $jsonData = json_decode($this->settings, true);

                if ($jsonData !== null) {
                    $this->settings_array = $jsonData;
                } else {
                    $this->settings_array = $this->settings;
                }

                if (!is_array($this->settings_array)) {
                    $this->settings_array = array();
                }

                return $this->settings_array;

            case 'dep':
                $this->dep = false;
                if ($this->dep_id > 0) {
                    try {
                        $this->dep = erLhcoreClassModelDepartament::fetch($this->dep_id,true);
                    } catch (Exception $e) {

                    }
                }
                return $this->dep;


            default:
                break;
        }
    }

    public $id = null;

    public $dep_id = null;

    public $settings = '';

    public $active = 1;

}

?>
