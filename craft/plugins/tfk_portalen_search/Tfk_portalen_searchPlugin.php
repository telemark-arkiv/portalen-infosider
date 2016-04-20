<?php
namespace Craft;

class Tfk_portalen_searchPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Telemarkportalen søk');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'Vangen&Plotz';
    }

    function getDeveloperUrl()
    {
        return 'http://www.vangenplotz.no';
    }


    public function getSettingsHtml()
    {
        return craft()->templates->render('tfk_portalen_search/_settings', array('settings' => $this->getSettings()));
    }

    protected function defineSettings()
    {
        return array(
            );
    }

    public function hasCpSection()
    {

        return true;
    }

//    public function registerCpRoutes()
//    {
//        return array(
//            'cronImport'=> array('action' => 'finnImport/import/importFromFinn'),
//        );
//    }
    public function registerSiteRoutes()
    {
//        return array(
//            'cronImport'=> array('action' => 'finnImport/import/importFromFinn'),
//        );
    }
    public function getMySetting()
    {
        $plugin = craft()->plugins->getPlugin('tfk_portalen_search');
        $settings = $plugin->getSettings();

        return $settings->mySetting;
    }
}
