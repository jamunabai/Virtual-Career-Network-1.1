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
class  VCN_Model_Eductrainexp extends VCN_Model_Base_Eductrainexp {
	
	protected $valid = array('ONETCODE','ELEMENTID','SCALEID','CATEGORY');
 
	public function countEductrainexp ($params, $fields=false)
	{
		if (array_key_exists('onetcode', $params))
		{
			$params['onetcode_new'] = $params['onetcode'];
			unset($params['onetcode']);
		}	
     	$query = $this->parseParams($params, $this->valid);
  		$stmt  = $this->getTable()->createQuery();

  		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }

		$stmt->from('VCN_Model_Eductrainexp t')
		     ->leftJoin("t.EductrainexpCategories c with c.scaleid='RL' and c.elementid='2.D.1' ")
			->leftJoin('t.OnetXWalk');
 		
  		if ($query['where']) {  foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }    
     		 
        $data['count'] = $stmt->count();
        
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
	
	public function listEductrainexp($params, $fields=false)
	{

		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery()->select();
        
  		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }

		$stmt->from('VCN_Model_Eductrainexp t')
		     ->leftJoin("t.EductrainexpCategories c with c.scaleid='RL' and c.elementid='2.D.1' ");
 
  		
  		if ($query['where']) {  foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }    
  		
        if ($query['limit'])
        	 $stmt->limit($query['limit']);
        if ($query['offset'])
		     $stmt->offset($query['offset']);
		if ($query['order']) 
			 $stmt->orderby($query['order']);

			 
		//echo $stmt->getSqlQuery();exit;		     
		     
    	$data = $stmt->fetchArray();
    	
       

  	   
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	     return $this->result;
	}
	
	public function getEductrainexp($params, $fields=false)
	{
		$query = $this->parseParams($params, $this->valid);
		$required = array('onetcode','elementid','scaleid','category');
		$missing = $multiples = $sep = $msep = false;
		$stmt = $this->getTable()->createquery();
	 	foreach ($required AS $req)
		{
			if (!array_key_exists($req, $params))  
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
 	 	
	 
	 	$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
 
   		if ($query['where']) {  foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }    
			
		$stmt->from('VCN_Model_Edutrainexp t');
			
		$data = $stmt->fetchArray();
  
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
    	     	
 		return $this->result;
 	}
  
}