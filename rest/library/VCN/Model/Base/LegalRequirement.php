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
Doctrine_Manager::getInstance()->bindComponent('VCN_Model_LegalRequirement', 'doctrine');

/**
 * VCN_Model_Base_LegalReq
 * 
 * @property integer $PROGRAM_ID
 * @property string $LEGAL_REQ_CODE
 * @property string $NAME
 * @property string $ACTIVE_YN
 * @property integer $CREATED_BY
 * @property datetime $CREATED_TIME
 * @property integer $UPDATED_BY
 * @property datetime $UPDATED_TIME
 */
abstract class VCN_Model_Base_LegalRequirement extends VCN_DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('vcn_legal_requirement');
        $this->hasColumn('LEGAL_REQ_CODE', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             ));
       $this->hasColumn('NAME', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             ));      
       $this->hasColumn('DESCRIPTION', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'autoincrement' => false,
             ));
      $this->hasColumn('ACTIVE_YN', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('CREATED_BY', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('CREATED_TIME', 'datetime', null, array(
             'type' => 'datetime',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('UPDATED_BY', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('UPDATED_TIME', 'datetime', null, array(
             'type' => 'datetime',
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
        $this->hasOne('VCN_Model_LegalRequirement as LegalReq', array(
             'local' => 'LEGAL_REQ_CODE',
             'foreign' => 'LEGAL_REQ_CODE'));
        
 
    }
}