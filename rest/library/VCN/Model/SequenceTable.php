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
 * VCN_Model_SequenceTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class VCN_Model_SequenceTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object VCN_Model_SequenceTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('VCN_Model_Sequence');
    }

    public static function getNextSequence($seqCode) {
        $sql = self::getInstance()->createQuery('s')
                ->update()
                ->set('s.LAST_VALUE', 's.LAST_VALUE + s.INCREMENT_BY')
                ->where('s.SEQUENCE_NAME = ?',$seqCode)
//                ->andWhere('@SEQ_INC := s.INCREMENT_BY')
                ->andWhere('@CUR_SEQ := s.LAST_VALUE');


        $rslt = $sql->execute();

        if (!$rslt) {
            $result['status']['value']    = 'fail';
            $result['status']['code']     = 'fail';
            $result['status']['msg']      = 'Next Seq Not Retrieved';
            $result['status']['rowcount'] = 0;
            $result['params']             = array();
            $result['data']['next_seq']   = 0;

            return $result;
        }

        $statement = Doctrine_Manager::getInstance()->connection();
        $sql = $statement->execute("SELECT @CUR_SEQ as cur_seq");
        $stmt = $sql->fetchAll();
        $sql = self::getInstance()->createQuery('s')
                ->select('s.INCREMENT_BY as seq_inc')
                ->where('s.SEQUENCE_NAME = ?',$seqCode);

        $rslt = $sql->execute()->toArray();
        $next_seq = $stmt[0]['cur_seq'] + $rslt[0]['seq_inc'];

        $result['status']['value']    = 'success';
 	    $result['status']['code']     = 'success';
 	    $result['status']['msg']      = 'next seq retrieved';
 	    $result['status']['rowcount'] = 1;
 	    $result['params']             = array();
 	    $result['data']['next_seq']   = $next_seq;

        return $result;
    }
}