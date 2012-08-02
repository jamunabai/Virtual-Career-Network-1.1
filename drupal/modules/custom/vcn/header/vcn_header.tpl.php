<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

	// function used to encode urls for the bounceback script
	
	function encodeIt($string1){
        $search = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "#", "[", "]");
        $replace = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D');
        $newstring = str_replace($search, $replace, $string1);
        return($newstring);
    }

    // debugging switch for testing - 0 is off
	// setting debug switch to 1 shows data flow
	// setting debug switch to 2, shows current headers.
	// setting debug switch to 3 displays browser identification
	
    $debug = 0;
	
    // extract and connect to hvcp database
	
    $dbpull .= hvcp_get_db_url();
    $tempArr1=explode("/",$dbpull);
    $tempArr2=explode(":",$tempArr1[2]);
    $dbuser=$tempArr2[0];
    $tempArr3=explode("@",$tempArr2[1]);
    $dbpass=$tempArr3[0];
    $dbserver=$tempArr3[1].":3306";
    unset($tempArr1,$tempArr2,$tempArr3);
    $connection = mysql_connect($dbserver,$dbuser,$dbpass)   or die("Error making database connection: ".mysql_error());
    $db = mysql_select_db('hvcp',$connection)   or die("Error selecting database: ".mysql_error());
	
    // get the drupal user id and profile
	
    global $user;
    $profile = profile_load_profile($user);
	
    // session variable and flag to determine whether the user is in provider portal or regular login page 
	
    $user_is_provider = false;
    
    if ($user->uid > 0 && (!empty($user->profile_provider_id))) {
        $user_is_provider = true;
        session_start();
        
        if ($_SESSION['provider'] == 0 && $_GET['toggleflag'] == 'true') {
            $_SESSION['provider']=1;
        }

        elseif ($_GET['toggleflag'] == 'false') {
            $_SESSION['provider']=0;
        }

        //echo "Views=". $_SESSION['provider'];
    }

    // determine if this is a proctor viewing a secured test page
	
    $curr_uri = $_SERVER['REQUEST_URI'];
    $proctor_secured = proctor_secured_page($user, $curr_uri);
	
    // test the page to see it is a forum or not - is now used throughout
	
    $isforum = (is_forum_page($_SERVER['REQUEST_URI']) || 
	            stristr($_SERVER['REQUEST_URI'],'/forum') || 
				stristr($_SERVER['REQUEST_URI'],'/comment/reply') || 
				stristr($_SERVER['REQUEST_URI'],'filter/tips'));
				
    $provider_osp_page = (($user->profile_provider_id &&    
	                      !$_SESSION['provider'] &&   
						  (strpos($_SERVER['REQUEST_URI'],"/osp")!==false || 
						   strpos($_SERVER['REQUEST_URI'],"/forum")!=false)) &&   
						  (stristr($_SERVER['HTTP_USER_AGENT'],"Firefox/7") || 
						  stristr($_SERVER['HTTP_USER_AGENT'],"Firefox/8")));
	
    // if the learning-inventory-output panel is accessed do not show any of the header
    
    if (strpos($_SERVER['REQUEST_URI'],"/learning-inventory-output") === false) {
	
        // make sure that the provider will be redirected to home page no matter where the user is coming from 
		
        $profile = profile_load_profile($user);
        $links = base_path();
        // load up the questions for the assessment
        $query="SELECT * FROM vcn_app_properties";
        $result=mysql_query($query)   or die("Error running query: ".mysql_error());
        while ($row = mysql_fetch_assoc($result)) {
            
            if ($row['ID'] == 3) {
                $providerEmail = $row['VALUE'];
            }

            elseif ($row['ID'] == 4) {
                $appVersionDrupal = $row['VALUE'];
            }

            elseif ($row['ID'] == 5) {
                $appVersionMoodle = $row['VALUE'];
            }

        }

        echo "\n\n\n\n";
        echo '<!-- ' . "\n";
        echo 'CURRENT_PHP_SERVER=' . $GLOBALS['hvcp_config_php_server_name'] . "\n";
        echo 'CURRENT_DRUPAL_CODE_VERSION=' . $appVersionDrupal . "\n";
        echo 'CURRENT_MOODLE_CODE_VERSION=' . $appVersionMoodle . "\n";
        echo '-->' . "\n";
        echo "\n\n\n\n";
        
        if (!empty($_POST['username']) && 
		    !empty($_POST['userfirstname']) && 
			!empty($_POST['userlastname'])) {
            drupal_set_message('Your information has been sent to VCN.org to be authorized.  If you are authorized you will receive an E-mail with your login information');
            $email = $providerEmail;
            $body = "\r\n";
            $body .= "User First Name: ".$_POST["userfirstname"]."<br>"."\r\n";
            $body .= "User Last Name: ".$_POST["userlastname"]."<br>"."\r\n";
            $body .= "Username: ".$_POST["username"]."<br>"."\r\n";
            $body .= "E-mail Address: ".$_POST["emailid"]."<br>"."\r\n";
            $body .= "User Title: ".($_POST["title"])."<br>"."\r\n";
            $body .= "User Phone: ".($_POST["phone"])."<br>"."\r\n";
            $body .= "Institution Name: ".$_POST["institutionname"]."<br>"."\r\n";
            $body .= "Institution Website: ".$_POST["institutionwebsite"]."<br>"."\r\n";
            $body .= "Disclaimer Response: ".($_POST["disclaimer"])."<br>"."\r\n";
            $params = array('subject' => t('Provider Portal Registration'),'body' => t($body),);
            drupal_provider_mail('provider', 'provider', $email, $language, $params, $from = NULL, $send = TRUE);
			
            // Provider Registration and Updates to Profile/Program Should be Logged 
			
            $today = date("F j, Y, g:i a");
            $bodylog = "-"."\r\n"."--------------------------------Begin $today --------------------------------"."\r\n".$body."\r\n"."----------------------------------End $today --------------------------------";
            
            if ($_SERVER['SERVER_NAME'] == "localhost") {
                $myFile = "../careerladder/AppLogs/provider_registration.txt";
            } else {
                $myFile = "/usr/local/zend/apache2/htdocs/careerladder/AppLogs/provider_registration.txt";
            }

            //$myFile = "http://hvcp2-dev-portal.hvcp.local/careerladder/AppLogs/provider_registration.txt";
			
            $fh = fopen($myFile, 'a');
            $stringData = $bodylog;
            fwrite($fh, $stringData);
            fclose($fh);
        }
        
        if ($debug==1) {
            echo "<b>HEADER DEBUGGING MODE CURRENTLY ON.</b><br />";
            echo "Drupal User ID is: ".$user->uid."<br />";
            echo "Request_URI is ".$_SERVER['REQUEST_URI']."<br />";
            echo "Base Path is ".base_path()."<br />";
        }

        if ($debug==2) {
            $url=$_SERVER['REQUEST_URI'];
            echo "url is $url<br />";
            $myArr=get_headers($url,1);
            echo "<pre>";
            print_r($myArr);
            echo "</pre>";
        }

        // use the phpsniff routine loaded in the onet_assessment module to detect the browser
		
        $timer =& new phpTimer();
        $timer->start('client1');
        $sniffer_settings = array('check_cookies'=>$GET_VARS['cc'],  'default_language'=>$GET_VARS['dl'],  'allow_masquerading'=>$GET_VARS['am']);
        $client =& new phpSniff($GET_VARS['UA'],$sniffer_settings);
        $timer->stop('client1');
        
        if ($debug==3) {
            echo "client browser is ".$client->property('browser')."<br />";
            echo "client browser version is ".$client->property('version')."<br />";
        }

        // determine if there is a page redirect, upon login
        
        if (isset($_GET['href'])) {
            $href=$_GET['href'];
            $href=urldecode($href);
            $href_arr=explode("http://",$href);
            
            if(count($href_arr)==2) {
                $href=$href_arr[1];
            }

            $href_arr=explode("https://",$href);
            
            if(count($href_arr)==2) {
                $href=$href_arr[1];
            }
        
            if($debug==1) {
                echo "href supplied is $href<br />";
            }
        }

        // if this is a new instance, initialize the array
        
        if (!isset($_SESSION['bounceback'])) {
            $_SESSION['bounceback']=array();           
            if ($debug==1) {
                echo "bounceback session initialized<br />";
            }

        }
        
        if ($_SESSION['bounceback']['myPage']=="") {
            $_SESSION['bounceback']['myPage']=$_SERVER['REQUEST_URI'];            
            if ($debug==1) {
                echo "my last page set to ".$_SESSION['bounceback']['myPage']."<br />";
            }
        }
        
        if ($_SERVER['HTTP_REFERER']=="" && $_SESSION['bounceback']['myPage']!="") {
            $_SESSION['bounceback']['value']=$_SESSION['bounceback']['myPage'];       
            if ($debug==1) {
                echo "referer set to last value in myPage: ".$_SESSION['bounceback']['value']."<br />";
            }
        }
        
        if ($debug==1) {
            echo "Initial HTTP Referer is ".$_SERVER['HTTP_REFERER']."<br />";
        }

        // get the referer if it doesn't contain "/user"
        
        if (strpos($_SERVER['HTTP_REFERER'],"/user")===false) {
            $strip_arr=explode("http://",$_SERVER['HTTP_REFERER']);
            $strip_arr2=explode("https://",$_SERVER['HTTP_REFERER']);
            
            if (count($strip_arr)==2 || count($strip_arr2)==2) {               
                if (count($strip_arr)==2) {
                    $referer=$strip_arr[1];
                } else {
                    $referer=$strip_arr2[1];
                }
            } else {
                $referer=$_SERVER['HTTP_REFERER'];
            }
            
            if($debug==1) {
                echo "encoded http referer is $referer<br />";
            }
            
            if ($href!="") {
                $referer=encodeIt($href);
                
                if ($debug==1) {
                    echo "encoded href is $referer<br />";
                }
            }
            
            if ($referer=="") {
                $referer=encodeIt($_SERVER['SERVER_NAME'].base_path());                
                if($debug==1) {
                    echo "after empty referer test, referer is $referer<br />";
                }
            }
            $_SESSION['bounceback']['value']=$referer;
        }
        
        if ($debug==1) {
            echo "referer is ".$_SESSION['bounceback']['value']."<br />";
        }
        
        if ($_SESSION['bounceback']['myPage']!==$_SERVER['REQUEST_URI']) {
            $_SESSION['bounceback']['myPage']=$_SERVER['REQUEST_URI'];       
            if ($debug==1) {
                echo "my page set to ".$_SESSION['bounceback']['myPage']."<br />";
            }
        }

        // end header redirect section 
		
        $includes = drupal_get_path('module','vcn').'/cma';
        include_once('sites/all/modules/custom/vcn/cma/vcn_cma.theme.inc');
        $cma = vcnCma::getInstance();
		
        //print_r($cma->userid);
		
		// keep track of what step in the Guided Approach you were last on
        
        if (strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) {
            $_SESSION['bounceback']['GA']=$_SERVER['REQUEST_URI'];
        }
        
        if ($_SESSION['bounceback']['GA']=="") {
            $_SESSION['bounceback']['GA']=base_path()."getting-started";
        }

        if ($user->uid) {
            $urlga=$_SESSION['bounceback']['GA'];
        } else {
            $urlga=$_SESSION['bounceback']['GA'];
        }

        // load up questions for the assessment
		
        $query = "SELECT * FROM vcn_cma_user_notebook WHERE USER_ID = \"" . $cma->userid . "\"";
        $result = mysql_query($query)   or die("Error running query: ".mysql_error());
        $row = mysql_fetch_assoc($result);
		
        // javascript snippet to replace a href external links:
		// So, instead of <a href="someLink">someLink</a>, we use <a href="javascript:popit('someLink')">someLink</a>
		// Note the nested single quotes inside the double quotes.  Using all double quotes breaks the script.
		
        echo "<script type=\"text/javascript\">
		  function popit(url)
			{
			window.open(url,\"\",\"height=480,width=640,toolbar=0,resizable=1,scrollbars=1,menubar=1,status=0\");
			}
		  </script>";
		  
        // clear the array if user clicks on the reset button
        
        if (isset($_POST['gs_reset']) && $_POST['gs_reset']==1) {
            unset($_SESSION['ga_mem']);
        }

        // initialize mem array, if it doesn't exist
        
        if(!isset($_SESSION['ga_mem'])) {
            $_SESSION['ga_mem']=array();
            $_SESSION['ga_mem']['lastStep']=1;
            //echo "<b>Session initialized</b>";
        }

        $ga_mem = & $_SESSION['ga_mem'];
		
        //echo "Initial Session info is set to ".$_SESSION['ga_mem']['lastStep']." ";
		//for testing (to reset session last step to 1), uncomment the line below:
		//$_SESSION['ga_mem']=array("lastStep"=>1);
		// logo stuff
        
        if ($user->uid) {        
            if ($proctor_secured) {
                echo "
			  <div id=\"vcn-header\" style=\"height: 120px;\">
				<div id=\"vcn--block\" class=\"front\">
				  <a class=\"logo\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0; padding-right:222px;\"></a>
				</div><!-- vcn-logo-block -->
				<style>.breadcrumb {display: none;}</style>";
            } elseif (strpos($_SERVER['REQUEST_URI'],"provider")!==false || 
			           ($user_is_provider && 
					    $_SESSION['provider']==1)) {
                if (strpos($_SERVER['REQUEST_URI'],"getting-started") > 0) {
                    echo "
				      <div id=\"vcn-header\" style=\"height: 120px;\">
				      <div id=\"vcn-logo-block-provider\" class=\"front\">
					  <a class=\"logo\" href=\"".base_path()."\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
				      </div><!-- vcn-logo-block-provider -->
				      <style>.breadcrumb {display: none;}</style>";
                } elseif ($client->property('browser')=='mz' || 
				          $client->property('browser')=='ie') {
                    echo "
				      <div id=\"vcn-header\" style=\"height: 100px;\">
					  <div id=\"vcn-logo-block-provider\" class=\"front\">
					  <a class=\"logo\" href=\"".base_path()."?toggleflag=false\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
					  </div><!-- vcn-logo-block-provider -->";
                } else {
                    echo "
				      <div id=\"vcn-header\" style=\"height: 120px;\">
				      <div id=\"vcn-logo-block-provider\" class=\"front\">
				      <a class=\"logo\" href=\"".base_path()."?toggleflag=false\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
				      </div><!-- vcn-logo-block-provider -->";
                }
            } elseif ((strpos($_SERVER['REQUEST_URI'],"/osp")!==false || $isforum)) {
                echo "
			       <div id=\"vcn-header\" style=\"height: 120px;\">
			       <div id=\"vcn-logo-block\" class=\"front\" style=\"width: 344px;\">
			       <a class=\"logo-block\" href=\"".base_path()."\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
			       </div><!-- vcn-logo-block-provider -->";
            } else {      
                if (strpos($_SERVER['REQUEST_URI'],"getting-started")>0) {
                    echo "
			           <div id=\"vcn-header\" style=\"height: 120px;\">
			           <div id=\"vcn-logo-block\" class=\"front\">
			           <a class=\"logo\" href=\"".base_path()."\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
			           </div><!-- vcn-logo-block -->
			           <style>.breadcrumb {display: none;}</style>";
                } else {
                    echo "
			           <div id=\"vcn-header\" style=\"height: 120px;\">
			           <div id=\"vcn-logo-block\" class=\"front\">
			           <a class=\"logo\" href=\"".base_path()."\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
			           </div><!-- vcn-logo-block -->";
                }
            }
        } elseif (($_GET['user'] == 'provider') ||    
		          (strpos($_SERVER['REQUEST_URI'],"provider-faq")!==false) ||    
				  (strpos($_SERVER['REQUEST_URI'],"register?type=provider")!==false) ||    
				  (strpos($_SERVER['REQUEST_URI'],"user?type=provider")!==false) ||    
				  (strpos($_SERVER['REQUEST_URI'],"password?type=provider")!==false)) {
            echo "
		       <div id=\"vcn-header\" style=\"height: 100px;\">
		       <div id=\"vcn-logo-block-provider\" class=\"front\">
		       <a class=\"logo\" href=\"".base_path()."\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
		       </div><!-- vcn-logo-block-provider -->";
        } elseif ((strpos($_SERVER['REQUEST_URI'],"/osp")!==false || $isforum)) {
            echo "
		       <div id=\"vcn-header\" style=\"height: 120px;\">
			   <div id=\"vcn-logo-block\" class=\"front\" style=\"width: 344px;\">
			   <a class=\"logo-block\" href=\"".base_path()."\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
			   </div><!-- vcn-logo-block-provider -->";
        } else {      
            if (strpos($_SERVER['REQUEST_URI'],"getting-started")>0) {
                echo "
		           <div id=\"vcn-header\" style=\"height: 120px;\">
			       <div id=\"vcn-logo-block\" class=\"front\">
			       <a class=\"logo\" href=\"".base_path()."\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
			       </div><!-- vcn-logo-block -->
			       <style>.breadcrumb {display: none;}</style>";
            } else {
                echo "
		           <div id=\"vcn-header\" style=\"height: 120px;\">
			       <div id=\"vcn-logo-block\" class=\"front\">
			       <a class=\"logo\" href=\"".base_path()."\" title=\"Home\" alt=\"Home\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>
			       </div><!-- vcn-logo-block -->";
            }
        }
        
        if (($_GET['user'] == 'provider') || 
		    (strpos($_SERVER['REQUEST_URI'],"provider")!==false)) {
            echo "<div id=\"ajc-logo-block\" style=\"margin-left:-15px; width:70px; height:20px; background: transparent url(" . base_path() . 
   			      "sites/all/modules/custom/vcn/header/images/ajc_logo.png) 0px 0px no-repeat; float:left; \">
				  <a style=\"outline:0; width:70px; height:20px; padding:56px 80px; background: transparent url(" . base_path() . "sites/all/modules/custom/vcn/header/images/ajc_logo.png) 0px 0px no-repeat; float:left; \" href=\"javascript:popit('http://jobcenter.usa.gov/')\" title=\"AJC Logo\" alt=\"AJC Logo\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>	  
				  </div>";
        } elseif (($_SESSION['provider'] == 1) ||    
		          (strpos($_SERVER['REQUEST_URI'],"register?type=provider")!==false) ||    
				  (strpos($_SERVER['REQUEST_URI'],"user?type=provider")!==false) ||    
				  (strpos($_SERVER['REQUEST_URI'],"password?type=provider")!==false)) {
            echo "<div id=\"ajc-logo-block\" style=\"margin-left:0px; width:70px; height:20px; background: transparent url(" . base_path() .          
			      "sites/all/modules/custom/vcn/header/images/ajc_logo.png) 0px 0px no-repeat; float:left; \">
				  <a style=\"outline:0; width:70px; height:20px; padding:56px 80px; background: transparent url(" . base_path() . "sites/all/modules/custom/vcn/header/images/ajc_logo.png) 0px 0px no-repeat; float:left; \" href=\"javascript:popit('http://jobcenter.usa.gov/')\" title=\"AJC Logo\" alt=\"AJC Logo\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>	  
				  </div>";
        } elseif ($proctor_secured) {
            echo "<div id=\"ajc-logo-block\" style=\"width:70px; height:20px; background: transparent url(" . base_path() . 
			      "sites/all/modules/custom/vcn/header/images/ajc_logo.png) 0px 0px no-repeat; float:left; \">
				  <a style=\"outline:0; width:70px; height:20px; padding:56px 80px; background: transparent url(" . base_path() . "sites/all/modules/custom/vcn/header/images/ajc_logo.png) 0px 0px no-repeat; float:left; \" href=\"javascript:popit('http://jobcenter.usa.gov/')\" title=\"AJC Logo\" alt=\"AJC Logo\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>	  
				  </div>";
        } else {
            echo "<div id=\"ajc-logo-block\" style=\"margin-left:110px; width:70px; height:20px; background: transparent url(" . base_path() .  
			      "sites/all/modules/custom/vcn/header/images/ajc_logo.png) 0px 0px no-repeat; float:left; \">
				  <a style=\"outline:0; width:70px; height:20px; padding:56px 80px; background: transparent url(" . base_path() . "sites/all/modules/custom/vcn/header/images/ajc_logo.png) 0px 0px no-repeat; float:left; \" href=\"javascript:popit('http://jobcenter.usa.gov/')\" title=\"AJC Logo\" alt=\"AJC Logo\" style=\"text-decoration: none; border: 0 none; outline: 0;\"></a>	  
				  </div>";
        }

        // get the CMA information
		
        $vars['cma']= vcnCma::getInstance();
        
        if($user->uid) {
		
            // show welcome message, with special rules for proctor or provider
            
            if (!$proctor_secured) {              
                if (strpos($_SERVER['REQUEST_URI'],"provider")!==false) {
                    
                    if($vars['cma']->firstname!='') {
                        echo '<div id="vcn-header-user-name" style="color : #A71E28">Welcome, '.ucfirst($vars['cma']->firstname).'</div>';
                    } else {
                        echo '<div id="vcn-header-user-name" style="color : #A71E28">Welcome, '.ucfirst($user->name).'</div>';
                    }
                } else {
                    if($vars['cma']->firstname!='') {
                        echo '<div id="vcn-header-user-name" style="color : #A71E28">Welcome, <a style="text-decoration : none" href='. base_path().'cma/profile/view>'.ucfirst($vars['cma']->firstname) .'</a></div>';
                    } else {
                        echo '<div id="vcn-header-user-name" style="color : #A71E28">Welcome, <a style="text-decoration : none" href='. base_path().'cma/profile/view>'.ucfirst($user->name) .'</a></div>';
                    }
                }
            }
        }

        // fix div overlap issue
		
        echo "<div style=\"clear:both;\"></div>";
        
        if ($user_is_provider || ($_GET['type'] == 'provider') || (strpos($_SERVER['REQUEST_URI'],"provider")!==false)) {
            echo '<div style="color : #189AB0; position:absolute; margin-left: 336px; margin-top: -8px; font-size: 1.6em; font-weight: bold;"></div>';
        }
   
        if ((strpos($_SERVER['REQUEST_URI'],"/user")===false) &&    
		    (strpos($_SERVER['REQUEST_URI'],"user=provider")===false) &&   
			($proctor_secured===false)) {
            echo "<div id=\"vcn-header-navbar\" class=\"noresize\">";
			
            // prepare search box
			
            $searchblock = module_invoke('search', 'block', 'view');
            $searchbox =  $searchblock['content'];
			
            // prepare font resize button
			
            $fontresizeimg = base_path() . "/sites/all/themes/zen_hvcp/images/font_size.png";
            $fontresizebox = "<span><a title=\"Font Size\" alt=\"Font Size\" href=\"javascript: fontresize();\"><img alt=\"Select Font\" src=\"" . $fontresizeimg . "\"></a></span>";
			
            // add help links
            
            if ($provider_osp_page) {
                echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-bottom: 21px; margin-right: -8px; margin-top: -8px;\">";
            } elseif (($_GET['user'] == 'provider' || 
			          ($user_is_provider && $_SESSION['provider']==0)) && 
					   !$isforum) {               
                if ($client->property('browser')=='mz') {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right: -26px; margin-top: -8px\">";
                } elseif ($client->property('browser')=='sf' && strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-7px;\">";
                } elseif ($client->property('browser')=='ie') {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-25px; margin-top: -8px\">";
                } else {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\">";
                }
            } elseif (strpos($_SERVER['REQUEST_URI'],"/osp")!==false || 
			          $isforum) {           
                if ($client->property('browser')=='mz') {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-bottom: 21px; margin-right: -9px; margin-top: -8px;\">";
                } elseif ($client->property('browser')=='sf' && strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-7px;\">";
                } elseif ($client->property('browser')=='sf' && strpos($_SERVER['REQUEST_URI'],"getting-started")==false) {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-7px;\">";
                } elseif ($client->property('browser')=='ie') {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-25px; margin-top: -8px\">";
                } else {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\">";
                }
            } elseif ($user_is_provider && 
			          $_SESSION['provider']==1 || 
					  strpos($_SERVER['REQUEST_URI'],"provider-faq")!==false) {
                //print_r($client->property('browser')); 
                
                if ($client->property('browser')=='mz') {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right: -26px; margin-top: -43px;\">";
                } elseif ($client->property('browser')=='sf' && strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-7px;\">";
                } elseif (strpos($_SERVER['REQUEST_URI'],"provider-faq")!==false && $client->property('browser')=='sf') {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-7px; margin-top: -43px;\">";
                } elseif ($client->property('browser')=='ie') {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-25px; margin-top: -43px;\">";
                } else {
                    echo "<div id=\"vcn-help-links\" class=\"noresize\">";
                }
            } else {   
                if (strpos($_SERVER['REQUEST_URI'],"getting-started")>0) {          
                    if ($client->property('browser')=='mz') {
                        echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-8px;\">";
                    } elseif ($client->property('browser')=='sf' && strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) {
                        echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-7px;\">";
                    } elseif($client->property('browser')=='ie') {
                        echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-25px;\">";
                    } else {
                        echo "<div id=\"vcn-help-links\" class=\"noresize\">";
                    }
                } else {
                    if ($client->property('browser')=='mz') {
                        echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-28px;\">";
                    } elseif ($client->property('browser')=='sf' && strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) {
                        echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-7px;\">";
                    } elseif ($client->property('browser')=='ie') {
                        echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-25px;\">";
                    } else {
                        echo "<div id=\"vcn-help-links\" class=\"noresize\">";
                    }
                }
            } 

            if (($user_is_provider &&    ($_SESSION['provider']==1)) ||    (strpos($_SERVER['REQUEST_URI'],"provider-faq")!==false)) {           
                if ($user->uid) {
                    echo "<ul><li>";
                    
                    if (($client->property('browser')=='mz') && ((strpos($_SERVER['REQUEST_URI'],"begin?start=")!==false) ||  (strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) ||  ($testURLVal==$basePathTest))) {
                        echo "<li>$PHP_EOL
							  <a href=\"".base_path()."provider-faq\" title=\"FAQ\" alt=\"Help\"><img style=\"margin-right:10px;\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
							  </li>$PHP_EOL";
                    } else {
                        echo "<li>$PHP_EOL
							  <a href=\"".base_path()."provider-faq\" title=\"FAQ\" alt=\"Help\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" style=\"margin-right:10px;\"></a>$PHP_EOL
							  </li>$PHP_EOL";
                    }

                    echo "<div id=\"vcn-search-block\"></div>
						  </div> <!-- vcn-help-links -->
						  </div> <!-- vcn-header-navbar -->";
                } else {
                    echo  "<ul><li>";
                    
                    if (($client->property('browser')=='mz') && 
					    ((strpos($_SERVER['REQUEST_URI'],"begin?start=")!==false) ||  
						 (strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) ||  
						 ($testURLVal==$basePathTest))) {
                        echo "<li>$PHP_EOL
							  <a href=\"".base_path()."provider-faq\" title=\"FAQ\" alt=\"Help\"><img style=\"margin-right:10px;\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
							  </li>$PHP_EOL";
                    } else {
                        echo "<li>$PHP_EOL
							  <a href=\"".base_path()."provider-faq\" title=\"FAQ\" alt=\"Help\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
							  </li>$PHP_EOL";
                    }

                    echo "<div id=\"vcn-search-block\"></div>
						  </div> <!-- vcn-help-links -->
						  </div> <!-- vcn-header-navbar -->";
                }
            } elseif ($user_is_provider &&   ($_SESSION['provider']==0) &&   (strpos($_SERVER['REQUEST_URI'],"/osp")===false) &&   !$isforum) {
                echo  "<ul>";
                
                if ($user_is_provider && $_SESSION['provider']==0) {
                    echo '<li><a href="'.base_path().'provider?toggleflag=true" title ="Provider Portal" alt="Provider Portal"><img src="'.base_path().drupal_get_path('module','vcn_header').'/images/btn_provider.png" alt="Provider Portal"></a>';
                    echo '</li>';
                    
                    if ((strpos($_SERVER['REQUEST_URI'],"/osp")===false) || !$isforum) {
                        echo "<li>$PHP_EOL
				    	      <a href=\"".base_path()."osp\" title=\"Open Source Portal\" alt=\"Open Source Portal\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/open_source_portal.png\" alt=\"Open Source Portal\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    }

                }
    
                if (!$user->uid) {
                    echo "<li>$PHP_EOL
 				          <a href=\"".base_path()."providerlogin?user=provider\" title=\"Provider Portal\" alt=\"Provider Portal\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_provider.png\" alt=\"provider\" /></a>$PHP_EOL
				          </li>$PHP_EOL";
                }

                echo "<li>";
                $searchbox = str_replace('<div class="container-inline">','<div class="container-inline" style="height:20px;">',$searchbox);
                echo $searchbox;
                echo "</li>";
                echo "<li>
				      $fontresizebox
				      </li>
				      <!--
				      <li>$PHP_EOL
				      <a href=\"".base_path()."resources\" title=\"Resources\" alt=\"Resources\"><img class=\"resources-header-cma\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_resources.jpg\" alt=\"Generic Recourses\" /></a>$PHP_EOL
				      </li>$PHP_EOL
				      -->";
                
                if (strpos($_SERVER['REQUEST_URI'],"getting-started")===false) {
                    echo "<li>$PHP_EOL
				   <a href=\"$urlga\" title=\"Career Guide\"><img src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_get_started.png\" alt=\"Career Guide\"/></a>
				   </li>$PHP_EOL";
                    echo "<li>$PHP_EOL";
                }

                // get getting started user keys from HVCP DB
                
				$result = $vars['cma']->getUserKeyList(array('key_name'=>'module'));
                $resultactivity = $vars['cma']->getUserKeyList(array('key_name'=>'activity'));
                echo "</li>$PHP_EOL";
                
				// wish list / CMA button
                
                if (strpos($_SERVER['REQUEST_URI'],"getting-started")===false) {    
                    if ((!$user->uid) && !(empty($row))) {
                        echo "<li id='wish_list_icon'>$PHP_EOL
					          <a href=\"".base_path()."cma/notebook/careers\" title=\"Wish List\" alt=\"Wish List\"><img id=\"header-cma-wish-list-icon\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_wish_list.png\" alt=\"Wish List\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    } else {
                        echo "<li id='wish_list_icon'></li>";
                    }
                    
                    if ($user->uid) {
                        echo "<li>$PHP_EOL
					          <a href=\"". base_path()."cma/profile/view\" title=\"My CMA\" alt=\"My CMA\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_cma.png\" alt=\"My CMA\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    }
                }

                $testURLVal=str_replace("/","",$_SERVER['REQUEST_URI']);
                $basePathTest=str_replace("/","",base_path());
                
                if ($user->uid) {                  
                    if ($client->property('browser')=='mz' &&      
					    (strpos($_SERVER['REQUEST_URI'],"begin?start=")!==false ||   
						 strpos($_SERVER['REQUEST_URI'],"getting-started")!==false ||   
						 $testURLVal==$basePathTest)) {
                        echo "<li>$PHP_EOL
					   <a href=\"".base_path()."help\" title=\"FAQ\" alt=\"Help\"><img style=\"margin-right:0px;\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
					   </li>$PHP_EOL";
                    } else {
                        echo "<li>$PHP_EOL
					  <a href=\"".base_path()."help\" title=\"FAQ\" alt=\"Help\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
					  </li>$PHP_EOL";
                    }
                } else {
                    if ($client->property('browser')=='mz' &&    
					    (strpos($_SERVER['REQUEST_URI'],"begin?start=")!==false || 
						 strpos($_SERVER['REQUEST_URI'],"getting-started")!==false || 
						 $testURLVal==$basePathTest)) {
                        echo "<li>$PHP_EOL
					          <a href=\"".base_path()."help\" title=\"FAQ\" alt=\"Help\"><img style=\"margin-right:0px;\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    } else {
                        echo "<li>$PHP_EOL
					          <a href=\"".base_path()."help\" title=\"FAQ\" alt=\"Help\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    }
                }

                echo "<div id=\"vcn-search-block\"></div>
			    </div> <!-- vcn-help-links -->
			    </div> <!-- vcn-header-navbar -->";
            } elseif (strpos($_SERVER['REQUEST_URI'],"/osp")!==false || $isforum) {
                echo  "<ul>";
                echo"<li>";
                $searchbox=str_replace('<div class="container-inline">','<div class="container-inline" style="height:20px;">',$searchbox);
                echo $searchbox;
                echo "</li>";
                echo  "<ul>";
                echo "<div id=\"vcn-search-block\"></div>
				      </div> <!-- vcn-help-links -->
				      </div> <!-- vcn-header-navbar -->";
            } else {
                echo  "<ul>";
                
                if (in_array("proctor",$user->roles)) {
                    echo "<li>$PHP_EOL
					<a href=\"".base_path()."tests\" title=\"Proctor\" alt=\"Proctor\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/proctor.png\" alt=\"provider\" /></a>$PHP_EOL
					</li>$PHP_EOL";
                }
                
                if (!$user->uid) {
                    echo "<li>$PHP_EOL
					<a href=\"".base_path()."providerlogin?user=provider\" title=\"Provider Portal\" alt=\"Provider Portal\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_provider.png\" alt=\"provider\" /></a>$PHP_EOL
					</li>$PHP_EOL";
                }
                
                if (strpos($_SERVER['REQUEST_URI'],"/osp")===false || 
				    !$isforum || 
					$user_is_provider && $_SESSION['provider']==0) {   
                    echo "<li>$PHP_EOL
				          <a href=\"".base_path()."osp\" title=\"Open Source Portal\" alt=\"Open Source Portal\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/open_source_portal.png\" alt=\"Open Source Portal\" /></a>$PHP_EOL
				          </li>$PHP_EOL";
                }

                echo "<li>";
                $searchbox = str_replace('<div class="container-inline">','<div class="container-inline" style="height:20px;">',$searchbox);
                echo $searchbox;
                echo "</li>";
                echo "<li>
				      $fontresizebox
				      </li>
				      <!--
				      <li>$PHP_EOL
				      <a href=\"".base_path()."resources\" title=\"Resources\" alt=\"Resources\"><img class=\"resources-header-cma\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_resources.jpg\" alt=\"Generic Recourses\" /></a>$PHP_EOL
				      </li>$PHP_EOL
				      -->";
                
                if (strpos($_SERVER['REQUEST_URI'],"getting-started")===false) {
                    echo "<li>$PHP_EOL
				          <a href=\"$urlga\" title=\"Career Guide\"><img src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_get_started.png\" alt=\"Career Guide\"/></a>
				          </li>$PHP_EOL";
                    echo "<li>$PHP_EOL";
                }

                // get getting started user keys from HVCP DB
                
				$result = $vars['cma']->getUserKeyList(array('key_name'=>'module'));
                $resultactivity = $vars['cma']->getUserKeyList(array('key_name'=>'activity'));
                echo "</li>$PHP_EOL";
                
				// wish list / CMA button
                
                if (strpos($_SERVER['REQUEST_URI'],"getting-started")===false) {
                    if ((!$user->uid) && !(empty($row))) {
                        echo "<li id='wish_list_icon'>$PHP_EOL
					   <a href=\"".base_path()."cma/notebook/careers\" title=\"Wish List\" alt=\"Wish List\"><img id=\"header-cma-wish-list-icon\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_wish_list.png\" alt=\"Wish List\" /></a>$PHP_EOL
					   </li>$PHP_EOL";
                    } else {
                        echo "<li id='wish_list_icon'></li>";
                    }
                   
                    if ($user->uid) {
                        echo "<li>$PHP_EOL
					  <a href=\"". base_path()."cma/profile/view\" title=\"My CMA\" alt=\"My CMA\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_cma.png\" alt=\"My CMA\" /></a>$PHP_EOL
					  </li>$PHP_EOL";
                    }
                }

                $testURLVal=str_replace("/","",$_SERVER['REQUEST_URI']);
                $basePathTest=str_replace("/","",base_path());
                
                if ($user->uid) {           
                    if ($client->property('browser')=='mz' &&  
					    (strpos($_SERVER['REQUEST_URI'],"begin?start=")!==false ||   
						 strpos($_SERVER['REQUEST_URI'],"getting-started")!==false ||   
						 $testURLVal==$basePathTest)) {
                        echo "<li>$PHP_EOL
					          <a href=\"".base_path()."help\" title=\"FAQ\" alt=\"Help\"><img style=\"margin-right:0px;\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    } else {
                        echo "<li>$PHP_EOL
					          <a href=\"".base_path()."help\" title=\"FAQ\" alt=\"Help\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    }
                } else {
                    if ($client->property('browser')=='mz' &&  
					    (strpos($_SERVER['REQUEST_URI'],"begin?start=")!==false ||   
						 strpos($_SERVER['REQUEST_URI'],"getting-started")!==false ||   
						 $testURLVal==$basePathTest)) {
                        echo "<li>$PHP_EOL
					          <a href=\"".base_path()."help\" title=\"FAQ\" alt=\"Help\"><img style=\"margin-right:0px;\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    } else {
                        echo "<li>$PHP_EOL
					          <a href=\"".base_path()."help\" title=\"FAQ\" alt=\"Help\"><img id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
					          </li>$PHP_EOL";
                    }
                }

                echo "<div id=\"vcn-search-block\"></div>
			          </div> <!-- vcn-help-links -->
			          </div> <!-- vcn-header-navbar -->"; 
            }
        }
        
        if ($_GET['user']=='provider') {
            echo "<div id=\"vcn-header-navbar\" class=\"noresize\">";
            
            if ($client->property('browser')=='mz') {
                echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right: -10px; margin-top: -43px;\">";
            } elseif ($client->property('browser')=='sf' && strpos($_SERVER['REQUEST_URI'],"getting-started")!==false) {
                echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-7px;\">";
            } elseif ($client->property('browser')=='ie') {
                echo "<div id=\"vcn-help-links\" class=\"noresize\" style=\"margin-right:-25px;\">";
            } else {
                echo "<div id=\"vcn-help-links\" class=\"noresize\">";
            }

            echo"<ul>";
            
            if ($client->property('browser')=='mz' && 
			    (strpos($_SERVER['REQUEST_URI'],"begin?start=")!==false ||  
				 strpos($_SERVER['REQUEST_URI'],"getting-started")!==false ||  
				 $testURLVal==$basePathTest)) {
                echo "<li>$PHP_EOL
				      <a href=\"".base_path()."provider-faq\" title=\"FAQ\" alt=\"Help\"><img style=\"margin-right:0px;\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
				      </li>$PHP_EOL";
            } else {
                echo "<li>$PHP_EOL
				      <a href=\"".base_path()."provider-faq\" title=\"FAQ\" alt=\"Help\"><img style=\"margin-top:-30px;\" id=\"header-cma\" src=\"".base_path().drupal_get_path('module','vcn_header')."/images/btn_help.png\" alt=\"Help\" /></a>$PHP_EOL
				      </li>$PHP_EOL";
            }

            echo "</ul>";
            echo "</div> <!-- vcn-help-links -->
		          </div> <!-- vcn-header-navbar -->";
        }

        // if the user isn't in the guided approach, display the menu...
        
        if ((strpos($_SERVER['REQUEST_URI'],"getting-started")===false) && 
		    (strpos($_SERVER['REQUEST_URI'],"/user")===false) && 
			($proctor_secured===false)) {
            
            if ((strpos($_SERVER['REQUEST_URI'],"/osp")!==false ||    
			     $isforum) &&   
			    ($client->property('browser')=='ie' ||    
				$client->property('browser')=='sf')) {
                echo "<div id=\"vcn-header-links\" class=\"front\" style=\"margin-top: 30px;\">";
            } else {
                echo "<div id=\"vcn-header-links\" class=\"front\"  >";
            }
            
            if (($_SERVER['REQUEST_URI']==base_path() ||    
			     $_SERVER['REQUEST_URI']==base_path()."/" ||    
				 strpos($_SERVER['REQUEST_URI'],'begin?start=')>0) ||  
				 (strpos($_SERVER['REQUEST_URI'],"/osp")!==false &&    
				  strpos($_SERVER['REQUEST_URI'],"osp/download")===false &&    
				  strpos($_SERVER['REQUEST_URI'],"osp/contribute")===false)) {
                echo "<div id=\"vcn-header-links-front-dark\"></div>";
            } else {
                echo "<div id=\"vcn-header-links-front\"></div>";
            }

            // Here, we are loading up the questions for the assessment
			
            $query="SELECT *
			  	    FROM   vcn_provider
				    WHERE  UNITID = \"".$user->profile_provider_id."\"";
            $result=mysql_query($query)or die("Error running query: ".mysql_error());
            $row=mysql_fetch_assoc($result);
            
            if (strpos($_SERVER['REQUEST_URI'],"/osp")>0 || $isforum) {
                
                if (strpos($_SERVER['REQUEST_URI'],"/osp")!==false &&  strpos($_SERVER['REQUEST_URI'],"osp/download")===false &&  strpos($_SERVER['REQUEST_URI'],"osp/contribute")===false) {
                    $cssclassosp = "leaf first active-trail";
                    $cssclassdownload = "leaf";
                    $cssclasscontribute = "leaf";
                    $cssclassforum = "leaf last";
                } elseif (strpos($_SERVER['REQUEST_URI'],"osp/download")!==false) {
                    $cssclassosp = "leaf first";
                    $cssclassdownload = "leaf active-trail";
                    $cssclasscontribute = "leaf";
                    $cssclassforum = "leaf last";
                } elseif (strpos($_SERVER['REQUEST_URI'],"osp/contribute")!==false) {
                    $cssclassosp = "leaf first";
                    $cssclassdownload = "leaf";
                    $cssclasscontribute = "leaf active-trail";
                    $cssclassforum = "leaf last";
                } elseif ($isforum) {
                    $cssclassosp = "leaf first";
                    $cssclassdownload = "leaf";
                    $cssclasscontribute = "leaf";
                    $cssclassforum = "leaf last active-trail";
                }

                ?>
			    <div id="vcn-primary-links">
			      <ul class="menu">
				    <li class="<?php  echo $cssclassosp; ?>"><a class="active" title="Welcome" href="<?php  echo base_path(); ?>osp">Welcome</a></li>
				    <li class="<?php  echo $cssclassdownload; ?>"><a title="Download" href="<?php  echo base_path()."osp/download"; ?>">Download</a></li>
				    <li class="<?php  echo $cssclasscontribute; ?>"><a title="Contribute" href="<?php  echo base_path()."osp/contribute"; ?>">Contribute</a></li>
				    <li class="<?php  echo $cssclassforum; ?>"><a title="Forum" href="<?php  echo base_path()."forum"; ?>">Forum</a></li>
			      </ul>
			    </div>
			    <?php 
            } elseif ($_GET['user'] == 'provider' ||    
			          (strpos($_SERVER['REQUEST_URI'],"provider-faq")!==false) &&    
					   !$user->uid){
                ?>
			    <ul class="menu">
				  <li><a class="active" title="Home Page" href="<?php  echo base_path().'providerlogin?user=provider'; ?> ">Home</a></li>
				  <li></li>
			    </ul>
			    <?php 
            } elseif (($user->uid && 
			          strpos($_SERVER['REQUEST_URI'],"provider")!==false || 
					  !empty($user->profile_provider_id)) && 
					  $_SESSION['provider']==1) {
                
                if (strpos($_SERVER['REQUEST_URI'],"school/unitid")!==false) {
                    $cssclasshome = "leaf first";
                    $cssclassprofile = "leaf active-trail";
                    $cssclassprogram = "leaf";
                    $_SESSION['provider'] = 1;
                } elseif(strpos($_SERVER['REQUEST_URI'],"program")!==false) {
                    $cssclasshome = "leaf first";
                    $cssclassprofile = "leaf";
                    $cssclassprogram = "leaf active-trail";
                    $_SESSION['provider'] = 1;
                } elseif(strpos($_SERVER['REQUEST_URI'],"healthcare")!==false && strpos($_SERVER['REQUEST_URI'],"provider-faq")===false) {
                    $cssclasshome = "leaf first active-trail";
                    $cssclassprofile = "leaf";
                    $cssclassprogram = "leaf";
                    
                    if(!empty($user->profile_provider_id)){
                        $_SESSION['provider'] = 1;
                    }
                }

                ?>
		        <div id="vcn-primary-links">
			      <ul class="menu">
			     	<li class="<?php  echo $cssclasshome; ?>"><a class="active" title="Home Page" href="<?php  echo base_path(); ?>provider">Home</a></li>
				    <li class="<?php  echo $cssclassprofile; ?>"><a title="Profile" href="<?php  echo base_path()."find-learning/detail/school/unitid/".$row['UNITID']; ?>">Profile</a></li>
				    <li class="<?php  echo $cssclassprogram; ?>"><a title="Programs" href="<?php  echo base_path()."find-learning/results/programs/unitid/".$row['UNITID']; ?>">Programs</a></li>
			      </ul>
		        </div>
		        <?php 
            } elseif ($proctor_secured) {
              
			  // no vcn-primary-links
    	    } else {
                echo "  <div id=\"vcn-primary-links\">";
				
                // because the "Take a Course Online" section doesn't properly highlight, I added this code to fix it.
				
                $block = module_invoke('menu', 'block', 'view', 'primary-links');
                $search="<li class=\"leaf\"><a href=\"".base_path()."online-courses/take-online/\" title=\"Take a course online\">Take a Course Online</a></li>";
                $replace="<li class=\"leaf active-trail\"><a href=\"".base_path()."online-courses/take-online/\" title=\"Take a course online\" class=\"active\">Take a Course Online</a></li>";
                
                if (strpos($_SERVER['REQUEST_URI'],"/online-courses/take-online/")!==false) {
                    $block['content']=str_replace($search,$replace,$block['content']);
                }

                // using the same trick to highlight Choose a Career when in Career Details
				
                $search="<li class=\"leaf\"><a href=\"".base_path()."explorecareers\" title=\"Choose a Career\">Choose a Career</a></li>";
                $replace="<li class=\"leaf active-trail\"><a href=\"".base_path()."explorecareers\" title=\"Choose a Career\" class=\"active\">Choose a Career</a></li>";
                
                if (strpos($_SERVER['REQUEST_URI'],"/careerdetails")!==false ||  
				    strpos($_SERVER['REQUEST_URI'],"/careergrid")!==false ||  
					strpos($_SERVER['REQUEST_URI'],"/interest-profiler")!==false ||  
					strpos($_SERVER['REQUEST_URI'],"/jobseekers")!==false ||  
					strpos($_SERVER['REQUEST_URI'],"/educationmatch")!==false) {
                    $block['content']=str_replace($search,$replace,$block['content']);
                }

                // doing it again for Get Qualified
				
                $search="<li class=\"leaf\"><a href=\"".base_path()."find-learning\" title=\"Get Qualified\">Get Qualified</a></li>";
                $replace="<li class=\"leaf active-trail\"><a href=\"".base_path()."find-learning\" title=\"Get Qualified\" class=\"active\">Get Qualified</a></li>";
                
                if (strpos($_SERVER['REQUEST_URI'],"/find-learning/results")!==false ||   
				    strpos($_SERVER['REQUEST_URI'],"/find-learning/financialaid")!==false ||   
					strpos($_SERVER['REQUEST_URI'],"/find-learning/detail")!==false ||   
					strpos($_SERVER['REQUEST_URI'],"/find-learning/resources")!==false) {
                    $block['content']=str_replace($search,$replace,$block['content']);
                }

                // doing it again for Take a Course Online - online course
				
                $search="<li class=\"leaf\"><a href=\"".base_path()."online-courses/take-online/\" title=\"Take a course online\">Take a Course Online</a></li>";
                $replace="<li class=\"leaf active-trail\"><a href=\"".base_path()."online-courses/take-online/\" title=\"Take a course online\" class=\"active\">Take a Course Online</a></li>";
                
                if (strpos($_SERVER['REQUEST_URI'],"online-courses")!==false ||   
				    (stristr($_SERVER['REQUEST_URI'],"/tests/") &&    
					 strpos($_SERVER['REQUEST_URI'],"/tests/list")===false) ||    
					 stristr($_SERVER['REQUEST_URI'],"testrequest")) {
                    $block['content'] = str_replace($search,$replace,$block['content']);
                }

                // now doing it for College Credit subsections
				
                $search="<li class=\"leaf\"><a href=\"".base_path()."pla\" title=\"Earn College Credits\">Earn College Credits</a></li>";
                $replace="<li class=\"leaf active-trail\"><a href=\"".base_path()."pla\" title=\"Earn College Credits\" class=\"active\">Earn College Credits</a></li>";
                
                if (strpos($_SERVER['REQUEST_URI'],"military-credit")!==false ||  
				    strpos($_SERVER['REQUEST_URI'],"college-courses")!==false ||  
					strpos($_SERVER['REQUEST_URI'],"placement-exams")!==false ||  
					strpos($_SERVER['REQUEST_URI'],"employer-training")!==false ||  
					strpos($_SERVER['REQUEST_URI'],"e-transcript")!==false) {
                    $block['content']=str_replace($search,$replace,$block['content']);
                }

                // now doing it for find work results
				
                $search="<li class=\"leaf\"><a href=\"".base_path()."findwork\" title=\"Find a Job\">Find a Job</a></li>";
                $replace="<li class=\"leaf active-trail\"><a href=\"".base_path()."findwork\" title=\"Find a Job\" class=\"active\">Find a Job</a></li>";
                
                if (strpos($_SERVER['REQUEST_URI'],"/findwork/")!==false ||  
				    strpos($_SERVER['REQUEST_URI'],"findworkresults")!==false) {
                    $block['content']=str_replace($search,$replace,$block['content']);
                }

                // now doing it for office locator
				
                $search="<li class=\"leaf last\"><a href=\"".base_path()."office-locator\" title=\"Office Locator\">Office Locator</a></li>";
                $replace="<li class=\"leaf last active-trail\"><a href=\"".base_path()."office-locator\" title=\"Office Locator\" class=\"active\">Office Locator</a></li>";
                
                if(strpos($_SERVER['REQUEST_URI'],"/office-locator/")!==false)  {
                    $block['content']=str_replace($search,$replace,$block['content']);
                }

                // make sure the menu is always http for not logged in user and https for a logged in user 
                
                print $block['content'];
                echo " </div><!-- vcn-primary-links -->";
            }

            echo "<!-- <div class=\"menu-spacer\">&nbsp;</div>-->
			 <div id=\"vcn-secondary-links\">
			 <ul class=\"menu\">";
            echo "<div id=\"vcn-header-links-end\"></div>";
			
            // make sure the logged in user has https for resource link and non logged in user has http for resource link
            
            if ($_GET['user']=='provider' ||    
			    strpos($_SERVER['REQUEST_URI'],"provider-faq")!==false ||    
				strpos($_SERVER['REQUEST_URI'],"/osp")!==false ||    
				$isforum) {
                
				// do nothing
				
            } elseif ($proctor_secured) {
                
				// for proctor, no resources
				
            } elseif ($user->uid && empty($user->profile_provider_id) || 
			          (!empty($user->profile_provider_id)&& $_SESSION['provider'] == 0)){
					  
                // this section fixes the highlighting issue for Resources
                
                if (strpos($_SERVER['REQUEST_URI'],"/resources")!==false &&    
				    strpos($_SERVER['REQUEST_URI'],"/find-learning/resources")!==true) {
                    echo "<li class=\"leaf first\" style=\"background: transparent url(".base_path()."sites/all/modules/custom/vcn/header/images/nav_bg_on.jpg) 0 0px no-repeat;\"><a style=\"text-decoration:none;\" title=\"Resources\" href=\"".base_path()."resources\">Resources</a></li>";
                } else {
                    echo "<li class=\"leaf first\"><a style=\"text-decoration:none;\" title=\"Resources\" href=\"".base_path()."resources\">Resources</a></li>";
                }
            } elseif (empty($user->profile_provider_id)) {
			
                // this section fixes the highlighting issue for Resources
                
                if (strpos($_SERVER['REQUEST_URI'],"/resources")!==false &&    
				    strpos($_SERVER['REQUEST_URI'],"/find-learning/resources")===false) {
                    echo "<li class=\"leaf first\" style=\"background: transparent url(".base_path()."sites/all/modules/custom/vcn/header/images/nav_bg_on.jpg) 0 0px no-repeat;\"><a style=\"text-decoration:none;\" title=\"Resources\" href=\"".base_path()."resources\">Resources</a></li>";
                } else {
                    echo "<li class=\"leaf first\"><a style=\"text-decoration:none;\" title=\"Resources\" href=\"".base_path()."resources\">Resources</a></li>";
                }
            }
            
            if ($user->uid) {
                echo "<li class=\"leaf last\"><a style=\"text-decoration:none;\" title=\"Sign Out\" href=\"http://".$_SERVER['SERVER_NAME'].base_path()."logout\">Sign Out</a></li>";
            } else {
                echo "<li class=\"leaf last\"><a style=\"text-decoration:none;\" title=\"Sign In\" href=\"https://".$_SERVER['SERVER_NAME'].base_path()."user\">Sign In</a></li>";
            }

            echo "</ul>
			      </div><!-- vcn-secondary-links -->
			      </div><!-- vcn-header-links -->";
        } elseif (strpos($_SERVER['REQUEST_URI'],"getting-started/start")!==false) {
		
            // the header for the getting started start page 
            ?>
		    <p>
			  <div class="progressBarContainer">
				  <div class="homeButton">
				  <img src="<?php  echo base_path(); ?>/sites/all/modules/custom/vcn/header/images/home.png" usemap="#homemap" width= 784px;>
				  <map name="homemap">
				  <area shape="rect" coords="0,0,80,35" href="<?php  echo base_path(); ?>" alt="Home" />
				  </map>
				  </div>
				  <div class="exploreButton"><a href="<?php  echo base_path(); ?>"><img alt="Explore on Your Own" src="<?php  echo base_path(); ?>/sites/all/modules/custom/vcn/header/images/ExploreOnYourOwn.jpg"></a></div>
			  </div>
		    </p>
		    <?php
		} elseif ((strpos($_SERVER['REQUEST_URI'],"/user")===false) &&   
		          ($proctor_secured===false)) {
				  
            // if the user is in the guided approach, display the progress bar instead of the menu
			
            echo "<p>";
            echo "<div class=\"progressBarContainer\">";
			
            // create the first progress bar item
            
			echo "";
            echo "<div class=\"progressBarLeftEndCapSelected\">&nbsp;</div>";
            echo "<div class=\"progressBarSelectedItem\"><a class=\"middleText\" href=\"".base_path()."\"><span class=\"verticalCenterText noresize\">Home</span></a></div>";
            
			// if it's step one, go green
            
            if (strpos($_SERVER['REQUEST_URI'],"step-one") !== false) {
                $selected=1;
                echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                echo "<div class=\"progressBarSelectedItem\">";
                echo "<div class=\"progressBarTopText\">Step 1</div>";
                echo "<div class=\"progressBarBottomText\">Get Started</div>";
                echo "</div>";
            } else {
            
  			    // else, go blue
                
				echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                echo "<div class=\"progressBarSelectedItem\">";
                echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-one\">";
                echo "<div class=\"progressBarTopText\">Step 1</div>";
                echo "<div class=\"progressBarBottomText\">Get Started</div>";
                echo "</a>";
                echo "</div>";
            }

            // Creating the second progress bar item 
            // if you're on step two...
            
            if (strpos($_SERVER['REQUEST_URI'],"step-two")>0) {
                echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                echo "<div class=\"progressBarSelectedItem\">";
                echo "<div class=\"progressBarTopText\">Step 2</div>";
                echo "<div class=\"progressBarBottomText\">Choose Career</div>";
                echo "</div>";
                
                if($_SESSION['ga_mem']['lastStep']==1) $_SESSION['ga_mem']['lastStep']=2;
                $selected=2;
            } else {
                
				// you're not on step 2
                // if the last selected step was one...
                
                if ($_SESSION['ga_mem']['lastStep']==1) {
                    echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                    echo "<div class=\"progressBarNonselectedItem\">";
                    echo "<div class=\"progressBarTopText\">Step 2</div>";
                    echo "<div class=\"progressBarBottomText\">Choose Career</div>";
                    echo "</div>";
                } else {
                
 				    // Step two was previously selected
                    
                    if ($selected==1) {
                        echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-two\">";
                        echo "<div class=\"progressBarTopText\">Step 2</div>";
                        echo "<div class=\"progressBarBottomText\">Choose Career</div>";
                        echo "</a>";
                        echo "</div>";
                    } else {
                        echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                        echo "<div class=\"progressBarSelectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-two\">";
                        echo "<div class=\"progressBarTopText\">Step 2</div>";
                        echo "<div class=\"progressBarBottomText\">Choose Career</div>";
                        echo "</a>";
                        echo "</div>";
                    }
                }
            }

            // Creating the third progress bar item 
			// if you're on step three...
            
            if (strpos($_SERVER['REQUEST_URI'],"step-three")>0) {
                echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                echo "<div class=\"progressBarSelectedItem\">";
                echo "<div class=\"progressBarTopText\">Step 3</div>";
                echo "<div class=\"progressBarBottomText\">Find Education</div>";
                echo "</div>";
                
                if($_SESSION['ga_mem']['lastStep']<3) {
				    $_SESSION['ga_mem']['lastStep']=3;
			    }
                $selected=3;
            } else {
			
                // you're not on step 3
				// if step three was previously selected...
                
                if ($_SESSION['ga_mem']['lastStep']>=3) {
                    
					// if the current step is step 2...
                    
                    if ($selected==2) {
                        echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-three\">";
                        echo "<div class=\"progressBarTopText\">Step 3</div>";
                        echo "<div class=\"progressBarBottomText\">Find Education</div>";
                        echo "</a>";
                        echo "</div>";
                    } elseif ($selected != 1 && $selected!=2) {
					
                        // elseif the current step is greater than step 3
						
                        echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                        echo "<div class=\"progressBarSelectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-three\">";
                        echo "<div class=\"progressBarTopText\">Step 3</div>";
                        echo "<div class=\"progressBarBottomText\">Find Education</div>";
                        echo "</a>";
                        echo "</div>";
                    } else {
					
                        // the current step is less than step 2
						
                        echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-three\">";
                        echo "<div class=\"progressBarTopText\">Step 3</div>";
                        echo "<div class=\"progressBarBottomText\">Find Education</div>";
                        echo "</a>";
                        echo "</div>";
                    }

                }

                elseif (strpos($_SERVER['REQUEST_URI'],"step-two")!==false) {
				
                    // if the current step is two...
					
                    echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                    echo "<div class=\"progressBarNonselectedItem\">";
                    echo "<div class=\"progressBarTopText\">Step 3</div>";
                    echo "<div class=\"progressBarBottomText\">Find Education</div>";
                    echo "</div>";
                } else {
				
                    // the last selected step was less than two...
					
                    echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                    echo "<div class=\"progressBarNonselectedItem\">";
                    echo "<div class=\"progressBarTopText\">Step 3</div>";
                    echo "<div class=\"progressBarBottomText\">Find Education</div>";
                    echo "</div>";
                }
            }

            // Creating the fourth progress bar item 
            // if you're on step four...
            
            if (strpos($_SERVER['REQUEST_URI'],"step-four")>0) {
                echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                echo "<div class=\"progressBarSelectedItem\">";
                echo "<div class=\"progressBarTopText\">Step 4</div>";
                echo "<div class=\"progressBarBottomText\">Prepare and Apply</div>";
                echo "</div>";
                
                if($_SESSION['ga_mem']['lastStep']<4) $_SESSION['ga_mem']['lastStep']=4;
                $selected=4;
            } else {
			
                // you're not on step 4
				// if step four was previously selected...
                
                if ($_SESSION['ga_mem']['lastStep']>=4) {
				
                    //if the current step is step 3...
                    
                    if ($selected==3) {
                        echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-four\">";
                        echo "<div class=\"progressBarTopText\">Step 4</div>";
                        echo "<div class=\"progressBarBottomText\">Prepare and Apply</div>";
                        echo "</a>";
                        echo "</div>";
                    } elseif ($selected != 1 && $selected!=2 && $selected!=3) {
                        // elseif the current step is greater than step 4
                        echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                        echo "<div class=\"progressBarSelectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-four\">";
                        echo "<div class=\"progressBarTopText\">Step 4</div>";
                        echo "<div class=\"progressBarBottomText\">Prepare and Apply</div>";
                        echo "</a>";
                        echo "</div>";
                    } else {
                        // the current step is less than step 4
                        echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-four\">";
                        echo "<div class=\"progressBarTopText\">Step 4</div>";
                        echo "<div class=\"progressBarBottomText\">Prepare and Apply</div>";
                        echo "</a>";
                        echo "</div>";
                    }
                } elseif (strpos($_SERVER['REQUEST_URI'],"step-three")!==false) {
                    // if the current step is three...
                    echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                    echo "<div class=\"progressBarNonselectedItem\">";
                    echo "<div class=\"progressBarTopText\">Step 4</div>";
                    echo "<div class=\"progressBarBottomText\">Prepare and Apply</div>";
                    echo "</div>";
                } else {
                    // the last selected step was less than two...
                    echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                    echo "<div class=\"progressBarNonselectedItem\">";
                    echo "<div class=\"progressBarTopText\">Step 4</div>";
                    echo "<div class=\"progressBarBottomText\">Prepare and Apply</div>";
                    echo "</div>";
                }
            }

            // Creating the fifth progress bar item 
            // if you're on step five...
            
            if (strpos($_SERVER['REQUEST_URI'],"step-five")>0) {
                echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                echo "<div class=\"progressBarSelectedItem\">";
                echo "<div class=\"progressBarTopText\">Step 5</div>";
                echo "<div class=\"progressBarBottomText\">
					  <div style=\"width: 87px; position:relative;\" class=\"noresize\">
					  Earn College Credit
					  </div>
				      </div>";
                echo "</div>";
                
                if ($_SESSION['ga_mem']['lastStep']<5) {
                    $_SESSION['ga_mem']['lastStep']=5;
                }

                $selected=5;
            } else {
			
                // you're not on step 5
				// if step five was previously selected...
                
                if ($_SESSION['ga_mem']['lastStep']>=5) {
				
                    //if the current step is step 4...
                    
                    if ($selected==4) {
                        echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-five\">";
                        echo "<div class=\"progressBarTopText\">Step 5</div>";
                        echo "<div class=\"progressBarBottomText\">
						<div style=\"width: 87px; position:relative;\" class=\"noresize\">
						Earn College Credit
						</div>
					    </div>";
                        echo "</a>";
                        echo "</div>";
                    } elseif ($selected != 1 && $selected!=2 && $selected!=3 && $selected!=4) {
                        // elseif the current step is greater than step 5
                        echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                        echo "<div class=\"progressBarSelectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-five\">";
                        echo "<div class=\"progressBarTopText\">Step 5</div>";
                        echo "<div class=\"progressBarBottomText\">
						<div style=\"width: 87px; position:relative;\" class=\"noresize\">
						Earn College Credit
						</div>
					    </div>";
                        echo "</a>";
                        echo "</div>";
                    } else {
                        // the current step is less than step 5
                        echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/step-five\">";
                        echo "<div class=\"progressBarTopText\">Step 5</div>";
                        echo "<div class=\"progressBarBottomText\">
						<div style=\"width: 87px; position:relative;\" class=\"noresize\">
						Earn College Credit
						</div>
					    </div>";
                        echo "</a>";
                        echo "</div>";
                    }
                } elseif (strpos($_SERVER['REQUEST_URI'],"step-four")!==false) {
                    // if the current step is four...
                    echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                    echo "<div class=\"progressBarNonselectedItem\">";
                    echo "<div class=\"progressBarTopText\">Step 5</div>";
                    echo "<div class=\"progressBarBottomText\">
					  <div style=\"width: 87px; position:relative;\" class=\"noresize\">
					  Earn College Credit
					  </div>
					  </div>";
                    echo "</div>";
                } else {
                    // the last selected step was less than four...
                    echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                    echo "<div class=\"progressBarNonselectedItem\">";
                    echo "<div class=\"progressBarTopText\">Step 5</div>";
                    echo "<div class=\"progressBarBottomText\">
					 <div style=\"width: 87px; position:relative;\" class=\"noresize\">
					 Earn College Credit
					 </div>
				     </div>";
                    echo "</div>";
                }
            }

            // creating the progress bar summary item 
            // if you are on "finished"
            
            if (strpos($_SERVER['REQUEST_URI'],"finished")>0) {
                echo "<div class=\"progressBarSelectedToSelected\">&nbsp;</div>";
                echo "<div class=\"progressBarSelectedItem\">";
                echo "<span class=\"middleText noresize\">Summary</span>";
                echo "</div>";
                echo "<div class=\"progressBarRightEndCapSelected\">&nbsp;</div>";
                
                if ($_SESSION['ga_mem']['lastStep']!=6) {
                    $_SESSION['ga_mem']['lastStep']=6;
                }

                $selected=6;
            } else {
			
                // you're not on "finished"
                // if step 3 has been previously selected
                
                if ($_SESSION['ga_mem']['lastStep']==6) {
				
                    // if the current step is step 5
                    
                    if ($selected==5) {
                        echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a class=\"middleText\" href=\"".base_path()."getting-started/finished\">";
                        echo "<span class=\"verticalCenterText noresize\">Summary</span>";
                        echo "</a>";
                        echo "</div>";
                        echo "<div class=\"progressBarRightEndCapNonselected\">&nbsp;</div>";
                    } else {
                        // the current step is not step 5
                        echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                        echo "<div class=\"progressBarNonselectedItem\">";
                        echo "<a style=\"text-decoration: none; color: black;\" href=\"".base_path()."getting-started/finished\">";
                        echo "<span class=\"middleText noresize\">Summary</span>";
                        echo "</a>";
                        echo "</div>";
                        echo "<div class=\"progressBarRightEndCapNonselected\">&nbsp;</div>";
                    }

                } else {
				
                    // finished has not been previously selected
                    //if the current step is step 5
                    
                    if ($selected==5) {
                        echo "<div class=\"progressBarSelectedToNonselected\">&nbsp;</div>";
                    } elseif ($_SESSION['ga_mem']['lastStep']==5) {
					
                        // elseif step 5 has been previously selected
						
                        echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                    } else {
					
                        // the current step is not step 5 and it hasn't ever been selected
						
                        echo "<div class=\"progressBarNonselectedToNonselected\">&nbsp;</div>";
                    }

                    echo "<div class=\"progressBarNonselectedItem\"><span class=\"middleText noresize\">Summary</span></div>";
                    echo "</span>";
                    echo "<div class=\"progressBarRightEndCapNonselected\">&nbsp;</div>";
                }

            }

            // create Explore On Your Own button 
			
            echo "<div class=\"exploreButton\"><a href=\"".base_path()."\"><img alt=\"Explore on Your Own\"    src=\"".base_path()."/sites/all/modules/custom/vcn/header/images/ExploreOnYourOwn.jpg\"></a></div>";
            echo "</div> <!-- end div class=\"progressBarContainer\" --></p>";
        }

        echo "<!--</div> center-float -->
	     </div><!-- /vcn-header -->";
    }

?>
<script>
//This is to make sure that in any iframe header and footer should not be displayed
$(document).ready(function() { 
var isInIframe = (window.location != window.parent.location) ? 'true' : 'false';
//alert('G   '+ isInIframe);
	if (isInIframe == 'true') {
		document.getElementById('vcn-header').style.display = 'none';
		document.getElementById('vcn-footer').style.display = 'none';
		document.getElementById('copyright').style.display = 'none';
		$('#page').css("overflow-x","auto");
		$('#page').css("overflow-y","auto");
		$('#page').css("height","675px");
		$('#page').css("width","980px");
		$('.breadcrumb').css("display","none");
	}
});
</script>