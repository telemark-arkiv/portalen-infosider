<?php
namespace Craft;

class Tfk_portalen_ssoPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Telemarkportalen infosider sso');
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
        return craft()->templates->render('tfk_portalen_sso/_settings', array('settings' => $this->getSettings()));
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
        $plugin = craft()->plugins->getPlugin('tfk_portalen_sso');
        $settings = $plugin->getSettings();

        return $settings->mySetting;
    }
}
