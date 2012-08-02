<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php

require_once ('Zend/Rest/Controller.php');

/**
 * @author hills
 *
 *
 */
class CmaSvc_HistoryController extends VCN_WebServices {

    private $user_id;
    private $item_type;
    private $form_values;


    public function init() {
        parent::init();

        error_log("HistoryController init - params: " . print_r($this->params,TRUE));

        $request_item_type  = (isset($this->params['item_type'])) ? $this->params['item_type'] : 'career';

        $this->item_type    = strtolower($request_item_type);

        $this->user_id      = (isset($this->params['user_id'])) ? $this->params['user_id'] : NULL;

        $this->record_id    = (isset($this->params['record_id'])) ? $this->params['record_id'] : NULL;

    }

    /**
     *
     * @see Zend_Rest_Controller::indexAction()
     */
    public function indexAction() {
        $this->_helper->layout->setLayout('rest');
        throw new Exception("No data found");
    }

    /**
     * listHistoryItems based on item_type and user_id class variables.
     * @see init() for setting of variables.
     */
    public function listHistoryItemsAction() {

        switch ($this->item_type) {
            case 'certification' : $data = $this->_listCertifications();
                                   break;
            case 'publication'   : $data = $this->_listPublications();
                                   break;
            case 'association'   : $data = $this->_listAssociations();
                                   break;
            case 'education'     : $data = $this->_listEducation();
                                   break;
            case 'employment'    :
            default              : $data = $this->_listEmployment();
                                   break;
        }

        $data = $this->_formatData($data);
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    /**
     * getHistoryItem based on item_type and record_id class variables.
     * @see init() for setting of variables.
     */
    public function getHistoryItemAction() {

        switch ($this->item_type) {
            case 'certification' : $data = $this->_getCertification();
                                   break;
            case 'publication'   : $data = $this->_getPublication();
                                   break;
            case 'association'   : $data = $this->_getAssociation();
                                   break;
            case 'education'     : $data = $this->_getEducation();
                                   break;
            case 'employment'    :
            default              : $data = $this->_getEmployment();
                                   break;
        }

        $data = $this->_formatData($data);
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    /**
     * updateHistoryItem based on item_type class variables and params from super class.
     * @see init() for setting of variables.
     */
    public function updateHistoryItemAction() {

        $this->form_values = $this->params['form_values'];

        switch ($this->item_type) {
            case 'certification' : $data = $this->_updateCertification();
                                   break;
            case 'publication'   : $data = $this->_updatePublication();
                                   break;
            case 'association'   : $data = $this->_updateAssociation();
                                   break;
            case 'education'     : $data = $this->_updateEducation();
                                   break;
            case 'employment'    :
            default              : $data = $this->_updateEmployment();
                                   break;
        }

        $data = $this->_formatData($data);
        $this->_response->setHeader('Content-Type', $this->format)->setBody($data);
    }

    // private functions

    // private list functions
    private function _listCertifications() {
        $data  = VCN_Model_CmaUserCertificateTable::listUserCertificates($this->user_id);
        return $data;
    }

    private function _listPublications() {
        $data  = VCN_Model_CmaUserPublicationTable::listUserPublications($this->user_id);
        return $data;
    }

    private function _listAssociations() {
        $data  = VCN_Model_CmaUserAssociationTable::listUserAssociations($this->user_id);
        return $data;
    }

    private function _listEducation() {
        $data  = VCN_Model_CmaUserEducationTable::listUserEducation($this->user_id);
        return $data;
    }

    private function _listEmployment() {
        $data  = VCN_Model_CmaUserEmploymentTable::listUserEmployment($this->user_id);
        return $data;
    }

    // private get functions
    private function _getCertification() {
        return VCN_Model_CmaUserCertificateTable::getUserCertificate($this->record_id);
    }

    private function _getPublication() {
        return VCN_Model_CmaUserPublicationTable::getUserPublication($this->record_id);
    }

    private function _getAssociation() {
        return VCN_Model_CmaUserAssociationTable::getUserAssociation($this->record_id);
    }

    private function _getEducation() {
        return VCN_Model_CmaUserEducationTable::getUserEducation($this->record_id);
    }

    private function _getEmployment() {
        return VCN_Model_CmaUserEmploymentTable::getUserEmployment($this->record_id);
    }

    // private update functions
    private function _updateCertification() {
        return VCN_Model_CmaUserCertificateTable::updateUserCertificate($this->form_values);
    }

    private function _updatePublication() {
        return VCN_Model_CmaUserPublicationTable::updateUserPublication($this->form_values);
    }

    private function _updateAssociation() {
        return VCN_Model_CmaUserAssociationTable::updateUserAssociation($this->form_values);
    }

    private function _updateEducation() {
        return VCN_Model_CmaUserEducationTable::updateUserEducation($this->form_values);
    }

    private function _updateEmployment() {
        return VCN_Model_CmaUserEmploymentTable::updateUserEmployment($this->form_values);
    }


    private function _formatData($data) {
        if ($this->format == 'json') {
            $data = json_encode($data);
        } else {
            $data = VCN_WebServices::toXml($data, 'result', 'cma');
        }

        return $data;
    }

}