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
class  VCN_Model_Cipcode extends VCN_Model_Base_Cipcode {
	protected $valid = array('CODE','TITLE');
	
	public function countCategories($params, $fields=false) 
	{
     	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
    	  
 	    $data['count'] = $stmt->count();
 	    
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function listCipcodes($params, $fields=false)  {
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
	
	public function getCipcode ($params, $fields=false)  {
     	$query = $this->parseParams($params, $this->valid);
		
		if (!isset($params['cipcode'])) 
	 	{
	 		$this->setResult('fail','Missing Parameters: cipcode', $params, false);
	 		return $this->result;
	 	}
	 	elseif (is_array($params['cipcode']))
	 	{
	 		$this->setResult('fail','Multiple values for Parameters: cipcode',$params, false);
	 		return $this->result;
	 	}

	 	$stmt = $this->getTable()->createquery();
	  	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
       
   		$data = $stmt->fetchArray();
 		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
 	
 	
}