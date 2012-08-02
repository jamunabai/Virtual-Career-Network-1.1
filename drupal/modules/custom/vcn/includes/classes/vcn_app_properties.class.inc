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
* vcnAppProperties()
* This class is used to get the VCN application properties
*/
class vcnAppProperties {
	
	public function  __construct() {
	
	}
	
	public function getPropertyValue($propertyName) {

		if (!mysql_ping()) {
			echo 'Lost db connection';
			exit;
		}

		$query = "SELECT * FROM vcn_app_properties WHERE name = '" . $propertyName . "' ";

		$result = mysql_query($query) or die("Error running query: ".mysql_error());

		$value = '';

		while ($row = mysql_fetch_assoc($result)) {

			$value = $row['VALUE'];

		}

		return $value;
	}
	
	public function getVCNSupportEmail() {
			
		return $this->getPropertyValue('vcn_support_email');
		
	}
	
	public function getCurrentDrupalVersion() {
			
		return $this->getPropertyValue('current_drupal_version');
	
	}
	
	public function getCurrentMoodleVersion() {
			
		return $this->getPropertyValue('current_moodle_version');
	
	}

	public function getProviderPortalEmail() {
			
		return $this->getPropertyValue('provider_portal_email');
	
	}
	
	public function getProviderContactEmail() {
			
		return $this->getPropertyValue('provider_contact_email');
	
	}
	
	public function getOneStopWebserviceKey() {
			
		return $this->getPropertyValue('one_stop_webservice_key');
	
	}
	
}
?>
