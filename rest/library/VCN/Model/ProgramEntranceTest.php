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
class  VCN_Model_ProgramEntranceTest extends VCN_Model_Base_ProgramEntranceTest {
	
	protected $valid = array('PROGRAM_ID', 'et.TEST_ID' );
	
	public function countProgramEntranceTest($params, $fields=false) 
	{
	  	// Handle parameters
		if (array_key_exists('test_code', $params)) $params['et.test_code'] = $params['test_code'];
		
    	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
         
        $select= $this->parseFields($stmt, $fields);
        
		if ($select) {
        	foreach ($select AS $field) {
        		$stmt->addselect($field);
        	}
		}
		else 
		{
			$stmt->addselect('*');
		}
		
		$stmt->from('VCN_Model_ProgramEntranceTest et')
	 			->leftJoin('et.Test t') ;
		
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }

        $data['count'] = $stmt->count();
 	    
        // Handle parameters
		if (array_key_exists('et.test_code', $params)) unset( $params['et.test_code'] );
        
        
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function listProgramEntranceTest ($params, $fields=false) 
	{
	  	// Handle parameters
		if (array_key_exists('test_code', $params)) $params['et.test_code'] = $params['test_code'];
		
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
        $select= $this->parseFields($stmt, $fields);
        
		if ($select) {
        	foreach ($select AS $field) { $stmt->addselect($field); }
		}
		else 
		{
			$stmt->addselect('et.*,t.*');
		}
 		
		$stmt->from('VCN_Model_ProgramEntranceTest et')
		 			->leftJoin('et.Test t') ;
		
	    	 	
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
  		if ($query['order'])    $stmt->orderby($query['order']);
        if ($query['limit'])    $stmt->limit($query['limit']);
        if ($query['offset'])   $stmt->offset($query['offset']);
//echo $stmt->getSqlQuery();exit;
        $data = $stmt->fetchArray();
        
       // Handle parameters
		if (array_key_exists('et.test_code', $params)) unset( $params['et.test_code'] );
        
  	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;
	}
	
	public function getProgramEntranceTest($params, $fields=false) 
	{
 		$query = $this->parseParams($params, $this->valid);
 		$required = array('program_id', 'test_code');
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

	  	// Handle parameters
		if (array_key_exists('test_code', $params)) $params['et.test_code'] = $params['test_code'];
	 	
	 	$stmt  = $this->getTable()->createQuery();
	  		
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
 		
		$stmt->from('VCN_Model_ProgramEntranceTest et') 
	 			->leftJoin('et.Test t') ;
				 			
	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
 
        $data = $stmt->fetchArray();
        
       // Handle parameters
		if (array_key_exists('et.test_code', $params)) unset( $params['et.test_code'] );
        
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
 	
	 
}
