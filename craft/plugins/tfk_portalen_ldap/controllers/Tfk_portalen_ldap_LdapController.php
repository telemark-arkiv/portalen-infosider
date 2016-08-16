<?php

namespace Craft;

use Mockery\CountValidator\Exception;


class Tfk_portalen_ldap_LdapController extends BaseController
{
	protected $allowAnonymous = array('ldapLogin','ldapLogout');

	public function actionLdapLogout(){
		craft()->httpSession->add('loginError', false);
		craft()->httpSession->add('ldapUser', false);
		return;
	}
	/**
	 * @param  [type]
	 * @param  [type]
	 * @return [type]
	 */
	public function actionLdapLogin() {
		$strDomain = $_SERVER['HTTP_HOST'];
		// dummly login on devserver.
		if($strDomain === 'dev.telemarkportalen.vpdev.no')
		{
			
		}
    craft()->httpSession->add('ldapUser', true);
      return;
		craft()->httpSession->add('loginError', false);

		$strLoginName = craft()->request->getPost('loginName');
		$strPassword = craft()->request->getPost('password');
				
		$strLdapServer =craft()->tfk_portalen_ldap_api->getMySetting('ldap_url');
		$strLdapPort= craft()->tfk_portalen_ldap_api->getMySetting('port');
		$strBindDn = craft()->tfk_portalen_ldap_api->getMySetting('bindDn');
		$strBindCredentials = craft()->tfk_portalen_ldap_api->getMySetting('bindCredentials');
		$strSearchBase = craft()->tfk_portalen_ldap_api->getMySetting('searchBase');
		$strSearchFilter = craft()->tfk_portalen_ldap_api->getMySetting('searchFilter');
		$strSearchFilter = craft()->tfk_portalen_ldap_api->getMySetting('searchFilter');
		/*$strPathSSL = craft()->tfk_portalen_ldap_api->getMySetting('pathSert');
		//$bSSL = craft()->tfk_portalen_ldap_api->getMySetting('ssl');

		if($bSSL == 'on')
			$bSSL = true;
		*/

		ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);

		$ds = ldap_connect($strLdapServer,$strLdapPort);
  		
  		$ldapbind=false;
		if($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);


			$strUserBind = str_replace("__USERNAME__", $strLoginName, $strBindDn);

			
			// binding to ldap server
		    $ldapbind = ldap_bind($ds ,$strUserBind,$strPassword);
		    // verify binding
		    if ($ldapbind) {
		    	craft()->httpSession->add('ldapUser', true);
		      
		    }
		    else
		    	craft()->httpSession->add('loginError','Feil kombinasjon av brukernavn og passord');
		    
		
		}
		else {
			craft()->httpSession->add('loginError','Ikke kontakt med serveren.');
		}
	return ;    	
	}
}