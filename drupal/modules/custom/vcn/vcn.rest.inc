<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php



require_once('sites/default/hvcp.functions.inc');


// Andrew's Error Handling


 class Error
{
    // CATCHABLE ERRORS
    public static function captureNormal( $number, $message, $file, $line )
    {
        // Insert all in one table
        $error = array( 'type' => $number, 'message' => $message, 'file' => $file, 'line' => $line );
        // Display content $error variable
		//echo '1VCN Healthcare will be up shortly.<br/>'.$message.'<br/><br/>';
		//exit;
    }
   
    // EXTENSIONS
    public static function captureException( $exception )
    {
        // Display content $exception variable
	echo 'VCN Healthcare will be back shortly.';
	exit;
    }
   
    // UNCATCHABLE ERRORS
    public static function captureShutdown( )
    {
        $error = error_get_last( );
        if( $error ) {
            ## IF YOU WANT TO CLEAR ALL BUFFER, UNCOMMENT NEXT LINE:
            ob_end_clean( );
           
            // Display content $error variable
			echo 'VCN Healthcare will be back shortly.';
			//exit;
        } else { return true; }
    }
}

ini_set( 'display_errors', 0 );
error_reporting(E_ALL);
set_error_handler( array( 'Error', 'captureNormal' ) );
set_exception_handler( array( 'Error', 'captureException' ) );
register_shutdown_function( array( 'Error', 'captureShutdown' ) );

// End of Andrew's Error Handling

/**
 * @file
 * REST services class for connecting to VCN rest services
 *
 */
class vcnRest
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

  public function getRequestKey($key) { return $this->_request[$key]; }
  public function setRequestKey($key, $val) { $this->_request[$key] = $val; }

  public function call() {
  	
  	// set the baseurl using the hvcp_get_rest_server function in hvcp.functions.inc
  	$resturl = hvcp_get_rest_server();
  	$this->setBaseurl($resturl);
  	 
  	// set the rest secret using the hvcp_get_rest_secret function in hvcp.functions.inc
  	$restsecret = hvcp_get_rest_secret();
  	$this->setSecret($restsecret);
  	 
  	// set the rest api key using the hvcp_get_rest_apikey function in hvcp.functions.inc
  	$restkey = hvcp_get_rest_apikey();
  	$this->setRequestKey('apikey',$restkey);
  	
    $auth    = $this->_signArgs($this->_request, $this->_secret);
    $this->setRequestKey('auth',$auth);
    $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
    $method  = $this->_method;
    $url     = $this->_baseurl."$this->_service/$this->_module/$this->_action/";

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
      $data['NODATA'] = 'No data found for request: ' . $url . http_build_query($this->_request,'','&');
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
?>
