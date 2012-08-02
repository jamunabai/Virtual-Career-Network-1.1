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
class TrainingSvc_TrainingController extends VCN_WebServices {
  	
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
				$this->params['latitude'] = $data['LATITUDE'];
				$this->params['longitude']= $data['LONGITUDE'];
				
				if (!array_key_exists('stfips',$this->params))
				{
					$this->params['stfips'] = $data['Licstate']['STFIPS'];
				}
			}
 		}
 
 		
 		$ecli='';
 		if (array_key_exists( 'education_category_id_less', $this->params)) {
 			$ecli = $this->params['education_category_id_less'];
 			unset($this->params['education_category_id_less']);
 		}
 		
		if ( array_key_exists( 'onetcode', $this->params)  ) {
	 		$model       = new VCN_Model_Occupation();
			$occupation  = $model->getOccupation($this->params);
 
			$result['status'] = $occupation['status'];
			$result['params'] = $occupation['params'];
			if ($result['status']['code'] == 'success')
				$result['data']['occupation'] = $occupation['data'][0];
			else 
	 			$result['data']['occupation'] = false;
		}
 		else 
 		{
			$result['status'] = 'success';
			$result['params'] = false;
 			$result['data']['occupation'] = false;
 		}
 		
  		if ($ecli>0)
  			$this->params['education_category_id_less'] = $ecli;  
 		
 		$model          = new VCN_Model_Program();
		$programs_count = $model->countProgram($this->params);
		$result['data']['programs_count']  = $programs_count['data']['count'];			
 
		$model = new VCN_Model_Certifications();
		$certifications_count = $model->countCertifications($this->params);
		$result['data']['certifications_count']  = $certifications_count['data']['count'];
  		
	 	$model = new VCN_Model_License();
		$licenses_count = $model->countLicenses($this->params);
		$result['data']['licenses_count']        = $licenses_count['data']['count'];
 		
	 	$model = new VCN_Model_Course();
		$courses_count = $model->countCourse($this->params);	
		$result['data']['courses_count']         = $courses_count['data']['count'];
 
	 	$model = new VCN_Model_Provider();
		$provider = $model->countProvider($this->params);	
		$result['data']['provider_count'] = $provider['data']['count'];
		
 		$this->params['VHS_YN'] = 'Y';
 		$model = new VCN_Model_Provider();
		$vhs_count = $model->countProvider($this->params);	
		$result['data']['vhs_count'] = $vhs_count['data']['count'];
		
	    if (is_array($result['params']))
	    {
			if (array_key_exists('latitude', $result['params'])) unset($result['params']['latitude']);
			if (array_key_exists('longitude',$result['params'])) unset($result['params']['longitude']);
	    }
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'program');
		} 
 
        // Setting up headers and body
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result);
	}
	
   /**
	* 
	* @see Zend_Rest_Controller::listAction()
	*/
	public function listAction( ) {
		$type = isset($this->params['type']) ? $this->params['type'] : false;
		$data = false;
		switch ($type)
		{
			case 'program':
				// get the cipcodes
  				$model  = new VCN_Model_Socxcip();
				$cipcodes = $model->listSocxcip($this->params);
			
 				foreach ($cipcodes['data'] AS $data) {
 					$cipcode = $data['CIPCODE'];
  					$this->params['cipcode'][] = $cipcode;
  				} 

		 		// find the schools offering program and get the programs and information
		 		$model = new VCN_Model_Schools();
				$result = $model->listSchools($this->params);
 
			break;
			case 'certification':
				$model  = new VCN_Model_Certifications();
				$certifications = $model->listCertifications($this->params);
			break;
			case 'license':
				$model  = new VCN_Model_Certifications();
				$licenses = $model->listCertifications($this->params);
			break;
			default:
				$this->_forward('index');
		}
		

		$result = $data;
		if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result','training' );
		} 
  
 		$this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}
 
		
   /**
	* 
	* @see Zend_Rest_Controller::getAction()
	 */
	public function getAction( ) {
  		$model = new VCN_Model_EductrainexpCategories();
	 	$result  = $model->getEductrainexpCategory($this->params);
	 
	 	if ($this->format == 'json') {
 			$result = json_encode($result);
		}
		else {
			$result = $this->toXml($result, 'result', 'eductrainexp_category');
		} 
 
        $this->_response->setHeader('Content-Type', $this->format)->setBody($result); 
	}	

	public function TestItAction( ) 
	{
  	
	}
}