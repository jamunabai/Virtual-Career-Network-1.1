<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
abstract class VCN_DoctrineRecord extends Doctrine_Record
{
	protected $valid;
	public $result;
	public $status;
	public $data;
	public $params;
		
 	public function  construct( )
    {  
      	$this->result['status'] = array();
      	$this->result['params'] = false;
    	$this->result['data']   = false;
    	
  	}
  	//TODO May not be used at all
	public function getValidParams($params=false, $data=false) {
 	    $data['valid_params'] = implode(', ', $this->valid);
 	    
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
    	     	
		return $this->result;
	}
	
   /*
	* set the result to return
	* @param string $code    status code
	* @param string $msg     status message
	* @param array  $params  array of params
 	* @param array  $data    data array to return
    * @return array $select
    */	
 	protected function setResult($code, $msg, $params, $data )
 	{
 		$this->data = $data;
 		$this->status['value']    = $code;
 		$this->status['code']     = $code;
 		$this->status['message']  = $msg;
 		$this->status['rowcount'] = ($data) ? sizeof($data): 0;
 	    $this->params = $params;
 	    
  		$this->result['status'] = $this->status;
 		$this->result['params'] = $this->params;
 		$this->result['data']   = $this->data;
   }

   /*
	* get the acceptable filters
	* @param &$stmt   doctrine query object
	* @param $fields array of field to add to select
    * @return array $select
    */
	protected function parseFields(&$stmt, $fields = array()) {
		if (!($stmt && $fields)) return false;
	   	$select = false;
    	foreach ($fields AS $field) 
     	{
  			$select[] = $field;
      	}
      	return $select;
	} 
	  	
   /*
	* get the acceptable filters
	* @param  array &$params parameters passed in request through model
	* @param  array $valid   acceptable parameters for calling model
	* @return array $query
    */	
	protected function parseParams(&$params, $valid = array()) {
	 	if (!$params) return false;
  	    $where='';
    	foreach ($params AS $key=>$value) 
     	{
     		// make sure no filters are not overriden by derived values
     		if ( $value == 'vcn-no-filter' ) continue;
     		$key = strtoupper($key); 
     		switch ($key) 
     		{
     			case 'MODULE':
     			case 'ACTION':
     			case 'CONTROLLER':
     		 		unset ($params[$key]);
     			break;
     			case 'ORDER':
					$order = (isset($order) AND $order) ? $value . ' ' . $order : $value;			     				
     			break;
     			case 'DIRECTION':
     				$order = (isset($order) AND $order) ? $order . ' ' . $value : $value;	
     				break;
     			case 'OFFSET':
					$offset = $value;			     				
     			break;
     			case 'LIMIT':
  					$limit = $value;			     				
      			break; 
     			case 'DISTANCE':
					$distance = $value;
     			break;
    			case 'CATEGORY':
// TODO this will become group and be removed
     				if (in_array( strtoupper($key),$valid) AND $value) {
						if (is_array($value))
	      					$where[] = "t.category IN ('".implode("','",$value)."')";
	      				else
					 		$where[] = "t.category = '$value'";
     				}     				
				break;
     			default:
      				if (in_array( $key, $valid) AND $value) 
    				{
    					$sep = $values = '';
 
 // TODO this needs to be handled in model
    				    switch ($key) 
    				    {
 	 						case 'WORKTYPECODE':
 								$key = 'WORKTYPE_CODE';			
	 						break;
	 	 					default:
    				    }
    				    if ($value == 'is null')
    				    {
    				    	$where[] = $key .' '.$value;
    				    }
      					elseif (is_array($value)) 
      					{
	      					foreach ($value AS $val)
	     					{
	     						$values[] = $val ;
	    					}
	     					$where[] = $key. " IN ('".strtolower(implode("','",$values))."')";
	      				}
    					      					 
     					else 
	      				{
	      					$where[] =  $key . " = '". strtolower($value)."'";
	      				}	
     				}
       		}
       	} //end foreach

     	$query['where'] = isset($where) ? $where : false;
     	$query['order'] = isset($order) ? $order : false;
     	$query['offset']= isset($offset)? $offset : false;
     	$query['limit'] = isset($limit) ? $limit : 200;
     	$query['distance'] = isset($distance) ? $distance: false;
      	return $query;
	}
	
	
	//TODO Andrew: document?
	protected function sortToolsTech($data) {
		$result = array();
		$result['tools']=array();
		$result['technology']=array();
		foreach($data as $val) {
 			if ($val['T2_CATEGORY'] == "Tools") {
 				//$result['tools'][]=$val['T2_EXAMPLE'];
 				//if (!in_array($val['UnspscReference'][0]['UNSPSC_TITLE'], $result['tools']))
 					$result['tools'][]=$val['UnspscReference'][0]['UNSPSC_TITLE'];
 			}
 			if ($val['T2_CATEGORY'] == "Technology") {
				//$result['technology'][]=$val['T2_EXAMPLE'];
				//if (!in_array($val['UnspscReference'][0]['UNSPSC_TITLE'], $result['technology']))
					$result['technology'][]=$val['UnspscReference'][0]['UNSPSC_TITLE'];
 			}
 		}
 		
 		//sort($result['tools']);
 		//sort($result['technology']);
 		
 		$array = array_count_values($result['technology']); 	
 		arsort($array);
 			
 		$result['technology']=array(); 		
 		
 		$count=0;
 		foreach($array as $k=>$v) {
 			$count++;
 			if ($count<=5)
 				$result['technology'][]=$k;
 		}
 		sort($result['technology']);	
 			
 			
 			
 		$array = array_count_values($result['tools']); 
 		arsort($array);
 		
 		//print_r($array); exit;
 		$result['tools']=array(); 		
 		
	 	$count=0;
 		foreach($array as $k=>$v) {
 			$count++;
 			if ($count<=5)
 				$result['tools'][]=$k;
 		}
 		
 		sort($result['tools']);			
 		
 		//print_r(array_count_values($array)); exit;
 		
		return $result;	 	
	}
	
}
