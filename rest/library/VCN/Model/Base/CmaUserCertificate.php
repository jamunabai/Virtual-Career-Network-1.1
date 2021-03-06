<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('VCN_Model_CmaUserCertificate', 'doctrine');

/**
 * VCN_Model_Base_CmaUserCertificate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $USER_CERT_ID
 * @property integer $USER_ID
 * @property string $CERT_ID
 * @property string $CERTIFICATE_NAME
 * @property string $CERTIFICATE_DESCRIPTION
 * @property date $DATE_CERTIFICATE_OBTAINED
 * @property timestamp $CREATED_TIME
 * @property timestamp $UPDATED_TIME
 * @property VCN_Model_Certifications $Certifications
 * @property VCN_Model_CmaUser $VcnCmaUser
 * @property Doctrine_Collection $VcnCmaResumeCertificate
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class VCN_Model_Base_CmaUserCertificate extends VCN_DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('vcn_cma_user_certificate');
        $this->hasColumn('USER_CERT_ID', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('USER_ID', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('CERT_ID', 'string', 4, array(
             'type' => 'string',
             'length' => 4,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('CERTIFICATE_NAME', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('CERTIFICATE_DESCRIPTION', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('DATE_CERTIFICATE_OBTAINED', 'date', null, array(
             'type' => 'date',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('CREATED_TIME', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('UPDATED_TIME', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('VCN_Model_Certifications as Certifications', array(
             'local' => 'CERT_ID',
             'foreign' => 'CERT_ID'));

        $this->hasOne('VCN_Model_CmaUser as VcnCmaUser', array(
             'local' => 'USER_ID',
             'foreign' => 'USER_ID'));

        $this->hasMany('VCN_Model_CmaResumeCertificate as VcnCmaResumeCertificate', array(
             'local' => 'USER_CERT_ID',
             'foreign' => 'USER_CERT_ID'));
    }
}