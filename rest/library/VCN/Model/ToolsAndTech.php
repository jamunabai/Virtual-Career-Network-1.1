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
 * @author kurtsera
 * 
 * 
 */
class VCN_Model_ToolsAndTech extends VCN_Model_Base_OnetToolsTechnology {
	protected $valid = array('ONETCODE_NEW');
	
	public function countToolsAndTech($params) 
	{
	    $query = $this->parseParams($params);
        $stmt  = $this->getTable()->createQuery();
        if ($query['where']) {
        	foreach ($query['where'] AS $where) {
        		$stmt->addwhere($where);
        	}
        }
   
 	    $data['count'] = $stmt->count();
 	    return $data;
	}
	
	public function ttquery($onetcode) {
		
		$stmt = Doctrine_Query::create()
 	     	->addselect('t.t2_category, t.t2_example')
 	     	->from('VCN_Model_OnetToolsTechnology t')
 	     	->addwhere('t.onetcode = ?', $onetcode);
 	     	
 	    $data = $stmt->fetchArray();
 	    
 	    return $data;		
		
	}
	
	public function sorttools($onetcode) {

		$techtools = $this->ttquery($onetcode);
		$data[0]['tools'] = array();
		$toolcount=0;
		foreach($techtools as $val) {
			$toolcount++;
			$toolcount = "tool".$toolcount;
			if (($val['T2_CATEGORY']) == "Tools")
				$data[0]['tools'][$toolcount] = $val['T2_EXAMPLE'];
			$pieces = explode("tool", $toolcount);
			$toolcount = $pieces[1];
			
		}
		
		return $data[0]['tools'];
	}

	public function sorttech($onetcode) {

		$techtools = $this->ttquery($onetcode);
		$data[0]['technologies']= array();
		$techcount=0;
		foreach($techtools as $val) {
			$techcount++;
			$techcount = "technology".$techcount;
			if (($val['T2_CATEGORY']) == "Technology")
				$data[0]['technologies'][$techcount] = $val['T2_EXAMPLE'];
			$pieces = explode("technology", $techcount);
			$techcount = $pieces[1]; 
		}
		
		return $data[0]['technologies'];	
	}
	
	public function listToolsAndTech($params) 
	{
		/*
		if (array_key_exists('onetcode', $params))
 		{
 		 	$params['onetcode_new'] = $params['onetcode'];
	 		unset($params['onetcode']);
 		}
 		*/
 		
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery()->select('t.*, ur.*');

 		$stmt->from('VCN_Model_OnetToolsTechnology t')
 		 ->leftJoin('t.UnspscReference ur')
 		 ->addwhere("onetcode = '".$params['onetcode']."'");
 		 

       if ($query['where']) {	foreach ($query['where'] AS $where) { $stmt->addwhere($where);} }
       //if ($query['limit'])  $stmt->limit($query['limit']);
       if ($query['offset']) $stmt->offset($query['offset']);

    //  echo $stmt->getSqlQuery();exit();
       
    	$data = $stmt->fetchArray();
    	
    	//$data[$key]['ToolsTechnology'] = $this->sortToolsTech($data[$key]['ToolsTechnology']);
    	
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
        return $data;
	}
	
	public function getToolsAndTech($params) {
		$query = $this->parseParams($params);
		
		if (!isset($params['id'])) 
	 	{
	 		$this->setResult('fail','Missing Parameters: id', $params, false);
	 		return $this->result;
	 	}
	 	elseif (is_array($params['id']))
	 	{
	 		$this->setResult('fail','Multiple values for Parameters: id',$params, false);
	 		return $this->result;
	 	}
 		
	 	$stmt = $this->getTable()->createquery();
        if ($query['where']) {
        	foreach ($query['where'] AS $where) {
        		$stmt->addwhere($where);
        	}
        }
        
   		$data = $stmt->fetchArray();
 		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
	}

 	
 
	
}
 