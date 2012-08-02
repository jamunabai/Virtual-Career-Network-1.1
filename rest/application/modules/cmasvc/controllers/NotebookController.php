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
 * @author hills
 *
 * TODO -- Because this code is so damned specific, I'm using stfips for programs too
 *  which now requires cipcode.
 *   AGAIN stfips is also cipcode!!!!!!! Fix it on the refactor after launch
 */
class CmaSvc_NotebookController extends VCN_WebServices {

    private $user_id;
    private $item_type;
    private $item_id;
    private $item_notes;
    private $stfips;

    private $requested_item_type = array();

    public function init() {
        parent::init();
        $this->requested_item_type['career']      = VCN_Model_CmaUserNotebookTable::$OCCUPATION;
        $this->requested_item_type['certificate'] = VCN_Model_CmaUserNotebookTable::$CERTIFICATE;
        $this->requested_item_type['course']      = VCN_Model_CmaUserNotebookTable::$COURSE;
        $this->requested_item_type['license']     = VCN_Model_CmaUserNotebookTable::$LICENSE;
        $this->requested_item_type['program']     = VCN_Model_CmaUserNotebookTable::$PROGRAM;
        $this->requested_item_type['vhs']         = VCN_Model_CmaUserNotebookTable::$VIRTUALHIGH;

        //error_log("NotebookController init - params: " . print_r($this->params,TRUE));
        
        $request_item_type  = (isset($this->params['item_type'])) ? $this->params['item_type'] : 'career';

        $this->item_type    = $this->requested_item_type[$request_item_type];

        $this->user_id      = $this->params['user_id'];

        $this->item_id    = (isset($this->params['item_id'])) ? $this->params['item_id'] : NULL;
        $this->item_notes = (isset($this->params['item_notes'])) ? $this->params['item_notes'] : NULL;
        $this->stfips     = (isset($this->params['item_stfips'])) ? $this->params['item_stfips'] : NULL;

    }

    /**
     *
     * @see Zend_Rest_Controller::indexAction()
     */
    public function indexAction() {
        $this->_helper->layout->setLayout('rest');
        throw new Exception("No data found");
    }


    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    public function saveCareerAction() {

        $this->user_id    = $this->params['user_id'];
        $this->item_type  = VCN_Model_CmaUserNotebookTable::$OCCUPATION;
        $this->item_id    = $this->params['onetcode'];
        $this->item_notes = $this->params['notes'];
        $this->stfips     = NULL;

        
        $data = $this->_saveToNotebook();

        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    public function saveToNotebookAction() {
    	
    	
    	if ($this->item_type!='OCCUPATION') {
    		
    		$data = $this->_saveToNotebook();
        	$this->_response->setHeader('Content-Type', $this->format)->setBody($data);
        	return;
    		
    	}
    	
    	$data = $this->_getCareers($this->_getNotebookItems());
    	$data = new SimpleXMLElement($data);
    	   	
    	  	
   		$nosaved=0;

    	foreach ($data->data->contentresults->item as $v) {
    		
    		$nosaved++;
    		
    	}
    	//echo $nosaved;
    	if (!$nosaved) {
    		$data = $this->_targetNotebookItem();    		
    	}
    	elseif ($nosaved <= 3) {
       		 $data = $this->_saveToNotebook();
       		 $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    	}
    	
	   else {
	    	return;
	    }
        
    }

    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    public function removeCareerAction() {

        $this->user_id    = $this->params['user_id'];
        $this->item_type  = VCN_Model_CmaUserNotebookTable::$OCCUPATION;
        $this->item_id    = $this->params['onetcode'];
        $this->stfips     = NULL;

        $data = $this->_removeFromNotebook();

        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    public function removeFromNotebookAction() {
        $data = $this->_removeFromNotebook();
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    public function targetCareerAction() {

        $this->user_id    = $this->params['user_id'];
        $this->item_type  = VCN_Model_CmaUserNotebookTable::$OCCUPATION;
        $this->item_id    = $this->params['onetcode'];
        $this->stfips     = NULL;

        $data = $this->_targetNotebookItem();

        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    public function targetNotebookItemAction() {
        $data = $this->_targetNotebookItem();
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    /**
     *
     * @see Zend_Rest_Controller::getAction()
    public function listCareersAction() {

        $this->user_id    = $this->params['user_id'];
        $this->item_type  = VCN_Model_CmaUserNotebookTable::$OCCUPATION;

        $data = $this->_getNotebookItems();

        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }
     */

    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    public function listNotebookItemsAction() {

        $request_item_type  = (isset($this->params['item_type'])) ? $this->params['item_type'] : 'career';

        $this->user_id      = $this->params['user_id'];
        $this->item_type    = $this->requested_item_type[$request_item_type];

        $data = $this->_getNotebookItems();

        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    /*
    public function getCareersAction() {

        $this->user_id    = $this->params['user_id'];
        $this->item_type  = VCN_Model_CmaUserNotebookTable::$OCCUPATION;

        $careerResults = $this->_getNotebookItems(TRUE);

        $onetcodes = array();
        foreach ($careerResults['data'] as $career) {
    //        error_log('career: ' . print_r($career,TRUE));
            $onetcodes[] = $career['onetcode'];
        }

        $occupation = new VCN_Model_Occupation();
        $params = array('onetcode' => $onetcodes);

        $snapshotResults = $occupation->snapshotOccupation($params);

        $data = $careerResults;  // includes status and other array elements

        unset($data['data']);
        $data['data']['careerResults']   = $careerResults['data'];
        $data['data']['snapshotResults'] = $snapshotResults['data'];
        
        $data = $this->_formatData($data);

        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }
     */

    /**
     *
     * @see Zend_Rest_Controller::getAction()
     */
    
    public function getNotebookItemsAction() {

   //     error_log('getNotebookItemsAction - item_type:' . $this->item_type . ':');
        $notebookResults = $this->_getNotebookItems(TRUE);

  //      error_log('NotebookController - getNotebookItemsAction - notebookResults: ' . print_r($notebookResults,TRUE));

        switch (strtolower($this->item_type)) {
            
            case 'vhs'     :
                    $data = $this->_getVirtualHighSchools($notebookResults);
                    break;
            case 'program'     :
                    $data = $this->_getPrograms($notebookResults);
                    break;
            case 'license'     :
                    $data = $this->_getLicenses($notebookResults);
                    break;
            case 'course'      :
                    $data = $this->_getCourses($notebookResults);
                    break;
            case 'certificate' :
                    $data = $this->_getCertificates($notebookResults);
                    break;
            case 'career'      :
            default            :
                    $data = $this->_getCareers($notebookResults);
                    break;
        }
  
//        error_log('NotebookController - getNotebookItemsAction - complete Results: ' . print_r($data,TRUE));
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    
    public function listNotebookTargetsAction() {
        $this->user_id  = $this->params['user_id'];
        $data = $this->_getNotebookTargets(TRUE);
       
     	foreach ($data['data'] AS $key=>$value)
        {

           	switch (strtolower($value['ITEM_TYPE'])) {
          		case 'program'     :
          			   	//TODO USING STFIPS FOR CIPCODE RENAME TO GENERIC IN REFACTOR    
           				$program_ids[] = $value['STFIPS'].$value['ITEM_ID'];
						$program = VCN_Model_ProgramTable::getProgramsForCma($program_ids);
						$data['data'][$key]['program'] = $program['data'];
	          	break;
 	            case 'certificate' :
	            		$certificate_ids[] = $value['ITEM_ID'];
	            		$certificate = VCN_Model_CertificationsTable::getCertificatesForCma($certificate_ids);
	                    $data['data'][$key]['certification'] = $certificate['data'];
                break;           
	          	case 'vhs'     :
	            		$vhs_unitids[] = $value['ITEM_ID'];
 	          			$vhs = VCN_Model_ProviderTable::getVirtualHighSchoolsForCma($vhs_unitids);
 	                    $data['data'][$key]['vhs'] =$vhs['data'];
	       		break;
 	            case 'license'     :
  					$stfips_licenseids[] = $value['STFIPS'] . $value['ITEM_ID'];
        			$license = VCN_Model_LicenseTable::getLicensesForCma($stfips_licenseids);
 	           		$data['data'][$key]['license'] = $license['data'];
 	         	break;
	            case 'course'	   :    
	           		$course_ids[] = $value['ITEM_ID'];
 	          		$course = VCN_Model_CourseTable::getCoursesForCma($course_ids);
 	              	$data['data'][$key]['course'] = $course['data'];
	       		break;
 	            case 'occupation'      :
	           		$onetcodes[] = $value['ITEM_ID'];
   					$occupation = new VCN_Model_Occupation();
        			$params = array('onetcode' => $onetcodes);
        			$result = $occupation->snapshotOccupation($params);
 				    $data['data'][$key]['occupation'] = $result['data']; 
  	        	break;
	        	default            :
        	}
        	
        }
        
        $data = $this->_formatData($data);
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }
     
    
    
    
    
    
    
    
    
    
    
    
    
    private function _getVirtualHighSchools($notebookResults) {

        $vhs_unitids = array();
        foreach ($notebookResults['data'] as $vhs) {
            $vhs_unitids[] = $vhs['vhs_unitid'];
        }

        $contentResults = VCN_Model_ProviderTable::getVirtualHighSchoolsForCma($vhs_unitids);

  //      error_log('NotebookController - _getPrograms - contentResults: ' . print_r($contentResults,TRUE));

        $data = $notebookResults;  // includes status and other array elements

        unset($data['data']);
        $data['data']['notebookResults'] = $notebookResults['data'];
        $data['data']['contentResults']  = $contentResults['data'];

        return $this->_formatData($data);
    }

    private function _getPrograms($notebookResults) {

        $program_ids = array();
        foreach ($notebookResults['data'] as $program) {
 			// TODO using stfips for cipcode needs to be renamed generically
            $program_ids[] = $program['STFIPS'].$program['program_id'];
        }

        $contentResults = VCN_Model_ProgramTable::getProgramsForCma($program_ids);

  //      error_log('NotebookController - _getPrograms - contentResults: ' . print_r($contentResults,TRUE));

        $data = $notebookResults;  // includes status and other array elements

        unset($data['data']);
        $data['data']['notebookResults'] = $notebookResults['data'];
        $data['data']['contentResults']  = $contentResults['data'];

        return $this->_formatData($data);
    }

    private function _getLicenses($notebookResults) {

        $stfips_licenseids = array();
        foreach ($notebookResults['data'] as $license) {
            $stfips_licenseids[] = $license['STFIPS'] . $license['license_id'];
        }
  //      error_log('NotebookController - _getLicenses - stfips_licenseids: ' . print_r($stfips_licenseids,TRUE));

        $contentResults = VCN_Model_LicenseTable::getLicensesForCma($stfips_licenseids);
 
        //error_log('NotebookController - _getLicenses - contentResults: ' . print_r($contentResults,TRUE));

        $data = $notebookResults;  // includes status and other array elements

        unset($data['data']);
        $data['data']['notebookResults'] = $notebookResults['data'];
        $data['data']['contentResults']  = $contentResults['data'];

        return $this->_formatData($data);
    }

    private function _getCourses($notebookResults) {

        $course_ids = array();
        foreach ($notebookResults['data'] as $course) {
            $course_ids[] = $course['course_id'];
        }

        $contentResults = VCN_Model_CourseTable::getCoursesForCma($course_ids);

  //      error_log('NotebookController - _getCourses - contentResults: ' . print_r($contentResults,TRUE));

        $data = $notebookResults;  // includes status and other array elements

        unset($data['data']);
        $data['data']['notebookResults'] = $notebookResults['data'];
        $data['data']['contentResults']  = $contentResults['data'];

        return $this->_formatData($data);
    }

    private function _getCertificates($notebookResults) {

        $certificate_ids = array();
        foreach ($notebookResults['data'] as $certificate) {
            $certificate_ids[] = $certificate['cert_id'];
        }

        $contentResults = VCN_Model_CertificationsTable::getCertificatesForCma($certificate_ids);

   //     error_log('NotebookController - _getCertificates - contentResults: ' . print_r($contentResults,TRUE));

        $data = $notebookResults;  // includes status and other array elements

        unset($data['data']);
        $data['data']['notebookResults'] = $notebookResults['data'];
        $data['data']['contentResults']  = $contentResults['data'];

        return $this->_formatData($data);
    }

    private function _getCareers($notebookResults) {

        $onetcodes = array();
        foreach ($notebookResults['data'] as $career) {
            $onetcodes[] = $career['onetcode'];
        }

        $occupation = new VCN_Model_Occupation();
        $params = array('onetcode' => $onetcodes);

        $contentResults = $occupation->snapshotOccupation($params);

        $data = $notebookResults;  // includes status and other array elements

        unset($data['data']);
        $data['data']['notebookResults'] = $notebookResults['data'];
        $data['data']['contentResults']  = $contentResults['data'];

        return $this->_formatData($data);
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



    // private methods /////////////////////////////////////////////////////////////////////

    private function _saveToNotebook() {
        $data = VCN_Model_CmaUserNotebookTable::addToNotebook($this->user_id,
                                                              $this->item_type,
                                                              $this->item_id,
                                                              $this->item_notes,
                                                              $this->stfips
                                                              );

        return $this->_formatData($data);
    }

    private function _removeFromNotebook() {
    	if ($this->item_type == 'OCCUPATION')
    	{
     		$occupation = VCN_Model_CmaUserNotebookTable::getNotebookItems($this->user_id,$this->item_type, true);
     		$current_item_id = $occupation['data'][0]['ITEM_ID'];
     		//error_log("G got that thing done !!! ". print_r($occupation['data'][0]['ITEM_ID'] , TRUE));
     		//error_log("NotebookController init - params: " . print_r($this->item_id,TRUE));
     		if($occupation['data'][0]['ITEM_RANK'] === '1' && $occupation['data'][0]['ITEM_ID'] === $this->item_id){
    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'PROGRAM' );
    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'CERTIFICATE' );
    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'LICENSE' );
    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'COURSE' );     			
     		}
    		
/*    		if ($current_item_id !== $this->item_id)
    		{
    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'PROGRAM' );
    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'CERTIFICATE' );
    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'LICENSE' );
    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'COURSE' );
     		}*/
    	}
      	
    	
        $data = VCN_Model_CmaUserNotebookTable::removeFromNotebook($this->user_id,
                                                                   $this->item_type,
                                                                   $this->item_id,
                                                                   $this->stfips
                                                                   );

        return $this->_formatData($data);
    }

    private function _targetNotebookItem() {
     	// if occupation get the current and untarget dependencies if change
    	if ($this->item_type == 'OCCUPATION')
    	{
     		$occupation = VCN_Model_CmaUserNotebookTable::getNotebookItems($this->user_id,$this->item_type, true);
     		if(isset($occupation['data'][0]['ITEM_ID'])){
     			$current_item_id = $occupation['data'][0]['ITEM_ID'];
    			if ($current_item_id !== $this->item_id)
    			{
    				VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'PROGRAM' );
    				VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'CERTIFICATE' );
    				VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'LICENSE' );
    				VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'COURSE' );
    				VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($this->user_id,'OCCUPATION' );
     			}
     		}
     	}
    	
		$data = VCN_Model_CmaUserNotebookTable::targetNotebookItem($this->user_id,
                                                                   $this->item_type,
                                                                   $this->item_id,
                                                                   $this->stfips
                                                                   );
                                                                   
         return $this->_formatData($data);
    }

    private function _getNotebookItems($returnRawData = FALSE) {
        $data = VCN_Model_CmaUserNotebookTable::getNotebookItems($this->user_id,
                                                                 $this->item_type
                                                                 );

                                                               
       // if ($returnRawData) {
            return $data;
      //  }
        
        return $this->_formatData($data);
    }

    private function _getNotebookTargets($returnRawData = FALSE) {
        $data = VCN_Model_CmaUserNotebookTable::getNotebookTargets( $this->user_id );
 
        if ($returnRawData) {
            return $data;
        }
        return $this->_formatData($data);
    }
    
    
    private function _formatData($data) {
        if ($this->format == 'json') {
            $data = json_encode($data);
        } else {
            $data = VCN_WebServices::toXml($data, 'result', 'cma');
        }

        return $data;
    }

}
