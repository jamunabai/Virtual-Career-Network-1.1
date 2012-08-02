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
class  VCN_Model_Skills extends VCN_Model_Base_Skills {
	protected $valid = array('ONETCODE','ELEMENTID','ELEMENTNAME','SCALEID','TITLE');
		
	
	public function countSkills($params, $fields=false)
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params))
		{
			$params['onetcode_new'] = $params['onetcode'];
			unset($params['onetcode']);
		}
		
    	$query = $this->parseParams($params, $this->valid);
		$stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
		
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
		
		// adding crosswalk
		$stmt->from('VCN_Model_Skills s')->leftjoin('s.OnetXWalk');
 			
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
        if (!array_key_exists('scaleid',$params)) $stmt->addwhere("s.SCALEID = 'LV'"); 
  	    
        $data['count'] = $stmt->count();
  	    
		// Crosswalk stuff
		if (array_key_exists('onetcode_new', $params))
		{
			$params['onetcode'] = $params['onetcode_new'];
			unset($params['onetcode_new']);
		}
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function listSkills($params, $fields = false) {
		// Crosswalk stuff
		/*if (array_key_exists('onetcode', $params))
		{
			$params['onetcode_new'] = $params['onetcode'];
			unset($params['onetcode']);
		}
		*/
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery()->select();
        
		$stmt->from('VCN_Model_Skills s')->leftjoin('s.OnetXWalk');
			 
			 
        if ($query['where']) {	foreach ($query['where'] AS $where) { $stmt->addwhere($where);} }
        if (!array_key_exists('scaleid',$params)) 
        $stmt->addwhere("s.SCALEID = 'LV'")
        ->addwhere("s.datavalue > '0'");


        if ($query['limit'])   $stmt->limit($query['limit']);
        if ($query['offset'])  $stmt->offset($query['offset']);
        if ($query['order']){
        	$stmt->orderBy($query['order']);
        }
        else {
        	$stmt->orderBy('datavalue desc');
        }
       // print $stmt->getSqlQuery(); exit;
        
    	$data = $stmt->fetchArray();
    	
		// Crosswalk stuff
		/*
		if (array_key_exists('onetcode_new', $params))
		{
			$params['onetcode'] = $params['onetcode_new'];
			unset($params['onetcode_new']);
		}
    	   */ 	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
 	public function getSkill($params) {
  		$required = array('onetcode','elementid','scaleid');
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
	 	// Crosswalk stuff
		if (array_key_exists('onetcode', $params))
		{
			$params['onetcode_new'] = $params['onetcode'];
			unset($params['onetcode']);
		}
		
 		$query = $this->parseParams($params, $this->valid);
 
	 	$stmt = $this->getTable()->createquery();
	 	$stmt->from('VCN_Model_Skills s')
			 ->leftjoin('s.OnetXWalk');       
			 
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
        
   		$data = $stmt->fetchArray();
 		
   		// Crosswalk stuff
		if (array_key_exists('onetcode_new', $params))
		{
			$params['onetcode'] = $params['onetcode_new'];
			unset($params['onetcode_new']);
		}
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
 	
	
	
	public function skillsquery($onetcode) {
		
		$stmt = Doctrine_Query::create()
 	     	->addselect('s.elementname')
 	     	->from('VCN_Model_Skills s')
 	     	->addwhere('s.onetcode = ?', $onetcode)
 	     	->addwhere('s.scaleid = ?', 'LV');
 	     	
 	    $data = $stmt->fetchArray();
 	    
 	    return $data;		
		
	}
	
	public function sortskills($onetcode) {
		
		$allskills = $this->skillsquery($onetcode);
		$data[0]['skills']= array();
		$skillcount=0;
		foreach($allskills as $val) {
			$skillcount++;
			$skillcount = "skill".$skillcount;
			$data[0]['skills'][$skillcount] = $val['ELEMENTNAME'];
			$pieces = explode("skill", $skillcount);
			$skillcount = $pieces[1];
		}
		
		return $data[0]['skills'];
		
	}
	

   	
 
   
}