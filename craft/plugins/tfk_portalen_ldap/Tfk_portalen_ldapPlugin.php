<?php
namespace Craft;

class Tfk_portalen_ldapPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Telemarkportalen ldap authentication');
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
        return craft()->templates->render('tfk_portalen_ldap/_settings', array('settings' => $this->getSettings()));
    }

    protected function defineSettings()
    {
        return array(
            'ldap_url' => array(AttributeType::String, 'required' => true),
            'bindDn' => array(AttributeType::String, 'required' => true),  
            'bindCredentials' => array(AttributeType::String, 'required' => true),    
            'searchBase' => array(AttributeType::String, 'required' => true),
            'searchFilter' => array(AttributeType::String, 'required' => true),     
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
        $plugin = craft()->plugins->getPlugin('tfk_portalen_ldap');
        $settings = $plugin->getSettings();

        return $settings->mySetting;
    }
}
