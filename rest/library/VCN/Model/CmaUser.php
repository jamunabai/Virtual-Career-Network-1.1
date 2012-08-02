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
 * VcnCmaUser
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class VCN_Model_CmaUser extends VCN_Model_Base_CmaUser {

    public function getUserInfo($params) {

        if (!isset($params['user_id']) || !isset($params['session_id'])) {
            $this->setResult('fail', 'Missing Parameters: user_session OR user_session_id', $params, false);
            return $this->result;
        } elseif (is_array($params['user_id']) || is_array($params['session_id'])) {
            $this->setResult('fail', 'Multiple values for Parameters: user_session OR user_session_id', $params, false);
            return $this->result;
        }

        $cma_user    = false;
        $cma_session = false;

        //error_log('getUserInfo - params: ' . print_r($params,true));

        
        //print_r($params); exit;

        if ($params['user_id'] > 0) {
            $user_id  = $params['user_id'];
              $cma_user = $this->getTable()->findOneByUser_sessionAndUser_session_id('U',$user_id);
        }
        $session_id  = $params['session_id'];
        $cma_session = $this->getTable()->findOneByUser_sessionAndUser_session_id('S',$session_id);

        if ($cma_session && $cma_user) {
            //error_log('getUserInfo - found both, merging');
            $userinfo = $this->_user_session_merge($cma_user, $cma_session);
            //error_log('getUserInfo - CMA User save results: ' . print_r($userinfo->toArray(),true));
            unset($cma_user);
            unset($cma_session);
        } elseif ($cma_user) {
            $userinfo = $cma_user;
            unset($cma_user);
            //error_log('getUserInfo - found user only');
        } else {
            if ($cma_session) {
                $userinfo = $cma_session;
                unset($cma_session);
                $userinfo = new VCN_Model_CmaUser;
                //This is to update the updated_time field in the vcn_cma_user table in the database
                $userinfo = Doctrine_Core::getTable('VCN_Model_CmaUser')->findOneByUser_session_id($params['session_id']);
                $userinfo->updated_time = date('Y-m-d H:i:s');  
                $userinfo ->save();
            } else {
                //error_log('getUserInfo - found neither, setting up new object');
                $userinfo = new VCN_Model_CmaUser;
                $userinfo->user_session    = 'S';
                $userinfo->user_session_id = $session_id;
				//This is to udpate the created_time field in the vcn_cma_user table in the database 
              	$userinfo->created_time = date('Y-m-d H:i:s');
                //$userinfo->updated_time = date('Y-m-d H:i:s');  
                $userinfo->save();
            }
        }
        
        //error_log('CmaUser Model: ' . print_r($userinfo->toArray(),true));

        $data = array('userinfo' => $userinfo->toArray());
        $this->setResult('success', 'data returned', $params, $data);

        return $this->result;
    }

    public function updateUserInfo($params) {

        if (!isset($params['user_id']) || !isset($params['session_id'])) {
            $this->setResult('fail', 'Missing Parameters: user_session OR user_session_id', $params, false);
            return $this->result;
        } elseif (is_array($params['user_id']) || is_array($params['session_id'])) {
            $this->setResult('fail', 'Multiple values for Parameters: user_session OR user_session_id', $params, false);
            return $this->result;
        }

        $cma_user    = false;
        $cma_session = false;
        $registering_user = false;

        if ($params['user_id'] > 0) {
            $user_id  = $params['user_id'];
              $cma_user = $this->getTable()->findOneByUser_sessionAndUser_session_id('U',$user_id);
            if (!$cma_user) {
                $cma_user = new VCN_Model_CmaUser;
                $cma_user->user_session = 'U';
                $cma_user->user_session_id = $params['user_id'];
                $registering_user = true;
            }
        }
        $session_id  = $params['session_id'];
        $cma_session = $this->getTable()->findOneByUser_sessionAndUser_session_id('S',$session_id);

        $userinfo = new VCN_Model_CmaUser;
        $userinfo->user_session    = 'S';
        $userinfo->user_session_id = $params['session_id'];

        if ($cma_session && $cma_user) {
            //error_log('updateUserInfo - found both, merging');
            $userinfo = $this->_user_session_merge($cma_user, $cma_session, $registering_user);
            //error_log('updatrUserInfo - CMA User save results: ' . print_r($userinfo->toArray(),true));
            unset($cma_user);
            unset($cma_session);
        } elseif ($cma_user) {
            $userinfo = $cma_user;
        } else {
            if ($cma_session) {
                $userinfo = $cma_session;
            }
        }

        //error_log('Attempting to save this data: ' . print_r($params['userinfo'],true));

        //error_log('UserInfo before the fromArray Call: ' . print_r($userinfo->toArray(),true));

        // process array, set empty values to null
        if(isset($params['userinfo'])){
	        foreach ($params['userinfo'] as $k => $v) {
	            if (empty($v)) {
	                $params['userinfo'][$k] = null;
	            }
	        }
        }
		
        if(isset($params['userinfo'])){
        	$userinfo->fromArray($params['userinfo']);
        }
        
        //error_log('UserInfo after the fromArray Call: ' . print_r($userinfo->toArray(),true));
        if(isset($userinfo)){
	        if ($userinfo->trySave()) {
	          $data = array('userinfo' => $userinfo->toArray());
	          $this->setResult('success', 'data returned', $params, $data);
	        } else {
	          //error_log('UserInfo save fails: ' . print_r($userinfo->errorStack(),true));
	          $this->setResult('fail', 'Unable to save updated information', $params, false);
	        }
        }

        return $this->result;
    }

    public function resetSessionId($params)
    {

        //error_log('resetSessionId called: ' . print_r($params,true));
        if (!isset($params['old_session_id']) || !isset($params['session_id'])) {
            $this->setResult('fail', 'Missing Parameters: user_session OR user_session_id', $params, false);
            return $this->result;
        } elseif (is_array($params['old_session_id']) || is_array($params['session_id'])) {
            $this->setResult('fail', 'Multiple values for Parameters: user_session OR user_session_id', $params, false);
            return $this->result;
        }

        $cma_session = false;

        $session_id  = $params['old_session_id'];
        $cma_session = $this->getTable()->findOneByUser_sessionAndUser_session_id('S',$session_id);

        if ($cma_session) {
            $cma_session->user_session_id = $params['session_id'];

            if ($cma_session->trySave()) {
                $data = array('userinfo' => $cma_session->toArray());
                $this->setResult('success', 'data returned', $params, $data);
            } else {
                //error_log('UserInfo save fails: ' . print_r($cma_session->errorStack(),true));
                $this->setResult('fail', 'Unable to save updated information', $params, false);
            }
        } else {
            $this->setResult('fail', 'Can not find CMA record: ', $params, false);
        }

        return $this->result;
    }

    private function _user_session_merge($cma_user, $cma_session, $registering_user = false)
    {

        $user_array = $cma_user->toArray();
        $session_array = $cma_session->toArray();
        foreach ($session_array as $k => $v) {
            if (empty($v)) {
                unset($session_array[$k]);
            }
        }
        // now we unset the user_id, user_session_id and user_session from the session array
        //   so the merged results retain the user_array values for those keys
        unset($session_array['user_id']);
        unset($session_array['user_session']);
        unset($session_array['user_session_id']);
        // return merged array
        $merged_array = array_merge($user_array, $session_array);
        //error_log("Here is the merged_array: " . print_r($merged_array,TRUE));
        $cma_user->synchronizeWithArray( $merged_array );
// the following line seems to do the same as the above two lines,
// but it does not explode the cma_user, so being sure it gets both in array format seems the better way
//        $cma_user->merge( $session_array, TRUE );
        $cma_user->save();
        // lets find all relations and be sure they are loaded as well
            // TODO -- it seems most relationships are broken, when all fixed, eliminate array -- see below TODO within foreach
            //  so, uncomment the relationship as it is verified to be a valid relationship
            //     which will allow the merging of that relationship data from session to user
        $cmaUserIncludeRelations = array(
//            'Occupation',
//            'Citizenship',
//            'Country',
//            'MaritalStatus',
//            'Race',
//            'VisaStatus',
            'KeyItems',
            'NotebookItems',
//            'Associations',
            'Certificates',
            'Courses',
//            'Employers',
            'Licenses',
//            'PrivacySettings',
//            'References',
            );

        foreach ($cma_session->getTable()->getRelations() as $name => $relation) {
        	
     	$occupationlogedinuser = VCN_Model_CmaUserNotebookTable::getNotebookItems($cma_user->user_id,'OCCUPATION', false);

/*     	$counting = count($occupationlogedinuser['data']);
     	
     	if (isset($occupationlogedinuser['data'])) {
     		error_log("To remove the extra occupation thats present: " . print_r($counting,TRUE));
     		error_log("DONE!!!!" );
     	}     	
     	if(isset($occupationlogedinuser['data']))
     	{
     		error_log("This is to make sure how many occs do i have: " . print_r($occupationlogedinuser['data'],TRUE));
     		error_log("AGAIN DONE!!!!" );
     	}*/
     	if(isset($occupationlogedinuser['data'][4]['ITEM_ID']))
     		VCN_Model_CmaUserNotebookTable::removeFromNotebook($cma_user->user_id,'OCCUPATION',$occupationlogedinuser['data'][4]['ITEM_ID']);  
     	elseif(isset($occupationlogedinuser['data'][5]['ITEM_ID']))
     		VCN_Model_CmaUserNotebookTable::removeFromNotebook($cma_user->user_id,'OCCUPATION',$occupationlogedinuser['data'][5]['ITEM_ID']);  
     	elseif(isset($occupationlogedinuser['data'][6]['ITEM_ID']))
     		VCN_Model_CmaUserNotebookTable::removeFromNotebook($cma_user->user_id,'OCCUPATION',$occupationlogedinuser['data'][6]['ITEM_ID']);  
     	elseif(isset($occupationlogedinuser['data'][7]['ITEM_ID']))
     		VCN_Model_CmaUserNotebookTable::removeFromNotebook($cma_user->user_id,'OCCUPATION',$occupationlogedinuser['data'][7]['ITEM_ID']);   
     	else 
     		//error_log("Do Nothing!!!!" );
     	
/*        print($name->$relation);exit;*/
           $relationshipName = $relation->getAlias();
            //error_log("Relation: " . $name . " : alias : " . $relationshipName);
           $relationTableName = $relation->getTable()->getTableName();
           $gaitem1 = Doctrine_Core::getTable('VCN_Model_CmaUserKey')->findOneByUser_id($cma_user->user_id);
            //error_log("Relation table name: " . $relationTableName);
            // TODO -- when all relationships are verified as working, eliminate the array check
            if(in_array($relationshipName, $cmaUserIncludeRelations)) {
                
                foreach ($cma_session->{$relationshipName} as $childItem) {
                    
                    //this condition is to make sure that if a user targets any CMA item, the item rank for the targeted item will be 1
                    //and the item rank for the rest of the CMA items will be forced to zero (even upon the user merge)
                    if ($relationshipName == 'NotebookItems')
                    {
                        //print_r($childItem);
                        //$table = new VCN_Model_CmaUserNotebookTable();
                        //$notebookitem = $table->getTable()->findOneByUser_idAndItem_idAndItem_rank($cma_user->user_id,$childItem->ITEM_TYPE, 1);
                        
                        $notebookitem = Doctrine_Core::getTable('VCN_Model_CmaUserNotebook')->findOneByUser_idAndItem_typeAndItem_idAndStfips($cma_user->user_id,$childItem->ITEM_TYPE, $childItem->ITEM_ID,$childItem->STFIPS);
                        
                           if (!$notebookitem or ($notebookitem AND $notebookitem->ITEM_RANK != $childItem->ITEM_RANK))
                        {
			                	  switch ($childItem->ITEM_TYPE)
			                	  {
			                		case 'OCCUPATION':
										$occupation = VCN_Model_CmaUserNotebookTable::getNotebookItems($cma_user->user_id,$childItem->ITEM_TYPE, true);
			     						$targeted_occupation = $occupation['data'][0]['ITEM_ID'];
			     						$occupationsession = VCN_Model_CmaUserNotebookTable::getNotebookItems($cma_session['user_id'],'OCCUPATION', true);
			                			if($targeted_occupation != $childItem->ITEM_ID && !empty($occupationsession['data'][0]['ITEM_RANK']))			 
			                			{               			
						    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'OCCUPATION' );
			                			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'PROGRAM' );
						    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'CERTIFICATE' );
						    			VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'LICENSE' );
						    			//VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'COURSE' );
			                			}
                                    case 'PROGRAM':
                                    	$programsession = VCN_Model_CmaUserNotebookTable::getNotebookItems($cma_session['user_id'],'PROGRAM', true);
                                    	//error_log("Program item rank: " . print_r($programsession,TRUE));
                                    	if(!empty($programsession['data'][0]['ITEM_RANK']))			 
			                			{
                                        VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'PROGRAM' );
			                			}
                                        break;
                                    case 'CERTIFICATE':
                                    	$certificatesession = VCN_Model_CmaUserNotebookTable::getNotebookItems($cma_session['user_id'],'CERTIFICATE', true);
			                	  		if(!empty($certificatesession['data'][0]['ITEM_RANK']))			 
			                			{
                                        VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'CERTIFICATE' );
			                			}
                                        break;
                                    case 'LICENSE':
                                    	$licensesession = VCN_Model_CmaUserNotebookTable::getNotebookItems($cma_session['user_id'],'LICENSE', true);
                                    	if(!empty($licensesession['data'][0]['ITEM_RANK']))			 
			                			{
                                        VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'LICENSE' );
			                			}
                                        break;
                                    case 'COURSE':
                                    	$coursesession = VCN_Model_CmaUserNotebookTable::getNotebookItems($cma_session['user_id'],'COURSE', true);
                                    	if(!empty($coursesession['data'][0]['ITEM_RANK']))			 
			                			{
                                        VCN_Model_CmaUserNotebookTable::removeTargetNotebookItem($cma_user->user_id,'COURSE' );
			                			}
                                        break;
                                            
                                    default;
                                  }
                            if($notebookitem)
                            {
                             $notebookitem->ITEM_RANK = $childItem->ITEM_RANK;
                             $notebookitem->save();
                            }
                        }
                       }
                       
                    else if ($relationshipName == 'KeyItems' && !empty($gaitem1))
                        { // GET THE CORRESPONDING DB ITEM IF IT ALREADY EXISTS
                        //error_log "(<br />In loop)";
                        //error_log(print_r($childItem));
                        //error_log "(<br />Should have printed child item");
                        
                        $gaitem = Doctrine_Core::getTable('VCN_Model_CmaUserKey')->findOneByUser_idAndKey_categoryAndKey_name($cma_user->user_id, $childItem->KEY_CATEGORY, $childItem->KEY_NAME);
                        
                        //error_log(print_r($gaitem));
                        //error_log( "should have printed gaitem");
                        
                        //IF YOU GET THE ITEM UPDATE THE VALUE TO NEW KEY_VALUE; CHECK THE CASE ON $childItem->key_value (or $childItem->KEY_VALUE)
                        if(isset($gaitem->key_value))
                        {
                            //error_log( "<br />KEY ITEM SET");
                            $gaitem->key_value = $childItem->key_value;
                        }
                        else
                        {
                            //error_log( "<br />KEY ITEM NOT SET");
                            //if it's there change the value
                            $gaitem->KEY_VALUE = $childItem->KEY_VALUE;
                        }                     
                        $gaitem->save();
                    }              
                       
                       
                   if (isset ($childItem->user_id)) {
                          $childItem->user_id = $cma_user->user_id;
                        } else {
                          $childItem->USER_ID = $cma_user->user_id;
                        }
                        try {
                          $childItem->save();
                        } catch (Doctrine_Connection_Exception $dce) {
                            //error_log("Update failed for this relationship: " . print_r($childItem,TRUE)); //do something
                        }

                }
            }
        }

        if (!$registering_user) {
            $cma_session->delete();
        }
        return $cma_user;
    }

}