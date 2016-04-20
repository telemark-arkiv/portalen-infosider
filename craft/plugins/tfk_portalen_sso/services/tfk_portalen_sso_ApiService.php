<?php
namespace Craft;

class Tfk_portalen_sso_ApiService extends BaseApplicationComponent
{
    /**
     *
     * Get settings defined in amdin module
     *
     * @param $strSettings
     * @return mixed
     */
    public function getMySetting($strSettings)
    {
        $plugin = craft()->plugins->getPlugin('tfk_portalen_sso');
        $settings = $plugin->getSettings();

        return $settings->$strSettings;
    }

}
