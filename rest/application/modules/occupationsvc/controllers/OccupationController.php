<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

require_once ('Zend/Rest/Controller.php');

/**
 * @author waltonr
 *
 *
 */
class OccupationSvc_OccupationController extends VCN_WebServices {
	/**
	 *
	 * @see Zend_Rest_Controller::indexAction()
	 */
	
	protected function sortToolsTech($data) {
		$result = array();
		$result['tools']=array();
		$result['technology']=array();
		foreach($data as $val) {
 			if ($val['T2_CATEGORY'] == "Tools") {
 				//$result['tools'][]=$val['T2_EXAMPLE'];
 				//if (!in_array($val['UnspscReference'][0]['UNSPSC_TITLE'], $result['tools']))
 					$result['tools'][]=$val['UnspscReference'][0]['UNSPSC_TITLE'];
 			}
 			if ($val['T2_CATEGORY'] == "Technology") {
				//$result['technology'][]=$val['T2_EXAMPLE'];
				//if (!in_array($val['UnspscReference'][0]['UNSPSC_TITLE'], $result['technology']))
					$result['technology'][]=$val['UnspscReference'][0]['UNSPSC_TITLE'];
 			}
 		}
 		
 		//sort($result['tools']);
 		//sort($result['technology']);
 		
 		$array = array_count_values($result['technology']); 	
 		arsort($array);
 			
 		$result['technology']=array(); 		
 		
 		$count=0;
 		foreach($array as $k=>$v) {
 			$count++;
 			if ($count<=5)
 				$result['technology'][]=$k;
 		}
 		sort($result['technology']);	
 			
 			
 			
 		$array = array_count_values($result['tools']); 
 		arsort($array);
 		
 		//print_r($array); exit;
 		$result['tools']=array(); 		
 		
	 	$count=0;
 		foreach($array as $k=>$v) {
 			$count++;
 			if ($count<=5)
 				$result['tools'][]=$k;
 		}
 		
 		sort($result['tools']);			
 		
 		//print_r(array_count_values($array)); exit;
 		
		return $result;	 	
	}
		
	public function indexAction() {
		$this->_helper->layout->setLayout('rest');
		throw new Exception("No data found");
	}

	public function countAction() {
		$model  = new VCN_Model_Occupation();
		$data = $model->countOccupations($this->params);
		if (!$data) return $this->_forward('index');

		if ($this->format == 'json') {
			$data = json_encode($data);
		}
		else {
			$data = VCN_WebServices::toXml($data, 'result', 'occupation');
		}

		// Setting up headers and body
		$this->_response->setHeader('Content-Type', $this->format)->setBody($data);
	}


	/**
	 *
	 * @see Zend_Rest_Controller::listAction()
	 */
	public function listAction( ) {
		$model  = new VCN_Model_Occupation();
		$data = $model->listOccupations($this->params);
		
		$count=-1;
		if (isset($this->params['skills'])) {
			foreach ($data['data'] as $occupation) {
				$count++;
				$thisonet = $occupation['onetcode'];
				$params = $this->params;
				$params['onetcode'] = $thisonet;
				unset($params['limit']);
				//echo $occupation['onetcode']."<br/>";
				//print_r($params);
				$model = new VCN_Model_Skills();
				$skills  = $model->listSkills($params);
		
				if (isset($skills['data'][0]['ELEMENTNAME'])) {
					foreach ($skills['data'] as $key=>$value) {
						$data['data'][$count]['skills'][$key]=$skills['data'][$key]['ELEMENTNAME'];
					}
				}
						
			}
		}
		$count=-1;
		if (isset($this->params['tnt'])) {
			foreach ($data['data'] as $occupation) {
				$count++;
				$thisonet = $occupation['onetcode'];
				$params = $this->params;
				$params['onetcode'] = $thisonet;
				unset($params['limit']);
				//echo $occupation['onetcode']."<br/>";
				//print_r($params);
				$model = new VCN_Model_ToolsAndTech();
				$tnt  = $model->listToolsAndTech($params);
				if (isset($tnt['data'][0]['T2_EXAMPLE'])) {
					foreach ($tnt['data'] as $key=>$value) {
						if ($tnt['data'][$key]['T2_CATEGORY']=="Tools") {
							$data['data'][$count]['toolstechnology']['tools'][$key]=$tnt['data'][$key]['UnspscReference'][0]['UNSPSC_TITLE'];
						}
					}
					
					$array = array_count_values($data['data'][$count]['toolstechnology']['tools']);
					arsort($array); 
										
					$data['data'][$count]['toolstechnology']['tools']=array();

			 		$counta=0;
			 		foreach($array as $k=>$v) {
			 			$counta++;
			 			if ($counta<=5)
			 				$data['data'][$count]['toolstechnology']['tools'][]=$k;
			 		}
			 					 		
			 		sort($data['data'][$count]['toolstechnology']['tools']);						
					
					$tcount=-1;
					foreach ($tnt['data'] as $key=>$value) {
						if ($tnt['data'][$key]['T2_CATEGORY']=="Technology") {
							$tcount++; 
							$data['data'][$count]['toolstechnology']['technology'][$tcount]=$tnt['data'][$key]['UnspscReference'][0]['UNSPSC_TITLE'];
						}
						
					}
					
					$array = array_count_values($data['data'][$count]['toolstechnology']['technology']);
					arsort($array); 
										
					$data['data'][$count]['toolstechnology']['technology']=array();

			 		$counta=0;
			 		foreach($array as $k=>$v) {
			 			$counta++;
			 			if ($counta<=5)
			 				$data['data'][$count]['toolstechnology']['technology'][]=$k;
			 		}
			 					 		
			 		sort($data['data'][$count]['toolstechnology']['technology']);						
					
				}

			}
		}		
		if (!$data) return $this->_forward('index');

		if ($this->format == 'json') {
			$data = json_encode($data);
		}
		else {
			$data = VCN_WebServices::toXml($data, 'result', 'occupation');
		}
		$this->_response->setHeader('Content-Type', $this->format)->setBody($data);
	}

	/**
	 *
	 * @see Zend_Rest_Controller::getAction()
	 */
	public function getAction( ) {
		$model = new VCN_Model_Occupation();
		$data  = $model->getOccupation($this->params);
		 
		if ($this->format == 'json') {
			$data = json_encode($data);
		}
		else {
			$data = VCN_WebServices::toXml($data, 'result', 'occupation');
		}

		$this->_response->setHeader('Content-Type', $this->format)->setBody($data);
	}


	/**
	 *
	 * @see Zend_Rest_Controller::getAction()
	 */
	public function detailAction( ) {
		$onetcode = $this->getRequest()->getParam('onetcode');

		$model = new VCN_Model_Occupation();
		$data  = $model->detailOccupation($this->params);
		
		//$this->params['onetcode'] = $model->changeCode($this->params);
		
		$model = new VCN_Model_OnetLaytitles();
		$lays  = $model->listOnetLaytitles($this->params);

		$laycount=0;
		
		if (isset($lays['data']['0']['LAYTITLE'])) {
			foreach ($lays['data'] as $key=>$value) {
				$data['data']['0']['onetsoclaytitle'][$key]['laytitle']=$lays['data'][$key]['LAYTITLE'];
				$data['data']['0']['onetsoclaytitle'][$key]['onetcode']=$lays['data'][$key]['ONETCODE'];
				
				$laycount++;
				

			}
		}		
		

		$model = new VCN_Model_Skills();
		$skills  = $model->listSkills($this->params);

		if (isset($skills['data']['0']['ELEMENTNAME'])) {
			foreach ($skills['data'] as $key=>$value) {
				$data['data']['0']['skills'][$key]=$skills['data'][$key]['ELEMENTNAME'];
			}
		}
		
		
		$model = new VCN_Model_ToolsAndTech();
		$tt  = $model->listToolsAndTech($this->params);
		
		$tt = $tt['data'];
		
		$data['data']['0']['ToolsTechnology'] = $this->sortToolsTech($tt);
		

		$oedarr=array();
		foreach ($data['data']['0']['OnetEducationDistribution'] as $oedk =>$oedv) {
			$oedarr[]=$data['data']['0']['OnetEducationDistribution'][$oedk]['datavalue'];
			
		}
		arsort($oedarr);
		//foreach ($data['data']['0']['OnetEducationDistribution'] as $oedk => $oedv)
		//print_r($data['data']['0']['OnetEducationDistribution'][$oedk]['EduCategory']); exit;

		unset($data['data']['0']['TypicalTraining']);
		
		foreach ($oedarr as $oedk => $oedv) { 
			$data['data']['0']['alltraining'][$oedk]['datavalue'] = $oedarr[$oedk];
			$data['data']['0']['alltraining'][$oedk]['category'] = $data['data']['0']['OnetEducationDistribution'][$oedk]['education_category_id'];
			$data['data']['0']['alltraining'][$oedk]['name'] = $data['data']['0']['OnetEducationDistribution'][$oedk]['EduCategory']['EDUCATION_CATEGORY_NAME'];
			
			if (!isset($data['data']['0']['TypicalTraining'])) {
				$data['data']['0']['TypicalTraining']['title'] =  $data['data']['0']['OnetEducationDistribution'][$oedk]['EduCategory']['EDUCATION_CATEGORY_NAME'];
				$data['data']['0']['TypicalTraining']['awlevelcode'] =  $data['data']['0']['OnetEducationDistribution'][$oedk]['EduCategory']['EDUCATION_CATEGORY_ID'];
			} 
		}

		
		
		unset($data['data']['0']['OnetEducationDistribution']);
		
		if ($this->format == 'json') {
			$data = json_encode($data);
		}
		else {
			$data = VCN_WebServices::toXml($data, 'result', 'occupation');
		}

		$this->_response->setHeader('Content-Type', $this->format)->setBody($data);
	}

	/**
	 *
	 * @see Zend_Rest_Controller::getAction()
	 */
	public function snapshotAction( ) {
		$onetcode = $this->getRequest()->getParam('onetcode');

		$model = new VCN_Model_Occupation();
		$data  = $model->snapshotOccupation($this->params);

		//$this->params['onetcode'] = $model->changeCode($this->params);

		if ($this->format == 'json') {
			$data = json_encode($data);
		}
		else {
			$data = VCN_WebServices::toXml($data, 'result', 'occupation');
		}

		$this->_response->setHeader('Content-Type', $this->format)->setBody($data);
	}

	/**
	 *
	 * @see Zend_Rest_Controller::putAction()
	 */
	public function putAction() {
		return $this->_forward('index');
	}

	/**
	 *
	 * @see Zend_Rest_Controller::deleteAction()
	 */
	public function deleteAction() {
		return $this->_forward('index');
	}

	/**
	 *
	 * @see Zend_Rest_Controller::postAction()
	 */
	public function postAction() {
		return $this->_forward('index');
	}
	public function listShortAction( ) {
		$onetcode = $this->getRequest()->getParam('onetcode');

		$model = new VCN_Model_Occupation();
		$data  = $model->listShort($this->params);

		//$this->params['onetcode'] = $model->changeCode($this->params);

		if ($this->format == 'json') {
			$data = json_encode($data);
		}
		else {
			$data = VCN_WebServices::toXml($data, 'result', 'occupation');
		}

		$this->_response->setHeader('Content-Type', $this->format)->setBody($data);
	}

}