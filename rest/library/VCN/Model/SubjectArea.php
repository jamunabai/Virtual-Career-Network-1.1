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
 * VCN_Model_SubjectArea
 * 
 * @package    VCN
 * @subpackage VCN_Model
 * @author     waltonr
 */
class VCN_Model_SubjectArea extends VCN_Model_Base_SubjectArea
{
	protected $valid = array('SUBJECT_AREA','CREATED_BY');
    /*
	* Standard count function
	* @param  array  $params parameters for query
	* @param  array  $fields parameters for select
    * @return array $select
    */	
	public function countSubjectArea($params, $fields=false) 
	{
      	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) {
        	foreach ($select AS $field) { $stmt->addselect($field); }
		}
        if ($query['where']) {
        	foreach ($query['where'] AS $where) { $stmt->addwhere($where); }
        }
   
 	    $data['count'] = $stmt->count();

 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function listSubjectArea($params, $fields=false) 
	{
    	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery()->select();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
     	if ($query['limit'])    $stmt->limit($query['limit']);
        if ($query['offset'])   $stmt->offset($query['offset']);
        if ($query['order'])    $stmt->offset($query['order']);
   	     
    	$data = $stmt->fetchArray();
 
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;		
	}
	
	public function getSubjectArea($params, $fields=false) 
	{
 
 		$query = $this->parseParams($params, $this->valid);
 	 	$required = array('subject_area');
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
     	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
 	
 	
 	public function saveSubjectArea($params, $fields=false) 
	{
		//education_id is the key for this table
		$subjectarea = false;
	    if (array_key_exists('subject_area',$params) && $params['subject_area'])
		{
			$subjectarea = Doctrine_Core::getTable('VCN_Model_SubjectArea')->findOneBySubject_area($params['subject_area']);
		} 

        if ( ! $subjectarea) {
            $subjectarea = new VCN_Model_SubjectArea();
           	$subjectarea->CREATED_TIME = date('Y-m-d H:i:s',mktime()); 
        }
        
      	$subjectarea->SUBJECT_AREA = (array_key_exists('subject_area', $params) AND $params('subject_area') ) ? $params['subject_area'] : '';
        $subjectarea->DESCRIPTION  = (array_key_exists('description', $params) AND $params('description') )   ? $params['description'] : '';
        $subjectarea->ACTIVE_YN    = (array_key_exists('active_yn', $params) AND $params('active_yn') )       ? $params['active_yn'] : '';
        $subjectarea->CREATED_BY   = (array_key_exists('created_by', $params) AND $params('created_by') )     ? $params['created_by'] : '';
        $subjectarea->UPDATED_BY   = (array_key_exists('updated_by', $params) AND $params('updated_by') )     ? $params['updated_by'] : '';
      	$subjectarea->UPDATED_TIME = date('Y-m-d H:i:s',mktime());
       	
       	$subjectarea->save();
      	
     	 
     	$data = false;
      	$this->setResult('success', 'data saved', $params, $data);
   	     	
		return $this->result;		
	}
	
 	public function deleteSubjectArea($params, $fields=false) 
	{
		$subjectarea = false;
		$data = false;
	    if (array_key_exists('subject_area',$params) && $params['subject_area'])
		{
			$subjectarea = Doctrine_Core::getTable('VCN_Model_SubjectArea')->findOneBySubject_area($params['subject_area']);
		} 

        if ( ! $subjectarea) {
         	$this->setResult('fail', 'record not found', $params, $data);
 			return $this->result;
        }
        $subjectarea->delete();
     	     
     
      	$this->setResult('success', 'data deleted', $params, $data);
   	     	
		return $this->result;		
	}
 	
		
}
 