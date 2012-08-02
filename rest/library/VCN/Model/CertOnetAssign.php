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
 * Certifications
 */
class VCN_Model_CertOnetAssign extends VCN_Model_Base_CertOnetAssign
{
	protected $valid = array('CERT_ID','CERTID','ORG_ID','ONETCODE_NEW' );
	
	public function countCertOnetAssigns($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];
				
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
      	 
  		$stmt->from ('VCN_Model_CertOnetAssign coa')
 		->innerJoin ('coa.OnetXWalk bcw')
 		->innerJoin ('bcw.Occupation o') 
		->innerJoin ('coa.Certification as cert')
 	 	->leftJoin ('cert.CertOrg as certorg')
 		->leftJoin ('cert.Certxtype as certxtype');
    		
 	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
  	
 	    $data['count'] = $stmt->count();
 
		// Crosswalk stuff
		if (array_key_exists('onetcode_new', $params)) unset($params['onetcode_new']);
   		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
 	}

	public function listCertOnetAssigns($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];
		
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
      
 		$stmt->from ('VCN_Model_CertOnetAssign coa')
 		->innerJoin ('coa.Certification as cert')
 		->innerJoin ('coa.OnetXWalk bcw')
 		->innerJoin ('bcw.Occupation o') 
 		->leftJoin ('cert.CertOrg as certorg')
 		->leftJoin ('cert.Certxtype as certxtype');
 	 
 		if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
      	if ($query['limit'])    $stmt->limit($query['limit']);
        if ($query['offset'])   $stmt->offset($query['offset']);
        if ($query['order'])    $stmt->offset($query['order']);
  		  
    	$data = $stmt->fetchArray();
    	
  		// Crosswalk stuff
		if (array_key_exists('onetcode_new', $params)) unset($params['onetcode_new']);
   		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;	
  	}
  	
	public function getCertOnetAssign($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];

		$query = $this->parseParams($params, $this->valid);
 		$stmt  = $this->getTable()->createQuery();
  		$required = array('onetcode','cert_id');
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
		
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
 		
 		$stmt->from ('VCN_Model_CertOnetAssign coa')
 		->innerJoin ('coa.Certification as cert')
 		->innerJoin ('coa.OnetXWalk bcw');
  	 	
	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
  
    	$data = $stmt->fetchArray();
 		
    	// Crosswalk stuff
		if (array_key_exists('onetcode_new', $params)) unset($params['onetcode_new']);
   		    	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;	
  	}		
 
	public function detailCertOnetAssign($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];

		$query = $this->parseParams($params, $this->valid);
 		$stmt  = $this->getTable()->createQuery();
  		$required = array('onetcode_new','cert_id');
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
		
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
 		
  		$stmt->from ('VCN_Model_CertOnetAssign coa')
 		->innerJoin ('coa.OnetXWalk bcw')
 		->innerJoin ('bcw.Occupation o') 
		->innerJoin ('coa.Certification as cert')
 	 	->leftJoin ('cert.CertOrg as certorg')
 		->leftJoin ('cert.Certxtype as certxtype');
 		
	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
     
    	$data = $stmt->fetchArray();

    	// Crosswalk stuff
		if (array_key_exists('onetcode_new', $params)) unset($params['onetcode_new']);
   		    	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;	
  	}		
	
}	