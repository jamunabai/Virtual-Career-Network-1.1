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
class  VCN_Model_UnspscReference extends VCN_Model_Base_UnspscReference {

	public function countUnspscReference($params) 
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
	
	public function sortUnspscReference($onetcode) {
		
		$stmt = Doctrine_Query::create()
 	     	->addselect('max(datavalue)')
 	     	->from('VCN_Model_Eductrainexp')
 	     	->addwhere('scaleid = ?', 'RL')
 	     	->addwhere('onetcode = ?', $onetcode);
 	     	
 	    $data = $stmt->fetchArray();
 	     	
 	    if (!$data)
 	    	return "N/A";
 	    	
 	     $stmt1 = Doctrine_Query::create()
 	     	->addselect('max(category)')
 	     	->from('VCN_Model_Eductrainexp')
 	     	->addwhere('scaleid = ?', 'RL')
 	     	->addwhere('datavalue = ?', $data[0]['max']);
 	     	
 	     $data1 = $stmt1->fetchArray();

 	    if (!$data1)
 	    	return "N/A";
	     	
 	    $stmt2 = Doctrine_Query::create()
 	     	->addselect('category_description')
 	     	->from('VCN_EductrainexpCategories')
 	     	->addwhere('scaleid = ?', 'RL')
 	     	->addwhere('category = ?', $data1[0]['max']);
 	     	
	     $data2 = $stmt2->fetchArray();
	     
	    if (!$data2)
 	    	return "N/A";

 	    $data2 = $data2[0]['CATEGORY_DESCRIPTION'];

 	    return $data2;
	}
 	
	public function listUnspscReference($params) {
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
        return $data;
	}
	
	public function getTraining($training_code) {
		if (!$training_code ) return false;
 		$data = $this->getTable()->findBy('CODE', $training_code)->toArray();
 
 		return $data;
 	}
 	
 	
	/*
	 * get the acceptable filters
	 */
	protected function parseParams($params) {
	 
	    $sep = '';
     	foreach ($params AS $key=>$value) 
     	{
     		switch (strtoupper($key)) {
     			case 'ORDER':
					$order = $value;			     				
     			break;	
     			case 'OFFSET':
					$offset = $value;			     				
     			break;
     			case 'LIMIT':
					$limit = $value;			     				
      			break;
 				case 'CODE':
      			case 'TITLE':
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
     	$query['limit'] = isset($limit) ? $limit : 50;
     	
     	return $query;
	}	
  
}