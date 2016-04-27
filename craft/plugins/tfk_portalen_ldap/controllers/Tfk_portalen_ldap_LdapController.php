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

		$loginName = craft()->request->getPost('loginName');
		$password = craft()->request->getPost('password');
				
		$strLdapServer =craft()->tfk_portalen_ldap_api->getMySetting('ldap_url');
		$strLdapPort= "389";
		$strBindDn = craft()->tfk_portalen_ldap_api->getMySetting('bindDn');
		$strBindCredentials = craft()->tfk_portalen_ldap_api->getMySetting('bindCredentials');
		$strSearchBase = craft()->tfk_portalen_ldap_api->getMySetting('searchBase');
		$strSearchFilter = craft()->tfk_portalen_ldap_api->getMySetting('searchFilter');

		ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);

		$ds = ldap_connect($strLdapServer,$strLdapPort);
  		
  		$ldapbind=false;
		if($ds) {
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);


			$strUserBind = 'dc=domain,dc=com,uid=riemann';

			// binding to ldap server
		    $ldapbind = ldap_bind($ds ,$strUserBind,"password");//,$strBindDn,$strPassword);
		    // verify binding
		    if ($ldapbind) {
		    	craft()->httpSession->add('ldapUser', true);
		       /*$r = ldap_search( $ds, "dc=example,dc=com",'sn='.$strUsername);
		       if($r){
		       		
		       		
		       		$result = ldap_get_entries( $ds, $r);
		       		if($result['count'] >0) {
		       			
		       		}
		       }
		       else {
		       		craft()->httpSession->add('loginError','Feil kombinasjon av brukernavn og passord');
		       }
		       */
		       
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