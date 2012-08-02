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
 * @author waltonr
 * 
 * 
 */
class TrainingSvc_ProgramsController extends VCN_WebServices {
    private $occupation;
    	
 	public function init() {
 		parent::init();
 		
       // make sure I've got the barest minimum
 	   // if (! (isset($this->params['onetcode']) && isset($this->params['zipcode'])) ) continue;
    	}
 
   	/**
	* 
	* @see Zend_Rest_Controller::indexAction()
    */
	public function indexAction( ) {
		 $this->_helper->layout->setLayout('rest');
	  	 throw new Exception("Invalid Request");
	}	
 	
	public function countAction() {

		if (isset ($this->params['zip'])) {
			$model = new VCN_Model_MasterZipcode();
			$zip   = $model->getMasterZipcode(array('zip'=>$this->params['zip']));
	 	 
			foreach ($zip['data'] AS $data) {
				$this->params['latitude'] = $data['LATITUDE'];
				$this->params['longitude']= $data['LONGITUDE'];
			}
 		}
		
 		$model = new VCN_Model_Program();
		$result = $model->countProgram($this->params);
		 
		// unset derived params
		if (array_key_exists('cipcode', $result['params'])) unset($result['params']['cipcode']);
		if (array_key_exists('latitude',     $result['params'])) unset($result['params']['latitude']);
		if (array_key_exists('longitude',    $result['params'])) unset($result['params']['longitude']);
		
 		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'programs');
		} 
 
        // Setting up headers and body
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result);
	}
	
   /**
	* 
	* @see Zend_Rest_Controller::listAction()
	*/
	public function listAction( ) {

		if (isset ($this->params['zip'])) {
			$model = new VCN_Model_MasterZipcode();
			$zip   = $model->getMasterZipcode(array('zip'=>$this->params['zip']));
 
			foreach ($zip['data'] AS $data) {
				$this->params['latitude'] = $data['LATITUDE'];
				$this->params['longitude']= $data['LONGITUDE'];
			}
 		}
 
		$model = new VCN_Model_Program();
		$result = $model->listProgram($this->params);

		// unset derived params
	 	if (array_key_exists('cipcode', $result['params'])) unset($result['params']['cipcode']);
		if (array_key_exists('latitude',     $result['params'])) unset($result['params']['latitude']);
		if (array_key_exists('longitude',    $result['params'])) unset($result['params']['longitude']);
		
 		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'programs');
		} 
 
 		$this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}
 
		
   /**
	* 
	* @see Zend_Rest_Controller::getAction()
	*/
	public function getAction( ) {
	 		
		$model = new VCN_Model_Program();
		$result = $model->getProgram($this->params);
 
 
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'programs');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	

   /**
	* 
	* @see Zend_Rest_Controller::getAction()
	*/
	public function detailAction( ) {
		$model = new VCN_Model_Program();
		$result = $model->detailProgram($this->params);
 		
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'programs');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	
	
   	public function smartCatalogImportAction ()
   	{	
   		$user_id = array_key_exists('user_id',$this->params) ? $this->params['user_id']:false;
   		$this->params = false;
   		$this->params['processed_status'] = 'is null';
   	 	$start = date("H:i:s", mktime());
   		$model  = new VCN_Model_SmDegreedataExpandprogram();
		$result = $model->countSmDegreedataExpandprogram($this->params);
 		$count  = $result['data']['count'];
 		$count = 1000;
 	 	$this->params['limit']  = 1000;
 		$this->params['offset'] = 0;
 		$i=0;
  		set_time_limit(0);
 		while ($count > $this->params['offset'] )
 		{
 		 	$result = $model->listSmDegreedataExpandprogram($this->params,false,true);
 	 
 			foreach ($result['data'] AS $record) 
 			{	
 				$record->processed_date  = date("Y-m-d", mktime());
 				if ($user_id) $record->processed_by  = $user_id;
  		 	  	if (!$record->award)
 			 	{
 			  		$record->processed_status= 'I';
 			 		$record->processed_notes = 'No award level found';
  			 	}
 			 	$record->save();
 			 	$i++;
  			}
 			print 'Finished '.$i . ' of '. $count .'<br />';
		 	$this->params['offset'] += $this->params['limit'];  
		 	sleep(20);
		 			
 		}
 		$end = date("H:i:s", mktime());
 		print '<br /><br />'. $start . '->' .$end;
   		exit;
    		
   	}
}