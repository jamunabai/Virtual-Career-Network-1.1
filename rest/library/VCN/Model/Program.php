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
class  VCN_Model_Program extends VCN_Model_Base_Program {
	
	protected $valid = array('PROGRAM_ID','UNITID','C.CIPCODE','EDUCATION_LEVEL','EDUCATION_CATEGORY_ID','EDUCATION_CATEGORY_ID_LESS','AWLEVEL','HBCU','O.ONETCODE', 'TYPE_ECB');
	
	public function countProgram($params, $fields=false) 
	{
	  	// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['o.onetcode'] = $params['onetcode'];
        if (!array_key_exists('distance', $params)) $params['distance'] = '25';
		// Duplicate filter
		if (array_key_exists('cipcode', $params)) { $params['c.cipcode'] = $params['cipcode']; }
        
    	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
         
        $select= $this->parseFields($stmt, $fields);
        
		if ($select) {
        	foreach ($select AS $field) { $stmt->addselect($field); }
		} 
		
		//distance
		if (array_key_exists('zip',$params) AND $params['zip']) {
			if (array_key_exists('latitude',$params) AND array_key_exists('longitude',$params) ) {
		 		$distance = (array_key_exists('distance',$params) AND $params['distance']) ? $params['distance'] : 25;
 				$stmt->addselect('round(SQRT( power(abs(pr.longitude-('.$params['longitude'].')),2)+power(abs(pr.latitude-('.$params['latitude'].')),2))/0.0144,1) distance');
				$stmt->addwhere('(round(SQRT( power(abs(pr.longitude-('.$params['longitude'].')),2)+power(abs(pr.latitude-('.$params['latitude'].')),2))/0.0144,1) <= '.$distance.')');
			}
		}

 	 	$stmt->from('VCN_Model_Program p')
    	  	 ->innerJoin('p.ProgramCipcode pc')
     	  	// ->innerJoin('pc.CipNewXOld cxo')
     	  	 ->innerJoin('pc.CipcodeDetail C')
    	   	
     	  	 ->innerJoin('pc.OnetXCip2010 oxc')        
 	   	 	 ->innerJoin('oxc.Occupation O') 	 
      	     ->innerJoin('p.Provider pr')
      	     ->innerJoin('p.EduCategoryIped eci with eci.IPED_LOOKUP_CODE=p.AWLEVEL');
     	 	// ->innerJoin("p.IpedsLookup i with i.COLTITLE='AWLEVEL' and i.COLCODE=p.AWLEVEL")   ;
	 	
      	foreach($query['where'] as $k=>$where) {
      	if (stristr($where,'education_category_id_less')) {
      		$query['where'][$k] = str_replace('EDUCATION_CATEGORY_ID_LESS', 'EDUCATION_CATEGORY_ID', $query['where'][$k]); 
      		$query['where'][$k] = str_replace('education_category_id_less', 'education_category_id', $query['where'][$k]); 
      		$query['where'][$k] = str_replace('=', '<=', $query['where'][$k]); 
      		
      		foreach($query['where'] as $k2=>$where2)
      			if (stristr($where2,'awlevel'))
      				unset($query['where'][$k2]);
      		
      	}  		
      }      	     
      	     
       if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
 
 	    $data['count'] = $stmt->count();
 	    
		// Crosswalk stuff
		if (array_key_exists('o.onetcode', $params)) unset($params['o.onetcode']);
		// Duplicate filter
 		if (array_key_exists('c.cipcode', $params)) unset($params['c.cipcode']);
		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function listProgram($params, $fields=false) 
	{
	 
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['o.onetcode'] = $params['onetcode'];
        // Duplicate filter
		if (array_key_exists('cipcode', $params)) { $params['c.cipcode'] = $params['cipcode']; }
        
		
		
		//status exception
		//print_r($params['order']); exit;
		
		if (isset($params['order']))
			if ($params['order']=='status')
				$params['order'] = 'pr.status';
        
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
        $select= $this->parseFields($stmt, $fields);
        
		if ($select) {
        	foreach ($select AS $field) { $stmt->addselect($field); }
		}
		else 
		{
			$stmt->addselect('p.program_id, p.unitid, p.awlevel, p.program_code, 
			(case when p.program_name is not null then p.program_name else C.ciptitle end) as program_name,
			(case when p.program_description is not null then p.program_description else C.cipdesc end) as program_description,
 	        (case when p.admission_url is not null then p.admission_url else pr.adminurl end) as admission_url,
			p.total_credits,p.program_url,p.program_contact_name, p.program_contact_phone, p.program_contact_email,
		 	p.how_to_apply, p.medical_req, p.immunization_req, p.other_req, p.total_courses,
		 	p.tuition_in_state, p.tuition_out_state, p.other_cost, p.duration, p.legal_req,p.type_ecb, 
		 	pc.cipcode, pc.cipcode_year, pc.fit_score, pc.ipeds_yn,
		 	oxc.*,O.onetcode,
			C.ciptitle, C.cipdesc, C.ciplevel,
			pr.*,ec.*,eci.*,oxi.*');
		}
	 
	   			
		//distance
		if (array_key_exists('zip',$params) AND $params['zip']) {
			if (array_key_exists('latitude',$params) AND array_key_exists('longitude',$params) ) {
		 		$distance = (array_key_exists('distance',$params) AND $params['distance']) ? $params['distance'] : 25;
 				$stmt->addselect('round(SQRT( power(abs(longitude-('.$params['longitude'].')),2)+power(abs(latitude-('.$params['latitude'].')),2))/0.0144,1) distance');
				$stmt->addwhere('(round(SQRT( power(abs(longitude-('.$params['longitude'].')),2)+power(abs(latitude-('.$params['latitude'].')),2))/0.0144,1) <= '.$distance.')');
				$stmt->orderby('distance asc');
 			}
		}
 		
 	 	$stmt->from('VCN_Model_Program p')
    	  	 ->innerJoin('p.ProgramCipcode pc ')
     	  	 //->innerJoin('pc.CipNewXOld cxo')
     	  	 ->innerJoin('pc.CipcodeDetail C')

	    	   	
     	  	 ->innerJoin('pc.OnetXCip2010 oxc')        
 	   	 	 ->innerJoin('oxc.Occupation O') 	 
      	     ->innerJoin('p.Provider pr')      	     
      	     ->innerJoin('p.EduCategoryIped eci with eci.IPED_LOOKUP_CODE=p.AWLEVEL')
      	     ->innerJoin('eci.EduCategory ec with ec.EDUCATION_CATEGORY_ID=eci.EDUCATION_CATEGORY_ID')
      	     ->innerJoin("O.Onetxindustry oxi with oxi.INDUSTRY_ID = '1'");
      	     
      	     //INNER JOIN vcn_onetxindustry v9 ON v9.ONETCODE = v5.ONETCODE AND (v9.INDUSTRY_ID = '1')
      	     
     	 //	->innerJoin("p.IpedsLookup i with i.COLTITLE='AWLEVEL' and i.COLCODE=p.AWLEVEL");
		
/* 
  	 	$stmt->from('VCN_Model_Program p')
    	  	 ->innerJoin('p.ProgramCipcode pc')
    	  	 ->innerJoin('pc.CipcodeDetail C with pc.cipcode_year = C.cipcode_year')
      	   	 ->innerJoin('C.SocXCip sxc')
  			 ->innerJoin('sxc.SocXOnet sxo')	   
 	  	 	 ->innerJoin('sxo.OnetXWalk bcw')         
 	  	 	 ->innerJoin('bcw.Occupation o') 	 
    	 	 ->innerJoin('p.Provider pr')
     	 	 ->innerJoin("p.IpedsLookup i with i.COLTITLE='AWLEVEL' and i.COLCODE=p.AWLEVEL");
*/ 	 
      	//$query['where'][0]="EDUCATION_CATEGORY_ID = '5'"; 

      	foreach($query['where'] as $k=>$where) {
      		if (stristr($where,'education_category_id_less')) { 
      			$query['where'][$k] = str_replace('EDUCATION_CATEGORY_ID_LESS', 'EDUCATION_LEVEL', $query['where'][$k]); 
      			$query['where'][$k] = str_replace('education_category_id_less', 'education_level', $query['where'][$k]); 
      			$query['where'][$k] = str_replace('=', '<=', $query['where'][$k]); 
      		}  
      		
      		foreach($query['where'] as $k2=>$where2)
      			if (stristr($where2,'awlevel'))
      				unset($query['where'][$k2]);      				
      	}

      	
      	//print_r($query['where']); exit;
      	

      	
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
        if ($query['order'])    $stmt->orderby($query['order']);
        if ($query['limit'])    $stmt->limit($query['limit']);
        if ($query['offset'])   $stmt->offset($query['offset']);

        
        //if ($params['onetcode'])
        	//$stmt->addwhere("o.onetcode = '".$params['onetcode']."'");

       // print_r($params);


//echo $stmt->getSqlQuery();exit;			   	 	
// $params['start'] = date("H:i:s",mktime());
     	$data = $stmt->fetchArray();
//  $params['end'] = date("H:i:s",mktime());

		for ($key = 0; $key < sizeof($data); $key++) {
			$data[$key]['ipedslookup']['colcode']=$data[$key]['EduCategoryIped']['IPED_LOOKUP_CODE'];	
			$data[$key]['ipedslookup']['codedesc']=$data[$key]['EduCategoryIped']['IPED_CATEGORY_NAME'];			
		}    	
     	
     	
     	// Crosswalk stuff
		if (array_key_exists('o.onetcode', $params)) unset($params['o.onetcode']);
		// Duplicate filter
 		if (array_key_exists('c.cipcode', $params)) unset($params['c.cipcode']);
		
  	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;
	}
	
	public function getProgram($params, $fields=false) 
	{
 		$query = $this->parseParams($params, $this->valid);
 		$required = array('program_id');
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
	 	
	 	 $stmt  = $this->getTable()->createQuery();
	  		
		$select= $this->parseFields($stmt, $fields);
 		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
		$stmt->from('VCN_Model_Program p')
   			->leftJoin('p.Provider pr')
    		 ->leftJoin('p.ProgramCipcode pc')
 	  	     ->leftJoin('pc.CipcodeDetail C')
	   		->innerJoin("p.IpedsLookup i with i.COLTITLE='AWLEVEL' and i.COLCODE=p.AWLEVEL");
	   		
	 	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
 
        $data = $stmt->fetchArray();
 		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
 	
	public function detailProgram($params, $fields=false) 
	{
 		// Duplicate filter
		if (array_key_exists('cipcode', $params)) { $params['c.cipcode'] = $params['cipcode']; }
		
 		$query = $this->parseParams($params, $this->valid);
 		
  		$required = array('program_id');
		$missing = $multiples = array();
				
		foreach ($required AS $req)
		{ 
			if (!array_key_exists($req, $params) OR !isset($params[$req]))  
			{ 
				$missing[] = $req;
				$sep = ', ';
 			}
 			elseif (is_array($params[$req]))
 			{
 				$multiples[] = $req;
 			}
		}
	 	if ($missing) 
	 	{
	 		$this->setResult('fail','Missing Parameters: '.implode(', ',$missing),$params, false);
	 		return $this->result;
	 	}
	 	if ($multiples)
	 	{
	 		$this->setResult('fail','Multiple values for Parameters: '.implode(', ',$multiples),$params, false);
	 		return $this->result;
	 	}
 		$stmt  = $this->getTable()->createQuery();  		
		$select= $this->parseFields($stmt, $fields);
 		if ($select) 
 		{ 
 			foreach ($select AS $field) { $stmt->addselect($field); } 
 		}
 		else 
 		{
 			$stmt->addselect('p.program_id, p.unitid, p.awlevel, p.program_code, 
			(case when p.program_name is not null then p.program_name else C.ciptitle end) as program_name,
			(case when p.program_description is not null then p.program_description else C.cipdesc end) as program_description,
 	        (case when p.admission_url is not null then p.admission_url else pr.adminurl end) as admission_url, p.admission_url_flag,
			p.total_credits,p.program_url,p.program_url_flag,p.program_contact_name, p.program_contact_phone, p.program_contact_email,
		 	p.how_to_apply, p.medical_req, p.immunization_req, p.other_req, p.total_courses,
		 	p.tuition_in_state, p.tuition_out_state, p.other_cost, p.duration, p.legal_req,p.type_ecb, 
		 	pc.cipcode, pc.cipcode_year, pc.fit_score, pc.ipeds_yn,
			C.ciptitle, C.cipdesc, C.ciplevel,
			pr.*,eci.*, ec.*, cr.*, co.*, cc.*, cs.*, dm.*, copr.*, er.*, e.*, 
			et.*, t.*, pa.*, psa.*, pr.*, prc.*, pret.*, prt.*, prcr.*,
			prco.*, prcs.*, prdm.*,cxo.*,sx.*,oxc.*,bcw.*, o.onetcode,o.title ');
	
 		}
 /*	 	$stmt->from('VCN_Model_Program p')
    	  	 ->innerJoin('p.ProgramCipcode pc with pc.cipcode_year = \'2000\'')
     	  	 ->innerJoin('pc.CipNewXOld cxo')
     	  	 ->innerJoin('cxo.CipcodeDetail C with pc.cipcode_year = \'2000\'')
    	   	 ->innerJoin('cxo.SocXCip2010 sxc')
        	 ->innerJoin('sxc.SocNewXOld sx')
    	   	 ->innerJoin('sx.SocXOnet sxo')	   
 	  	 	 ->innerJoin('sxo.OnetXWalk bcw')         
 	   	 	 ->innerJoin('bcw.Occupation o') 
*/
 	   	 	  	 	$stmt->from('VCN_Model_Program p')
    	  	 ->innerJoin('p.ProgramCipcode pc')
    	  	 ->innerJoin('pc.CipcodeDetail C')
     	  	 //->innerJoin('pc.CipNewXOld cxo')
    	   	 //->innerJoin('cxo.SocXCip2010 sxc')
    	   	// ->innerJoin('sxc.SocXOnet sxo')	    	   	
     	  	 ->innerJoin('pc.OnetXCip2010 oxc')
    	   	 ->innerJoin('oxc.Occupation O')          	 
    	 	 ->leftJoin('p.ProgramCourseReq cr')
      	     ->innerJoin('p.Provider pr')
     	 	// ->innerJoin("p.IpedsLookup i with i.COLTITLE='AWLEVEL' and i.COLCODE=p.AWLEVEL")
     	 	 ->innerJoin('p.EduCategoryIped eci with eci.IPED_LOOKUP_CODE=p.AWLEVEL')
      	     ->innerJoin('eci.EduCategory ec with ec.EDUCATION_CATEGORY_ID=eci.EDUCATION_CATEGORY_ID')     	 	 
 	   	 	 ->leftJoin('cr.Course co')
	   		 ->leftJoin('co.CourseCipcode cc with cc.cipcode = pc.cipcode')
	   		 ->leftJoin('co.Subject cs')
	   		 ->leftJoin('co.CourseDeliveryMode dm')
	   		 ->leftJoin('co.Provider copr')
	   		 ->leftJoin('p.ProgramEducationReq er')
	  		 ->leftJoin('er.Education e')
	  		 ->leftJoin('p.ProgramEntranceTest et')
	  		 ->leftJoin('et.Test t')  
	  		 ->leftJoin('p.ProgramAccreditor pa')
	  		 ->leftJoin('pa.SchoolAccreditor psa')   
	  	     ->leftJoin('pr.ProviderContact prc')
	  	     ->leftJoin('pr.ProviderEntranceTest pret')
	  	     ->leftJoin('pret.Test prt')
	  	     ->leftJoin('pr.ProviderCourseReq prcr')
	  	   	 ->leftJoin('prcr.Course prco')
	    	 ->leftJoin('prco.Subject prcs')	  	     
	   		 ->leftJoin('prco.CourseDeliveryMode prdm') ;
	   		 
 		if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
 //echo $stmt->getSqlQuery();exit;
 		
        $data = $stmt->fetchArray();
        
		for ($key = 0; $key < sizeof($data); $key++) {
			$data[$key]['ipedslookup']['colcode']=$data[$key]['EduCategoryIped']['IPED_LOOKUP_CODE'];	
			$data[$key]['ipedslookup']['codedesc']=$data[$key]['EduCategoryIped']['IPED_CATEGORY_NAME'];	

		if ($data[$key]['ADMISSION_URL_FLAG']!=1) {
			unset($data[$key]['admission_url']);			
		}	
		
		if ($data[$key]['PROGRAM_URL_FLAG']!=1) {
			unset($data[$key]['PROGRAM_URL']);			
		}			
					
		} 
      
		// Duplicate filter
 		if (array_key_exists('c.cipcode', $params)) unset($params['c.cipcode']);
        
   		
 		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
 	
}
