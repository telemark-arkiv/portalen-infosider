<?php
namespace Craft;

class Tfk_portalen_search_ApiService extends BaseApplicationComponent
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
        $plugin = craft()->plugins->getPlugin('tfk_portalen_search');
        $settings = $plugin->getSettings();

        return $settings->$strSettings;
    }

}
