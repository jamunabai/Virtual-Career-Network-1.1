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
class VCN_Model_Occupation extends VCN_Model_Base_Occupation {

    public $result;
    public $valid = array('WORKTYPECODE', 'ONETCODE', 'TITLE', 'GROUP_ID', 'EDUCATION_CATEGORY_ID', 'EDUCATION_CATEGORY_ID_LESS', 'EDUCATION_CATEGORY_ID_LESS_2', 'TRAINING_CODE', 'SOCCODE', 'SCORE');

    public function changeCode($params) {
        $query = $this->parseParams($params, $this->valid);

        $stmt = Doctrine_Query::create()
                        ->addselect('o.onetcode')
                        ->addselect('bcw.onetcode_new, bcw.onetcode_old')
                        ->from('VCN_Model_Occupation o')
                        ->leftjoin('o.OnetXWalk bcw');

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

        return $this->result['data'][0]['OnetXWalk']['ONETCODE_OLD'];
    }

    protected function getState($zipcode) {
        $statestmt = Doctrine_Query::create()
                        ->select('state')
                        ->from('VCN_Model_MasterZipcode')
                        ->where('zip = ?', $zipcode);

        $statedata = $statestmt->fetchArray();
        if (isset($statedata[0]['STATE'])) {
            $state = $statedata[0]['STATE'];
            return $state;
        } else {
            return "false";
        }
    }

    protected function getSTFIPS($state) {

        $statestmt = Doctrine_Query::create()
                        ->select('stfips')
                        ->from('VCN_Model_State')
                        ->where('abbrev = ?', $state);

        $statedata = $statestmt->fetchArray();
        $stfips = $statedata[0]['STFIPS'];

        if ($stfips)
            return $stfips;
        else
            return "false";
    }

    protected function getArea($zipcode) {

        $stmt = Doctrine_Query::create()
                        ->select('z.area')
                        ->from('VCN_Model_Zipxarea z')
                        ->where('z.zipcode = ?', $zipcode);

        $data = $stmt->fetchArray();

        if (isset($data[0]['AREA']))
            return $data[0]['AREA'];
        else
            return "false";
    }

    public function countOccupations($params) {

        $query = $this->parseParams($params, $this->valid);
        $stmt = Doctrine_Query::create()
                        ->addselect('o.onetcode as onetcode, o.title as title, o.group_id,  o.video_link, o.display_title')
                        ->addselect('c.group_id, c.title, c.description')
                        ->addselect('vw.*')
                        //->addselect('d.text')
                        ->addselect('t.category, tc.category_description')
                        ->addselect('w.area, w.ratetype, w.empcount, w.median')
                        ->addselect('wt.onetcode, wt.worktype_code, wt.score')
                        ->addselect('bcw.onetcode_new,bcw.onetcode_old, so.soccode, sxs.*')
                        ->from('VCN_Model_Occupation o')
                        ->leftJoin('o.OccupationWorkType wt')
                        ->leftJoin('o.Group c')
                        //->leftJoin('o.OccupationDescription  d')
                       // ->leftJoin('o.OnetXWalk bcw')
                        ->leftJoin('o.VwOnetEducationDistribution vw')
                        ->leftJoin('o.SocXOnet so')
                        ->leftJoin('so.Socxsocwage sxs')
                        ->leftJoin("sxs.WageOcc w with w.areatype='00' AND w.area = '000000' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '00'  AND w.wagesource='3' AND w.ratetype IN (1, 4)")
                        //->leftJoin("o.Eductrainexp t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
                        //->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category')
                        ->addwhere('o.active_yn = ?', 'Y');

        if ($query['where']) {
            foreach ($query['where'] AS $where) {
            	if (stristr($where,'EDUCATION_CATEGORY_ID_LESS')) {
            		$where = str_replace('EDUCATION_CATEGORY_ID_LESS', 'EDUCATION_CATEGORY_ID', $where);
            		$where = str_replace('=', '<=', $where);
            	}

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

    // this function looks to be deprecated
    protected function joblistings($jlarray,$zipcode) {
    	$onetcodes="";
		foreach ($jlarray as $value)
			$onetcodes .= $value.",";
		
		$onetcodes = substr($onetcodes, 0, -1);
		
		
        $objDOM = new DOMDocument();
        ini_set('display_errors', 'Off');
        for ($j = 1; $j <= 7; $j++) {
            if ($objDOM->load("http://devv2.jobcentral.com/api.asp?key=&onets=$onetcodes&zc1=$zipcode&rd1=50&tm=100&rc=1"))
                break;
            else
                sleep(1);
        }

		$title="";
        $jobnos = $objDOM->getElementsByTagName("item");
        $count=-1; 
        foreach ($jobnos as $value) {
        	$count++;
        	$titles = $value->getElementsByTagName("recordcount");
			$title  = $titles->item(0)->nodeValue;
			$jlarray[$count] = $title;
        	
        }

        ini_set('display_errors', 'On');
		
        if ($j>7)
        	$jlarray=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ');
        	
        return $jlarray;
    }

    protected function jobgrowth($pchg) {

        switch ($pchg) {
            case ($pchg > 20):
                return "Much faster than average";
                break;
            case (($pchg <= 20) && ($pchg > 14)):
                return "Faster than average";
                break;
            case (($pchg <= 14) && ($pchg > 7)):
                return "Average";
                break;
            case (($pchg <= 7) && ($pchg > 3)):
                return "Slower than average";
                break;
            case (($pchg <= 3) && ($pchg > -2)):
                return "Little or no change";
                break;
            case (($pchg <= -2) && ($pchg > -9)):
                return "Decline slowly or moderately";
                break;
            case ($pchg <= -9):
                return "Decline rapidly";
                break;
        }
    }

    //	with w.periodyear = (select max(periodyear) from Wage_Occ where ratetype IN (1,4) AND occcode = o.soccode ) and w.ratetype IN (1,4) and  w.stfips = '00'
    public function listOccupations($params) {

        $query = $this->parseParams($params, $this->valid);
               $stmt = Doctrine_Query::create()
                        ->addselect('o.onetcode as onetcode, o.title as title, o.group_id,  o.video_link, o.display_title, o.academic_requirement, o.detailed_description')
                        ->addselect('c.group_id, c.title, c.description')
                        ->addselect('vw.*,ec.*')
                        //->addselect('d.text')
                        ->addselect('wt.onetcode, wt.worktype_code, wt.score')
                       // ->addselect('t.category, tc.category_description')
                        ->addselect('w.*');
                        if (isset($params['tt']))
                        	$stmt->addselect('tt.t2_category,tt.t2_example, tt.commodity_code, sk.*, ur.*');
                        $stmt->addselect('i.pchg, i.projemp, i.estemp, i.aopent')
                        ->addselect('tcw.onetcode_new, so.soccode, sxs.*, m.*, ojc.*');
                        
                        if (isset($params['laytitles']))
                        	$stmt->addselect('olt.*');
                        
                        $stmt->from('VCN_Model_Occupation o')
                        ->leftJoin('o.Group  c')
                        //->leftJoin('o.OccupationDescription  d')
                        ->leftJoin('o.VwOnetEducationDistribution vw')
                        ->leftJoin('vw.EduCategory ec')
                        ->leftJoin('o.OccupationWorkType wt')
                        //->leftJoin('o.OnetXWalk bcw')
                        ->leftJoin('o.SocXOnet so')
                       
                        ->leftJoin('so.Socxsocwage sxs')
                        ->leftJoin('so.Matxsoc m');
                        
                        if (isset($params['laytitles']))
                        	$stmt->leftJoin('o.OnetsocLaytitle olt');
                        
                        $stmt->leftJoin('o.OccupationJobCount ojc');

        if ((isset($params['zipcode'])) && ($this->getState($params['zipcode']) != "false")) {
            $params['state'] = $this->getState($params['zipcode']);
            $stmt->leftJoin("sxs.WageOcc w with w.area = '" . $this->getArea($params['zipcode']) . "' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '" . $this->getSTFIPS($params['state']) . "'  AND w.wagesource='3' AND w.ratetype IN (1, 4)");
        } else {
            $stmt->leftJoin("sxs.WageOcc w with w.areatype='00' AND w.area = '000000' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '00'  AND w.wagesource='3' AND w.ratetype IN (1, 4)");
        }

       // $stmt->leftJoin("o.Eductrainexp t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
       //         ->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category');
                
                
               if ((isset($params['zipcode'])) && ($this->getState($params['zipcode']) != "false"))
                	$stmt->leftJoin("m.Iomatrix i with i.stfips='" . $this->getSTFIPS($params['state']) . "' and matincode='000001'");
                else 
                	$stmt->leftJoin("m.Iomatrix i with i.stfips='00' and matincode='000001'");

                	
                if (isset($params['tt'])) {
                	//$stmt->leftJoin('o.OnetXWalkTools tcw');
                	//$stmt->leftJoin('tcw.ToolsTechnology tt');
               		$stmt->leftJoin('o.ToolsTechnology tt');
                	$stmt->leftJoin('tt.UnspscReference ur');                	
                }
                //->leftJoin("bcw.Skills sk with sk.scaleid='LV'")
                $stmt->addwhere("o.active_yn = 'Y'");


        if ($query['where']) {
            foreach ($query['where'] AS $where) {
            	if (stristr($where,'EDUCATION_CATEGORY_ID_LESS_2')) {
            		$where = str_replace('EDUCATION_CATEGORY_ID_LESS_2', 'o.MINIMUM_EDUCATION_CATEGORY_ID', $where);
            		$where = str_replace('=', '<=', $where);
            	} else if (stristr($where,'EDUCATION_CATEGORY_ID_LESS')) {
            		$where = str_replace('EDUCATION_CATEGORY_ID_LESS', 'vw.EDUCATION_CATEGORY_ID', $where);
            		$where = str_replace('=', '<=', $where);
            	}

                $stmt->addwhere($where);
            }
        }
//print_r($query['where']); exit;
      
        if ($query['limit'] && !isset($params['jl']))
            $stmt->limit($query['limit']);
        if ($query['order'])
            $stmt->orderBy($query['order']);
        if ($query['offset'])
            $stmt->offset($query['offset']);
            
    	 // print $stmt->getSqlQuery(); exit;    
	
        $data = $stmt->fetchArray();
        /*
        if (is_array($params['onetcode'])) {
        	$count=0;
        	foreach ($data as $value) {
        	 	$count++;
        	 	if ($data[$count]->onetcode != $params['onetcode'][$count])
        	 		echo '#';
        	}
        }
        exit;
        print_r($data2); exit;
        echo is_array($params['onetcode']); exit;
               
        print_r(strpos($query['where'][0],'IN' )); exit;
		*/
       // print_r($data[0]['OnetXWalk']); exit;
        if (isset($params['zipcode']))
          $thezip=$params['zipcode'];
        else 
          $thezip=0;
            	        
        for ($key = 0; $key < sizeof($data); $key++) {
          //  $data[$key]['TypicalTraining']['title'] = isset($data[$key]['OnetXWalk']['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION']) ? $data[$key]['OnetXWalk']['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] : false;
            
            $data[$key]['TypicalTraining']['title'] = $data[$key]['VwOnetEducationDistribution']['EduCategory']['EDUCATION_CATEGORY_NAME'];
            $data[$key]['TypicalTraining']['awlevelcode'] = $data[$key]['VwOnetEducationDistribution']['Education_Category_ID'];
            
       
            unset($data[$key]['VwOnetEducationDistribution']);
           // unset($data[$key]['Eductrainexp']);

            if (isset($params['jl'])) {
            //	$data[$key]['JOBLISTINGS']= $this->joblistings($data[$key]['ONETCODE'],$thezip);
            	
            	//$jlarray[$key] =  $this->joblistings($data[$key]['ONETCODE'],$thezip);
            	//$jlarray[] =  $data[$key]['OnetXWalk']['ONETCODE_OLD'];
            	//unset($data[$key]['OnetXWalk']);
            }
         	
            //print_r($data[5]['OnetXWalk']['SocXOnet']['WageOcc'][1]); exit;
//print_r($data[$key]['SocXOnet'][0]); exit;
			 if (isset($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['ESTEMP'])) {
			 
	            if ($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['ESTEMP']) {
	              //  $data[$key]['jobgrowth']['text'] = $this->jobgrowth($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PCHG']);
	              //  $data[$key]['jobgrowth']['percent'] = $data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PCHG'];
	                
	                $data[$key]['jobgrowth']['percent'] = number_format(100*(floatval($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PROJEMP'])/floatval($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['ESTEMP'])-1),0,'.',',');
	                $data[$key]['jobgrowth']['text'] = $this->jobgrowth($data[$key]['jobgrowth']['percent']); 
	                $data[$key]['jobgrowth']['estemp'] = $data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['ESTEMP'];
	                $data[$key]['jobgrowth']['projemp'] = $data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PROJEMP'];
	                $data[$key]['jobgrowth']['aopent'] = $data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['AOPENT'];	                               
	            }    
			 }

            if (isset($data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0])) {
	            $data[$key]['WageOcc'][0]['RATETYPE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['RATETYPE'];
	            $data[$key]['WageOcc'][0]['ENTRYWG'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['ENTRYWG'];
	            $data[$key]['WageOcc'][0]['EXPERIENCE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['EXPERIENCE'];
	            $data[$key]['WageOcc'][0]['MEDIAN'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['MEDIAN'];
	            $data[$key]['WageOcc'][0]['PCT10'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT10'];
	            $data[$key]['WageOcc'][0]['PCT25'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT25'];
	            $data[$key]['WageOcc'][0]['PCT75'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT75'];
	            $data[$key]['WageOcc'][0]['PCT90'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT90'];
            }
            
            if (isset($data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1])) {
	            $data[$key]['WageOcc'][1]['RATETYPE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['RATETYPE'];
	            $data[$key]['WageOcc'][1]['ENTRYWG'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['ENTRYWG'];
	            $data[$key]['WageOcc'][1]['EXPERIENCE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['EXPERIENCE'];
	            $data[$key]['WageOcc'][1]['MEDIAN'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['MEDIAN'];
	            $data[$key]['WageOcc'][1]['PCT10'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT10'];
	            $data[$key]['WageOcc'][1]['PCT25'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT25'];
	            $data[$key]['WageOcc'][1]['PCT75'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT75'];
	            $data[$key]['WageOcc'][1]['PCT90'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT90'];
            }
            
            if (isset($params['tt'])) {
            	$data[$key]['ToolsTechnology'] = $this->sortToolsTech($data[$key]['ToolsTechnology']);
            	unset($data[$key]['OnetXWalkTools']);
            }
            unset($data[$key]['SocXOnet']);
            
            if (isset($params['jl']) && !isset($params['zipcode'])) { 
                $data[$key]['JOBLISTINGS'] = $data[$key]['OccupationJobCount']['JOB_COUNT'];            	
         		unset($data[$key]['OccupationJobCount']);
            }
        }
        

    /*   
    if (isset($params['jl']) && isset($params['zipcode'])) { 
    	
    	//print_r($jlarray); exit;
    	$jlarray =  $this->joblistings($jlarray,$thezip); 
    	
    	
    	if (isset($params['dl'])) {
	    	if ($params['dl']=="desc")
	    		arsort($jlarray);
	    	elseif ($params['dl']=="asc")
	    		asort($jlarray);
    	}


    	$count=0;
	    foreach($jlarray as $key=>$value) {
	    	$count++;
	    	 $data[$key]["joblistings"] = $value;
	    	$gina[]= $data[$key];
	    	if ($count==$query['limit'])
	    		break;
	    }
	    
	    
		$data = $gina;    	
    }
	*/    




        if ($data)
            $this->setResult('success', 'data returned', $params, $data);
        else
            $this->setResult('fail', 'request failed', $params, $data);
        return $this->result;
    }

    public function getOccupation($params) {
        $query = $this->parseParams($params, $this->valid);

        if (!isset($params['onetcode'])) {
            $this->setResult('fail', 'Missing Parameters: onetcode', $params, false);
            return $this->result;
        } elseif (is_array($params['onetcode'])) {
            $this->setResult('fail', 'Multiple values for Parameters: onetcode', $params, false);
            return $this->result;
        }

        $stmt = $this->getTable()->createquery();
        if ($query['where']) {
            foreach ($query['where'] AS $k=>$where) {
            	if (stristr($where,'education_category_id_less'))
            		unset($query['where'][$k]);
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

    public function detailOccupation($params) {

        $time[] = date('H:i:s:u', mktime());
        $query = $this->parseParams($params, $this->valid);

        if (!isset($params['onetcode'])) {
            $this->setResult('fail', 'Missing Parameters: onetcode', $params, false);
            return $this->result;
        } elseif (is_array($params['onetcode'])) {
            $this->setResult('fail', 'Multiple values for Parameters: onetcode', $params, false);
            return $this->result;
        }

        $stmt = Doctrine_Query::create()
                        ->addselect('o.onetcode as onetcode, o.title as title, o.group_id,  o.video_link, o.display_title, o.academic_requirement, o.day_in_life, o.day_in_life_url, o.day_in_life_url_flag, o.day_in_life_url_description, o.narative_salary_outlook, o.detailed_description, o.physical_requirement, o.physical_requirement_url, physical_requirement_url_flag, o.health_requirement, o.edu_graph_src_desc')
                        ->addselect('c.group_id, c.title, c.description')
                        //->addselect('d.text')
                        ->addselect('wt.onetcode, wt.worktype_code, wt.score')
                        ->addselect('t.category, tc.category_description')                         
                        ->addselect('w.*')
                        ->addselect('lr.*')                        
                        //->addselect('tt.t2_category,tt.t2_example, tt.commodity_code, sk.*')
                        ->addselect('ur.*')
                        ->addselect('i.pchg,i.estemp,i.projemp,i.aopent')                       
                        ->addselect('tcw.onetcode_new, so.soccode, sxs.*, m.*, ojc.*')
                        ->addselect('fa.*')
                        ->addselect('or.*, orc.category_id, orc.category_name')
                        ->addselect('int.*,vw.*,oed.*,ec.*')
                        ->from('VCN_Model_Occupation o')
                        ->leftJoin('o.Group  c')
                        //->leftJoin('o.OccupationDescription  d')
                        ->leftJoin('o.OccupationWorkType wt')
                        //->leftJoin('o.OnetXWalk bcw')
                        //->leftJoin('o.OnetsocLaytitle olt')
                        ->leftJoin('o.OccupationFinancialAid fa')
                        ->leftJoin('o.OccupationResource or')
                        ->leftJoin('or.OccResourceCategory orc')
                        ->leftJoin('o.OccupationInterview int')  
                        ->leftJoin('o.VwOnetEducationDistribution vw') 
                        ->leftJoin('o.OnetEducationDistribution oed') 
                        ->leftJoin('oed.EduCategory ec')
                        ->leftJoin('o.SocXOnet so')
                        ->leftJoin('so.Socxsocwage sxs')
                        ->leftJoin('so.Matxsoc m')
                        ->leftJoin('o.OccupationJobCount ojc');

        if ((isset($params['zipcode'])) && ($this->getState($params['zipcode']) != "false")) {
            $params['state'] = $this->getState($params['zipcode']);
            $stmt->leftJoin("sxs.WageOcc w with w.area = '" . $this->getArea($params['zipcode']) . "' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '" . $this->getSTFIPS($params['state']) . "'  AND w.wagesource='3' AND w.ratetype IN (1, 4)");
        	$stmt->leftJoin("o.OccupationLegalRequirement lr with lr.state = '".$params['state']."'");
        } else {
            $stmt->leftJoin("sxs.WageOcc w with w.areatype='00' AND w.area = '000000' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '00'  AND w.wagesource='3' AND w.ratetype IN (1, 4)");
        }

       // $stmt->leftJoin("o.Eductrainexp t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
       //         ->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category');

                if ((isset($params['zipcode'])) && ($this->getState($params['zipcode']) != "false"))
                	$stmt->leftJoin("m.Iomatrix i with i.stfips='" . $this->getSTFIPS($params['state']) . "' and matincode='000001'");
                else 
                	$stmt->leftJoin("m.Iomatrix i with i.stfips='00' and matincode='000001'");
              //  ->leftJoin('o.OnetXWalkTools tcw')
               // $stmt->leftJoin('o.ToolsTechnology tt')
               // ->leftJoin('tt.UnspscReference ur')
                //	->leftJoin("bcw.Skills sk with sk.scaleid='LV'")
               $stmt->addwhere("o.active_yn = 'Y'");

        if ($query['where']) {
            foreach ($query['where'] AS $where) {
                $stmt->addwhere($where);
            }
        }

      //  echo $stmt->getSqlQuery();exit;
        $data = $stmt->fetchArray();

 
//print_r($data[0]); exit;
        for ($key = 0; $key < sizeof($data); $key++) {
           // $data[$key]['TypicalTraining']['title'] = isset($data[$key]['OnetXWalk']['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION']) ? $data[$key]['OnetXWalk']['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] : false;
            //$data[$key]['TypicalTraining']['title'] = isset($data[$key]['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] ) ? $data[$key]['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] : false;
            //$data[$key]['TypicalTraining']['title'] = $data[$key]['VwOnetEducationDistribution']['Category_Description'];
            
            unset($data[$key]['VwOnetEducationDistribution']);    
                    
            if (isset($params['zipcode']))
            	$thezip=$params['zipcode'];
            else 
            	$thezip=0;
			
            /*
            if (isset($params['jl'])) {
            	if (isset($params['zipcode'])) {
            		$jlp[] = $data[0]['OnetXWalk']['ONETCODE_OLD'];
            		$getfirst = $this->joblistings($jlp,$thezip);
            		$data[$key]['JOBLISTINGS'] = $getfirst[0];
            	} else {
            		$data[$key]['JOBLISTINGS'] = $data[$key]['OccupationJobCount']['JOB_COUNT'];
            		unset($data[$key]['OccupationJobCount']); 
            	}
            	
            	
            	
            }
			*/
            	
           // unset($data[0]['OnetXWalk']);
            
            if (isset($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['ESTEMP'])) { 
            	if ($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['ESTEMP']) {
	                $data[$key]['jobgrowth']['percent'] = number_format(100*(floatval($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PROJEMP'])/floatval($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['ESTEMP'])-1),0,'.',',');
	                $data[$key]['jobgrowth']['text'] = $this->jobgrowth($data[$key]['jobgrowth']['percent']);
	                $data[$key]['jobgrowth']['estemp'] = $data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['ESTEMP'];
	                $data[$key]['jobgrowth']['projemp'] = $data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PROJEMP'];
	                $data[$key]['jobgrowth']['aopent'] = $data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['AOPENT'];
	            }
        	}

           // $data[$key]['oldonetcode'] = $this->changeCode($params);

            
          //  $data[$key]['ToolsTechnology'] = $this->sortToolsTech($data[0]['ToolsTechnology']);
          //  unset($data[0]['OnetXWalkTools']);

            unset($data[$key]['Iomatrix']);
            unset($data[$key]['Eductrainexp']);

            if (isset($data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0])) {
	            $data[$key]['WageOcc'][0]['RATETYPE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['RATETYPE'];
	            $data[$key]['WageOcc'][0]['ENTRYWG'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['ENTRYWG'];
	            $data[$key]['WageOcc'][0]['EXPERIENCE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['EXPERIENCE'];
	            $data[$key]['WageOcc'][0]['MEDIAN'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['MEDIAN'];
	            $data[$key]['WageOcc'][0]['PCT10'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT10'];
	            $data[$key]['WageOcc'][0]['PCT25'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT25'];
	            $data[$key]['WageOcc'][0]['PCT75'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT75'];
	            $data[$key]['WageOcc'][0]['PCT90'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT90'];
	            $data[$key]['WageOcc'][0]['PERIODYEAR'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PERIODYEAR'];
            }
            
            if (isset($data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1])) {
	            $data[$key]['WageOcc'][1]['RATETYPE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['RATETYPE'];
	            $data[$key]['WageOcc'][1]['ENTRYWG'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['ENTRYWG'];
	            $data[$key]['WageOcc'][1]['EXPERIENCE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['EXPERIENCE'];
	            $data[$key]['WageOcc'][1]['MEDIAN'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['MEDIAN'];
	            $data[$key]['WageOcc'][1]['PCT10'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT10'];
	            $data[$key]['WageOcc'][1]['PCT25'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT25'];
	            $data[$key]['WageOcc'][1]['PCT75'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT75'];
	            $data[$key]['WageOcc'][1]['PCT90'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT90'];
	            $data[$key]['WageOcc'][1]['PERIODYEAR'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PERIODYEAR'];
            }
            unset($data[$key]['SocXOnet']);
        }
       /*
        if (isset($data[0]['OccupationFinancialAid'])) {
        	$facount=0;
        	foreach($data[0]['OccupationFinancialAid'] as $fa) {
        		$facount++;
        		unset($data[0]['OccupationFinancialAid'][$facount]);  
        		
        	}
	
         	
        }
        */


        if ($data)
            $this->setResult('success', 'data returned', $params, $data);
        else
            $this->setResult('fail', 'request failed', $params, $data);

        return $this->result;
    }

    public function snapshotOccupation($params) {

        $time[] = date('H:i:s:u', mktime());
        $query = $this->parseParams($params, $this->valid);

        if (!isset($params['onetcode']) || empty ($params['onetcode'])) {
            $this->setResult('fail', 'Missing Parameters: onetcode', $params, false);
            return $this->result;
        }
        $stmt = Doctrine_Query::create()
                        ->addselect('o.title as title, o.display_title')
                        ->addselect('t.category, tc.category_description')                               // typical trining
                        ->addselect('w.area, w.ratetype, w.empcount, w.entrywg, w.experience, w.pct25, w.pct75')
                        ->addselect('i.pchg')
                        ->addselect('bcw.onetcode_new, bcw.onetcode_old, so.soccode, sxs.*, m.*')
                        ->from('VCN_Model_Occupation o')
                        //->leftJoin('o.OnetXWalk bcw')
                        ->leftJoin('o.SocXOnet so')
                        
                       ->leftJoin('so.Socxsocwage sxs')
                       ->leftJoin('so.Matxsoc m');                       

        if ((isset($params['zipcode'])) && ($this->getState($params['zipcode']) != "false")) {
            $params['state'] = $this->getState($params['zipcode']);
            $stmt->leftJoin("sxs.WageOcc w with w.area = '" . $this->getArea($params['zipcode']) . "' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '" . $this->getSTFIPS($params['state']) . "'  AND w.wagesource='3' AND w.ratetype IN (1, 4)");
        } else {
            $stmt->leftJoin("sxs.WageOcc w with w.areatype='00' AND w.area = '000000' AND w.periodyear = '2010' AND w.periodtype ='01' AND w.period = '00' AND w.occodetype='09' AND w.stfips = '00'  AND w.wagesource='3' AND w.ratetype IN (1, 4)");
        }

        $stmt->leftJoin("o.Eductrainexp t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
                ->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category')
                ->leftJoin("m.Iomatrix i with i.stfips='00' and matincode='000001'")
                ->addwhere("o.active_yn = 'Y'");

        if ($query['where']) {
            foreach ($query['where'] AS $where) {
                $stmt->addwhere($where);
            }
        }

        $data = $stmt->fetchArray();

//print_r($data[0]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]); exit;
        for ($key = 0; $key < sizeof($data); $key++) {
           // $data[$key]['TypicalTraining']['title'] = isset($data[$key]['OnetXWalk']['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION']) ? $data[$key]['OnetXWalk']['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] : false;
			$data[$key]['TypicalTraining']['title'] = isset($data[$key]['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] ) ? $data[$key]['Eductrainexp'][0]['EductrainexpCategories']['CATEGORY_DESCRIPTION'] : false;
            
            if (isset($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PCHG'])) {
//                $data[$key]['jobgrowth']['text'] = $this->jobgrowth($data[$key]['OnetXWalk']['SocXOnet']['Iomatrix'][0]['PCHG']);
//                $data[$key]['jobgrowth']['percent'] = $data[$key]['OnetXWalk']['SocXOnet']['Iomatrix'][0]['PCHG'];
                $data[$key]['jobgrowth'] = array(
                    'text' => $this->jobgrowth($data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PCHG']),
                    'percent' => $data[$key]['SocXOnet'][0]['Matxsoc'][0]['Iomatrix']['PCHG'],
                    );
            } else {
                $data[$key]['jobgrowth'] = array(
                    'text' => 'Nothing Found',
                    'percent' => 'N/A'
                    );

            }

            unset($data[$key]['Iomatrix']);
            unset($data[$key]['Eductrainexp']);


	            $data[$key]['WageOcc'][0]['RATETYPE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['RATETYPE'];
	            $data[$key]['WageOcc'][0]['ENTRYWG'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['ENTRYWG'];
	            $data[$key]['WageOcc'][0]['EXPERIENCE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['EXPERIENCE'];
	            $data[$key]['WageOcc'][0]['PCT25'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT25'];
	            $data[$key]['WageOcc'][0]['PCT75'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][0]['PCT75'];

	            $data[$key]['WageOcc'][1]['RATETYPE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['RATETYPE'];
	            $data[$key]['WageOcc'][1]['ENTRYWG'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['ENTRYWG'];
	            $data[$key]['WageOcc'][1]['EXPERIENCE'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['EXPERIENCE'];
	            $data[$key]['WageOcc'][1]['PCT25'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT25'];
	            $data[$key]['WageOcc'][1]['PCT75'] = $data[$key]['SocXOnet'][0]['Socxsocwage'][0]['WageOcc'][1]['PCT75'];	            

            unset($data[$key]['SocXOnet']);
        }

        if ($data)
            $this->setResult('success', 'data returned', $params, $data);
        else
            $this->setResult('fail', 'request failed', $params, $data);

        return $this->result;
    }

     function listShort($params) {
 		$query = $this->parseParams($params, $this->valid);
     	$stmt = Doctrine_Query::create()
            	->addselect('o.onetcode, o.display_title, o.minimum_education_category_id, ecm.*,bcw.*,vw.*,ec.*')
            	->from('VCN_Model_Occupation o')
            	->leftJoin('o.EduCategoryMin ecm')
                ->leftJoin('o.VwOnetEducationDistribution vw') 
                ->leftJoin('vw.EduCategory ec');       	
            	//->leftJoin('o.OnetXWalk bcw')
               // ->leftJoin("o.Eductrainexp t with t.elementid='2.D.1' and t.scaleid='RL' and t.datavalue = (select max(datavalue) from eductrainexp where `onetcode`=o.onetcode and elementid='2.D.1' AND scaleid = 'RL' )")
               // ->leftJoin('t.EductrainexpCategories tc on t.elementid = tc.elementid and t.scaleid=tc.scaleid and t.category = tc.category')
            	//->innerJoin('t.EducationLevel e with t.elementid=\'2.D.1\' and t.scaleid=\'RL\'');s

     	if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); } }
     	if ($query['limit'])    $stmt->limit($query['limit']);
        if ($query['offset'])   $stmt->offset($query['offset']);
        if ($query['order']) 
        {
           $stmt->orderby($query['order']);
        }
        else 
        {
        	$stmt->orderby('display_title asc');
        }        
     	$data = $stmt->fetchArray();
     	
     	
      	
     	if ($data)
            $this->setResult('success', 'data returned', $params, $data);
        else
            $this->setResult('fail', 'request failed', $params, $data);

        return $this->result;              
     }
}

