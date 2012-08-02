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
 * VCN_Model_CertificationsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class VCN_Model_CertificationsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object VCN_Model_CertificationsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('VCN_Model_Certifications');
    }

    public static function getCertificatesForCma($certificate_ids)
    {
        if (is_array($certificate_ids))
        {
            $values = array();
            foreach ($certificate_ids AS $val)
            {
                $values[] = $val ;
            }
            $where = "c.CERT_ID IN ('".implode("','",$values)."')";
        }
        else
        {
            $where =  "c.CERT_ID = '". $value."'";
        }

        $stmt  = self::getInstance()->createQuery();
		$stmt->from ('VCN_Model_Certifications c')
			->leftJoin ('c.CertOrg as certorg')
 			->leftJoin ('c.Certxtype as certxtype')
			->leftJoin ('c.CertOnetAssign coa')
 			->leftJoin ('coa.OnetXWalk bcw')
 			->leftJoin ('bcw.Occupation o')
            ->addwhere($where);


  //error_log($stmt->getSqlQuery());//;exit;
     	$data = $stmt->fetchArray();

        $result['status']['value']    = 'success';
 	    $result['status']['code']     = 'success';
 	    $result['status']['msg']      = 'data retrieved';
 	    $result['status']['rowcount'] = ($data) ? sizeof($data): 0;
 	    $result['params']             = array('certificate_id' => $certificate_ids);
 	    $result['data']               = $data;

        return $result;
    }
}