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
class TrainingSvc_CoursesController extends VCN_WebServices {
   
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
		
 		$model = new VCN_Model_Course();
		$result = $model->countCourse($this->params);
		 
		// unset derived params
		if (array_key_exists('cipcode',  $result['params'])) unset($result['params']['cipcode']);
		if (array_key_exists('latitude', $result['params'])) unset($result['params']['latitude']);
		if (array_key_exists('longitude',$result['params'])) unset($result['params']['longitude']);
		
 		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'courses');
		} 
 
        // Setting up headers and body
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result);
	}
	
   /**
	* 
	* @see Zend_Rest_Controller::listAction()
	*/
	public function listAction( ) {
		if ( isset($this->params['onetcode']) ) {
			// get the cipcodes
	  		$model  = new VCN_Model_Socxcip();
			$cipcodes = $model->listSocxcip(array('onetcode'=>$this->params['onetcode'])) ;
 		
	 		foreach ($cipcodes['data'] AS $data) {
	 			$cipcode = $data['CIPCODE'];
	  			$this->params['cipcode'][] = $cipcode;
	  		} 
		}
		if (isset ($this->params['zip'])) {
			$model = new VCN_Model_MasterZipcode();
			$zip   = $model->getMasterZipcode(array('zip'=>$this->params['zip']));
	 	 
			foreach ($zip['data'] AS $data) {
				$this->params['latitude'] = $data['LATITUDE'];
				$this->params['longitude']= $data['LONGITUDE'];
			}
 		}
 
		$model = new VCN_Model_Course();
		$result = $model->listCourse($this->params);

		// unset derived params
		if (array_key_exists('cipcode',  $result['params'])) unset($result['params']['cipcode']);
		if (array_key_exists('latitude', $result['params'])) unset($result['params']['latitude']);
		if (array_key_exists('longitude',$result['params'])) unset($result['params']['longitude']);
				
 		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'courses');
		} 
 
 		$this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}
 
		
   /**
	* 
	* @see Zend_Rest_Controller::getAction()
	*/
	public function getAction( ) {
	 		
		$model = new VCN_Model_Course();
		$result = $model->getCourse($this->params);
 
 
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'courses');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	

   /**
	* 
	* @see Zend_Rest_Controller::getAction()
	*/
	public function detailAction( ) {
		$model = new VCN_Model_Course();
		$result = $model->detailCourse($this->params);
 		
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'courses');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	
    
	public function  listCourseTypeAction() {
		$model = new VCN_Model_CourseType();
		$result = $model->listCourseType($this->params);

		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'courses');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
  	}
		
	public function listSubjectAreaAction () {
		$model = new VCN_Model_SubjectArea();
		$result = $model->listSubjectArea($this->params);

		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'courses');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
   	}
		
	public function listDeliveryModeAction () {
		$model = new VCN_Model_CourseDeliveryMode();
		$result = $model->listCourseDeliveryMode($this->params);
		
		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'courses');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
   	}
	public function listLanguageCodeAction () {
		$model = new VCN_Model_Language();
		$result = $model->listLanguage($this->params);
		
		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'courses');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
   	}
   	

}