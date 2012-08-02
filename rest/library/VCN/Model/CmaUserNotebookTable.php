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
 * VCN_Model_CmaUserNotebookTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class VCN_Model_CmaUserNotebookTable extends Doctrine_Table
{
    public static $VIRTUALHIGH = 'VHS';
    public static $OCCUPATION  = 'OCCUPATION';
    public static $PROGRAM     = 'PROGRAM';
    public static $LICENSE     = 'LICENSE';
    public static $COURSE      = 'COURSE';
    public static $CERTIFICATE = 'CERTIFICATE';

    /**
     * Returns an instance of this class.
     *
     * @return object VCN_Model_CmaUserNotebookTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('VCN_Model_CmaUserNotebook');
    }

    public function addToNotebook($user_id,$item_type,$item_id,$item_notes=null,$stfips=null)
    {
    //error_log('cmaUserNotebookTable saveToNotebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $stfips . ':');
    	//TODO USING STFIPS FOR CIPCODE RENAME TO GENERIC IN REFACTOR    
    	if (strtoupper($item_type) == 'LICENSE' OR strtoupper($item_type) == 'PROGRAM') {
          $record = self::getInstance()->findOneByUser_idAndItem_typeAndItem_idAndStfips($user_id,$item_type,$item_id,$stfips);
        } else {
          $record = self::getInstance()->findOneByUser_idAndItem_typeAndItem_id($user_id,$item_type,$item_id);
        }
        $curDate = date('Y-m-d H:i:s');
        if ( ! $record) {
            $record = new VCN_Model_CmaUserNotebook();
            $record->USER_ID      = $user_id;
            $record->ITEM_TYPE    = $item_type;
            $record->ITEM_ID      = $item_id;
            $record->STFIPS       = $stfips;
            $record->ITEM_NOTES   = $item_notes;
            $record->ITEM_RANK    = 0;
            $record->ACTIVE_YN    = "Y";
            $record->CREATED_TIME = $curDate;
        }
        $record->UPDATED_TIME = $curDate;
        $record->save();

        $result['status']['value']    = 'success';
 	    $result['status']['code']     = 'success';
 	    $result['status']['msg']      = $item_type . ' saved';
 	    $result['status']['rowcount'] = 1;
 	    $result['params']             = array('user_id' => $user_id, 'item_id' => $item_id);

        return $result;
    }

    public function removeFromNotebook($user_id,$item_type,$item_id,$stfips=null)
    {
    //error_log('cmaUserNotebookTable removeFromNotebook - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $stfips . ':');
    	//TODO USING STFIPS FOR CIPCODE RENAME TO GENERIC IN REFACTOR    
    	if (strtoupper($item_type) == 'LICENSE' OR strtoupper($item_type) == 'PROGRAM') {
          $record = self::getInstance()->findOneByUser_idAndItem_typeAndItem_idAndStfips($user_id,$item_type,$item_id,$stfips);
        } else {
          $record = self::getInstance()->findOneByUser_idAndItem_typeAndItem_id($user_id,$item_type,$item_id);
        }
        if ( isset($record)) {
           	$record->delete();
        }

        $result['status']['value']    = 'success';
 	    $result['status']['code']     = 'success';
 	    $result['status']['msg']      = $item_type . ' removed';
 	    $result['status']['rowcount'] = 1;
 	    $result['params']             = array('user_id' => $user_id, 'item_id' => $item_id);

        return $result;
    }

    public function targetNotebookItem($user_id,$item_type,$item_id,$stfips=null)
    {
    	//error_log('cmaUserNotebookTable targetNotebookItem - item_type:' . $item_type . ': and item_id:' . $item_id . ': and item_stfips:' . $stfips . ':');
    
		//self::removeTargetNotebookItem($user_id,$item_type );
		
    	//TODO USING STFIPS FOR CIPCODE RENAME TO GENERIC IN REFACTOR    
    	if (strtoupper($item_type) == 'LICENSE' OR strtoupper($item_type) == 'PROGRAM') {
           $record = self::getInstance()->findOneByUser_idAndItem_typeAndItem_idAndStfips($user_id,$item_type,$item_id,$stfips);
        } 
   		else {
          $record = self::getInstance()->findOneByUser_idAndItem_typeAndItem_id($user_id,$item_type,$item_id);
        }
        $curDate = date('Y-m-d H:i:s');
        if ( ! $record) {
            $record = new VCN_Model_CmaUserNotebook();
            $record->USER_ID      = $user_id;
            $record->ITEM_TYPE    = $item_type;
            $record->ITEM_ID      = $item_id;
            $record->STFIPS       = $stfips;
            $record->ITEM_NOTES   = NULL;
            $record->ACTIVE_YN    = "Y";
            $record->CREATED_TIME = $curDate;
        }
        $record->ITEM_RANK    = 1;
        $record->UPDATED_TIME = $curDate;
        $record->save();

        $result['status']['value']    = 'success';
 	    $result['status']['code']     = 'success';
 	    $result['status']['msg']      = $item_type . ' targeted';
 	    $result['status']['rowcount'] = 1;
 	    $result['params']             = array('user_id' => $user_id, 'item_id' => $item_id);

        return $result;
    }

    public function getNotebookItems($user_id,$item_type, $target=false)
    {
        $sql = self::getInstance()->createQuery();
        switch ($item_type) {
            case self::$CERTIFICATE : $sql->select('ITEM_ID as cert_id, *');
                                      break;
            case self::$COURSE      : $sql->select('ITEM_ID as course_id, *');
                                      break;
            case self::$LICENSE     : $sql->select('ITEM_ID as license_id, *');
                                      break;
            case self::$PROGRAM     : $sql->select('ITEM_ID as program_id, *');
                                      break;
            case self::$VIRTUALHIGH : $sql->select('ITEM_ID as vhs_unitid, *');
                                      break;
            case self::$OCCUPATION  :
            default                 : $sql->select('ITEM_ID as onetcode, *');
                                      break;
        }
        $sql->where('USER_ID = ?',$user_id)
            ->addWhere('ITEM_TYPE = ?',  $item_type);
            
        if ($target)
        	$sql->addWhere('ITEM_RANK = 1');
            
        //target should appear first later it should put the newest career in the end 
        //if (!$target)
        $sql->orderBy('ITEM_RANK DESC, UPDATED_TIME DESC');
       // else
       // $sql->orderBy('ITEM_RANK DESC, UPDATED_TIME DESC');
       
        $data = $sql->fetchArray();
 //echo $sql->getSqlQuery();exit;
        $result['status']['value']    = 'success';
 	    $result['status']['code']     = 'success';
 	    $result['status']['msg']      = 'data retrieved';
 	    $result['status']['rowcount'] = ($data) ? sizeof($data): 0;
 	    $result['params']             = array('user_id' => $user_id);
 	    $result['data']               = $data;

        return $result;
    }

    
    public function removeTargetNotebookItem($user_id,$item_type )
    {
    	//error_log('cmaUserNotebookTable removeTargetNotebookItem - item_type:' . $item_type . ':');
        self::getInstance()->createQuery()
                           ->update()
                           ->set('ITEM_RANK', 0)
                           ->where('USER_ID = ?',$user_id)
                           ->addWhere('ITEM_TYPE = ?',  $item_type)
                           ->execute();
          return true;
    }
    
   public function getNotebookTargets( $user_id,$item_type=false )
    { 

       	$sql = self::getInstance()->createQuery();
        $sql->select('*');
       	$sql->where('USER_ID = ?',$user_id)->addWhere('ITEM_RANK = 1');
		
		//echo $sql; exit;
      	$data = $sql->fetchArray();
 
        $result['status']['value']    = 'success';
 	    $result['status']['code']     = 'success';
 	    $result['status']['msg']      = 'data retrieved';
 	    $result['status']['rowcount'] = ($data) ? sizeof($data): 0;
 	    $result['params']             = array('user_id' => $user_id);
 	    $result['data']               = $data;

        return $result;
    }
}