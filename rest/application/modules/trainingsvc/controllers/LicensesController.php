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
class TrainingSvc_LicensesController extends VCN_WebServices {
 
 	public function init() {
 		parent::init();
 		
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
		if ( array_key_exists( 'zip', $this->params) ) {
			$model = new VCN_Model_MasterZipcode();
			$zip   = $model->getMasterZipcode(array('zip'=>$this->params['zip']));
	  	 
			foreach ($zip['data'] AS $data) {
	 			if (!array_key_exists('stfips',$this->params))
				{
					$this->params['stfips'] = $data['Licstate']['STFIPS'];
				}
			}
 		}
		
	  $model = new VCN_Model_License();
	  $result = $model->countLicenses($this->params);
	   	
 		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'licenses');
		} 
 
        // Setting up headers and body
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result);
	}
	
   /**
	* 
	* @see Zend_Rest_Controller::listAction()
	*/
	public function listAction( ) {
		if ( array_key_exists( 'zip', $this->params) ) {
			$model = new VCN_Model_MasterZipcode();
			$zip   = $model->getMasterZipcode(array('zip'=>$this->params['zip']));
	  	 
			foreach ($zip['data'] AS $data) {
	 			if (!array_key_exists('stfips',$this->params))
				{
					$this->params['stfips'] = $data['Licstate']['STFIPS'];
				}
			}
 		}
 		
 	 	$model  = new VCN_Model_License();
	 	$result = $model->listLicenses($this->params);
		
	  
  
		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'licenses');
		} 

 		$this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}
		
   /**
	* 
	* @see Zend_Rest_Controller::getAction()
    */
	public function getAction( ) {
		$model  = new VCN_Model_License();
		$result = $model->getLicense($this->params);
		
 
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'licenses');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	

   /**
	* 
	* @see Zend_Rest_Controller::getAction()
    */
	public function detailAction( ) {
		$model  = new VCN_Model_License();
		$result = $model->detailLicense($this->params);
		
 
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'licenses');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	
	
    
}