<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
vcn_gs_saveUserKey ('GETTINGSTARTED','module','step-one');
vcn_gs_saveUserKey ('GETTINGSTARTED','activity','3');
</script>
<div id="step-1-actvity-2-main-content">

    <p class="font-14">We use ZIP Codes as a non-intrusive means of locating the general geographic area where you work and live. This way, we can provide information customized to your local area. <strong class="cg_highlight">Please enter your ZIP Code and hit the "GO" button.</strong>
                       A map will then be displayed on the right along with healthcare jobs in your area. The job titles are listed below the map. You can click on a job title to view the actual job listing.</p>
    <div id="step-1-zipcode" class="zip-code">
        <div id="step-1-zipcode-inner">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td>ZIP Code</td>
                    <td>

                        <label for="ziptext"><input type="text" name="ziptext" maxlength="5" id="ziptext" onkeyup="handleAction(event)" onblur="$('#zip').val(this.value); vcn_gs_saveToCMA ('zipcode', this.value);" value="<?php echo $vars['zip'];?>"  tabindex="1"/>
                       </label>
                    </td>
                    <td>

            <a title ="Go!" alt="Enter ZIP Code" alt="Go" title="Go" >

                <img class="zip-code-go-img" alt="Go" style= "margin-right:1cm"  onclick="handleAction('button');"  src="<?php echo base_path() . drupal_get_path('module','vcn_getting_started'); ?>/images/go.png"; tabindex="2"/>
            </a>

                    </td></tr></table>
        </div>
    </div>
</div>

<script type="text/javascript">
function handleAction(event, mapOnly) {
	var zip = document.getElementById('ziptext').value;

	$('#loading').addClass('off');
	
	initializeMap();
	
	if (zip.length == 5) {
		if (!isNaN(zip)) {
			$('#zipresult').load('/careerladder/zipvalidation.php?zipcode='+zip, function() {
				var zval = document.getElementById("zipresult").innerHTML;

				if(zval != 'true'){
					$('#step-1-jobs-1').html('<div id="job_listing"><div class="vcn-gs-heading" >Job Openings</div><br><br>Please Enter a Valid US ZIP Code</div>');
					alert('Please Enter a Valid US ZIP Code');
					map.setCenter(new GLatLng(39.1, -98.8));
					map.setZoom(3);
					$('#loading').addClass('off');
					return false;
				}
				
				if (!mapOnly) {
					if (event && ( event == 'button' || event.keyCode == 13 )) {
						loadJobs();
					}
				}

				$('#step-1-jobs-1').html('<div id="job_listing"><div class="vcn-gs-heading" >Job Openings</div><br><br>Enter a ZIP Code and click the Go button to see Job Openings listed here.</div>');
				
				loadGMap(zip);
				
		    });
		} else {
			alert('Please Enter a Valid US ZIP Code');
			map.setCenter(new GLatLng(39.1, -98.8));
			map.setZoom(3);
			$('#loading').addClass('off');
			return false;
		}
	} else {
		if (event && ( event == 'button' || event.keyCode == 13 )) {
			alert('Please Enter a Valid US ZIP Code');
			map.setCenter(new GLatLng(39.1, -98.8));
			map.setZoom(3);
			$('#loading').addClass('off');
			return false;
		}
	}
}
function loadGMap(zip) {
	geocoder.geocode( { 'address': zip}, addLangLat);
}
function loadJobs() {
	vcn_gs_buttons_off();
	$('#loading').removeClass('off');
    $('#step-1-jobs-1').text('Searching ...');
	$('#step-1-jobs-1').load('/careerladder/jobopenings.php?zipcode='+document.getElementById('ziptext').value, function() {
		getCountry(document.getElementById('ziptext').value);
		vcn_gs_buttons_on();
	    $('#loading').addClass('off');
	});

	//window.open(base_path + 'node/34?zipcode='+document.getElementById('ziptext').value,'loadhere');
	displayJobPoints($('#zip').val());
}

</script>

<iframe name="loadhere" src="" style="height: 0px; width: 0px; border: 0px;"></iframe>

<div style="display: none;" id="zipresult">
default val
</div>
