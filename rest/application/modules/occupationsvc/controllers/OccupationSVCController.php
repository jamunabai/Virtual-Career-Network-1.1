<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

class OccupationSVCController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	//$albums = new VCN_Model_DbTable_Albums();
        //$this->view->albums = $albums->fetchAll();
    }
    
    
		
 	public function listAction()
    {
    	$this->_helper->layout->setLayout('rest');
    	
    	function occupations() {

			$records = new VCN_Model_DbTable_occupations();
			$allrecords = $records->fetchAll();
			
	    	if (!$allrecords) {
	            throw new Exception("Could not find table");
	        }
				
			$xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
			
			<occupations>';
			foreach($allrecords as $record) :
				$xml.='<occupation>';
				$xml.='<onetcode>'.htmlentities($record->ONETCODE).'</onetcode>';
				$xml.='<title>'.htmlentities($record->TITLE).'</title>';
				$xml.='<clustercode>'.htmlentities($record->CLUSTER_CODE).'</clustercode>';
			    $xml.='<videolink>'.htmlentities($record->VIDEO_LINK).'</videolink>';
			    $xml.='<displaytitle>'.htmlentities($record->DISPLAY_TITLE).'</displaytitle>';
			    $xml.='</occupation>';			    
			endforeach;
			$xml.='</occupations>';
			
			$xml = simplexml_load_string($xml);
			    
			return $xml;
		
		}

    	function jobfamily() {

			$records = new VCN_Model_DbTable_jobfamily();
			$allrecords = $records->fetchAll();
			
	    	if (!$allrecords) {
	            throw new Exception("Could not find table");
	        }
				
			$xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
			
			<categories>';
			foreach($allrecords as $record) :
			    $xml.= '<item><jobfamily>'.htmlentities($record->JOBFAMILY).'</jobfamily>';
			    $xml.='<familydesc>'.htmlentities($record->FAMILYDESC).'</familydesc></item>';
			    
			endforeach;
			$xml.='</categories>';
			
			$xml = simplexml_load_string($xml);
			    
			return $xml;
		
		}
        	
		function code($key) {

			$albums = new VCN_Model_DbTable_wgsource();
			$allalbums = $albums->fetchAll();
				
			$xml ='<?xml version="1.0" encoding="ISO-8859-1"?>
			
			<categories>';
			$xml .= '<key>'.testkey($key).'</key>';
			if (testkey($key)=="Failure.")
				return "Invalid Key"; 
				
			foreach($allalbums as $album) :
			    $xml.= '<code>'.$album->WAGESRDESC.'</code>';
			    //$xml.='<category>'.$album->title.'</category>';
			    
			endforeach;
			$xml.='</categories>';
			
			$xml = simplexml_load_string($xml);
			    
			return $xml;
		
		}
		
		function testkey($x) {
			if ($x=="test")
				return "Success!";
			else
				return "Failure.";			
		}
		
		
		$server = new Zend_Rest_Server();
		$server->addFunction('occupations');
		$server->addFunction('jobfamily');
		$server->addFunction('code');
		$server->handle();
    }

}