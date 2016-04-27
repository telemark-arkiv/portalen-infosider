<?php

	namespace Craft;

	/**
	* 
	*/
	class Tfk_portalen_ldapVariable
	{
		public function testPlugin(){
			craft()->httpSession->add( 'ldapUser',false );
		}

		public function getErrorMessage() {
			return craft()->httpSession->get('loginError');
		}

		public function getLoginStatus() {
			return craft()->httpSession->get( 'ldapUser' );
		}

		
		public function login($strUsername=null,$strPassword=null) {
				$bValidUser = false;
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
				    $ldapbind = ldap_bind($ds , $strUserBind,"password");//,$strBindDn,$strPassword);

				    // verify binding
				    if ($ldapbind) {
				    	print "ping";
				       $r = ldap_search( $ds, "dc=example,dc=com",'sn='.$strUsername);

				       if($r){
				       		
				       		
				       		$result = ldap_get_entries( $ds, $r);
				       		if($result['count'] >0)
				       			$bValidUser = true;
				        
				       }
				       
				    }
				    else
				    	print "pong";
				    
				return $bValidUser;    
				}
    /*

          			ldap_set_option($ds, LDAP_OPT_TIMELIMIT, 10);
          		 	$ldapbind=false;

				   if(ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3)){
				      if(ldap_set_option($ds, LDAP_OPT_REFERRALS, 0)){
				         if(ldap_start_tls($ds)) {
				              $ldapbind = @ldap_bind($ds, $strUsername, $strPassword);    
				         }
				         
				      }
				      else {
				      	echo "set_option ref failed";
				      }
				   }
				   else 
				   	echo "set_option version failed";
				   ldap_close($ds);

				   if(!$ldapbind)
				      echo "ERROR";
				   else
				      echo "OK";
				}
				else {
					echo "ds failed";
				}
			   // $ldapServer =  craft()->tfk_portalen_ldap_api->getMySetting("hitsPerPage");
			   
				//print $ldapServer;
			   // $ldap = ldap_connect($adServer) or die("could not connect to {$adServer}");
			    /*$username = "stian";
			    $password = "test";
			    $strSearchBase = "OU=TFK,dc=login,dc=top,DC=no";
			    $strSearchFilter = "(sAMAccountName={{username}})";

			    $ldaprdn = 'daps://139.164.159.38:636' . "\\" . $username;

			    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

			    $bind = @ldap_bind($ldap, $ldaprdn, $password);


			    if ($bind) {
			        $filter=$strSearchFilter;
			        $result = ldap_search($ldap,$strSearchBase,$filter);
			        ldap_sort($ldap,$result,"sn");
			        $info = ldap_get_entries($ldap, $result);
			        for ($i=0; $i<$info["count"]; $i++)
			        {
			            if($info['count'] > 1)
			                break;
			            echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
			            echo '<pre>';
			            var_dump($info);
			            echo '</pre>';
			            $userDn = $info[$i]["distinguishedname"][0]; 
			        }
			        @ldap_close($ldap);
			    } else {
			        $msg = "Invalid email address / password";
			        echo $msg;
			    }
				*/
			
			
		}

	}

?>