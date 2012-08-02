<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php 

	$type = $vars['type'];
 	$data = $data->$type;

?>
	
<?php if ($errors) : ?>
	<div class="errors">
<?php foreach ($errors AS $error):?>
		<span class="error"><?php echo $error . '<br />'; ?></span>
<?php endforeach;?>
	</div>
<?php endif; ?>
 
<?php echo $content['search']; ?> 
  
 <style>
 
 dd {
	margin-bottom:30px;
	}
</style>
 

<div id="training-detail" class="panel-2col panel-col-first" style="float:left;">

		<p>
		Everyone knows that college is expensive. <a alt="factsheet" title="factsheet" href="javascript:popit('/careerladder/Resourcespdfs/The_Cost_of_Going_To_College.pdf')">Click here</a> for a factsheet explaining the cost of going to college.  But how will you pay for it? There are a variety of financial aid options available to you - grants, loans,
		fellowships, and work-study programs. <a alt="factsheet" title="factsheet" href="javascript:popit('/careerladder/Resourcespdfs/Financial_Aid.pdf')">Click here</a>
		for a factsheet explaining all of your financial aid options. Click on one of the resource links
		below to find detailed information about financial aid.
		</p>
		<br/>
		<dl>
		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://www.fafsa.ed.gov/')">Free Application for Federal Student Aid (FAFSA)</a></dt>
		<dd>Federal Student Aid, an office of the U.S. Department of Education, ensures that all eligible individuals can benefit from federally funded financial assistance for education beyond high school. We consistently champion the promise of postsecondary education to all Americans and its value to our society.</dd>
	 <br />
		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://www.acinet.org/scholarshipsearch/ScholarshipCategory.asp?searchtype=category&nodeid=22')">Career One Stop Scholarship Information</a></dt>
		<dd>Search more than 5,000 scholarships, fellowships, loans, and other financial aid opportunities.</dd>
 	<br />	 
		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://www.studentaid.ed.gov/')">Students.gov</a></dt>
		<dd>Student gateway to the US Government.</dd>
  	<br />	 
		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://edu.military.com/gibill/?ESRC=ggl_edu_gi_spec.kw&np=1&nipkw=gi%20bill')">Military.com</a></dt>
		<dd>Connect with Military and Veteran Friendly schools that offer VA approved education programs.</dd>
  	<br />		 
		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://nhsc.hrsa.gov/scholarships/')">National Health Service Corps</a></dt>
		
		<dd>NHSC offers thousands of dollars in loan repayments and scholarships to help train healthcare professionals in critical careers who agree to serve in urban and rural <a href="javascript:popit('/careerladder/Resourcespdfs/HPSA.pdf')">Health Professional Shortage Areas (HPSA)</a></dd>
 	
	<br />
		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/257/Accreditation_Matters_Part_I')">Accreditation Matters: (Part I)</a></dt>
		<dd>How to Be a Smart Consumer of Academic Programs in Health Care</dd>

	<br />
		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/260/Accreditation_Matters_Part_II_Consequences_of_Attending_a_NonAccredited_School')">Accreditation Matters: (Part II)</a></dt>
		<dd>Consequences of Attending a Non-Accredited School</dd>

	<br />
		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/258/How_to_Finance_Your_Health_Sciences_Education')">How to Finance Your Health Sciences Education</a></dt>
	
		<br/>
		<p><strong>A good resource for nursing:</strong></p>
 		<dt><a title="financialaid" alt="financialaid" href="javascript:popit('http://www.petersons.com/college-search/nursing-school.aspx')">Peterson's College Search</a></dt>
		<dd>Begin your journey to a successful nursing career today! Their extensive database of nursing schools makes it easy to find the nursing program that's right for you. Whether you're looking for the best path to a career as a registered nurse or physician assistant, they can help speed your search.</dd>
		</dl>
		
 
	<?php if (0): ?>	
		<h3>Statewide Financial Programs</h3>
		<p>This would be based on selected program or course? Is it required?</p>
	<?php endif; ?>

	<?php if ($data): ?>
 		<?php if ($type == 'programs') :?>
	 		<h3>Provider Financial Aid</h3>
	 		<h4><?php echo $data->cipcodedetail->ciptitle; ?></h4>
			<p><?php echo $data->cipcodedetail->cipdesc; ?></p>
				
			<span class="detail-school">
			<?php 
		    	if ((string)$data->provider->webaddr !== 'NULL' AND trim((string)$data->provider->webaddr) !== '') 
		        {
		        	$webaddr = substr_compare( 'http',(string)$data->provider->webaddr,0,4,true) ? 'http://'. (string)$data->provider->webaddr : (string)$data->provider->webaddr;
		            echo '<a target="_blank" href="'.$webaddr.'">'.$data->provider->instnm.'</a>';
		        }
		        else 
		        {
		        	echo $data->provider->instnm;
		        }
		    ?>
		    </span> 
		    <br />
		    <?php 
		    	if ((string)$data->provider->addr !== 'NULL'  AND trim((string)$data->provider->addr) !== '' )  echo $data->provider->addr.'<br />'; 
		        if ((string)$data->provider->city !== 'NULL'  AND trim((string)$data->provider->city) !== '' ) echo $data->provider->city; 
		        if ((string)$data->stabbr !== 'NULL' ) 
		        {
		        	if ((string)$data->provider->city !== 'NULL' AND trim((string)$data->provider->city) !== '' )  echo ', '; 
		             	echo $data->provider->stabbr; 
		             }
		             if ((string)$data->provider->zip !== 'NULL' AND trim((string)$data->provider->zip) !== '' )  echo ' '. $data->provider->zip;
		             echo '<br />';
		             if ((string)$data->provider->gentele !== 'NULL' AND trim((string)$data->provider->gentele) !== '' ) echo ' '. vcn_format_phone( $data->provider->gentele ).'<br />';
		
		           	 if ((string)$data->provider->admnurl !== 'NULL' AND trim((string)$data->provider->admnurl) != '')
		           	 {
		           	 	$appurl = substr_compare( 'http',(string)$data->provider->admnurl,0,4,true) ? 'http://'. (string)$data->provider->admnurl : (string)$data->provider->admnurl;
		           		echo '<a class="small" target="_blank" href="'.$appurl.'">Admissions</a><br />';
		           	 }	
		           	 if ((string)$data->provider->faidurl !== 'NULL' AND trim((string)$data->provider->faidurl) !== '')  
		           	 { 
		           		$faidurl = substr_compare( 'http',(string)$data->provider->faidurl,0,4,true) ? 'http://'. (string)$data->provider->faidurl : (string)$data->provider->faidurl;
		           	 	echo '<a class="small" target="_blank"  href="'.$faidurl.'">Provider Financial Aid</a><br />';
		        }
		  ?>
			
		<?php endif; ?>
		
		<?php if ($type == 'certifications') :?>
			<!-- currently only supports programs -->
		<?php endif; ?>
		
		<?php if ($type == 'licenses') :?>
			<!-- currently only supports programs -->
		<?php endif; ?>
		
		<?php if ($type == 'courses') :?>
			<!-- currently only supports programs -->
		<?php endif; ?>
 
	<?php endif; ?>
</div>

<div style="float:left; width:27%;">

<table class="vcn-table find-learning-right ff-resources-right" style="margin-top:0px;">
<tr><th>Federally-funded Resources</th></tr>

<!--
<tr><td>
<ul class="vcn-resources" style="width:101%;">
<li><strong>Grant-Funded Programs Near You</strong><br /><br/>
Community colleges, hospitals and other organizations across
the Nation are offering special healthcare training programs - often at
reduced costs - to unemployed, dislocated, and incumbent workers. One
of these programs may be near you - why not find out more.
<br /><br />
<a href="<?php echo base_path(); ?>find-learning/resources/grant-funded-healthcare-programs">See More</a>
</li>
</ul>
</td></tr>
-->

<tr><td>
<ul class="vcn-resources" style="width:101%;">

<li><strong>Job Corps Programs Healthcare</strong><br /><br/>
Free healthcare training in a dozen allied health careers is available
to eligible youth...
<br /><br />
<a href="<?php echo base_path(); ?>find-learning/resources/job-corps">See More</a>
</li>
</ul>
</td></tr>
<tr><td>
<ul class="vcn-resources" style="width:101%;">

<li><strong>Apprenticeship Training Healthcare</strong><br /><br/>
Healthcare apprenticeship combines course study with on-the-job practical
training. 
<br /><br />
<a href="<?php echo base_path(); ?>find-learning/resources/apprenticeship-training">See More</a>
</li>
</ul>
</td></tr>
<tr><td>
<ul class="vcn-resources" style="width:101%;">
<li class="bottom"><strong>National Health Service Corps</strong><br /><br/>
NHSC offers thousands of dollars in loan repayments and scholarships to help train healthcare professionals in critical careers who agree to serve in urban and rural Health Professional Shortage Areas...
<br /><br />
<a href="<?php echo base_path(); ?>find-learning/resources/health-service-corps">See More</a>
</li>

</ul>
</td></tr>
<tr><td>
<ul class="vcn-resources" style="width:101%;">
<li class="bottom"><strong>Nursing</strong><br /><br/>
The Nursing Student Loan program provides long-term, low-interest rate loans to full-time and half-time financially needy students...
<br /><br />
<a href="javascript:popit('http://www.hrsa.gov/loanscholarships/loans/nursing.html')">See More</a>
</li>

</ul>
</td></tr>
<tr><td>
<ul class="vcn-resources" style="width:101%;">
<li class="bottom"><strong>Health Professions</strong><br /><br/>
Millions of Americans do not have access to health care, because they live where there are not enough health professionals to meet basic needs.
<br /><br />
<a href="javascript:popit('http://www.hrsa.gov/loanscholarships/loans/')">See More</a>
</li>

</ul>
</td></tr>
</table>


</div>

