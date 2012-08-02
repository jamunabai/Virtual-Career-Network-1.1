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
class VCN_Model_WageOcc extends VCN_Model_Base_WageOcc {
	
 	public $result;
	
 	public function  construct( )
    {  
      	$this->result['status'] = array();
      	$this->result['params'] = false;
    	$this->result['data']   = false;
  	}
    
	public function countWageOcc($params) 
	{
 	   	$query = $this->parseParams($params);
  		$stmt  = $this->getTable()->createQuery();
 		
        if ($query['where']) {
        	foreach ($query['where'] AS $where) {
        		$stmt->addwhere($where);
        	}
        }
       
  	   	$data['count'] = $stmt->count();
   	    
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
   	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	      	     	
		return $this->result;
	}
 	
	public function listWageOcc($params) {
   		$query = $this->parseParams($params);
        $stmt  = $this->getTable()->createQuery()->select();
        
        if ($query['where']) {
        	foreach ($query['where'] AS $where) {
        		$stmt->addwhere($where);
        	}
        }
        if ($query['limit'])
        	 $stmt->limit($query['limit']);
        if ($query['offset'])
		     $stmt->offset($query['offset']);
		     
    	$data = $stmt->fetchArray();
 
    		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
 	  	else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 	     	
		return $this->result;
	}
	
	public function getWageOcc ($params) {

		$query = $this->parseParams($params);
		$required = array('stfips','areatype','area','occodetype','wagesource','ratetype','periodyear','periodtype','period','occcode');
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
		
 	protected function setResult($code, $msg, $params, $data )
 	{
 		$this->result['status']['code'] = $code;
 		$this->result['status']['msg']  = $msg;
 		$this->result['status']['count']= ($data) ? sizeof($data): 0;
 		$this->result['params']         = $params;
 		$this->result['data']           = $data;
   	}
	/*
	 * get the acceptable filters
	 */
	protected function parseParams(&$params) {
	 	if (!$params) return false;
	    $sep = '';

     	foreach ($params AS $key=>$value) 
     	{
     		switch (strtoupper($key)) {
     			case 'MODULE':
     			case 'ACTION':
     			case 'CONTROLLER':
     				unset ($params[$key]);
     			break;
     			case 'ORDER':
					$order = $value;			     				
     			break;	
     			case 'OFFSET':
					$offset = $value;			     				
     			break;
     			case 'LIMIT':
					$limit = $value;			     				
      			break;
 				case 'ONETCODE':
 					//may want to set occcode based on this value?
					$where['OCCCODE'] = strtoupper($key) . " = '". preg_replace('[^0-9]', '',substr($value, 0, -2)) . "'";
				break;
 				case 'MEDIAN':
      			case 'STFIPS':
      			case 'AREATYPE':
      			case 'AREA':
      			case 'PERIODYEAR':
      			case 'PERIODTYPE':
      			case 'PERIOD':
      			case 'INDCODTY':
      			case 'INDCODE':
      			case 'OCCODETYPE':
      			case 'WAGESOURCE':
      			case 'RATETYPE':
      			case 'EMPCOUNT':
      			case 'RESPONSE':
      			case 'MEAN':
      			case 'ENTRYWG':
      			case 'EXPERIENCE':
      			case 'PCT10':
      			case 'PCT25':
      			case 'PCT75':
      			case 'PCT90':
      			case 'UDPCT':
      			case 'UDPCTWAGE':
      			case 'UDRNGLOPCT':
      			case 'UDRNGHIPCT':
      			case 'UDRNGMEAN':
      			case 'WPCTRELERR':
      			case 'EPCTRELERR':
      			case 'SUPPRESS':
					if (is_array($value))
      					$where[] = strtoupper($key) . " IN ('".implode("','",$value)."')";
      				else
				 		$where[] = strtoupper($key) . "= '$value'";
				break;
     			default:
     		}
     	}

     	$query['where'] = isset($where) ? $where : false;
     	$query['order'] = isset($order) ? $order : false;
     	$query['offset']= isset($offset)? $offset : false;
     	$query['limit'] = isset($limit) ? $limit : 1000;
     	
     	return $query;
	}	
}
 