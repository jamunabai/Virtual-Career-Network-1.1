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
class VCN_Model_Certifications extends VCN_Model_Base_Certifications
{
	protected $valid = array('O.ONETCODE','CERT_ID','ORG_ID','TRAINING');
	
	private function certMagic($data,$mylimit,$myorder,$myoffset) {
		$data2=array();
    	$k2=-1;
		foreach($data as $k=>$v) {		
	
			$k2++;

			$ccount=0;
			if (isset($data[$k]['Certxtype']))
				$ccount = count($data[$k]['Certxtype']);
			
			if ($ccount>=2) {
								
				$data2[$k2]=$data[$k];
				unset($data2[$k2]['Certxtype']['1']);
				$k2++;
				$data2[$k2]=$data[$k];
				unset($data2[$k2]['Certxtype']['0']);
				$data2[$k2]['Certxtype']['0']=$data2[$k2]['Certxtype']['1'];
				unset($data2[$k2]['Certxtype']['1']);
			} else {
				$data2[$k2]=$data[$k];				
			}
			


		} 

		$data3=array();
		
		$offset=0;
		$limit=count($data2);

		if (stristr($myorder,'cert_type_name')) { 
			$tempcert=array();
			foreach ($data2 as $k=>$v) { 
				$tempcert[$k]=$data2[$k]['Certxtype'][0]['CERT_TYPE_NAME'];
			}
			
			if (stristr($myorder,'cert_type_name asc'))
				asort($tempcert);
				
			if (stristr($myorder,'cert_type_name desc'))
				arsort($tempcert);
											 
			$tempdata2 = array();
			
			foreach($tempcert as $k=>$v) { 
				$tempdata2[]=$data2[$k];
				
			}
			
			$data2 = $tempdata2;
			//print_r($tempcert); exit;
		}
		
		
		
		if ($myoffset)
			$offset=$myoffset;
			
		if (isset($mylimit))
			$limit=$mylimit;
		
		//echo $offset.' - '.($limit+$offset); exit;
		
		for ($i=$offset; $i<($limit+$offset); $i++) {
			if (isset($data2[$i])) {
				$data3[$i]=$data2[$i];
			}
		}
		
		$k4=-1;
		foreach ($data3 as $k=>$v) {
			$k4++;
			$data4[$k4]=$data3[$k];
		}

		//print_r($data3); exit;
		//exit;

		$data=$data4;	

		return $data;
		
	}
	
	
	public function countCertifications($params, $fields=false) 
	{
	  	// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['o.onetcode'] = $params['onetcode'];
 
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { foreach ($select AS $field) { $stmt->addselect($field); } }
	
		$stmt->from ('VCN_Model_Certifications c')
			->innerJoin ("c.CertOnetAssign coa with coa.rank<='6' and coa.suppress_yn!='Y'")
 		//	->innerJoin ('coa.OnetXWalk bcw')
 			->innerJoin ('coa.Occupation O') 
 			->leftJoin ('c.CertOrg as certorg')
 		 	->leftJoin ('c.Certxtype as certxtype') ;
	 	
 		
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
// echo $stmt->getSqlQuery();exit;   
 	//    $data['count'] = $stmt->count();
 	
		$data = $stmt->fetchArray();
		
		if ($data)
			$data = $this->certMagic($data,$query['limit'],$query['order'],$query['offset']);   	
				
    	$k2=count($data);
		
		unset($data);    
		$data['count'] = $k2;
 	    
		// Crosswalk stuff
		if (array_key_exists('o.onetcode', $params)) unset($params['o.onetcode']);
	 	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function listCertifications($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['o.onetcode'] = $params['onetcode'];
	 	
		
		$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery()->select();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { 
			foreach ($select AS $field) { $stmt->addselect($field); } 
		}
		else {
 			$stmt->addselect('c.cert_id,c.cert_name,c.org_id,c.training,c.experience,c.either,c.exam,c.renewal,c.ceu,c.reexam,c.cpd,c.cert_any,c.url,c.acronym,c.nssb_url,c.cert_url,c.keyword1,c.keyword2,c.keyword3,c.cert_description')
				 ->addselect('coa.cert_id, coa.onetcode, coa.rank')
				// ->addselect('bcw.onetcode_old, bcw.onetcode_new')
				 ->addselect('co.org_id, co.org_name,co.org_addres,co.org_phone1,co.ext,co.org_phone2,co.org_fax,co.org_email,co.org_webpag,co.acronym')
				 ->addselect('cx.cert_id,cx.cert_type,cx.cert_type_name')
              	->addselect('O.onetcode as onetcode, O.title as title, O.group_id,  O.video_link, O.display_title') ;
  		}

		$stmt->from ('VCN_Model_Certifications c')
			->innerJoin ("c.CertOnetAssign coa with coa.rank<='6' and coa.suppress_yn!='Y'")
 			//->innerJoin ('coa.OnetXWalk bcw')
 			->innerJoin ('coa.Occupation O') 
 			->leftJoin ('c.CertOrg as co')
 		 	->leftJoin ('c.Certxtype as cx') ;
 
 		 	
 		

 		//print_r($query);
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
     	//if ($query['limit'])    $stmt->limit($query['limit']);
        //if ($query['offset'])   $stmt->offset($query['offset']);
        
		if (!isset($params['order']) || $params['order']=='rank') {
			$o1 = 'cx.display_rank asc';
			$o2 = 'c.cert_name asc';

			$stmt->orderby($o1);
			$stmt->addorderby($o2);

		} else {
			
			if ($query['order'])    $stmt->orderby($query['order']);
			
		}
        

  // echo $stmt->getSqlQuery();exit;  
    	$data = $stmt->fetchArray();
	
		if ($data)
    		$data = $this->certMagic($data,$query['limit'],$query['order'],$query['offset']);
		
		// Crosswalk stuff
		if (array_key_exists('o.onetcode', $params)) unset($params['o.onetcode']);
    	
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;		
	}
	
	public function getCertification($params, $fields=false) 
	{
 
 		$query = $this->parseParams($params, $this->valid);
 		$required = array('cert_id');
		$missing = $multiples = $sep = $msep = false;
 		
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
 	
	public function detailCertification($params, $fields=false) 
	{
		// Crosswalk stuff
		if (array_key_exists('onetcode', $params)) $params['o.onetcode'] = $params['onetcode'];
		 
		 
 		$query = $this->parseParams($params, $this->valid);
 		$required = array('cert_id');
		$missing = $multiples = $sep = $msep = false;
 		
 	 	$stmt = $this->getTable()->createquery();
		$select= $this->parseFields($stmt, $fields);
 
		if ($select) { 
			foreach ($select AS $field) { $stmt->addselect($field); } 
		}
		else 
		{
			$stmt->addselect('c.cert_id,c.cert_name,c.org_id,c.training,c.experience,c.either,c.exam,c.renewal,c.ceu,c.reexam,c.cpd,c.cert_any,c.url,c.acronym,c.nssb_url,c.cert_url,c.keyword1,c.keyword2,c.keyword3,c.cert_description')
				 ->addselect('coa.cert_id, coa.onetcode')
				// ->addselect('bcw.onetcode_old, bcw.onetcode_new')
				 ->addselect('co.org_id, co.org_name,co.org_addres,co.org_phone1,co.ext,co.org_phone2,co.org_fax,co.org_email,co.org_webpag,co.acronym')
				 ->addselect('cx.cert_id,cx.cert_type,cx.cert_type_name')
              	 ->addselect('O.onetcode as onetcode, O.title as title, O.group_id,  O.video_link, O.display_title') ;
			
		}
 
		$stmt->from ('VCN_Model_Certifications c')
			->innerJoin ('c.CertOnetAssign coa')
 			//->innerJoin ('coa.OnetXWalk bcw')
 			->innerJoin ('coa.Occupation O') 
 			->leftJoin ('c.CertOrg as co')
 		 	->leftJoin ('c.Certxtype as cx') ;
 		 			
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
   
   		$data = $stmt->fetchArray();
 
		// Crosswalk stuff
		if (array_key_exists('o.onetcode', $params)) unset($params['o.onetcode']);
   		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}	
}