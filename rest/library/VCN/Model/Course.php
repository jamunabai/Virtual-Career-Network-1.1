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
 * Courses Class
 * 
 * @package    VCN
 * @subpackage
 * @author     waltonr
 * @version    SVN: $Id:$
 */
class VCN_Model_Course extends VCN_Model_Base_Course
{
	protected $valid = array('COURSE_ID','PROGRAM_ID','cc.CIPCODE','COURSE_CODE','UNITID','LANGUAGE_CODE','BASE_COURSE_ID','SJA.SUBJECT_AREA','CT.COURSE_TYPE','DELIVERY_MODE',
	'ONETCODE','INSTNM','KEYWORD','ACTIVE_YN');
 
   /*
	* Standard count function
	* @param  array  $params parameters for query
	* @param  array  $fields parameters for select
    * @return array $select
    */	
	public function countCourse($params, $fields=false) 
	{
		// handle subject area param
		if (array_key_exists('subject_area', $params)) $params['sja.subject_area'] = $params['subject_area'];
		if (array_key_exists('course_type', $params)) $params['ct.course_type']    = $params['course_type'];
		if (array_key_exists('delivery_mode_name', $params)) $params['cdm.name']   = $params['delivery_mode_name'];
		// Duplicate filter
		if (array_key_exists('cipcode', $params)) { $params['cc.cipcode'] = $params['cipcode']; }
		
      	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
		
 	
		$stmt->from('VCN_Model_Course c')
	 		->leftJoin('c.Provider p')
	 		->leftJoin('c.Cipcode cc')	
			->leftJoin('c.Keywords ck with ck.cipcode = cc.cipcode')
			->leftJoin('ck.Keyword')
			->leftJoin('c.CourseAccreditor cacc')
	 		->leftJoin('cacc.Accreditor sa')
			->leftJoin('c.Type CT')
			->leftJoin('c.CourseDeliveryMode cdm')		
			->leftJoin('c.Language l')
			->leftJoin('c.Subject SJA')
			->leftJoin('c.Accessibility ca')
			->leftJoin('ca.Access cac')
			->leftJoin('c.Contact cct')
			->leftJoin('c.CourseOnetcode co')
			->leftJoin('c.ProgramCourseReq pc');
		 
		//distance
		if (array_key_exists('zip',$params) AND $params['zip']) {
			if (array_key_exists('latitude',$params) AND array_key_exists('longitude',$params) ) {
			 	 $distance = (array_key_exists('distance',$params) AND $params['distance']) ? $params['distance'] : 25;
 			   	 $stmt->addselect('round(SQRT( power(abs(p.longitude-('.$params['longitude'].')),2)+power(abs(p.latitude-('.$params['latitude'].')),2))/0.0144,1) distance');
				 $stmt->addwhere('(round(SQRT( power(abs(p.longitude-('.$params['longitude'].')),2)+power(abs(p.latitude-('.$params['latitude'].')),2))/0.0144,1) <= '.$distance.')');
			}
		}
		  	
        if ($query['where']) {	foreach ($query['where'] AS $where) { $stmt->addwhere($where); }    }
        if ($query['limit'])    $stmt->limit($query['limit']);
        if ($query['offset'])   $stmt->offset($query['offset']);
        if ($query['order'])    $stmt->orderby($query['order']);
         
        
//  echo $stmt->getSqlQuery();exit; 
 	    $data['count'] = $stmt->count();
 	    
    	//handle params
 		if (array_key_exists('sja.subject_area', $params)) unset($params['sja.subject_area']);
 		if (array_key_exists('ct.course_type', $params)) unset($params['ct.course_type']);
 		if (array_key_exists('cdm.name', $params)) unset($params['cdm.name']);
 		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	/*
	* Standard list function
	* @param  array  $params parameters for query
	* @param  array  $fields parameters for select
    * @return array $select
    */	
	public function listCourse($params, $fields=false) 
	{
		// handle subject area param
		if (array_key_exists('subject_area', $params)) $params['sja.subject_area'] = $params['subject_area'];
		if (array_key_exists('course_type', $params)) $params['ct.course_type']    = $params['course_type'];
		if (array_key_exists('delivery_mode_name', $params)) $params['cdm.name']  = $params['delivery_mode_name'];
		// Duplicate filter
		if (array_key_exists('cipcode', $params)) { $params['cc.cipcode'] = $params['cipcode']; }
		
 		
    	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery()->select();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) 
		{ 
			foreach ($select AS $field) { $stmt->addselect($field); } 
		}
		else {
		 	$stmt->addselect('c.*,p.*,cc.*, CT.*,cdm.*, SJA.*');
		}
 	
		$stmt->from('VCN_Model_Course c')
	 		->leftJoin('c.Provider p')
	 		->leftJoin('c.Cipcode cc')	
			->leftJoin('c.Keywords ck with ck.cipcode = cc.cipcode')
			->leftJoin('ck.Keyword')
			->leftJoin('c.CourseAccreditor cacc')
	 		->leftJoin('cacc.Accreditor sa')
			->leftJoin('c.Type CT')
			->leftJoin('c.CourseDeliveryMode cdm')		
			->leftJoin('c.Language l')
			->leftJoin('c.Subject SJA')
			->leftJoin('c.Accessibility ca')
			->leftJoin('ca.Access cac')
			->leftJoin('c.Contact cct')
			->leftJoin('c.CourseOnetcode co')
			->leftJoin('c.ProgramCourseReq pc');
		
			//distance
			if (array_key_exists('zip',$params) AND $params['zip']) {
				if (array_key_exists('latitude',$params) AND array_key_exists('longitude',$params) ) {
		 		 	 $distance = (array_key_exists('distance',$params) AND $params['distance']) ? $params['distance'] : 25;
 				   	 $stmt->addselect('round(SQRT( power(abs(p.longitude-('.$params['longitude'].')),2)+power(abs(p.latitude-('.$params['latitude'].')),2))/0.0144,1) distance');
					 $stmt->addwhere('(round(SQRT( power(abs(p.longitude-('.$params['longitude'].')),2)+power(abs(p.latitude-('.$params['latitude'].')),2))/0.0144,1) <= '.$distance.')');
				}
		  	}
 
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
     	if ($query['limit'])    $stmt->limit($query['limit']);
        if ($query['offset'])   $stmt->offset($query['offset']);
        if ($query['order'])    $stmt->orderby($query['order']);
   	     
//echo $stmt->getSqlQuery();exit;          
    	$data = $stmt->fetchArray();
    	
    	//handle params
 		if (array_key_exists('sja.subject_area', $params)) unset($params['sja.subject_area']);
 		if (array_key_exists('ct.course_type', $params)) unset($params['ct.course_type']);
 		if (array_key_exists('cdm.name', $params)) unset($params['cdm.name']);
 				// Duplicate filter
 		if (array_key_exists('cc.cipcode', $params)) unset($params['cc.cipcode']);
 		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;		
	}
	
   /*
	* Standard get function
	* @param  array  $params parameters for query
	* @param  array  $fields parameters for select
    * @return array $select
    */	
	public function getCourse($params, $fields=false) 
	{
 		// Duplicate filter
		if (array_key_exists('cipcode', $params)) { $params['cc.cipcode'] = $params['cipcode']; }
		
 		$query = $this->parseParams($params, $this->valid);
 	 	$required = array('course_id');
		$missing = $multiples = $sep = $msep = false;
		
	 	foreach ($required AS $req)
		{ 
			if (!isset($params[$req]))  
			{ 
				$missing  .= $sep.$req;
				$sep = ', ';
 			}
 			elseif (is_array($params[$req]))
 			{
 				$multiples .= $msep.$req;
 			}
		}
	 	if ($missing) 
	 	{
	 		$this->setResult('fail','Missing Parameters: '.$missing,$params, false);
	 		return $this->result;
	 	}
	 	
	 	if ($multiples)
	 	{
	 		$this->setResult('fail','Multiple values for Parameters: '.$multiples,$params, false);
	 		return $this->result;
	 	}
		
 	 	$stmt = $this->getTable()->createquery();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
   
   		$data = $stmt->fetchArray();
     	 				// Duplicate filter
 		if (array_key_exists('cc.cipcode', $params)) unset($params['cc.cipcode']);
 		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
 	
   /*
	* Standard detail function
	* @param  array  $params parameters for query
	* @param  array  $fields parameters for select
    * @return array $select
    */	
	public function detailCourse($params, $fields=false) 
	{
 		// Duplicate filter
		if (array_key_exists('cipcode', $params)) { $params['cc.cipcode'] = $params['cipcode']; }
		
 		$query = $this->parseParams($params, $this->valid);
 	 	$required = array('course_id');
		$missing = $multiples = $sep = $msep = false;
		
	 	foreach ($required AS $req)
		{ 
			if (!isset($params[$req]))  
			{ 
				$missing  .= $sep.$req;
				$sep = ', ';
 			}
 			elseif (is_array($params[$req]))
 			{
 				$multiples .= $msep.$req;
 			}
		}
	 	if ($missing) 
	 	{
	 		$this->setResult('fail','Missing Parameters: '.$missing,$params, false);
	 		return $this->result;
	 	}
	 	
	 	if ($multiples)
	 	{
	 		$this->setResult('fail','Multiple values for Parameters: '.$multiples,$params, false);
	 		return $this->result;
	 	}
		
 	 	$stmt = $this->getTable()->createquery();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
		
		$stmt->from('VCN_Model_Course c')
	 		->leftJoin('c.Provider p')
	 		->leftJoin('c.Cipcode cc')	
			->leftJoin('c.Keywords ck with ck.cipcode = cc.cipcode')
			->leftJoin('ck.Keyword')
			->leftJoin('c.CourseAccreditor cacc')
	 		->leftJoin('cacc.Accreditor sa')
			->leftJoin('c.Type ct')
			->leftJoin('c.CourseDeliveryMode cdm')		
			->leftJoin('c.Language l')
			->leftJoin('c.Subject SJA')
			->leftJoin('c.Accessibility ca')
			->leftJoin('ca.Access cac')
			->leftJoin('c.Contact cct')
			->leftJoin('c.CourseOnetcode co');
		
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
 
//  echo $stmt->getSqlQuery();exit;  
   		$data = $stmt->fetchArray();
     	 				// Duplicate filter

   		
		if ($data[0]['COURSE_INFO_URL_FLAG']!=1) {
			unset($data[0]['COURSE_INFO_URL']);			
		}
		
		if ($data[0]['ONLINE_COURSE_URL_FLAG']!=1) {
			unset($data[0]['ONLINE_COURSE_URL']);			
		}   		
		
		if ($data[0]['Provider']['WEBADDR_FLAG']!=1) {
			unset($data[0]['Provider']['WEBADDR']);
		}
			
		if ($data[0]['Provider']['ADMINURL_FLAG']!=1) {
			unset($data[0]['Provider']['ADMINURL']);			
		}
		
		if ($data[0]['Provider']['APPLURL_FLAG']!=1) {
			unset($data[0]['Provider']['APPLURL']);			
		}	
		
		if ($data[0]['Provider']['FAIDURL_FLAG']!=1) {
			unset($data[0]['Provider']['FAIDURL']);			
		}		
			
 		if (array_key_exists('cc.cipcode', $params)) unset($params['cc.cipcode']);
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}	
}
 