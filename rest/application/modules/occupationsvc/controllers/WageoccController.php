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
class OccupationSvc_WageoccController extends VCN_WebServices {
 
    	
  /**
	* 
	* @see Zend_Rest_Controller::indexAction()
    */
	public function indexAction( ) {
		 $this->_helper->layout->setLayout('rest');
	  	 throw new Exception("Invalid Request");
	}	
		
	public function countAction() {
		
 		$model  = new VCN_Model_Wageocc();
		$data = $model->countWageOcc($this->params);
 		
 		if ($this->format == 'json') {
 			$data = json_encode($data);
		}
		else {
			$data = $this->toXml($data, 'result', 'wageocc');
		} 
 
        // Setting up headers and body
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
	}
	
   /**
	* 
	* @see Zend_Rest_Controller::listAction()
	*/
	public function listAction( ) {
 		$model  = new VCN_Model_WageOcc();
		$data = $model->listWageocc($this->params);
 		
		if ($this->format == 'json') {
 			$data = json_encode($data);
		}
		else {
			$data = $this->toXml($data, 'result', 'wageocc');
		} 

 		$this->_response->setHeader('Content-Type', $this->format)->setBody($data); 
	}
 
		
   /**
	* 
	* @see Zend_Rest_Controller::getAction()
	 */
	public function getAction( ) {
  		$model = new VCN_Model_WageOcc();
	 	$data  = $model->getWageOcc($this->params);
 
	 	if ($this->format == 'json') {
 			$data = json_encode($data);
		}
		else {
			$data = $this->toXml($data, 'result', 'wageocc');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data); 
	}	

 	
    
}