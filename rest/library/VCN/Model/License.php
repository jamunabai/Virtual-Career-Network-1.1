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
class VCN_Model_License extends VCN_Model_Base_License
{
	protected $valid = array('O.ONETCODE','STFIPS','AREATYPE','AREA','LICENSEID','LICAUTHID','LICTITLE','LICDESC');
	
	public function countLicenses($params, $fields=false) 
	{
	  	// Crosswalk stuff -- not required but just in case onetcode pops up in a join table down the road
		if (array_key_exists('onetcode', $params)) $params['o.onetcode'] = $params['onetcode'];
		
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { 
 			foreach ($select AS $field) { $stmt->addselect($field); } 
 		}
 		else 
 		{
 			$stmt->addselect('*');
 		}
 		 
 		$stmt->from ('VCN_Model_License l')
 			 ->innerJoin ('l.Licxonet lo with l.stfips = lo.stfips')
			// ->innerJoin ('lo.OnetXWalk bcw')
  		     ->innerJoin ('lo.Occupation O')
  	 	     ->leftJoin ('l.Licauth as la with la.stfips = lo.stfips'); 
 	 
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
 // echo $stmt->getSqlQuery();exit;     
    	$data['count'] = $stmt->count();
    	
        // Crosswalk stuff
		if (array_key_exists('o.onetcode', $params)) unset($params['o.onetcode']);
    	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
 	}

	public function listLicenses($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['o.onetcode'] = $params['onetcode'];
		
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
  
  		$stmt->from ('VCN_Model_License l')
 			 ->innerJoin ('l.Licxonet lo with l.stfips = lo.stfips')
		//	 ->innerJoin ('lo.OnetXWalk bcw')
  		     ->innerJoin ('lo.Occupation O')
  	 	     ->leftJoin ('l.Licauth as la with la.stfips = lo.stfips');
 		
 		if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
        if ($query['limit'])  $stmt->limit($query['limit']);
        if ($query['offset']) $stmt->offset($query['offset']);
        if ($query['order'])  $stmt->orderby(preg_replace('/licenseid/','l.licenseid',$query['order']));
  //  echo $stmt->getSqlQuery();exit;       
        
    	$data = $stmt->fetchArray();
    	
        // Crosswalk stuff
		if (array_key_exists('o.onetcode', $params)) unset($params['o.onetcode']);
    	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;	
  	}
	
	public function getLicense($params, $fields=false) 
	{
	  	// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['onetcode_new'] = $params['onetcode'];
		
		$query = $this->parseParams($params, $this->valid);
 		$stmt  = $this->getTable()->createQuery();
  		$required = array('stfips','licenseid');
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

	public function detailLicense($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['o.onetcode'] = $params['onetcode'];
		
 		$query = $this->parseParams($params, $this->valid);
 		$stmt  = $this->getTable()->createQuery();
  		$required = array('stfips','licenseid');
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
 		
  		$stmt->from ('VCN_Model_License l')
 			 ->innerJoin ('l.Licxonet lo with l.stfips = lo.stfips')
			// ->innerJoin ('lo.OnetXWalk bcw')
  		     ->innerJoin ('lo.Occupation O')
  	 	     ->leftJoin ('l.Licauth as la with la.stfips = lo.stfips');
 		
 	 	
	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
   
    	$data = $stmt->fetchArray();
    	
    	$data[0]['LICDESC'] = nl2br($data[0]['LICDESC']);
    	
        // Crosswalk stuff
		if (array_key_exists('o.onetcode', $params)) unset($params['o.onetcode']);
    	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;	
  	}		

}	