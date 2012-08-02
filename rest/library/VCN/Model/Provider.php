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
 * Provider
 * 
 * 
 * @package    VCN
 * @subpackage
 * @author     waltonr
 * @version    SVN: $Id:$
 */
class VCN_Model_Provider extends VCN_Model_Base_Provider
{
	
	protected $valid=array ('UNITID','CITY','STABBR','FIPS','OBEREG','EIN','DUNS',
							'OPEID','OPEFLAG','SECTOR','ICLEVEL','CONTROL','HLOFFER','UGOFFER','GROFFER',
							'FPOFFER','HDEOFFR','DEGGRANT','HBCU','HOSPITAL','MEDICAL','TRIBAL','LOCALE',
							'OPENPUBL','ACT','NEWID','DEATHYR','CLOSEDAT','CYACTIVE','POSTSEC'=>'PSEFLAG','PSET4FLG',
							'RPTMATH','INSTCAT','CCBASIC','CCIPUG','CCIPGRAD','CCUGPROF','CCENRPRF','CCSIZSET',
							'CARNEGIE','TENURSYS','LANDGRANT','INSTSIZE', 'CBSA','CSA','NECTA','DFRCGID',
							'COUNTYCD','CNGDSTCD', 'SOURCE','VERIFIED_YN','VERIFIED_BY','IPEDS_YN',
							'AACC_YN','VHS_YN','TYPE_VCB','CREATED_BY', 'UPDATED_BY','CREATED_TIME','UPDATED_TIME');
	
  	public function countProvider($params, $fields=false) 
	{
 
    	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
		$stmt->select('*');
		
        //distance
		if (array_key_exists('zip',$params) AND $params['zip']) {
			if (array_key_exists('latitude',$params) AND array_key_exists('longitude',$params) ) {
			 	 $distance = (array_key_exists('distance',$params) AND $params['distance']) ? $params['distance'] : 25;
 			   	 $stmt->addselect('round(SQRT( power(abs(longitude-('.$params['longitude'].')),2)+power(abs(latitude-('.$params['latitude'].')),2))/0.0144,1) distance');
				 $stmt->addwhere('(round(SQRT( power(abs(longitude-('.$params['longitude'].')),2)+power(abs(latitude-('.$params['latitude'].')),2))/0.0144,1) <= '.$distance.')');
			}
		}
    		
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
  //  echo $stmt->getSqlQuery();exit; 
 	    $data['count'] = $stmt->count();
     
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
		return $this->result;
	}
	
	public function listProvider($params, $fields=false) 
	{
     	$query = $this->parseParams($params, $this->valid);
        $stmt  = $this->getTable()->createQuery();
      	$select= $this->parseFields($stmt, $fields);
   		$stmt->select('pv.*');
 		$stmt->addSelect('(SELECT count(*) FROM VCN_Model_Program pg WHERE pg.unitid = pv.unitid) as num_programs');
	    $stmt->from ('VCN_Model_Provider pv');

	    //distance
		if (array_key_exists('zip',$params) AND $params['zip']) {
			if (array_key_exists('latitude',$params) AND array_key_exists('longitude',$params) ) {
			 	 $distance = (array_key_exists('distance',$params) AND $params['distance']) ? $params['distance'] : 25;
 			   	 $stmt->addselect('round(SQRT( power(abs(longitude-('.$params['longitude'].')),2)+power(abs(latitude-('.$params['latitude'].')),2))/0.0144,1) distance');
				 $stmt->addwhere('(round(SQRT( power(abs(longitude-('.$params['longitude'].')),2)+power(abs(latitude-('.$params['latitude'].')),2))/0.0144,1) <= '.$distance.')');
			}
		}
	    
        if ($query['where']) { foreach ($query['where'] AS $where) { $stmt->addwhere($where); }}
  		if ($query['order'])  $stmt->orderby($query['order']);
        if ($query['limit'])  $stmt->limit($query['limit']);
        if ($query['offset']) $stmt->offset($query['offset']);
//  echo $stmt->getSqlQuery();exit;
      
    	$data = $stmt->fetchArray();

 		// URL FLAG CHECK
   		foreach ($data as $k=>$v) {
			if ($data[$k]['WEBADDR_FLAG']!=1) {
				unset($data[$k]['WEBADDR']);
			}
				
			if ($data[$k]['ADMINURL_FLAG']!=1) {
				unset($data[$k]['ADMINURL']);			
			}
			
			if ($data[$k]['APPLURL_FLAG']!=1) {
				unset($data[$k]['APPLURL']);			
			}	
			
			if ($data[$k]['FAIDURL_FLAG']!=1) {
				unset($data[$k]['FAIDURL']);			
			}		
			
		
   		}
		// URL FLAG CHECK END    	
 
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
 
		return $this->result;
	}
	
	public function getProvider($params, $fields=false) 
	{
    	$query = $this->parseParams($params, $this->valid);
				
		if (!array_key_exists('unitid',$params) OR !$params['unitid']) 
	 	{
	 		$this->setResult('fail','Missing Parameters: unitid', $params, false);
	 		return $this->result;
	 	}
	 	elseif (is_array($params['unitid']))
	 	{
	 		$this->setResult('fail','Multiple values for Parameters: unitid',$params, false);
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
 	
	public function detailProvider($params, $fields=false) 
	{
    	$query = $this->parseParams($params, $this->valid);
				
					
		if (!array_key_exists('unitid',$params) OR !$params['unitid']) 
	 	{
	 		$this->setResult('fail','Missing Parameters: unitid', $params, false);
	 		return $this->result;
	 	}
	 	elseif (is_array($params['unitid']))
	 	{
	 		$this->setResult('fail','Multiple values for Parameters: unitid',$params, false);
	 		return $this->result;
	 	}
 		
	 	$stmt = $this->getTable()->createquery();

	 	$stmt->addSelect('p.*,pd.*,ps.*,pst.*,i.*,pr.*,ipr.*,pret.*,paf.*,af.*');
	 	
		$stmt->from('VCN_Model_Provider p')

		
		->leftJoin('p.ProviderDetail pd')
		->leftJoin('p.ProviderService ps')
 		->leftjoin ('ps.ProviderServiceType pst')
 		->innerJoin("p.IpedsLookup i with i.COLTITLE='SECTOR' and i.COLCODE=p.SECTOR")
 		->innerJoin('p.Program pr with pr.AWLEVEL>0')
 		->innerJoin("pr.IpedsLookup ipr with ipr.COLTITLE='AWLEVEL' and ipr.COLCODE=pr.AWLEVEL")
 		->leftJoin('p.ProviderEntranceTest pret')
 		->leftJoin('p.ProviderAdditionalFaid paf')
		->leftJoin('paf.AdditionalFaid af');

	 	
	 			 
        if ($query['where']) {
        	foreach ($query['where'] AS $where) {
        		$stmt->addwhere($where);
        	}
        }

       // echo $stmt->getSqlQuery();exit;
        
   		$data = $stmt->fetchArray();
   		
		if (!$data) {
			
			$stmt->from('VCN_Model_Provider p')
	
			
			->leftJoin('p.ProviderDetail pd')
			->leftJoin('p.ProviderService ps')
	 		->leftjoin ('ps.ProviderServiceType pst')
	 		//->innerJoin("p.IpedsLookup i with i.COLTITLE='SECTOR' and i.COLCODE=p.SECTOR")
	 		//->innerJoin('p.Program pr with pr.AWLEVEL>0')
	 		//->innerJoin("pr.IpedsLookup ipr with ipr.COLTITLE='AWLEVEL' and ipr.COLCODE=pr.AWLEVEL")
	 		->leftJoin('p.ProviderEntranceTest pret')
	 		->leftJoin('p.ProviderAdditionalFaid paf')
	 		->leftJoin('paf.AdditionalFaid af');			
	
	 		$data = $stmt->fetchArray();
			
		}   	

		// URL FLAG CHECK
   		
		if ($data[0]['WEBADDR_FLAG']!=1) {
			unset($data[0]['WEBADDR']);
		}
			
		if ($data[0]['ADMINURL_FLAG']!=1) {
			unset($data[0]['ADMINURL']);			
		}
		
		if ($data[0]['APPLURL_FLAG']!=1) {
			unset($data[0]['APPLURL']);			
		}	
		
		if ($data[0]['FAIDURL_FLAG']!=1) {
			unset($data[0]['FAIDURL']);			
		}		

		if ($data[0]['ProviderDetail']['MISSION_STATEMENT_URL_FLAG']!=1) {
			unset($data[0]['ProviderDetail']['MISSION_STATEMENT_URL']);			
		}			
		
		// URL FLAG CHECK END
		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	}
 	
//Added a new action shortdetailProvider to improve the provider home page speed.  
 	
	public function shortdetailProvider($params, $fields=false) 
	{
    	$query = $this->parseParams($params, $this->valid);
				
					
		if (!array_key_exists('unitid',$params) OR !$params['unitid']) 
	 	{
	 		$this->setResult('fail','Missing Parameters: unitid', $params, false);
	 		return $this->result;
	 	}
	 	elseif (is_array($params['unitid']))
	 	{
	 		$this->setResult('fail','Multiple values for Parameters: unitid',$params, false);
	 		return $this->result;
	 	}
 		
	 	$stmt = $this->getTable()->createquery();
	 	$stmt->addSelect('p.*,pd.*,i.*,pr.*');
	 	
		$stmt->from('VCN_Model_Provider p')

		
		->leftJoin('p.ProviderDetail pd')
 		->innerJoin("p.IpedsLookup i with i.COLTITLE='SECTOR' and i.COLCODE=p.SECTOR")
 		->innerJoin('p.Program pr with pr.AWLEVEL>0');
		

	
	 			 
        if ($query['where']) {
        	foreach ($query['where'] AS $where) {
        		$stmt->addwhere($where);
        	}
        }
        $data = $stmt->fetchArray();
   		
		if (!$data) {
			
			$stmt->from('VCN_Model_Provider p')
	
			
			->leftJoin('p.ProviderDetail pd');		
	
	 		$data = $stmt->fetchArray();
			
		}   		
		
 		// URL FLAG CHECK
   		
		if ($data[0]['WEBADDR_FLAG']!=1) {
			unset($data[0]['WEBADDR']);
		}
			
		if ($data[0]['ADMINURL_FLAG']!=1) {
			unset($data[0]['ADMINURL']);			
		}
		
		if ($data[0]['APPLURL_FLAG']!=1) {
			unset($data[0]['APPLURL']);			
		}	
		
		if ($data[0]['FAIDURL_FLAG']!=1) {
			unset($data[0]['FAIDURL']);			
		}		

		if ($data[0]['ProviderDetail']['MISSION_STATEMENT_URL_FLAG']!=1) {
			unset($data[0]['ProviderDetail']['MISSION_STATEMENT_URL']);			
		}			
		
		// URL FLAG CHECK END
				
		//echo $stmt->getSqlQuery();exit;
   		
 		
 	    if ($data)
 	     	$this->setResult('success', 'data returned', $params, $data);
  	    else 
  	     	$this->setResult('fail', 'request failed', $params, $data);
  	     	
  	    return $this->result;
 	} 	
	
 	public function saveProvider($params, $fields=false) 
	{
		//education_id is the key for this table
		$provider = false;
	    if (array_key_exists('unitid',$params) && $params['unitid'])
		{
			$provider = Doctrine_Core::getTable('VCN_Model_Provider')->findOneByUnitid($params['unitid']);
		} 

        if ( ! $provider) {
            $provider = new VCN_Model_Provider();
           	$provider->CREATED_TIME = date('Y-m-d H:i:s',mktime()); 
          	$provider->CREATED_BY   = (array_key_exists('user_id', $params) AND $params('user_id') ) ? $params['user_id'] : '';
         }
        
      	$provider->UNITID = (array_key_exists('course_type', $params) AND $params('unitid') ) ? $params['unitid'] : '';
        $provider->INSTNM  = (array_key_exists('instnm', $params) AND $params('instnm') )   ? $params['instnm'] : '';
        $provider->ADDR  = (array_key_exists('addr', $params) AND $params('addr') )   ? $params['addr'] : '';
       	$provider->CITY  = (array_key_exists('city', $params) AND $params('city') )   ? $params['city'] : '';
      	$provider->STABBR  = (array_key_exists('stabbr', $params) AND $params('stabbr') )   ? $params['stabbr'] : '';
   		$provider->ZIP  = (array_key_exists('zip', $params) AND $params('zip') )   ? $params['zip'] : '';
     	
   		$provider->FIPS  = (array_key_exists('fips', $params) AND $params('fips') )            ? $params['fips'] : '';
  		$provider->OBEREG  = (array_key_exists('obereg', $params) AND $params('obereg') )      ? $params['obereg'] : '';
      	$provider->CHFNM  = (array_key_exists('chfnm', $params) AND $params('chfnm') )         ? $params['chfnm'] : '';
		$provider->CHFTITLE  = (array_key_exists('chftitle', $params) AND $params('chftitle')) ? $params['chftitle'] : '';
		$provider->GENTELE  = (array_key_exists('gentele', $params) AND $params('gentele') )   ? $params['gentele'] : '';
 		$provider->EIN  = (array_key_exists('ein', $params) AND $params('ein') )               ? $params['ein'] : '';
 		$provider->DUNS  = (array_key_exists('duns', $params) AND $params('duns') )            ? $params['duns'] : '';
 		$provider->OPEID  = (array_key_exists('opeid', $params) AND $params('opeid') )         ? $params['opeid'] : '';
 		$provider->OPEFLAG  = (array_key_exists('opeflag', $params) AND $params('opeflag') )   ? $params['opeflag'] : '';
 		$provider->WEBADDR  = (array_key_exists('webaddr', $params) AND $params('webaddr') )   ? $params['webaddr'] : '';
 		$provider->ADMINURL  = (array_key_exists('adminurl', $params) AND $params('adminurl')) ? $params['adminurl'] : '';
 		$provider->FAIDURL  = (array_key_exists('faidurl', $params) AND $params('faidurl') )   ? $params['faidurl'] : '';
 		$provider->APPLURL  = (array_key_exists('applurl', $params) AND $params('applurl') )   ? $params['applurl'] : '';
 		$provider->SECTOR  = (array_key_exists('sector', $params) AND $params('sector') )      ? $params['sector'] : '';
		$provider->ICLEVEL  = (array_key_exists('iclevel', $params) AND $params('iclevel') )   ? $params['iclevel'] : '';
 		$provider->CONTROL  = (array_key_exists('control', $params) AND $params('control') )   ? $params['control'] : '';
 		$provider->HLOFFER  = (array_key_exists('hloffer', $params) AND $params('hloffer') )   ? $params['hloffer'] : '';
 		$provider->UGOFFER  = (array_key_exists('ugoffer', $params) AND $params('ugoffer') )   ? $params['ugoffer'] : '';
 		$provider->GROFFER  = (array_key_exists('groffer', $params) AND $params('groffer') )   ? $params['groffer'] : '';
 		$provider->FPOFFER  = (array_key_exists('fpoffer', $params) AND $params('fpoffer') )   ? $params['fpoffer'] : '';
 		$provider->HDEOFFR  = (array_key_exists('hdeoffr', $params) AND $params('hdeoffr') )   ? $params['hdeoffr'] : '';
 		$provider->DEGGRANT  = (array_key_exists('deggrant', $params) AND $params('deggrant')) ? $params['deggrant'] : '';
 		$provider->HBCU  = (array_key_exists('hbcu', $params) AND $params('hbcu') )            ? $params['hbcu'] : '';
 		$provider->HOSPITAL  = (array_key_exists('hospital', $params) AND $params('hospital')) ? $params['hospital'] : '';
 		$provider->MEDICAL  = (array_key_exists('medical', $params) AND $params('medical') )   ? $params['medical'] : '';
 		$provider->TRIBAL  = (array_key_exists('tribal', $params) AND $params('tribal') )      ? $params['tribal'] : '';
 		$provider->LOCALE  = (array_key_exists('locale', $params) AND $params('locale') )      ? $params['locale'] : '';
 		$provider->OPENPUBL  = (array_key_exists('openpubl', $params) AND $params('openpubl')) ? $params['openpubl'] : '';
 		$provider->ACT  = (array_key_exists('act', $params) AND $params('act') )               ? $params['act'] : '';
 		
 		$provider->NEWID    = (array_key_exists('newid', $params) AND $params('newid') )       ? $params['newid'] : '';
 		$provider->DEATHYR  = (array_key_exists('deathyr', $params) AND $params('deathyr') )   ? $params['deathyr'] : '';
 		$provider->CLOSEDAT = (array_key_exists('closedat', $params) AND $params('closedat'))  ? $params['closedat'] : '';
 		$provider->CYACTIVE = (array_key_exists('cyactive', $params) AND $params('cyactive'))  ? $params['cyactive'] : '';
		$provider->POSTSEC  = (array_key_exists('postsec', $params) AND $params('postsec') )   ? $params['postsec'] : '';
 		$provider->PSEFLAG  = (array_key_exists('pseflag', $params) AND $params('pseflag') )   ? $params['pseflag'] : '';
 		$provider->PSET4FLG = (array_key_exists('pset4flg', $params) AND $params('pset4flg') ) ? $params['pset4flg'] : '';
 		$provider->RPTMTH   = (array_key_exists('rptmth', $params) AND $params('rptmth') )     ? $params['rptmth'] : '';
 		$provider->IALIAS   = (array_key_exists('ialias', $params) AND $params('ialias') )     ? $params['ialias'] : '';
 		$provider->INSTCAT  = (array_key_exists('instcat', $params) AND $params('instcat') )   ? $params['instcat'] : '';
		$provider->CCBASIC  = (array_key_exists('ccbasic', $params) AND $params('ccbasic') )   ? $params['ccbasic'] : '';
 		$provider->CCIPUG   = (array_key_exists('ccipug', $params) AND $params('ccipug') )     ? $params['ccipug'] : '';


 		$provider->CCIPGRAD = (array_key_exists('ccipgrad', $params) AND $params('ccipgrad'))  ? $params['ccipgrad'] : '';
 		$provider->CCUGPROF  = (array_key_exists('ccugprof', $params) AND $params('ccugprof')) ? $params['ccugprof'] : '';
 		$provider->CCENRPRF  = (array_key_exists('ccenrprf', $params) AND $params('ccenrprf')) ? $params['ccenrprf'] : '';
 		$provider->CCSIZSET  = (array_key_exists('ccsizset', $params) AND $params('ccsizset')) ? $params['ccsizset'] : '';
 		$provider->CARNEGIE  = (array_key_exists('carnegie', $params) AND $params('carnegie')) ? $params['carnegie'] : '';
 		$provider->TENURSYS  = (array_key_exists('tenursys', $params) AND $params('tenursys')) ? $params['tenursys'] : '';
 		$provider->LANDGRNT  = (array_key_exists('landgrnt', $params) AND $params('landgrnt')) ? $params['landgrnt'] : '';
 		$provider->INSTSIZE  = (array_key_exists('instsize', $params) AND $params('instsize')) ? $params['instsize'] : '';
 		$provider->CBSA      = (array_key_exists('cbsa', $params) AND $params('cbsa') )        ? $params['cbsa'] : '';
 		$provider->CBSATYPE  = (array_key_exists('cbsatype', $params) AND $params('cbsatype')) ? $params['cbsatype'] : '';
 		$provider->CSA       = (array_key_exists('csa', $params) AND $params('csa') )          ? $params['csa'] : '';
 		$provider->NECTA     = (array_key_exists('necta', $params) AND $params('necta') )      ? $params['necta'] : '';
 		$provider->DFRCGID   = (array_key_exists('dfrcgid', $params) AND $params('dfrcgid') )  ? $params['dfrcgid'] : '';
 		$provider->LATITUDE  = (array_key_exists('latitude', $params) AND $params('latitude')) ? $params['latitude'] : '';
 		$provider->LONGITUDE = (array_key_exists('longitude',$params) AND $params('longitude')) ? $params['longitude'] : '';
 		$provider->COUNTYCD  = (array_key_exists('countycd', $params) AND $params('countycd')) ? $params['countycd'] : '';
 		
        $provider->COUNTYNM  = (array_key_exists('countynm', $params) AND $params('countynm')) ? $params['countynm'] : '';
        $provider->CNGDSTCD  = (array_key_exists('cngdstcd', $params) AND $params('cngdstcd')) ? $params['cngdstcd'] : '';
        $provider->SOURCE    = (array_key_exists('source', $params) AND $params('source') )    ? $params['source'] : '';
        $provider->VERIFIED_YN = (array_key_exists('verified_yn', $params) AND $params('verified_yn')) ? $params['verified_yn'] : '';
        $provider->VERIFIED_BY = (array_key_exists('verified_by', $params) AND $params('verified_by')) ? $params['verified_by'] : '';
        $provider->IPEDS_YN    = (array_key_exists('ipeds_yn', $params) AND $params('ipeds_yn') )      ? $params['ipeds_yn'] : '';
    	$provider->AACC_YN     = (array_key_exists('aacc_yn', $params) AND $params('aacc_yn') )        ? $params['aacc_yn'] : '';
        $provider->VHS_YN      = (array_key_exists('vhs_yn', $params) AND $params('vhs_yn') )          ? $params['vhs_yn'] : '';
        $provider->UPDATED_BY  = (array_key_exists('user_id', $params) AND $params('user_id') )  ? $params['user_id'] : '';
      	$provider->UPDATED_TIME = date('Y-m-d H:i:s',mktime());
    	
       	$provider->save();
      	
     	 
     	$data = false;
      	$this->setResult('success', 'data saved', $params, $data);
   	     	
		return $this->result;		
	}
	
 	public function deleteProvider($params, $fields=false) 
	{
		$provider = false;
	    if (array_key_exists('coursetype',$params) && $params['$provider'])
		{
			$provider = Doctrine_Core::getTable('VCN_Model_Provider')->findOneByUnitid($params['unitid']);
		} 

        if ( ! $provider) {
        	$this->setResult('fail', 'record not found', $params, $data);
 			return $this->result;
        }
        $provider->delete();
    	$this->setResult('success', 'data deleted', $params, $data);
   	     	
		return $this->result;		
	}
 	
 	
}