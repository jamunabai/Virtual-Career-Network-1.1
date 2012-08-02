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
 * CmaUserKey Class
 * 
 * 
 * @package    VCN
 * @subpackage
 * @author     waltonr
 * @version    SVN: $Id:$
 */
class VCN_Model_CmaUserKey extends VCN_Model_Base_CmaUserKey
{
	protected $valid = array( 'KEY_ID','USER_ID','KEY_CATEGORY','KEY_NAME','KEY_VALUE');
 
   /*
	* Standard count function
	* @param  array  $params parameters for query
	* @param  array  $fields parameters for select
    * @return array $select
    */	
	public function countCmaUserKey($params, $fields=false) 
	{
      	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) {
        	foreach ($select AS $field) { $stmt->addselect($field); }
		}

        if ($query['where']) {
        	foreach ($query['where'] AS $where) { $stmt->addwhere($where); }
        }
   
 	    $data['count'] = $stmt->count();

 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function listCmaUserKey($params, $fields=false) 
	{
    	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery()->select();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
		
		$stmt->from('VCN_Model_CmaUserKey');
		
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
	
	public function getCmaUserKey($params, $fields=false) 
	{
 
 		$query = $this->parseParams($params, $this->valid);
 	 	$required = array('key_id');
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
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
   
   		$data = $stmt->fetchArray();
     	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
		
 	public function saveCmaUserKey($params, $fields=false) 
	{
		$userkey = false;
	    if (array_key_exists('id',$params) && $params['id'])
		{
			$userkey = Doctrine_Core::getTable('VCN_Model_CmaUserKey')->findOneByKey_id($params['id']);
		} 
		else 
		{
 	 		if (array_key_exists('user_id',$params) AND
			    array_key_exists('key_category',$params) AND
			    array_key_exists('key_name',$params)  )
			{
	  			$userkey = Doctrine_Core::getTable('VCN_Model_CmaUserKey')->findOneByUser_idAndKey_categoryAndKey_name($params['user_id'],$params['key_category'],$params['key_name']);
			}
		}
        if ( ! $userkey) {
            $userkey = new VCN_Model_CmaUserKey();
        }
        
     	$userkey->USER_ID      = $params['user_id'];
       	$userkey->KEY_CATEGORY = $params['key_category'];
       	$userkey->KEY_NAME     = $params['key_name'];
       	$userkey->KEY_VALUE    = $params['key_value'];
      	$userkey->save();
     	     
     	$data = false;
      	$this->setResult('success', 'data saved', $params, $data);
   	     	
		return $this->result;		
	}
	
 	public function deleteCmaUserKey($params, $fields=false) 
	{
		$userkey = false;
		$data = false;
	    if (array_key_exists('id',$params) && $params['id'])
		{
			$userkey = Doctrine_Core::getTable('VCN_Model_CmaUserKey')->findOneByKey_id($params['id']);
		} 
		else 
		{
 	 		if (array_key_exists('user_id',$params) AND
			    array_key_exists('key_category',$params) AND
			    array_key_exists('key_name',$params)  )
			{
	  			$userkey = Doctrine_Core::getTable('VCN_Model_CmaUserKey')->findOneByUser_idAndKey_categoryAndKey_name($params['user_id'],$params['key_category'],$params['key_name']);
			}
		}
        if ( ! $userkey) {
            $this->setResult('fail', 'record not found', $params, $data);
 			return $this->result;
        }
        $userkey->delete();
     	     
     
      	$this->setResult('success', 'data deleted', $params, $data);
   	     	
		return $this->result;		
	}
	
	
}
 