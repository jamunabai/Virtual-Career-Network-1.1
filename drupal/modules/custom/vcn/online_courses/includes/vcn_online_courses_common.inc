<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 
	function vcn_online_courses_get_valid ( $key = false) 
	{
		$valid = array();
		if ($key) 
		{
   			$valid = array('delivery_mode_name'=>'valid','course_id'=>'key','program_id'=>'valid','course_code'=>'valid','unitid'=>'valid','language_code'=>'valid', 'base_course_id'=>'valid','subject_area'=>'valid','course_type'=>'valid','delivery_mode'=>'valid', 'keyword'=>'valid');
   		}
		else 
		{
	 		$valid  = array('delivery_mode_name'=>'valid','course_id'=>'valid','program_id'=>'valid','course_code'=>'valid','unitid'=>'valid','language_code'=>'valid', 'base_course_id'=>'valid','subject_area'=>'valid','course_type'=>'valid','delivery_mode'=>'valid', 'keyword'=>'valid');
 		}
 		return $valid;
	}
	 	function vcn_online_courses_vars_post (&$vars, $post)
	{
 		if (!$post) return $vars;
 		foreach ($post as $key => $value) {
 			$key = strtolower(trim($key));
 	   	 	if ( $key ) $vars[$key] = $value;
 		}
 		return $vars;
 	}
  	
	function vcn_online_courses_vars_get (&$vars, $get)
	{
 		if (!$get) return $vars;
		foreach ($get as $key => $value) {
 			$key = strtolower(trim($key));
 		 	if ( $key ) $vars[$key] = $value;
  		}
  		return $vars;
 	} 	
 
	function vcn_online_courses_vars_arg (&$vars, $args)
	{
		if (!$args) return $vars;
		for ($i=3; $i < sizeof($args)+1; $i++) {
			$key = strtolower(trim($args[$i]));
 			if ( $key ) $vars[$key] = $args[++$i];
	  	} 	
 	  	return $vars;
	}
	
	function vcn_online_courses_vars_set (&$vars, $type = false)
	{
		$vars['cma'] = vcnCma::getInstance();
		if (!$_POST) {
	    // set some defaults
 
		 	$vars['stabbr']   = (array_key_exists('stabbr', $vars) AND $vars['stabbr']) ? $vars['stabbr'] : $vars['cma']->state;
			$vars['zip']      = (array_key_exists('zip', $vars) AND $vars['zip']) ? $vars['zip'] : $vars['cma']->zipcode;
		 	$vars['distance'] = (array_key_exists('distance', $vars) AND $vars['distance']) ? $vars['distance'] : 25;
 		}
 		
 		$vars['delivery_mode_name'] = 'VCN'; 

 		return $vars;
	}
	
	function vcn_online_courses_format_phone ($number)
	{
		$number = preg_replace('/[^\d]/', '', $number);
		switch (strlen($number))
		{
			case '7':
				return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $number);
			break;
			case '10':
				return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $number);
			break;
			default:
				return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4}) ([0-9])/", "($1) $2-$3 $4", $number);
				
		}
		return false;
	}
	
		function vcn_online_courses_get_data (&$errors, $vars, $valid, $service, $module, $action, $limit=false, $offset=false, $order=false, $direction=false, $format='xml', $method='post' ) 
	{
		$data = false;
		if (!$valid) $valid = array();
 		$rest = new vcnRestOnlineCourses;
  
		$rest->setSecret(hvcp_get_rest_secret()); 
		$rest->setBaseurl(hvcp_get_rest_server()); 
		$rest->setMethod($method);
			
 	 	$rest->setService($service);
		$rest->setModule($module);
 		$rest->setAction($action);
		 	
	  	$rest->setRequestKey('apikey',hvcp_get_rest_apikey());
	  	$rest->setRequestKey('format',$format);
 
		if ($limit) 	$rest->setRequestKey('limit',$limit);
		if ($offset) 	$rest->setRequestKey('offset',$offset);
		if ($order) 	$rest->setRequestKey('order',$order);
		if ($direction) $rest->setRequestKey('direction',$direction);

		foreach ($vars as $key => $value) { if ($value AND array_key_exists($key, $valid) ) $rest->setRequestKey($key,$value); } 
 
    	$result = new SimpleXMLElement( $rest->call());

  	 	$status = $result->status->code;
	  	$params = $result->params;
		$data   = $result->data ;
		
	    if ($status == 'success') { $data = $result->data ; }
	     	
 	 	return $data;
	}	
	
 
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class vcnRestOnlineCourses
{
  protected $_secret = '';
  protected $_baseurl = 'http://x.x.1.139/rest/public/';
  protected $_method = 'post';
  protected $_service;
  protected $_module;
  protected $_action;
  protected $_request = array();


  public function getSecret() { return $this->_secret; }
  public function setSecret($val) { $this->_secret = $val; }

  public function getBaseurl() { return $this->_baseurl; }
  public function setBaseurl($val) { $this->_baseurl = $val; }

  public function getMethod() { return $this->_method; }
  public function setMethod($val) { $this->_method = $val; }

  public function getService() { return $this->_service; }
  public function setService($val) { $this->_service = $val; }

  public function getModule() { return $this->_module; }
  public function setModule($val) { $this->_module = $val; }

  public function getAction() { return $this->_action; }
  public function setAction($val) { $this->_action = $val; }
  
  public function getRequest() { return $this->_request; }
  public function setRequest($val = array()) { $this->_request = $val; }
  
  public function getRequestKey($key) { return $this->_request[$key]; }
  public function setRequestKey($key, $val, $append = false) {
  if ($append) { 
  		$this->_request[$key][] = $val;
  	}
  	else {
  		$this->_request[$key] = $val;
  	} 
  }


  public function call() {
    $auth    = $this->_signArgs($this->_request, $this->_secret);
    $this->setRequestKey('auth',$auth);
    $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
    $method  = $this->_method;
    $url     = $this->_baseurl."$this->_service/$this->_module/$this->_action/";

 
// the value of $str is actually bool(true), not empty string ''
//var_dump($str);
 
    $content = drupal_http_request($url, $headers, strtoupper($method), http_build_query($this->_request,'','&') );

    if (isset($_GET['debug'])) {
      echo "<div style='border: 1px black solid;'><p><pre>";
      echo "REST parameters: <br>";
      echo "url: " . $url . "<br>";
      echo "headers: " . print_r($headers,true) . "<br>";
      echo "method: " . strtoupper($method) . "<br>";
      echo "request: " . print_r($this->_request,true) . "<br>";
      echo "raw results: " . print_r($content,true) . "<br>";
      echo "</pre></p></div>";
    }
 
    if ($content->data) {
      $data = $content->data;
    } else {
      $data['NODATA'] = 'No data found for request: ' . $url . http_build_query($this->request,'','&');
    }

    return $data;
  }

  private function _signArgs($args, $secret) {

		ksort($args);
    	$a = '';
    	foreach($args as $k => $v)
      	{
         	$a .= $k . $v;
    	}
   		return md5($secret.$a);
	}
}
	
	
	
	
	