<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
/*
 * @category   VCN
 * @package    VCN
 */

/** Zend_Controller_Action */
require_once 'Zend/Controller/Action.php';
 
class VCN_WebServices extends Zend_Controller_Action {
	protected $apikey;
	protected $auth;
	protected $params;
	protected $format;
	protected $content_type;
    protected $signature;
    
   /**
    * Initialize web services and check apikey. Uses class params
    * @return void
    */
	public function init()
    {
    	// turn off display
    	$this->_helper->viewRenderer->setNoRender(true);
	  	$this->_helper->getHelper('layout')->disableLayout();
    	
	  	// get the params
    	$this->params = $this->getRequest()->getParams();
  
 		// save some time, Check API KEY first!
    	$this->config = new Zend_Config_Ini(APPLICATION_PATH ."/configs/application.ini", APPLICATION_ENV);
 
    	if (! $this->authAccepted())
    	{
           throw new Exception("authentication failed: ");
    	}
    	
		$this->format = isset($this->params['format']) ? $this->params['format'] : 'xml';
		if ($this->format == 'json') {
			$this->content_type = 'text/html; charset=utf-8';
		}
		else {
			$this->content_type = 'text/xml; charset=utf-8';
		}
 
    }
    
   /**
    * The authorization function to verify the apikey. Uses class params.
    * @uses signArgs()
    * @return Boolean true/false
    */  	
	private function authAccepted() {
		//TODO
		return true;
 
	 	$apikey = $this->apikey = isset($this->params['apikey']) ? $this->params['apikey'] : false;
 	  	$this->auth = isset($this->params['auth']) ? $this->params['auth'] : false;
	  	unset($this->params['auth']);
 
	  	if (!($apikey && $this->auth)) return false;
	 
   		$this->clientKey =  $this->config->webservice->$apikey->secret ;
 	  	$signature = $this->signArgs($this->params);
    	$this->signature = $signature;
 
    	unset($this->params['apikey']);
 	 
    	if ($signature == $this->auth)
        	return true;
         	
  		return false;
	}
	
   /**
    * The api verification function for converting request arguments into encrypted string
    * Pass in an array of arguments from request through auth_accepted() function
	* @param array $args
    * @return string MD5 encrypted args
    */  	
	private function signArgs($args) {
  		ksort($args);
    	$a = '';
    	foreach($args as $k => $v)
      	{
      		if ( in_array($k, array('module','controller','action')) ) continue;
         	$a .= $k . $v;
    	}
    	
   		return md5($this->clientKey.$a);
	}
 	
   /**
    * The main function for converting to an XML document.
    * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
	* @param array $data
    * @param string $rootNodeName - what you want the root node to be - defaults to result.
    * @param string $childNodeName - what you want the child node to be - defaults to item.
    * @param SimpleXMLElement $xml - should only be used recursively
    * @return string XML
    */
	public static function toXml($data, $rootNodeName = 'result', $childNodeName = 'item', $xml=null)
   	{
 
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1) { ini_set ('zend.ze1_compatibility_mode', 0); }
  		if ($xml == null)  {
 			$xml = simplexml_load_string("<?xml version='1.0' encoding='UTF-8'?><$rootNodeName />");
 		}
 
      	// loop through the data passed in.
		foreach($data as $key => $value)
      	{
       		$key = strtolower($key);

       		// no numeric or empty keys in our xml please!
 	      	if (is_numeric($key))  $key =  $childNodeName;
  	      				 
       		$key = preg_replace('/[^a-z0-9]/i', '', $key);
  	      	if ($key == '') $key = $childNodeName;
      		
      		// if there is another array found recrusively call this function
      		if (is_array($value))
      		{
				$node = $xml->addChild($key);
                if (isset($value[0])) {
                	if ($key == 'data') $key = $childNodeName;
                	else $key = 'item';
                }
      			// recrusive call.
      			VCN_WebServices::toXml($value, $rootNodeName, $key, $node);
      		}
      		 else
 		  	{
       			// add single node.
       	  		$value = self::xmlentities($value, ENT_QUOTES,'UTF-8');
       		    $xml->addChild($key,$value);
       		}
     	}

      	// pass back as string. or simple xml object if you want!
       return $xml->asXML();
	}
	
   /**
    * The function for converting strings using xml entities.
    * Pass in same args for htmlentities (as it is called here)
	* @param  string $string
    * @param  string $quote_style
    * @param  string $charset - what you want the child node to be - defaults to item.
    * @param  string $double_encode
    * @return string $string
    */
	public function xmlentities($string = false, $quote_style = null, $charset = null, $double_encode = null)
	{	
		if (!trim($string)) return false;
		
		$string = trim(htmlentities($string, $quote_style, $charset, $double_encode));
 
		$patterns = array( 
		    '/&nbsp/','/&iexcl/','/&cent/','/&pound/','/&curren/','/&yen/','/&brvbar/',
			'/&sect/','/&uml/', '/&copy/','/&ordf/','/&laquo/','/&shy/','/&reg/','/&macr/',
			'/&deg/','/&plusmn/','/&sup2/','/&sup3/','/&acute/', '/&micro/','/&para/','/&middot/','/&cedil/',
			'/&sup1/','/&ordm/','/&raquo/','/&frac14/','/&frac12/','/&frac34/','/&iquest/','/&Agrave/',
			'/&Aacute/','/&Acirc/','/&Atilde/','/&Auml/','/&Aring/','/&AElig/','/&Ccedil/','/&Egrave/',				
			'/&Eacute/','/&Ecirc/','/&Euml/','/&Igrave/','/&Iacute/','/&Icirc/','/&Iuml/','/&ETH/','/&Ntilde/',
			'/&Ograve/','/&Oacute/','/&Ocirc/','/&Otilde/','/&Ouml/','/&times/','/&Oslash/','/&Ugrave/','/&Uacute/',
			'/&Ucirc/','/&Uuml/','/&Yacute/','/&THORN/','/&szlig/','/&agrave/','/&aacute/','/&acirc/','/&atilde/','/&auml/',
			'/&aring/','/&aelig/','/&ccedil/','/&egrave/','/&eacute/','/&ecirc/','/&euml/','/&igrave/','/&iacute/',
			'/&icirc/','/&iuml/','/&eth/','/&ntilde/','/&ograve/','/&oacute/','/&ocirc/','/&otilde/','/&ouml/',
			'/&divide/','/&oslash/','/&ugrave/','/&uacute/','/&ucirc/','/&uuml/','/&yacute/','/&thorn/','/&yuml/',
   		    '/&quot/','/&amp/','/&lt/','/&gt/','/&OElig/','/&oelig/','/&Scaron/','/&scaron/','/&Yuml/','/&fnof/',
 			'/&circ/','/&tilde/',
 			'/&ensp/','/&emsp/','/&thinsp/','/&zwnj/','/&zwj/','/&lrm/','/&rlm/','/&ndash/','/&mdash/','/&lsquo/',
   			'/&rsquo/','/&sbquo/','/&ldquo/','/&rdquo/','/&bdquo/','/&dagger/','/&Dagger/','/&permil/','/&lsaquo/','/&rsquo/',
 			'/&euro/','/&hellip/','/&prime/','/&Prime/','/&oline/','/&bull/','/&frasl/','/&weierp/','/&image/','/&real/',
   			'/&trade/','/&alefsym/','/&larr/','/&uarr/','/&rarr/','/&darr/','/&harr/','/&crarr/','/&lArr/','/&uArr/',
   			'/&rArr/','/&dArr/','/&hArr/','/&forall/','/&part/','/&exist/','/&empty/','/&nabla/','/&isin/','/&notin/', 		 		
  			'/&ni/','/&prod/','/&sum/','/&minus/','/&lowast/','/&radic/','/&prop/','/&infin/','/&ang/','/&and/', 		 		
  			'/&or/','/&cap/','/&cup/','/&int/','/&there4/','/&sim/','/&cong/','/&asymp/','/&ne/','/&equiv/', 	
  			'/&le/','/&ge/','/&sub/','/&sup/','/&nsub/','/&sube/','/&supe/','/&oplus/','/&otimes/','/&perp/', 	
 			'/&sdot/','/&lceil/','/&rceil/','/&lfloor/','/&rfloor/','/&lang/','/&rang/','/&loz/','/&spades/','/&clubs/', 	
  			'/&hearts/','/&diams/', 
 		
  		);
		 
		$replace = array(
	        '&#160','&#161','&#162','&#163','&#164','&#165','&#166',
 			'&#167','&#168','&#169','&#170','&#171','&#173','&#174','&#175',
			'&#176','&#177','&#178','&#179','&#180','&#181','&#182','&#183','&#184',
			'&#185','&#186','&#187','&#188','&#189','&#190','&#191','&#192',
			'&#193','&#194','&#195','&#196','&#197','&#198','&#199','&#200',
			'&#201','&#202','&#203','&#204','&#205','&#206','&#207','&#208','&#209',				
			'&#210','&#211','&#212','&#213','&#214','&#215','&#216','&#217','&#218',
			'&#219','&#220','&#221','&#222','&#223','&#224','&#225','&#226','&#227','&#228',
			'&#229','&#230','&#231','&#232','&#233','&#234','&#235','&#236','&#237',
			'&#238','&#239','&#240','&#241','&#242','&#243','&#244','&#245','&#246',
			'&#247','&#248','&#249','&#250','&#251','&#252','&#253','&#254','&#255', 
			'&#34', '&#38', '&#60', '&#62', '&#338','&#339','&#352','&#353','&#376','&#402',
			'&#710','&#732',
			'&#8194','&#8195','&#8201','&#8204','&#8205','&#8206','&#8207','&#8211','&#8212','&#8216',
			'&#8217','&#8218','&#8220','&#8221','&#8222','&#8224','&#8225','&#8240','&#8249','&#8250',
			'&#8364','&#8230','&#8242','&#8243','&#8254','&#8226','&#8260','&#8472','&#8465','&#8476',
			'&#8482','&#8501','&#8592','&#8593','&#8594','&#8595','&#8596','&#8629','&#8656','&#8657',
			'&#8658','&#8659','&#8660','&#8704','&#8706','&#8707','&#8709','&#8711','&#8712','&#8713',
			'&#8715','&#8719','&#8721','&#8722','&#8727','&#8730','&#8733','&#8734','&#8736','&#8743',
			'&#8744','&#8745','&#8746','&#8747','&#8756','&#8764','&#8773','&#8776','&#8800','&#8801',
			'&#8804','&#8805','&#8834','&#8835','&#8836','&#8838','&#8839','&#8853','&#8855','&#8869',
			'&#8901','&#8968','&#8969','&#8970','&#8971','&#9001','&#9002','&#9674','&#9824','&#9827',
			'&#9829','&#9830',
 	
		) ;
 
		ksort($patterns);
		ksort($replace);
		$string = preg_replace($patterns, $replace, $string);
 		// remove non-printable characters
		//$string = preg_replace('/[^\x0A\x20-\x7E]/','',$string);
	     $string = preg_replace('/[\x00-\x09\x0B-\x1F]/', '', $string);
		
		return $string;
	}
  

	
	/* saving for later */
	public static function trackingCode() {
	/*<!-- Piwik -->
	<script type="text/javascript">
	var pkBaseURL = (("https:" == document.location.protocol) ? "https://localhost/piwik/" : "http://localhost/piwik/");
	document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
	</script><script type="text/javascript">
	try {
	var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
	piwikTracker.trackPageView();
	piwikTracker.enableLinkTracking();
	} catch( err ) {}
	</script><noscript><p><img src="http://localhost/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
	<!-- End Piwik Tag -->
		*/
	}
}

