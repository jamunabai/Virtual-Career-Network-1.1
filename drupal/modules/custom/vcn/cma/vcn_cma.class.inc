<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
/**
 * @file
 * Carreer Management Account class for the user's account
 *
 */

global $user;
$url = $_SERVER['REQUEST_URI'];
$url = explode('/', $url);
$cp = dirname(drupal_get_path('module','vcn_cma'));

require_once($cp . '/vcn.rest.inc');


class vcnCma
{
    /**
    *
    * @var array The collection of all CMA related data
    */
    protected static $_cma;

    /**
    *
    * @var string session variable
    */
    protected $sessionId;

    /**
    *
    * @var int the Drupal user id
    */
    protected $userId;

    /**
    *
    * @var int the HVCP CAM user id
    */
    protected $cmaId;

    private $item_label = array(
      'career'      => 'Careers',
      'course'      => 'Courses',
      'certificate' => 'Certificates',
      'license'     => 'Licenses',
      'program'     => 'Programs',
      'documents'   => 'Documents',
	  'jobs'  		=> 'Jobs',
	  'tests'  		=> 'Tests',
    );

    private $item_code = array(
      'career'      => 'onetcode',
      'course'      => 'courseid',
      'certificate' => 'certid',
      'license'     => 'licenseid',
      'program'     => 'programid',
      'educationlist' =>'educationid',
      'employmentlist' =>'employmentid',
      'userkeylist'   => 'keyid',
      'documents' => 'documentid',
	  'tests' => 'testsid',
    );

    private $cma_section = array(
      'career'      => 'mycareers',
      'course'      => 'mycourses',
      'certificate' => 'mycertificates',
      'license'     => 'mylicenses',
      'program'     => 'myprograms',
      'targets'     => 'mytargets',
      'educationlist'  =>'myeducationlist',
      'employmentlist' =>'myemploymentlist',
      'userkeylist'    =>'myuserkeylist',
      'documents'    => 'mydocumentslist',
	  'tests'    => 'mytestslist'
    );
    


    /**
     * Singleton implementation for class
     *
     * @return self
     */
    public static function getInstance()
    {
        if ( ! isset(self::$_cma)) {
    //        error_log("CMA - getInstance: Not already present, call the constructor...");
            self::$_cma = new self();
    //    } else {
    //        error_log("CMA - getInstance: Already present, simply return it");
        }
        return self::$_cma;
    }

    /**
     * Private constructor - use getInstance
     */
    private function  __construct()
    {
        global $user;

        $this->sessionId = session_id();

        if (isset($_SESSION['old_session_id'])) {
            if ($_SESSION['old_session_id'] != $this->sessionId) {
                $this->resetSessionId();
            }
        }
        $_SESSION['old_session_id'] = $this->sessionId;

        if ($user) {
            $this->userId = $user->uid;
        } else {
            $this->userId = 0;
        }
        $this->getCmaUserInfo();
    }

    public function setUserId($v) {
        $this->userId = $v;
    }

    public function getCmaUserInfo() {
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('user');
        $rest->setAction('get-user-info');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userId);
        $rest->setRequestKey('session_id', $this->sessionId);

        $rest->setMethod('post');


        $content = $rest->call();

        if ('<?xml' == substr($content, 0, 5)) {
        	if(isset($content))
				$content = new SimpleXMLElement($content);

            $this->_parseUserInfo($content->data->userinfo);


            if (isset($_GET['debug'])) {
                echo "<br><br><div style='border: 1px black solid;'><p>CONTENT OF REST CALL:<br><br><pre>";
                print_r($content);
                echo "</pre></p></div>";
            }
        }
    	elseif($url[2]=='user' && $url[3]=='reset' || $url[2]=='user' && $url[3]=='validate')
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
        //    drupal_set_message('2 It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }
        else
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
            drupal_set_message('It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }
    }

    public function _parseUserInfo($userinfo) {

        $parsedArray = hvcp_simplexml2array($userinfo);

 //       error_log('simplexml2array results: ' . print_r($parsedArray,TRUE));

        foreach ($parsedArray as $k => $v) {
            $this->{$k} = $v;
        }

    }

    public function updateCmaUserInfo() {
        $rest = new vcnRest;
		
        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('user');
        $rest->setAction('update-user-info');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userId);
        $rest->setRequestKey('session_id', $this->sessionId);
        $rest->setRequestKey('userinfo', $this->_setUserInfo());

        $rest->setMethod('post');

        $content = $rest->call();
        

        if ('<?xml' == substr($content, 0, 5)) {
        	if(isset($content))
            	$content = new SimpleXMLElement($content);

//            error_log('Calling _parseUserInfo from updateCmaUserInfo....');
            $this->_parseUserInfo($content->data->userinfo);

            if (isset($_GET['debug'])) {
                echo "<br><br><div style='border: 1px black solid;'><p>CONTENT OF REST CALL:<br><br><pre>";
                print_r($content);
                echo "</pre></p></div>";
            }
        }
        elseif($url[2]=='user' && $url[3]=='reset' || $url[2]=='user' && $url[3]=='validate')
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
        //    drupal_set_message('2 It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }
		else 
		{
		drupal_set_message('It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');	
		}
    }

    
    
    
    private function _setUserInfo() {
//        error_log('_setUserInfo - cma:' . print_r($this,true));
        $userinfo['first_name']  = $this->firstname;
        $userinfo['last_name']   = $this->lastname;
        $userinfo['address1']    = $this->address1;
        $userinfo['address2']    = $this->address2;
        $userinfo['city']        = $this->city;
        $userinfo['state']       = $this->state;
        $userinfo['zipcode']     = $this->zipcode;
        $userinfo['home_phone']  = $this->homephone;
        $userinfo['cell_phone']  = $this->cellphone;
//        error_log('_setUserInfo - resulting in userinfo:' . print_r($userinfo,true));

        return $userinfo;
    }

    public function resetSessionId() {
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('user');
        $rest->setAction('reset-session-id');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('old_session_id', $_SESSION['old_session_id']);
        $rest->setRequestKey('session_id', $this->sessionId);

        $rest->setMethod('post');

        $content = $rest->call();

//        error_log('results of cma rest call: ' . print_r($content,  true));

        if ('<?xml' == substr($content, 0, 5)) {
//            error_log('It seems that $content[\'NODATA\'] is set');
		if(isset($content))
            $content = new SimpleXMLElement($content);

            if ($content->status->code == "fail") {
                error_log ("Unable to migrate session to logged in user");
            }
        }
       	elseif($url[2]=='user' && $url[3]=='reset' || $url[2]=='user' && $url[3]=='validate')
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
        //    drupal_set_message('2 It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }        
        else
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
            drupal_set_message('It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }
    }

    public function getNotebookItems($item_type = 'career') {

        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('notebook');
        $rest->setAction('get-notebook-items');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);
        $rest->setRequestKey('item_type', $item_type);

        $rest->setMethod('post');

        $content = $rest->call();
 //           error_log('getNotebookItems - rest results - content: ' . print_r($content,true));

        if ('<?xml' == substr($content, 0, 5)) {
        	if(isset($content))
            	$content = new SimpleXMLElement($content);

            $savedItems = hvcp_simplexml2array($content->data);
 //           error_log('getNotebookItems - rest results - savedItems: ' . print_r($savedItems,  true));

            if (isset ($savedItems['notebookresults']['item'])) {
                $itemCode   = $this->item_code[$item_type];
                $cmaSection = $this->cma_section[$item_type];
                foreach ($savedItems['notebookresults']['item'] as $item) {
                    $curItemId = $item[$itemCode];
                    foreach($savedItems['contentresults']['item'] as $contentItem) {
                        if ($contentItem[$itemCode] == $item[$itemCode]) {
/*                        	print_r($item);
                        	exit();*/
                            $this->{$cmaSection}[$curItemId] = $contentItem;
                            break;
                        }
                    }
                }
            }
            if (isset($_GET['debug'])) {
                echo "<br><br><div style='border: 1px black solid;'><p>CONTENT OF REST CALL:<br><br><pre>";
                print_r($content);
                echo "</pre></p></div>";
            }
        }
       elseif($url[2]=='user' && $url[3]=='reset' || $url[2]=='user' && $url[3]=='validate')
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
        //    drupal_set_message('2 It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }
        else
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
            drupal_set_message('It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }
    }

    public function saveToNotebook($item_type = 'career', $item_id = NULL, $item_stfips = NULL) {
    // If no onetcode is passed, we create an appropriate message
        $itemCode   = $this->item_code[$item_type];
        $cmaSection = $this->cma_section[$item_type];
        if (!isset($item_id)) {
            return "Missing " . ucfirst($item_type) . " Id, nothing saved";
        }

        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('notebook');
        $rest->setAction('save-to-notebook');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);
        $rest->setRequestKey('item_type', $item_type);

        $rest->setRequestKey('item_id', $item_id);
        $rest->setRequestKey('item_stfips', $item_stfips);

        $rest->setMethod('post');
		global $user;
        $content = $rest->call();
        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
                return ucfirst($item_type) . " NOT Saved to Career Management Account";
                //error_log ("Unable to save $item_type ($item_id) to notebook ($$this->userId/$this->sessionId)");
            }
            $loggedIn = ($this->userId == 0) ? ':' : '';
            if (ucfirst($item_type)== 'Course'){
            return $this->userId.'###'. 'The '. ucfirst($item_type) . ' has been saved to your Career Management Account';
            }else{
            return $this->userId.'###'.ucfirst($item_type) . " Saved to Career Management Account";
            }
        }
        return ucfirst($item_type) . " NOT Saved to Career Management Account";

    }

    public function removeFromNotebook($item_type = 'career', $item_id = NULL, $item_stfips = NULL) {
    	global $user;
    // If no onetcode is passed, we create an appropriate message
        $itemCode   = $this->item_code[$item_type];
        $cmaSection = $this->cma_section[$item_type];
        if (!isset($item_id)) {
            return "Missing " . ucfirst($item_type) . " Id, nothing removed";
        }

        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('notebook');
        $rest->setAction('remove-from-notebook');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);
        $rest->setRequestKey('item_type', $item_type);

        $rest->setRequestKey('item_id', $item_id);
        $rest->setRequestKey('item_stfips', $item_stfips);

        $rest->setMethod('post');

        $content = $rest->call();

        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
                //return ucfirst($item_type) . " NOT Removed from Career Account";
                if($user->uid){return $loggedIn . ucfirst($item_type) . " NOT Removed from Career Management Account";}
            	else {return $loggedIn . ucfirst($item_type) . " NOT Removed from Wish List";}                
                //error_log ("Unable to remove $item_type ($item_id) from notebook ($$this->userId/$this->sessionId)");
            }
            $loggedIn = ($this->userId == 0) ? ':' : '';
            if($user->uid){return $loggedIn . ucfirst($item_type) . " Removed from Career Management Account";}
            else {return $loggedIn . ucfirst($item_type) . " Removed from Wish List";}
        }
        //return ucfirst($item_type) . " NOT Removed from Career Account";
        if($user->uid){return $loggedIn . ucfirst($item_type) . " NOT Removed from Career Management Account";}
        else {return $loggedIn . ucfirst($item_type) . " NOT Removed from Wish List";}                
        

    }
    
    
    
    
public function removedocument($document_id = NULL) {
    	global $user;
    // If no onetcode is passed, we create an appropriate message
        $itemCode   = $this->item_code[$item_type];
        $cmaSection = $this->cma_section[$item_type];


        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('cmauserdocument');
        $rest->setAction('delete');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);


        $rest->setRequestKey('document_id', $document_id);

        $rest->setMethod('post');

        $content = $rest->call();

        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
                //return ucfirst($item_type) . " NOT Removed from Career Account";
                if($user->uid){return $loggedIn . "Document NOT Removed from Career Management Account";}
            	else {return $loggedIn . "Document NOT Removed from Wish List";}                
                //error_log ("Unable to remove $item_type ($item_id) from notebook ($$this->userId/$this->sessionId)");
            }
            $loggedIn = ($this->userId == 0) ? ':' : '';
            if($user->uid){return $loggedIn . "Document Removed from Career Management Account";}
            else {return $loggedIn . ucfirst($item_type) . "Document Removed from Wish List";}
        }
        //return ucfirst($item_type) . " NOT Removed from Career Account";
        if($user->uid){return $loggedIn . "Document NOT Removed from Career Management Account";}
        else {return $loggedIn . "Document NOT Removed from Wish List";}                
        

    }
    
    

public function removejobs($job_scout_id = NULL) {
    	global $user;
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('cmauserjobscout');
        $rest->setAction('delete');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);


        $rest->setRequestKey('job_scout_id', $job_scout_id);
//echo"<pre>"; print_r($rest); exit;
        $rest->setMethod('post');

        $content = $rest->call();
		

        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
                //return ucfirst($item_type) . " NOT Removed from Career Account";
                if($user->uid){return $loggedIn . "Job Search NOT Removed from Career Management Account";}
            	else {return $loggedIn . "Job Search NOT Removed from Wish List";}                
                //error_log ("Unable to remove $item_type ($item_id) from notebook ($$this->userId/$this->sessionId)");
            }
            $loggedIn = ($this->userId == 0) ? ':' : '';
            if($user->uid){return $loggedIn . "Job Search Removed from Career Management Account";}
            else {return $loggedIn . ucfirst($item_type) . "Job Search Removed from Wish List";}
        }
        //return ucfirst($item_type) . " NOT Removed from Career Account";
        if($user->uid){return $loggedIn . "Job Search NOT Removed from Career Management Account";}
        else {return $loggedIn . "Job Search NOT Removed from Wish List";}            
        

    }    
    
	
	
public function shareyndocuments($document_id = NULL, $share_yn = NULL) {

		
    	global $user;
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('cmauserdocument');
        $rest->setAction('put');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        //$rest->setRequestKey('user_id', $this->userid);

		
        $rest->setRequestKey('document_id', $document_id);
		$rest->setRequestKey('share_yn', $share_yn);
		//$rest->setRequestKey('job_scout_id', $active_yn);
		//echo"Ganappa <pre>"; print_r($rest); exit;
        $rest->setMethod('post');

        $content = $rest->call();
		

        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
				return "Document is not added for the share list";              
                //error_log ("Unable to remove $item_type ($item_id) from notebook ($$this->userId/$this->sessionId)");
            }
			if($share_yn == "y" || $share_yn == "Y"){
				return "Document is added for the share list";
			}else{
				return "Document is deleted from the share list"; 
			}
        }
        //return ucfirst($item_type) . " NOT Removed from Career Account";
        if($user->uid){return $loggedIn . "Document is added for the share list";}
        else {return $loggedIn . "Document is deleted from the share list";}            
        

    } 	
public function activeynjobs($job_scout_id = NULL, $active_yn = NULL) {

		
    	global $user;
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('cmauserjobscout');
        $rest->setAction('put');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        //$rest->setRequestKey('user_id', $this->userid);

		
        $rest->setRequestKey('job_scout_id', $job_scout_id);
		$rest->setRequestKey('active_yn', $active_yn);
		//$rest->setRequestKey('job_scout_id', $active_yn);
//echo"Ganappa <pre>"; print_r($rest); exit;
        $rest->setMethod('post');

        $content = $rest->call();
		

        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
				return "You have unsubscribed from the Email List";              
                //error_log ("Unable to remove $item_type ($item_id) from notebook ($$this->userId/$this->sessionId)");
            }
			if($active_yn == "y" || $active_yn == "Y"){
				return "You have subscribed to the Email List";
			}else{
				return "You have unsubscribed from the Email List"; 
			}
        }
        //return ucfirst($item_type) . " NOT Removed from Career Account";
        if($user->uid){return $loggedIn . "Job Search NOT Removed from Career Management Account";}
        else {return $loggedIn . "Job Search NOT Removed from Wish List";}            
        

    } 

public function alldatajobs($user_id = NULL, $zip = NULL, $distance = NULL, $onetcode = NULL, $keyword = NULL, $active_yn = NULL, $created_time = NULL) {
    	global $user;
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('cmauserjobscout');
        $rest->setAction('put');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);

		
        //$rest->setRequestKey('job_scout_id', $job_scout_id);
		$rest->setRequestKey('zip', $zip);
		$rest->setRequestKey('distance', $distance);
		$rest->setRequestKey('onetcode', $onetcode);
		$rest->setRequestKey('keyword', $keyword);
		$rest->setRequestKey('active_yn', $active_yn);
		$rest->setRequestKey('created_time', $created_time);
		//$rest->setRequestKey('job_scout_id', $active_yn);
		//echo"Ganappa <pre>"; print_r($rest); exit;
        $rest->setMethod('post');

        $content = $rest->call();
		

        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
				return "fail: Your Job Search Criteria has not been saved in Career Management Account";              
                //error_log ("Unable to remove $item_type ($item_id) from notebook ($$this->userId/$this->sessionId)");
            }
			if($active_yn == "y" || $active_yn == "Y"){
				return "Your job search criteria has been saved as a Job Scout in your Career Management  Account.";
			}else{
				return "Your Job Search Criteria has not been saved in Career Management Account"; 
			}
        }
        //return ucfirst($item_type) . " NOT Removed from Career Account";
/*         if($user->uid){return $loggedIn . "Your Job Search Criteria has not been saved in Career Management Account";}
        else {return $loggedIn . "Your job search criteria has been saved as a Job Scout in your Career Management  Account.";}  */           
        

    } 	
public function countjobs($user_id = NULL) {
    	global $user;
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('cmauserjobscout');
        $rest->setAction('count');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        //$rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);


        //$rest->setRequestKey('job_scout_id', $job_scout_id);

        $rest->setMethod('post');

        $content = $rest->call();
		$content = new SimpleXMLElement($content);
		echo $content->data->count; 
    } 	



    public function targetNotebookItem($item_type = 'career', $item_id = NULL, $item_stfips = NULL) {
    // If no onetcode is passed, we create an appropriate message
        $itemCode   = $this->item_code[$item_type];
        $cmaSection = $this->cma_section[$item_type];
        if (!isset($item_id)) {
            return "Missing " . ucfirst($item_type) . " Id, nothing targeted";
        }

        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('notebook');
        $rest->setAction('target-notebook-item');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);
        $rest->setRequestKey('item_type', $item_type);

        $rest->setRequestKey('item_id', $item_id);
        $rest->setRequestKey('item_stfips', $item_stfips);

        $rest->setMethod('post');

        $content = $rest->call();

        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
                return ucfirst($item_type) . " NOT Targeted in Career Management Account";
                //error_log ("Unable to target $item_type ($item_id) in notebook ($$this->userId/$this->sessionId)");
            }
            $loggedIn = ($this->userId == 0) ? ':' : '';
            return $this->userId.'###'.ucfirst($item_type) . " Targeted in Career Management Account";
        }
        return ucfirst($item_type) . " NOT Targeted in Career Management Account";

    }
    
    public function saveUserKey( $key_category, $key_name, $key_value=false, $key_id=false) {
     	if (!$key_category) {
            return "Missing user key category information,  nothing saved";
        }
     	if (!$key_name) {
            return "Missing user key name information,  nothing saved";
        }
        
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('userkey');
        $rest->setAction('put');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
        

        if ($key_id) $rest->setRequestKey('key_id', $key_id);
        $rest->setRequestKey('key_category', $key_category);
        $rest->setRequestKey('key_name', $key_name);
        $rest->setRequestKey('key_value', $key_value);
  
        $rest->setMethod('post');

        $content = $rest->call();
 
        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
                return ucfirst($key_name) . " NOT saved";
                //error_log ("Unable to save $key_category ($key_name) for user ($$this->userId/$this->sessionId)");
            }
            $loggedIn = ($this->userId == 0) ? ':' : '';
            return $this->userId.'###'. ucfirst($key_name) . " saved in Career Management Account";
        }
        return ucfirst($key_name) . " NOT saved in Career Management Account";

    }
    
    public function deleteUserKey( $key_category, $key_name, $key_value=false, $key_id=false) {
    	if ( !$key_id )
    	{
	     	if (!$key_category) {
	            return "Missing user key category information,  nothing saved";
	        }
	     	if (!$key_name) {
	            return "Missing user key name information,  nothing saved";
	        }
    	}
    	        
        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('userkey');
        $rest->setAction('put');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
                
       
        if ($key_id) $rest->setRequestKey('key_id', $key_id);
        $rest->setRequestKey('key_category', $key_category);
        $rest->setRequestKey('key_name', $key_name);
        $rest->setRequestKey('key_value', $key_value);
  
        $rest->setMethod('post');

        $content = $rest->call();

        if ('<?xml' == substr($content, 0, 5)) {
            if ($content->status->code == "fail") {
                return ucfirst($key_name) . " NOT deleted";
                //error_log ("Unable to delete $key_category ($key_name) for user ($$this->userId/$this->sessionId)");
            }
            $loggedIn = ($this->userId == 0) ? ':' : '';
            return $loggedIn . ucfirst($key_name) . " deleted in Career Management Account";
        }
        return ucfirst($key_name) . " NOT deleted Career Management Account";

    }
    
    // Get getUserKeyList 
    
	function getUserKeyList($params = false)
	{
		$itemCode   = $this->item_code['userkeylist']; 
		$cmaSection = $this->cma_section['userkeylist'];
		
		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('userkey');
		$rest->setAction('list');
		
		// standard filters
		
		$rest->setRequestKey('apikey', 'apikey');
		$rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
				
		foreach ($params AS $key=>$value)
		{
			if ($value)
			{
			$key = str_replace('-','_',$key);
			$rest->setRequestKey($key, $value);
			}
		
		}
		
		$rest->setMethod('post');
        $content = $rest->call();
 
        if(isset($content))
        	$content = new SimpleXMLElement($content);
 	    
		$status = $content->status->code;
 		$params = $content->params;
 		$data   = $content->data ;        
		if ($status == 'success') {
			$this->{$cmaSection} = $data;
			return $data;
		}
		else {
			return false;
		}		
 	}
    


 //////////////////rest for educaiton and employment/////////////////////////////////////////////////////////////////////////
public function updateCmaUserEducation( $params = false) {

		if ( !$params ) { return false;	}

		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('cmausereducation');
		$rest->setAction('put');
		
		// standard filters
		
		$rest->setRequestKey('apikey', 'apikey');
		$rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
				
		foreach ($params AS $key=>$value)
		{
			if ($value)
			{
			$key = str_replace('-','_',$key);
			$rest->setRequestKey($key, $value);
			}
		
		}
		
		
		$rest->setMethod('post');
        $content = $rest->call();
		
		$status = $result->status->code;
		
		$params = $result->params;
		
		$data = $result->data ;
		        
		if ($status == 'success') { return true;} else {return false;}


}
    
    
      public function updateCmaUserEmployment($params=false) {
		if ( !$params ) { return false; }
 
		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('cmauseremployment');
		$rest->setAction('put');
		
		// standard filters
		
		$rest->setRequestKey('apikey', 'apikey');
		$rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
				
		foreach ($params AS $key=>$value)
		{
			if ($value)
			{
			$key = str_replace('-','_',$key);
			$rest->setRequestKey($key, $value);
			}
		
		}
		
		
		$rest->setMethod('post');
        $content = $rest->call();
		$status = $result->status->code;
		
		$params = $result->params;
		
		$data = $result->data ;
		        
		if ($status == 'success') { return true;} else {return false;}
    }
	
	function getEducationList()
	{
		$itemCode   = $this->item_code['educationlist']; 
		$cmaSection = $this->cma_section['educationlist'];
		
		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('cmausereducation');
		$rest->setAction('list');
		
		// standard filters
		
		$rest->setRequestKey('apikey', 'apikey');
		$rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
				
		
		$rest->setMethod('post');
        $content = $rest->call();
 	    $content = new SimpleXMLElement($content);
 	    
		$status = $content->status->code;
 		$params = $content->params;
 		$data   = $content->data ;
//print_r((array)$data->cma);exit;	        
		if ($status == 'success') {
			$this->{$cmaSection} = $data;
			return $data;
		}
		else {
			return false;
		}		
 	}
 	
 	
 	
	function getDocumentsList()
	{
		//$itemCode   = $this->item_code['documents']; 
		//$cmaSection = $this->cma_section['documents'];
		
		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('cmauserdocument');
		$rest->setAction('list');
		
		// standard filters
		
		$rest->setRequestKey('apikey', 'apikey');
		$rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
				
		
		$rest->setMethod('post');
        $content = $rest->call();
 	    $content = new SimpleXMLElement($content);
 	    
		$status = $content->status->code;
 		$params = $content->params;
 		$data   = $content->data ;
//print_r((array)$data->cma);exit;	        
		//if ($status == 'success') {
		//	$this->{$cmaSection} = $data;
			return $data;
		//}
		//else {
		//	return false;
		//}		
 	} 	
	
	
	function getJobsList()
	{
/* 		//$itemCode   = $this->item_code['documents']; 
		//$cmaSection = $this->cma_section['documents'];
		
		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('cmauserdocument');
		$rest->setAction('list');
		
		// standard filters
		
		$rest->setRequestKey('apikey', 'apikey');
		$rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
				
		
		$rest->setMethod('post');
        $content = $rest->call();
 	    $content = new SimpleXMLElement($content);
 	    
		$status = $content->status->code;
 		$params = $content->params;
 		$data   = $content->data ;
//print_r((array)$data->cma);exit;	        
		//if ($status == 'success') {
		//	$this->{$cmaSection} = $data;
			return $data;
		//}
		//else {
		//	return false;
		//}		 */
 	} 	
 	
	function getEmploymentList()
	{
 
		$itemCode   = $this->item_code['employmentlist']; 
		$cmaSection = $this->cma_section['employmentlist'];
		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('cmauseremployment');
		$rest->setAction('list');
		
		// standard filters
		
		$rest->setRequestKey('apikey', 'apikey');
		$rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
				
		
		$rest->setMethod('post');
        $content = $rest->call();
	    $content = new SimpleXMLElement($content);
 	    
		$status = $content->status->code;
 		$params = $content->params;
 		$data   = $content->data ;
		        
		        
		if ($status == 'success') {
			$this->{$cmaSection} = $data;
			return $data;
		}
		else {
			return false;
		}			
		
		
	}    
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	function getNotebookTargetList()
	{
		$cmaSection = $this->cma_section['targets'];
		
  		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('notebook');
		$rest->setAction('list-notebook-targets');
		
		// standard filters
		
		$rest->setRequestKey('apikey', 'apikey');
		$rest->setRequestKey('format', 'xml');
		$rest->setRequestKey('user_id', $this->userid);
		$rest->setRequestKey('session_id', $this->sessionid);
 		
		$rest->setMethod('post');
        $content = $rest->call();
 
        $content = new SimpleXMLElement($content);
 	    
		$status = $content->status->code;
 		$params = $content->params;
 		$data   = $content->data ;        
		if ($status == 'success') {
			$this->{$cmaSection} = $data;
			return  $data;
 		}
		else {
			return false;
		}		
 	}
    

    public function getHistoryItemsList($item_type = 'employment') {

        $rest = new vcnRest;

        $rest->setSecret('');
        $rest->setBaseurl(hvcp_get_rest_server());
        $rest->setService('cmasvc');
        $rest->setModule('history');
        $rest->setAction('list-history-items');

        // standard filters
        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);
        $rest->setRequestKey('item_type', $item_type);

        $rest->setMethod('post');

        $content = $rest->call();
 //           error_log('getNotebookItems - rest results - content: ' . print_r($content,true));

        if ('<?xml' == substr($content, 0, 5)) {
            $content = new SimpleXMLElement($content);

            $status = $content->status->code;
            $params = $content->params;
            $data   = $content->data ;
            if ($status == 'success') {
                $this->{$item_type . 'List'} = $data;
                return  $data;
            }
            else {
                return false;
            }


            $savedItems = hvcp_simplexml2array($content->data);
            error_log('getHistoryItems - rest results - savedItems: ' . print_r($savedItems,  true));
/*
            if (isset ($savedItems['notebookresults']['item'])) {
                $itemCode   = $this->item_code[$item_type];
                $cmaSection = $this->cma_section[$item_type];
                foreach ($savedItems['notebookresults']['item'] as $item) {
                    $curItemId = $item[$itemCode];
                    foreach($savedItems['contentresults']['item'] as $contentItem) {
                        if ($contentItem[$itemCode] == $item[$itemCode]) {
// *                        	print_r($item);
                        	exit();*--/
                            $this->{$cmaSection}[$curItemId] = $contentItem;
                            break;
                        }
                    }
                }
            }*/
            if (isset($_GET['debug'])) {
                echo "<br><br><div style='border: 1px black solid;'><p>CONTENT OF REST CALL:<br><br><pre>";
                print_r($content);
                echo "</pre></p></div>";
            }
        }
        elseif($url[2]=='user' && $url[3]=='reset' || $url[2]=='user' && $url[3]=='validate')
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
        //    drupal_set_message('2 It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }        
        else
        {
            //error_log('Web service call failed with these results: ' . print_r($content,  true));
            drupal_set_message('It appears the web service call failed, Please try again soon and if it continues to fail notify the web adminisrator.');
        }
    }

	function getHistoryItem($item_type = 'employment', $record_id = NULL)
	{
        if ($record_id === NULL) { return false; }

        $rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
		$rest->setModule('history');
		$rest->setAction('get-history-item');

		// standard filters

        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);
        $rest->setRequestKey('item_type', $item_type);

		$rest->setRequestKey('record_id', $record_id);

		$rest->setMethod('post');
        $content = $rest->call();

        $content = new SimpleXMLElement($content);
        //error_log('getHistoryItem - content: ' . print_r($content,TRUE));
		$status = $content->status->code;
 		$params = $content->params;
 		$data   = $content->data ;
		if ($status == 'success') {
            $this->{$item_type} = $data;
            return  $data;
		}
		else {
			return false;
		}
    }

	function updateHistoryItem($item_type = 'employment', $form_values = NULL)
	{
		if ( $form_values === NULL ) { return false; }

		$rest = new vcnRest;
		$rest->setSecret('');
		$rest->setBaseurl(hvcp_get_rest_server());
		$rest->setService('cmasvc');
        $rest->setModule('history');
        $rest->setAction('update-history-item');


		// standard filters

        $rest->setRequestKey('apikey', 'apikey');
        $rest->setRequestKey('format', 'xml');
        $rest->setRequestKey('user_id', $this->userid);
        $rest->setRequestKey('item_type', $item_type);

		foreach ($form_values AS $key=>$value)
		{
			if ($value)
			{
                $newkey = strtoupper(str_replace('-','_',$key));
                $form_values[$newkey] = $form_values[$key];
                if ($key != $newkey) {
                  unset($form_values[$key]);
                }
			} else {
                unset($form_values[$key]);
            }
            $form_values['USER_ID'] = $this->userid;
		}
        $rest->setRequestKey('form_values', $form_values);

		$rest->setMethod('post');
        $result = $rest->call();
        $result = new SimpleXMLElement($result);
        //error_log('updateHistoryItem - result: ' . print_r($result,TRUE));
		$status = $result->status->code;
        //error_log('updateHistoryItem - status: ' . $status);

		$params = $result->params;

		$data = $result->data ;

		if ($status == 'success') { return true;} else {return false;}
    }

}