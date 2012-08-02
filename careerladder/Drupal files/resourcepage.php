<?php
require_once('../drupal/sites/default/hvcp.functions.inc');

$base_url = $GLOBALS['hvcp_config_default_base_path'];
$path=$base_url . "sites/all/themes/zen_hvcp/js/boxover.js";
$path2=$base_url . "sites/default/files/images/links/";
echo "<script type=\"text/javascript\" src=\"$path\"></script> ";
?>



<script language="javascript"> 
function toggle() {
	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "See More";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "See Less";
	}
} 


var dge=document.getElementById;
function cl_expcol(a)
  {
  if(!dge)return;
    document.getElementById(a).style.display =
      (document.getElementById(a).style.display=='none')?
      'block':'none';
	  
	 if (document.getElementById(a).style.display=='none')
		document.getElementById(a+'operator').innerHTML='[+]';
	else
		document.getElementById(a+'operator').innerHTML='[ - ]';
	  
  }
function cl_colall()
  {
  if(!dge)return;
  for(i=1;document.getElementById('expand'+i);i++)
    {
    document.getElementById('expand'+i).style.display='none';
    }
  }
</script>

<style>
.title2
  {
  font-size: 16px;
  font-family: arial, helvetica, sans-serif;
  font-weight: bold;
  border: 1px solid black;
  background-color: #189AB0;
  color: white;
  }

.container
  {
  font-size: 14px;
  font-family: arial, helvetica, sans-serif;
  }

.strong
  {
  font-weight: bold;
  padding-top: 10px;
  padding-bottom: 10px;
  list-style-type: none;
  }

td
  {
  font-size: 14px;
  font-family: arial, helvetica, sans-serif;
  }

.nodot
  {
  list-style-type: none;
  }

.disc
  {
  list-style-type: disc;
  }

.tt-head
  {
  width:310px;
  color: white;
  background: #189AB0;
  border:1px solid #663300;
  text-align: center;
  }

.tt-body
  {
  width:300px;
  background: #FEF5FE;
  font-size: 10px;
  border-left:1px solid #663300;
  border-right:1px solid #663300;
  border-bottom:1px solid #663300;
  padding: 5px;
  }

span.hint
  {
  float: right;
  padding-top: 4px;
  padding-right: 5px;
  text-align: right;
  font-size: 12px;
  }

</style>

<!-- <body onload='cl_colall()'> -->

<div class="container">
<ul>
  <li style="list-style-type: none;"><div class="title2"><a id='expand1operator' href="javascript:cl_expcol('expand1');" style="color: rgb(255,255,255)"><font color="FFFFFF">[ - ]</font></a> I. Helpful Links</div></li>
    <ul id="expand1">
    <table style="width: 100%;">
      <tr>
        <td style="width: 50%;"><li class="strong">Partner Sites</li></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="nodot">American Association of Community Colleges (AACC)</li></td>
        <td><a href="javascript:popit('http://www.aacc.nche.edu')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.aacc.nche.edu</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">National Association of Workforce Boards (NAWB)</li></td>
        <td><a href="javascript:popit('http://www.nawb.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.nawb.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">American Council on Education (ACE)</li></td>
        <td><a href="javascript:popit('http://www.acenet.edu/AM/Template.cfm?Section=Home')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.acenet.edu</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">National Association of State Workforce Agencies (NASWA)</li></td>
        <td><a href="javascript:popit('http://www.workforceatm.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.workforceatm.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">DirectEmployers Association (DEA)</li></td>
        <td><a href="javascript:popit('http://www.directemployers.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.directemployers.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">Jobs for the Future (JFF)</li></td>
        <td><a href="javascript:popit('http://www.jff.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.jff.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">American Dental Education Association's(ADEA) Explore Health Careers</li></td>
        <td><a href="javascript:popit('http://explorehealthcareers.org/en/home')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.explorehealthcareers.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">Advanced Distributed Learning (ADL)</li></td>
        <td><a href="javascript:popit('http://www.adlnet.gov/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.adlnet.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">Cengage Learning's Education To Go (Ed2Go)</li></td>
        <td><a href="javascript:popit('http://www.ed2go.com/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.ed2go.com</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">Internet System for Education and Employment Knowledge (iSEEK)</li></td>
        <td><a href="javascript:popit('http://www.iseek.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.iseek.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">Goodwill Industries International</li></td>
        <td><a href="javascript:popit('http://www.goodwill.org/') "title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.goodwill.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">International Association of Jewish Vocational Services (IAJVS)</li></td>
        <td><a href="javascript:popit('http://www.iajvs.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.iajvs.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">SER-Jobs for Progress National Inc</li></td>
        <td><a href="javascript:popit('http://www.ser-national.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>ExploreHealthCareers.jpg'>]">www.ser-national.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="strong">Career Exploration</li></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="nodot">MyFuture.com</li></td>
        <td><a href="javascript:popit('http://www.myfuture.com')" title="header=[] body=[<img src='<?php echo $path2; ?>MyFuture.jpg'>]">www.myfuture.com</a></td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="nodot">Decision Critical</li></td>
        <td><a href="javascript:popit('http://www.decisioncritical.com/Critical_Portfolio.asp')" title="header=[] body=[<img src='<?php echo $path2; ?>DecisionCritical.jpg'>]">www.decisioncritical.com</a></td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="nodot">American Medical Association's <i>Health Care Careers Directory</i></li></td>
        <td><a href="javascript:popit('http://wdn.ipublishcentral.net/impelsys549/viewinside/11562831314328')" title="header=[] body=[<img src='<?php echo $path2; ?>AMA-HealthCareCareersDirectory.jpg'>]">wdn.ipublishcentral.net</a></td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="nodot">The American Medical Association's Health Care Careers E-Letter</li></td>
        <td><a href="javascript:popit('http://www.ama-assn.org/ama/pub/education-careers/careers-health-care/health-care-careers-e-letter.page')" title="header=[] body=[<img src='<?php echo $path2; ?>amaHealthCareeletter.jpg'>]">www.ama-assn.org</a></td>
      </tr>
	  <td style="width: 50%;"><li class="strong">HealthCare</li></td>
        <td>&nbsp;</td>
		<tr>
        <td style="width: 50%;"><li class="nodot">Healthcare Practitioners and Technical Occupations</li></td>
        <td><a href="javascript:popit('http://www.careerinfonet.org/crl/library.aspx?LVL2=31&LVL3=y&LVL1=13&CATID=58&PostVal=3')" title="header=[] body=[<img src='<?php echo $path2; ?>CareerOneStopHealthPractice.jpg'>]">www.careeronestop.com</a></td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="nodot">Healthcare Support Occupations</li></td>
        <td><a href="javascript:popit('http://www.careerinfonet.org/crl/library.aspx?LVL2=32&LVL3=y&LVL1=13&CATID=59&PostVal=3')" title="header=[] body=[<img src='<?php echo $path2; ?>CareerOneStopHealthSupport.jpg'>]">www.careeronestop.com</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">The Best Guide to Health Careers and Related Medical Sites</li></td>
        <td><a href="javascript:popit('http://www.khake.com/page22.html')" title="header=[] body=[<img src='<?php echo $path2; ?>BestGuideToHealthCareers.jpg'>]">www.khake.com</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">LifeWorks NIH</li></td>
        <td><a href="javascript:popit('http://science.education.nih.gov/LifeWorks')" title="header=[] body=[<img src='<?php echo $path2; ?>LifeWorksNIH.jpg'>]">science.education.nih.gov</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">HealthCare Information Technology</li></td>
        <td><a href="javascript:popit('http://www.hitcareermoves.org/?page_id=38')" title="header=[] body=[<img src='<?php echo $path2; ?>OrangeCoastCollege.jpg'>]">www.hitcareermoves.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">BLS Spotlight </li></td>
        <td><a href="javascript:popit('http://www.bls.gov/oco/cg/cgs035.htm')" title="header=[] body=[<img src='<?php echo $path2; ?>OccupationalHandbook.jpg'>]">www.bls.gov</a></td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="strong">National Associations related to HealthCare</li></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="nodot"> American Medical Association </li></td>
        <td><a href="javascript:popit('http://www.ama-assn.org')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.ama-assn.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot"> American Medical Group Association </li></td>
        <td><a href="javascript:popit('http://www.amga.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.amga.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot"> American Health Care Association </li></td>
        <td><a href="javascript:popit('http://www.ahcancal.org/Pages/Default.aspx')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.ahcancal.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot"> National Environmental Health Association </li></td>
        <td><a href="javascript:popit('http://www.neha.org/index.shtml')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.neha.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot"> Service Employees International Union - Healthcare </li></td>
        <td><a href="javascript:popit('http://www.seiu.org/seiuhealthcare/')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.seiu.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">National Rural Health Association </li></td>
        <td><a href="javascript:popit('http://www.ruralhealthweb.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.ruralhealthweb.org</a></td>
      </tr>
      <tr>
        <td style="width: 50%;"><li class="nodot">National Consortium for Health Science Technology</li></td>
        <td><a href="javascript:popit('http://www.nchste.org')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.nchste.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">American Public Health Association</li></td>
        <td><a href="javascript:popit('http://www.apha.org/')" title="header=[] body=[<img src='<?php echo $path2; ?> NationalConsortium1.jpg'>]">www.apha.org</a></td>
      </tr>

	  <tr>
        <td style="width: 50%;"><li class="nodot">American College of Healthcare Administrators</li></td>
        <td><a href="javascript:popit('http://www.achca.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.achca.org</a></td>
      </tr>
	  <tr>
        <td style="width: 50%;"><li class="nodot">American College of Healthcare Executives</li></td>
        <td><a href="javascript:popit('http://www.ache.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.achce.org</a></td>
      </tr>
      </table>
<br />
<a id="displayText" href="javascript:toggle();" style="margin-left:440px">See More</a> 
<div id="toggleText" style="display: none">
<br />
<table>
<tr>
        <td style="width: 72.8%;"><li class="nodot">Professional Association of Health Care Office Management</li></td>
        <td><a href="javascript:popit('http://www.pahcom.com/')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericanMedicalAssociation.jpg'>]">www.pahcom.com</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Health Information Management Association </li></td>
        <td><a href="javascript:popit('http://www.ahima.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.ahima.org</a> </td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Society for Healthcare Human Resources Administrators</li></td>
        <td><a href="javascript:popit('http://www.ashhra.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.ashhra.org</a> </td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Association for Healthcare Documentation Integrity</li></td>
        <td><a href="javascript:popit('http://www.ahdionline.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.ahdionline.org</a> </td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Association of State and Territorial Health Officials</li></td>
        <td><a href="javascript:popit('http://www.statepublichealth.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.statepublichealth.org</a> </td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Health Care Information and Management Systems Society </li></td>
        <td><a href="javascript:popit('http://www.himss.org/ASP/index.asp')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.himss.org</a> </td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Medical Group Management Association</li></td>
        <td><a href="javascript:popit('http://www.mgma.com/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.mgma.org</a> </td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Emergency Medical Services</li></td>
        <td><a href="javascript:popit('http://www.ems.gov/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.ems.gov</a> </td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">National Association of Emergency Medical Technicians</li></td>
        <td><a href="javascript:popit('http://www.naemt.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.naemt.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Academy of Audiology</li></td>
        <td><a href="javascript:popit('http://www.audiology.org/Pages/default.aspx')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.audiology.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Academy of Ophthalmology</li></td>
        <td><a href="javascript:popit('http://www.aao.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aao.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Academy of Orthotists and Prosthetists</li></td>
        <td><a href="javascript:popit('http://www.oandp.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.oandp.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Association for Clinical Chemistry</li></td>
        <td><a href="javascript:popit('http://www.aacc.org/Pages/default.aspx')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aacc.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Association for Respiratory Care</li></td>
        <td><a href="javascript:popit('http://www.aarc.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aarc.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American College of Clinical Pharmacy</li></td>
        <td><a href="javascript:popit('http://www.accp.com/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.accp.com</a></td>
      </tr>
	<tr>
        <td style="width: 72.8%;"><li class="nodot">American Hospital Association</li></td>
        <td><a href="javascript:popit('http://www.aha.org/aha_app/index.jsp')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aha.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Pharmacists Association</li></td>
        <td><a href="javascript:popit('http://www.pharmacist.com/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.pharmacist.com</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Society for Clinical Laboratory Science</li></td>
        <td><a href="javascript:popit('http://www.ascls.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.ascls.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Society for Clinical Pharmacology and Therapeutics</li></td>
        <td><a href="javascript:popit('http://www.ascpt.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.ascpt.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Society for Radiologic Technologists</li></td>
        <td><a href="javascript:popit('https://www.asrt.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.asrt.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Society of Anesthesiologists</li></td>
        <td><a href="javascript:popit('http://www.asahq.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.asahq.org</a></td>
      </tr>
	<tr>
        <td style="width: 72.8%;"><li class="nodot">American Society of Speech Language Hearing Association</li></td>
        <td><a href="javascript:popit('http://www.asha.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.asha.org</a></td>
      </tr><tr>
        <td style="width: 72.8%;"><li class="nodot">American Nurses Association</li></td>
        <td><a href="javascript:popit('http://nursingworld.org')/" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.nursingworld.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Academy of Nursing</li></td>
        <td><a href="javascript:popit('http://www.aannet.org/i4a/pages/index.cfm?pageid=1')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aannet.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Association of Critical Care Nurses</li></td>
        <td><a href="javascript:popit('http://www.aacn.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aacn.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Association of Nurse Anesthetists</li></td>
        <td><a href="javascript:popit('http://www.aana.com/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aana.com</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American College of Nurse Midwives</li></td>
        <td><a href="javascript:popit('http://www.midwife.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.midwife.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American College of Nurse Practitioners</li></td>
        <td><a href="javascript:popit('http://www.acnpweb.org/i4a/pages/index.cfm?pageid=1')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.acnpweb.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Organization of Nurse Executives</li></td>
        <td><a href="javascript:popit('http://www.aone.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aone.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Association of Rehabilitation Nurses</li></td>
        <td><a href="javascript:popit('http://www.rehabnurse.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.rehabnurse.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">National League for Nursing</li></td>
        <td><a href="javascript:popit('http://www.nln.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.nln.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">National Organization for Associate Degree Nursing</li></td>
        <td><a href="javascript:popit('https://www.noadn.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.noadn.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">The National Federation of Licensed Professional Nurses </li></td>
        <td><a href="javascript:popit('http://www.nflpn.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.nflpn.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">National League for Nursing</li></td>
        <td><a href="javascript:popit('http://www.nln.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.nln.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Optimetric  Association</li></td>
        <td><a href="javascript:popit('http://www.aoa.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aoa.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Opticians Association of America</li></td>
        <td><a href="javascript:popit('http://www.oaa.org/index.php')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.oaa.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Dental Association</li></td>
        <td><a href="javascript:popit('http://www.ada.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.ada.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Dental Hygienists Association</li></td>
        <td><a href="javascript:popit('http://www.adha.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.adha.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Dental Assistants Association</li></td>
        <td><a href="javascript:popit('http://www.dentalassistant.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.dentalassistant.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Dietetic Association</li></td>
        <td><a href="javascript:popit('http://www.eatright.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.eatright.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Academy of Anesthesiologist Assistants</li></td>
        <td><a href="javascript:popit('http://www.anesthetist.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.anesthetist.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Academy of Physician Assistants</li></td>
        <td><a href="javascript:popit('http://www.aapa.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aapa.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Association of Medical Assistants</li></td>
        <td><a href="javascript:popit('http://www.aota.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aota.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Art Therapy Association</li></td>
        <td><a href="javascript:popit('http://arttherapy.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.arttherapy.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Massage Therapy Association</li></td>
        <td><a href="javascript:popit('http://www.amtamassage.org/index.html')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.amtamassage.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">American Physical Therapy Association</li></td>
        <td><a href="javascript:popit('http://www.apta.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.apta.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">The American Occupational Therapy Association</li></td>
        <td><a href="javascript:popit('http://www.aota.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.aota.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Aerobics and Fitness Association of America</li></td>
        <td><a href="javascript:popit('http://www.afaa.com/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.afaa.com</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Clinical Laboratory Management Association</li></td>
        <td><a href="javascript:popit('http://www.clma.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.clma.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">National Association for Home Care and Hospice</li></td>
        <td><a href="javascript:popit('http://www.nahc.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.nahc.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">National Association of Veterinary Technologists and Technicians</li></td>
        <td><a href="javascript:popit('http://www.navta.net/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.navta.net</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Radiological Society of North America</li></td>
        <td><a href="javascript:popit('http://www.rsna.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.rsna.org</a></td>
      </tr>
	  <tr>
        <td style="width: 72.8%;"><li class="nodot">Society of Diagnostic Medical Songraphy</li></td>
        <td><a href="javascript:popit('http://www.sdms.org/')" title="header=[] body=[<img src='<?php echo $path2; ?>NationalConsortium1.jpg'>]">www.sdms.org</a></td>
      </tr>
</table>
</div>	
<table>
	  <tr>
		<td style="width:76.3%;"><li class="strong">Federal Resources</li></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="width: 76.3%;"><li class="nodot">CareerOneStop</li></td>
        <td><a href="javascript:popit('http://careeronestop.org')" title="header=[] body=[<img src='<?php echo $path2; ?>CareerOneStop.jpg'>]">careeronestop.org</a></td>
      </tr>
      <tr>
        <td style="width: 76.3%;"><li class="nodot">America's Career InfoNet</li></td>
        <td><a href="javascript:popit('http://www.acinet.org')" title="header=[] body=[<img src='<?php echo $path2; ?>AmericasCareerInfoNet.jpg'>]">www.acinet.org</a></td>
      </tr>
      <tr>
        <td style="width: 76.3%;"><li class="nodot">O*Net Online</li></td>
        <td><a href="javascript:popit('http://online.onetcenter.org')" title="header=[] body=[<img src='<?php echo $path2; ?>ONetOnline.jpg'>]">online.onetcenter.org</a></td>
      </tr>
      <tr>
        <td style="width: 76.3%;"><li class="nodot">Occupational Handbook</li></td>
        <td><a href="javascript:popit('http://www.bls.gov/oco')" title="header=[] body=[<img src='<?php echo $path2; ?>OccupationalHandbook.jpg'>]">www.bls.gov/oco</a></td>
      </tr>
      <tr>
        <td style="width: 76.3%;"><li class="nodot">Industry Guide BLS</li></td>
        <td><a href="javascript:popit('http://www.bls.gov/oco/cg')" title="header=[] body=[<img src='<?php echo $path2; ?>IndustryGuideBLS.jpg'>]">www.bls.gov/oco/cg</a></td>
      </tr>  
</table>	  
    </ul>
  <br />
  <li style="list-style-type: none;">
    <div class="title2">
      <a id='expand2operator' href="javascript:cl_expcol('expand2');" style="color: rgb(255,255,255)"><font color="FFFFFF">[ - ]</font></a> II. Research Studies <span class="hint">Hint : Mouse-over each item for a brief synopsis</span>
    </div>
  </li>
    <ul id="expand2">
      <div>
      <table><tr><td>
      <li class="disc" ><a href="#" title="cssheader=[tt-head] cssbody=[tt-body]  header=[Additional Information] body=[This study examines the history of the American educational system and its continuing failure to address the needs of youth and young adult learners in achieving high school graduation and the attainment of at least some level of training leading to a working wage job with an articulated career pathway. It discusses how and why the system has failed, the importance of creating new ways to provide career solutions, and the importance of accessible pathways as they relate to our American society and economy.]">Pathways to Prosperity-Harvard Study</a></li>
      <li class="disc"><a href="#" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[Intended for allied healthcare program developers who seek to serve the needs of disadvantaged youth and young adults, the Guide covers program design, funding management, and the advantages of systems integration within One-Stop workforce centers. The case study focuses on the Los Angeles Reconnections Academies model funded through ARRA Youth and ARRA Adult funding and administered by the City of Los Angeles Community Development Department of Health and Human Services.]">Allied Health Access Guidebook</a></li>
      <li class="disc"><a href="#" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[By creating a new career ladder leading to an acute care nursing assistant position, this project shows how existing hospital employees in lower level jobs can gain the skills necessary to begin and advance to a nursing career. This program describes how the development of new skills and on-the-job training can be used to increase advancement opportunities for current employees while increasing the quality of patient care, and filling immediate workplace needs of hospitals in the Baltimore area.]">Jobs to Careers-Promoting Work-Based Learning for Quality Care: Advancing in Health and Health Care Careers - Rung by Rung</a></li>
      <li class="disc"><a href="#" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[This report describes how distance learning technologies can be used to meet the challenges of workforce skills development by providing access to training and education that is not time or place-bound. It emphasizes the importance of technology in reaching many more adults who need effective college and job readiness preparation who may not be able to participate in traditional classrooms or job site training. and the benefits they bring to adults seeking workplace skills training.]">The Power of Technology to Transform Adult Learning - Expanding Access to Adult Education and Workforce Skills through Distance Learning</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/1007TECHNICALWORKERS.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[By studying a recent model for technical education called the Automotive Manufacturing Technical Education Collaborative (AMTEC), this report details the work of thirty-four automakers and thirty community colleges in twelve states in identifying and implementing improvements in technical education for autoworkers. This joint effort is showcased as an example which could be adapted for many different technical education fields.  Designed as a report for state governors, the paper states important recommendations for the future of technical education and lays out a roadmap for governors.]">National Governors Association: A Sharper focus on Technical Workers</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/career_counseling.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[By examining currently available career counseling and development services, this paper calls attention to lack of a national easily accessible network by which working adults and ‘working learners’ can find assistance to plan, build, and navigate a career and the education and training needed to maintain it in an ongoing manner. Defining ‘working learners’ as working adults who lack credentials or education beyond high school and cannot afford to stop out of the job market to attend school fulltime, the paper highlights the struggle for these individuals who need help in identifying the education and training that matches their skills and interests which would enable them to secure work in a career pathway that pays a family living wage.]">Center for American Progress: A New National Approach to Career Navigation for Working Learners</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/CAP_Report_on_Working_Learners.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[This paper defines the concept of &#34;working learners&#34; as adults who are currently working but lack documented education or training beyond high school. By describing the unmet needs of these 75 million workers, the case is made for changes in the U.S. educational system to address the lack of suitable access for advancement for these learners and the negative impact of these unmet needs on a 21st  century economy. The major points made as necessary for improvement include increased flexibility for part time learners to achieve educational goals, re-structuring of curriculum into smaller ‘chunks’ which may build to a credential or degree but are designed as stand-alone components, expanded funding for working learners who have limited time and money to spend on their education, and the design and implementation of a national career development system of services.]">Center for American Progress: Working Learners - Educating our entire workforce for success in the 21st century</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/for_profit_health_care.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[By comparing education and training provided for the health care workforce through both for-profit career schools/colleges with private non-profit colleges and universities, this paper provides a viewpoint on the structure, quality, costs, and roles each sector can play in meeting the increasing demand for high-demand, high-wage jobs in this cluster. Citing the Bureau of Labor Statistics estimate that 3.2 million jobs will be created in health care sectors between 2008 and 2018, the author describes for-profit schools and colleges as a necessary part of the nation’s health care training system, especially as public and private colleges and universities are at capacity in many of these occupations.]"> Center for American Progress: Profiting from Health Care - The Role of For-Profit Schools in Training the Health Care Workforce</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/Nursing_Career_Lattice_Example_1_.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[This project describes a successful employment and training model designed to create a career framework to meet critical shortages for qualified nurses and other healthcare workers. Explained as a &#34;grow your own&#34; internal plan, the hospitals and care facilities involved provided carefully designed training for both current employees in non-clinical jobs as well as for newly hired entry-level workers by creating a 'career lattice' of opportunities for these individuals. The education and training was provided by the employer at no cost to the employee so that those in training may continue to earn wages throughout the career lattice advancement process. The project involved 23 sites in 8 states with positive results measured by the number of employees engaging in nursing career lattice work, improved entry-level job retention and turnover rates, increased quality of care for patients, while adding diversity among the staff.]">CAEL’s Nursing Career Lattice Project: How Career Lattices Help Solve Nursing and Other Workforce Shortages in Healthcare</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/332_846_1_.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[This paper investigates and compares the ways in which online courses may not be as effective for low-income and under-prepared college and university students as they have proven to be for other student populations. The author discusses reasons for this apparent difference by looking at research done on the rates of academic access, progression, and successful online course completion for students. Suggestions given for increased effectiveness include changes in online learning support systems, changes in Pell grant financial aid, pre-screening of students, and additional research to study ways to use improve online course technology and structure for underprepared students.]">Community College Research Center: Online Learning: Does It Help Low-Income and Underprepared Students?</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/whatsitworth-complete.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[Of course, you already know that the average graduate with a bachelor’s degree from a four year college or university makes more money than those with only a high school diploma, right? But did you know that they earn 84 percent more over a lifetime of work? Based on a report published by the Georgetown University on Center on Education and the Workforce, this fact is just the beginning of what you may need to consider when choosing a college and a major course of study. For the first time, this report gives you a set of the most comprehensive findings to date on the economic impact that college graduation has on students’ earning power and fields of employment. Based on college major, graduation rates, ethnicity, gender, and industry placement, the report not only includes data on recent graduates, but also factors in all workers with a Bachelor’s degree through the entire U. S. By reading this report, you will learn information that may influence for your economic future as you choose a college major and degree.]">What’s it worth: The Economic Value of College Majors.</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/community_health_workers.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[As the need for medical care is increasing, some health care providers are in short supply and/or unevenly distributed across the Nation. Solutions for better communication, early diagnoses, less invasive procedures, shorter hospitalization, and outreach capabilities through telemedicine have been used to help solve the shortages. These developments set the stage for the emergence of the community health worker (CHW) workforce. Community health workers are lay members of communities who work in association with the local health care system. This bibliography covers 45 articles and research reports to provide a better understanding of the CHW workforce and its contributions to the National health care delivery system. The articles, overviews and surveys of multiple programs describe definitions, roles, demographics, education, and training of CHWs, as well as program evaluation. Other topics include cost, funding and policy implications.]">Community Health Workers.</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/HS-153-KSCHART.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[Health Science Career Cluster: Cluster Knowledge and Skill Statements]">Health Science Career Cluster: Cluster Knowledge and Skill Statements</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/newswire_65_081910.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[Jobs for the Future: Advancing the Frontline Workforce in Health Care]">Jobs for the Future: Advancing the Frontline Workforce in Health Care</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/The_Careers_Project_-_November_2010.pdf')" title="cssheader=[tt-head] cssbody=[tt-body] header=[Additional Information] body=[The Careers Project]">The Careers Project</a></li>
      </td></tr></table></div>
    </ul>
  <br />
  <li style="list-style-type: none;"><div class="title2"><a id='expand3operator' href="javascript:cl_expcol('expand3');" style="color: rgb(255,255,255)"><font color="FFFFFF">[ - ]</font></a> III. Fact Sheets</div></li><br />
    <ul id="expand3">
      <table><tr><td>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/Why_Go_To_College.pdf')" >Why Should I Go To College?</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/The_Cost_of_Going_To_College.pdf')">What It Costs to Attend College</a></li></ul>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/Financial_Aid.pdf')">Financial Aid Opportunities</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/Student_Services.pdf')">What College Services Are Offered for Students?</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/Distance_Learning.pdf')">How Can Distance Education Be a Benefit for Students?</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/Common_College_Terms_and_What_They_Mean.pdf')">Common College Terms and What They Mean</a></li>
      <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/PLA_Factsheet.pdf')">Prior Learning Assessment</a></li>
      <li class="disc"><a href="javascript:popit('http://www.caahep.org/Content.aspx?ID=64')">Things to consider before choosing a Program in HealthCare</a></li>
      <li class="disc"><a href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/253/How_to_Manage_a_Career_Change_Part_1')">How to Manage a Career Change (Part 1)</a></li>
      <li class="disc"><a href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/254/How_to_Manage_a_Career_Change_Part_2')">How to Manage a Career Change (Part 2)</a></li>
      <li class="disc"><a href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/255/Personal_Responsibility_Financing_Your_Health_Sciences_Education')">Personal Responsibility: Financing Your Health Sciences Education</a></li>
      <li class="disc"><a href="javascript:popit('http://explorehealthcareers.org/en/BlogPost/247/Which_medical_field_suits_me_best')">Which Medical Field Suits Me Best?</a></li>
      <li class="disc"><a href="javascript:popit('http://explorehealthcareers.org/en/BlogPost/248/How_will_credit_card_debt_affect_financial_aid')">How will Credit Card Debt Affect Financial Aid?</a></li>
	  <li class="disc"><a href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/257/Accreditation_Matters_Part_I')">Accreditation Matters: (Part I) September 19, 2011</a></li>
	  <li class="disc"><a href="javascript:popit('http://explorehealthcareers.org/en/issues/news/Article/258/How_to_Finance_Your_Health_Sciences_Education')">How to Finance Your Health Sciences Education September 19, 2011</a></li>
	  <li class="disc"><a href="javascript:popit('/careerladder/Resourcespdfs/Common_Core_State_Standards.pdf')">Common Core State Standards</a></li>
      </td></tr></table>
    </ul>
</ul>

</div><!-- end <div class="container"> -->
