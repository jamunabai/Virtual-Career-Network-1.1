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
Doctrine_Manager::getInstance()->bindComponent('VCN_Model_CertOnetAssign', 'doctrine');

/**
 * BaseCertOnetAssign
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property decimal $ID
 * @property string $CERT_ID
 * @property string $ONETCODE
 * @property string $ACTIVE_YN
 * @property Certifications $Certifications
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class VCN_Model_Base_CertOnetAssign extends VCN_DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cert_onet_assign');
        $this->hasColumn('CERT_ID', 'string', 4, array(
             'type' => 'string',
             'length' => 4,
             'fixed' => true,
             'unsigned' => false,
             'primary' => true,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('ONETCODE', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('ACTIVE_YN', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('RANK', 'string', 11, array(
             'type' => 'string',
             'length' => 11,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             )); 
        $this->hasColumn('SUPPRESS_YN', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));                         
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('VCN_Model_Certifications as Certification', array(
             'local' => 'CERT_ID',
             'foreign' => 'CERT_ID'));
        $this->hasOne('VCN_Model_Occupation as Occupation', array(
        	'local'=>'ONETCODE',
            'foreign' => 'ONETCODE'));
        
        $this->hasOne('VCN_Model_OnetNewxold as OnetXWalk', array(
        	'local' => 'ONETCODE',
        	'foreign' => 'ONETCODE_OLD'));
    }
}