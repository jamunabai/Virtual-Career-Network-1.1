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
 * Licxonet
 */
class VCN_Model_Licxonet extends VCN_Model_Base_Licxonet
{
	protected $valid = array('STFIPS','LICENSEID', 'ONETCODE_NEW');
	
	public function countLicxonets($params, $fields=false) 
	{
	  	// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];
		
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { 
 			foreach ($select AS $field) { $stmt->addselect($field);}   
 		}
 		else {
 			$stmt->addselect('*');
 		} 
 		
 		
  		$stmt->from ('VCN_Model_Licxonet lo')
  			 ->innerJoin ('lo.OnetXWalk bcw')
  		     ->innerJoin ('bcw.Occupation o')
  		     ->leftJoin ('lo.License l with l.stfips = lo.stfips')
  	 	     ->leftJoin ('l.Licauth as la with la.stfips = lo.stfips'); 

  
 	/* 	  		$stmt->from ('VCN_Model_License l')
 			 ->innerJoin ('l.Licxonet lo with l.stfips = lo.stfips')
			 ->innerJoin ('lo.OnetXWalk bcw')
  		     ->innerJoin ('bcw.Occupation o')
  	 	     ->leftJoin ('l.Licauth as la with la.stfips = lo.stfips');
 		
 	 	*/
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
 //echo $stmt->getSqlQuery();exit;        
        $data['count'] = $stmt->count();
        
        // Crosswalk stuff
		if (array_key_exists('onetcode_new', $params)) unset($params['onetcode_new']);
        
  	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
 	}

	public function listLicxonet($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];
		
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
   	 	
  		$stmt->from ('VCN_Model_Licxonet lo')
  			 ->innerJoin ('lo.OnetXWalk bcw')
  		     ->innerJoin ('bcw.Occupation o')
  		     ->leftJoin ('lo.License l with l.stfips = lo.stfips')
  	 	     ->leftJoin ('l.Licauth as la with la.stfips = lo.stfips'); 
 
 	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
        if ($query['limit'])  $stmt->limit($query['limit']);
        if ($query['offset']) $stmt->offset($query['offset']);
        if ($query['order'])  $stmt->orderby($query['order']);   
      
    	$data = $stmt->fetchArray();
 
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;	
  	}
	
	public function getLicxonet($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];
		
		
		if (isset($params['onetcode_new']) AND !array_key_exists('soconetcod', $params) ) 
		{
			$params['soconetcod'] = $params['onetcode'];
		}
		
 		$query = $this->parseParams($params, $this->valid);
 		$stmt  = $this->getTable()->createQuery();
  		$required = array('stfips','licenseid','soconetcod');
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
 		
  		$stmt->from ('VCN_Model_Licxonet lo')
  			 ->innerJoin ('lo.OnetXWalk bcw')
  		     ->innerJoin ('bcw.Occupation o')
  		     ->leftJoin ('lo.License l with l.stfips = lo.stfips')
  	 	     ->leftJoin ('l.Licauth as la with la.stfips = lo.stfips'); 
 		
 	 	
	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
    //  echo $stmt->getSqlQuery();exit;
   
    	$data = $stmt->fetchArray();
 
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;	
  	}		
 
	public function detailLicxonet($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];
		
	 
		if (isset($params['onetcode_new']) AND !array_key_exists('soconetcod', $params) ) 
		{
			$params['soconetcod'] = $params['onetcode_new'];
		}
		
 		$query = $this->parseParams($params, $this->valid);
 		$stmt  = $this->getTable()->createQuery();
  		$required = array('stfips','licenseid','soconetcod');
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

 		$stmt->from ('VCN_Model_Licxonet lo')
 	 	->leftJoin ('lo.Occupation-detail o') 
 		->leftJoin ('lo.License-detail l with l.stfips = lo.stfips')
 	 	->leftJoin ('l.Licauth as la with l.stfips = l.stfips');
 		
 
	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
     //   echo $stmt->getSqlQuery();exit;
   
    	$data = $stmt->fetchArray();
 
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;	
  	}		
 
}	