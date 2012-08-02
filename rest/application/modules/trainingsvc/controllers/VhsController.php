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
class TrainingSvc_VhsController extends VCN_WebServices {
 
 
   	/**
	* 
	* @see Zend_Rest_Controller::indexAction()
    */
	public function indexAction( ) {
		 $this->_helper->layout->setLayout('rest');
	  	 throw new Exception("Invalid Request");
	}	
 	
	public function countAction() {
/*
 		if (!array_key_exists('stabbr', $this->params))
 		{
			if (array_key_exists('zip', $this->params) AND $this->params['zip'] ) {
				$model = new VCN_Model_MasterZipcode();
				$zip   = $model->getMasterZipcode(array('zip'=>$this->params['zip']));
				foreach ($zip['data'] AS $data) {
					$this->params['stabbr'] = $data['STATE'];
				}
	  		}
 		}
*/
		
 		$this->params['VHS_YN'] = 'Y';
 		$model = new VCN_Model_Provider();
		$result = $model->countProvider($this->params);
  
   		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'vhs');
		} 
 
        // Setting up headers and body
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result);
	}
	
   /**
	* 
	* @see Zend_Rest_Controller::listAction()
	*/
	public function listAction( ) {
 	if (!array_key_exists('stabbr', $this->params))
 		{
			if (array_key_exists('zip', $this->params) AND $this->params['zip'] ) {
				$model = new VCN_Model_MasterZipcode();
				$zip   = $model->getMasterZipcode(array('zip'=>$this->params['zip']));
				foreach ($zip['data'] AS $data) {
					$this->params['stabbr'] = $data['STATE'];
				}
	  		}
 		}
 	 
  		$this->params['VHS_YN'] = 'Y';
 		
		$model = new VCN_Model_Provider();
		$result = $model->listProvider($this->params);
 
 		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'vhs');
		} 
 
 		$this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}
 
		
   /**
	* 
	* @see Zend_Rest_Controller::getAction()
	*/
	public function getAction( ) {
 		$this->params['VHS_YN'] = 'Y';
		
		$model = new VCN_Model_Provider();
		$result = $model->getProvider($this->params);
 
 
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'vhs');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	

   /**
	* 
	* @see Zend_Rest_Controller::getAction()
	*/
	public function detailAction( ) {
		$this->params['VHS_YN'] = 'Y';
		
		$model = new VCN_Model_Provider();
		$result = $model->detailProvider($this->params);
 		
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'vhs');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	
    
}