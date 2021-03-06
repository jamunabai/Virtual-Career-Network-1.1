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
Doctrine_Manager::getInstance()->bindComponent('VCN_Model_CmaAssessmentQuestion', 'doctrine');

/**
 * VCN_Model_Base_CmaAssessmentQuestion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $question_id
 * @property string $question_text
 * @property string $active
 * @property integer $created_by
 * @property timestamp $created_time
 * @property integer $updated_by
 * @property timestamp $updated_time
 * @property VCN_Model_CmaUser $CmaUser
 * @property VCN_Model_CmaUser $CmaUser_2
 * @property Doctrine_Collection $CmaAssessmentAnswer
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class VCN_Model_Base_CmaAssessmentQuestion extends VCN_DoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('vcn_cma_assessment_question');
        $this->hasColumn('question_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('question_text', 'string', 500, array(
             'type' => 'string',
             'length' => 500,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('active', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'default' => 'y',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('created_by', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('created_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('updated_by', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('updated_time', 'timestamp', null, array(
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
        $this->hasOne('VCN_Model_CmaUser as CmaUser', array(
             'local' => 'created_by',
             'foreign' => 'user_id'));

        $this->hasOne('VCN_Model_CmaUser as CmaUser_2', array(
             'local' => 'updated_by',
             'foreign' => 'user_id'));

        $this->hasMany('VCN_Model_CmaAssessmentAnswer as CmaAssessmentAnswer', array(
             'local' => 'question_id',
             'foreign' => 'question_id'));
    }
}