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
		
		craft()->httpSession->add('loginError', false);

		$strLoginName = craft()->request->getPost('loginName') . "@login.top.no";
		$strPassword = craft()->request->getPost('password');
		$strLdapServer =craft()->tfk_portalen_ldap_api->getMySetting('ldap_url');
		$strLdapPort= craft()->tfk_portalen_ldap_api->getMySetting('port');
		$strBindDn = craft()->tfk_portalen_ldap_api->getMySetting('bindDn');
		$strBindCredentials = craft()->tfk_portalen_ldap_api->getMySetting('bindCredentials');
		$strSearchBase = craft()->tfk_portalen_ldap_api->getMySetting('searchBase');
		$strSearchFilter = craft()->tfk_portalen_ldap_api->getMySetting('searchFilter');
		$strSearchFilter = craft()->tfk_portalen_ldap_api->getMySetting('searchFilter');


		$ldapconn = ldap_connect($strLdapServer)
		          or die("Could not connect to {$ldaphost}");
  		
  		
		if($ldapconn) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			
		    $bind = ldap_bind($ldapconn, $strBindDn, $strBindCredentials);
		    $strSearchFilter =  str_replace("__USERNAME__",$strLoginName, $strSearchFilter);
		   
		    $search = ldap_search($ldapconn, $strSearchBase, $strSearchFilter) or die ("Error in search query: ".ldap_error($ldapconn));
			$data = ldap_get_entries($ldapconn, $search);
			
		    if (ldap_bind($ldapconn, $strLoginName, $strPassword)){
		    	craft()->httpSession->add('ldapUser', true);
		    }
		    else {
		    	craft()->httpSession->add('loginError','Feil brukernavn/passord.');
		    	craft()->httpSession->add('ldapUser', false);
		    }	
		}
		else {
			craft()->httpSession->add('loginError','Ikke kontakt med serveren.');
		}
		return ;    	
	}
}