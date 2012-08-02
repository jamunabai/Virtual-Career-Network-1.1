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
class  VCN_Model_RelatedOccupations extends VCN_Model_Base_RelatedOccupations 
{
	protected $valid = array('WORKTYPECODE', 'X.ONETCODE_NEW', 'TITLE', 'GROUP_ID', 'CATEGORY', 'TRAINING_CODE', 'SOCCODE', 'SCORE');
 	
	public function countRelatedOccupations($params, $fields=false)
	{
	 
     	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
	
        $select= $this->parseFields($stmt, $fields);
 		if ($select) { 
 			foreach ($select AS $field) { $stmt->addselect($field); } 
 		}
	 	else 
	 	{
 			$stmt->addselect('r.*,X.onetcode_new,X.onetcode_old')
 		 	 	 ->addselect('bcw.onetcode_new,bcw.onetcode_old')
 		 	 	 ->addselect('o.*, so.*, sxs.*, m.*')
 		 	 	 ->addselect('w.area, w.ratetype, so.soccodew.empcount, w.pct25, w.pct75')
  		         ->addselect('t.category, tc.category_description')  ;
 		}
 		$wheretext="r.onetcode = '".$params['onetcode']."'";
        $stmt->from ('VCN_Model_RelatedOccupations r')
         	 //->innerJoin('r.OnetXRWalk X')
         	 //->innerJoin('r.OnetXWalk bcw')
             ->innerJoin ('r.Occupation o') 
             ->leftJoin('o.SocXOnet so')
             ->leftJoin('so.Socxsocwage sxs')
             ->leftJoin("sxs.WageOcc w with w.areatype='00' AND w.area = '000000' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '00'  AND w.wagesource='3' AND w.ratetype IN (1, 4)")
             ->leftJoin("o.Eductrainexp t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
             ->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category')
            // ->addwhere('o.active_yn = ?', 'Y');	
            ->addwhere($wheretext);
             
        if ($query['where']) {  foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }    
     		  //	 echo $stmt->getSqlQuery();exit;	
        $data['count'] = $stmt->count();
        
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
 	
	public function listRelatedOccupations($params, $fields=false)
	{
		// Crosswalk stuff
	//	if (array_key_exists('onetcode', $params)) $params['X.onetcode_new'] = $params['onetcode'];
		
	 	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
        $select= $this->parseFields($stmt, $fields);
 		if ($select) { 
 			foreach ($select AS $field) { $stmt->addselect($field); } 
 		}
 	 	else 
 		{
 			$stmt->addselect('r.*')
 		 	 	 ->addselect('bcw.onetcode_new,bcw.onetcode_old')
 		 	 	 ->addselect('o.*, so.*, sxs.*, m.*')
 		 	 	 ->addselect('w.area, w.ratetype, so.soccodew.empcount, w.pct25, w.pct75')
  		         ->addselect('t.category, tc.category_description')  ;
 		}
 	 	
 		$wheretext="r.onetcode = '".$params['onetcode']."'";
 		
        $stmt->from ('VCN_Model_RelatedOccupations r')
         	// ->innerJoin('r.OnetXRWalk X')
         	// ->innerJoin('r.OnetXWalk bcw')
             ->innerJoin ('r.Occupation o') 
             ->leftJoin('o.SocXOnet so')
             ->leftJoin('so.Socxsocwage sxs')
             ->leftJoin("sxs.WageOcc w with w.areatype='00' AND w.area = '000000' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '00'  AND w.wagesource='3' AND w.ratetype IN (1, 4)")
             ->leftJoin("o.Eductrainexp t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
             ->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category')
         //   ->addwhere('o.active_yn = ?', 'Y')
            ->addwhere($wheretext);
 	 

        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
        if ($query['order'])    $stmt->orderby($query['order']);
        if ($query['limit'] && !$params['onetcode'])    $stmt->limit($query['limit']);
        if ($query['offset'])   $stmt->offset($query['offset']);
 



       	 
       //	 echo $stmt->getSqlQuery();exit;	
	  	$data = $stmt->fetchArray();
	  	
	  	
	  	//print_r($data[0]['OnetXWalk']['Occupation'][0]['SocXOnet'][0]['WageOcc'][0]['EXPERIENCE']); exit;
	  	
	  	//echo sizeof($data)-1; exit;
	  	//print_r($data[0]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]); exit;
	  	//print_r($data[1]['OnetXWalk']['SocXOnet']['WageOcc'][0]['RATETYPE']); exit;
		for ($key=0; $key<sizeof($data); $key++) {
			

 			$data[$key]['TypicalTraining']['title'] = isset($data[$key]['Occupation']['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] ) ? $data[$key]['Occupation']['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] : false;
			
 			if (isset($data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['RATETYPE'])
 			&& isset($data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT25'])
 			&& isset($data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT75'])
 			) { 
 			$data[$key]['Occupation']['WageOcc'][0]['RATETYPE'] = $data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['RATETYPE'];
			$data[$key]['Occupation']['WageOcc'][0]['PCT25'] = $data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT25'];
			$data[$key]['Occupation']['WageOcc'][0]['PCT75'] = $data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT75'];
 			}
 			
 			if (isset($data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['RATETYPE'])
 			&& isset($data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT25'])
 			&& isset($data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT75'])
 			) {
			$data[$key]['Occupation']['WageOcc'][1]['RATETYPE'] = $data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['RATETYPE'];
			$data[$key]['Occupation']['WageOcc'][1]['PCT25'] = $data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT25'];
			$data[$key]['Occupation']['WageOcc'][1]['PCT75'] = $data[$key]['Occupation']['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT75'];
 			} 
			$data[$key]['Occupation']['Title'] = $data[$key]['Occupation']['DISPLAY_TITLE'];
			$data[$key]['Occupation']['Onetcode'] = $data[$key]['Occupation']['ONETCODE'];
			
			unset($data[$key]['Occupation']['SocXOnet']);
			


	 	}
	  	
	  	
	  	// Crosswalk stuff
		if (array_key_exists('X.onetcode_new', $params)) unset($params['X.onetcode_new']);
	  	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function getRelatedOccupations($params, $fields=false)
	{
 		//TODO make sure drupal not using as detail and simplify
   		$query = $this->parseParams($params, $this->valid);
		$required = array('onetcode','relatedonet');
 		$missing = $multiples = $sep = $msep = false;
 		
		foreach ($required AS $req)
		{ 
			if (!array_key_exists($req, $params) )  
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
	  	//$wheretext="r.onetcode = '".$params['onetcode']."'";
		$stmt = $this->getTable()->createquery();
	 	$select= $this->parseFields($stmt, $fields);
 		if ($select) { 
 			foreach ($select AS $field) { $stmt->addselect($field); } 
 		}
 		else 
 		{

	   			
 			$stmt->addselect('r.*')
 		 	 	 ->addselect('o.*, so.*, sxs.*')
 		 	 	 ->addselect('w.area, w.ratetype, w.pct25, w.pct75')
  		         ->addselect('t.category, tc.category_description');
  		      //   ->addselect('tt.t2_category,tt.t2_example')  ;	   			
 		}
 		
        $stmt->from ('VCN_Model_RelatedOccupations r')
        	->innerJoin ('r.Occupation o') 
             ->leftJoin('o.SocXOnet so')
             ->leftJoin('so.Socxsocwage sxs')        	
        	->leftJoin("sxs.WageOcc w with w.areatype='00' AND w.area = '000000' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '00'  AND w.wagesource='3' AND w.ratetype IN (1, 4)" )
  			->leftJoin("o.Eductrainexp as t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
 	  		->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category');
 		
 	  		
        if ($query['where']) {  foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }     
   
    	$data = $stmt->fetchArray();
     	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	 
 	}
	
	public function detailRelatedOccupations($params, $fields=false)
	{
 	 	$query = $this->parseParams($params, $this->valid);
		$required = array('onetcode','relatedonet');
 		$missing = $multiples = $sep = $msep = false;

 		foreach ($required AS $req)
		{ 
			if (!array_key_exists($key, $params) )  
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
	 	
 		if ($select) { 
 			foreach ($select AS $field) { $stmt->addselect($field); } 
 		}
 		else 
 		{
 			$stmt->addselect('t.category, tc.category_description')
	   			->addselect('w.area, w.ratetype, w.empcount, w.entrywg, w.experience')
	   			->addselect('tt.t2_category,tt.t2_example')
	   			->addselect('r.*')
	   			->addselect('o.onetcode, o.title');
 		}
 		
        $stmt->from ('VCN_Model_RelatedOccupations r')
        	->innerJoin ('r.Occupation o') 
        	->leftJoin("o.WageOcc w with w.areatype='00' AND w.area = '000000' AND w.periodyear = (select max(periodyear) from wage_occ where occcode=o.soccode ) AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='08' AND w.stfips = '00'  AND w.wagesource='3' AND w.ratetype IN (1, 4)" )
  			->leftJoin("o.Eductrainexp as t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
 	  		->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category');
 		
 	  		
        if ($query['where']) {  foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }     
   
    	$data = $stmt->fetchArray();
     	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	 
 	}
 	
  
}