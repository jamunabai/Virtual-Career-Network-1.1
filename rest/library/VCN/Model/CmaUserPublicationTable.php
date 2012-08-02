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
 * VCN_Model_CmaUserPublicationTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class VCN_Model_CmaUserPublicationTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object VCN_Model_CmaUserPublicationTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('VCN_Model_CmaUserPublication');
    }

    public static function listUserPublications($user_id)
    {
        $sql = self::getInstance()->createQuery();
        $sql->where('USER_ID = ?',$user_id);

        $sql->orderBy('PUBLISHED_DATE DESC');

        $data = $sql->fetchArray();

        return self::_returnStatus('success',
                                   'data retrieved',
                                   array('user_id' => $user_id),
                                   $data);
    }

    public static function updateUserPublication($form_values)
    {
        $table = self::getInstance();
        $columns = $table->getColumnNames();
  //      error_log('updateUserPublication form_values: ' . print_r($form_values,TRUE));
  //      error_log('List of columns in Publication Table: ' . print_r($columns,TRUE));
        if (isset($form_values['REC_ID'])) {
            $record = $table->find($form_values['REC_ID']);
            if (!$record) {
                return self::_returnStatus('failed','Record NOT found',$form_values,NULL);
            }
            if (isset($form_values['REC_MODE']) && $form_values['REC_MODE'] == 'D') {
                $record->delete();
                return self::_returnStatus('success','Record Removed',$form_values,NULL);
            }
            $record->UPDATED_TIME = date('Y/m/d H:i:s');
        } else {
            $record = new VCN_Model_CmaUserPublication();
            $record->CREATED_TIME = date('Y/m/d H:i:s');
        }
        foreach ($form_values as $col => $val) {
            if (in_array(strtolower($col),$columns)) {
                $record->{$col} = $val;
            }
        }
//        error_log('About to save Publication Record: ' . print_r($record->toArray(),TRUE));
        $record->save();

        return self::_returnStatus('success','Record Updated',$form_values,NULL);
    }

    public static function getUserPublication($record_id)
    {
        $table = self::getInstance();
        $record = $table->find($record_id);
        if (!$record) {
            return self::_returnStatus('failed','Record NOT found',$record_id,NULL);
        }

        return self::_returnStatus('success',
                                   'Record Updated',
                                   array('record_id' => $record_id),
                                   $record->toArray());
    }

    private static function _returnStatus($stat,$msg,$params,$data)
    {
        $result = array();
        $result['status']['value']    = $stat;
 	    $result['status']['code']     = $stat;
 	    $result['status']['msg']      = $msg;
 	    $result['status']['rowcount'] = ($data) ? sizeof($data): 0;
 	    $result['params']             = $params;
 	    $result['data']               = $data;

        return $result;
    }

}