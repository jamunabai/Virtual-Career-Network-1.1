<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<script type="text/javascript">
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
	document.getElementById(a+'operator').innerHTML='[-]';

}
function cl_colall()
{
	if(!dge)return;
	for(i=1;document.getElementById('expand'+i);i++)
	{
	document.getElementById('expand'+i).style.display='none';
	}
}

$(document).ready(function() {

});
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
<?php 
//$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
	$url = "http://".$_SERVER['SERVER_NAME'];
	$base_path = base_path();
?>


<div class="container">
<ul style="margin:0; padding:0;">
	<p>The VCN uses <a href="javascript:popit('http://us.jobs/')">us.jobs</a> as its job source.  Two of this project's partners--<a href="javascript:popit('http://directemployers.org/')">Direct Employers Association</a> (DE) and the <a href="javascript:popit('http://www.naswa.org/')">National Association of State Workforce Agencies</a> (NASWA)--have come together to create the <i>National Labor Exchange</i> which powers <a href="javascript:popit('http://us.jobs/')">us.jobs</a>.  NASWA represents the 50 public state workforce agencies which operate the state job banks where local businesses can post jobs for free.  DE is a non-profit association of over 600 national companies (including almost all of the Fortune 500) who have joined together to lower the cost of entry to the online job market.  In addition to the jobs from its member companies, DE also "indexes" jobs (with permission) from the websites of nearly 2000 other national employers.  The combination of all jobs in the state job banks and all of the DE jobs (from larger, national employers) makes the <i>National Labor Exchange</i> the largest collection of jobs on the Internet.  Unlike most online job boards, the <i>National Labor Exchange</i> operates without intermediaries between the job seeker and the employer.  When job seekers find and access jobs through the NLE, they are taken directly to the employer, either to an online application process or to instructions on how to apply for the job.</p> 

	<li style="cursor:pointer; list-style-type: none; margin:0; padding: 5px 0 5px 0;" onclick="javascript:cl_expcol('expand1');"><div class="title2"><a id='expand1operator' title="expand/collapse list" style="font-family:monospace;color: rgb(255,255,255); text-decoration:none;"><font color="FFFFFF">[-]</font></a> Post a job on us.jobs (powered by the National Labor Exchange)</div></li>
		<ul id="expand1">
			<p>Post a job today! <a href="javascript:popit('http://us.jobs/postajob.asp')">Click here</a></p>
			<p>Are you a large employer and need to post multiple jobs?  You can also have your jobs indexed and uploaded to <a href="javascript:popit('http://us.jobs/')">us.jobs</a> for FREE! <a href="javascript:popit('http://us.jobs/indexingrequest.asp')">Click here</a></p>
		</ul>		
</div>
		

	<li style="cursor:pointer; list-style-type: none; margin:0; padding: 5px 0 5px 0;" onclick="javascript:cl_expcol('expand2');"><div class="title2"><a id='expand2operator' title="expand/collapse list" style="font-family:monospace;color: rgb(255,255,255); text-decoration:none;"><font color="FFFFFF">[-]</font></a> Post a job on your STATE JOB BANK</div></li>
	<ul id="expand2">
		<div>
			<table border="0" cellpadding="8px">
				<tr>
					<td><a href="javascript:popit('https://joblink.alabama.gov/ada/customization/Alabama/documents/empJOReqForm.cfm')">Alabama</a></td>
					<td><a href="javascript:popit('https://www.employflorida.com/')">Florida</a></td>
					<td><a href="javascript:popit('https://www.kansasworks.com/ada/')">Kansas</a></td>
					<td><a href="javascript:popit('http://www.mdes.ms.gov/Home/index.html#null')">Mississippi</a></td>
					<td><a href="javascript:popit('http://newyork.us.jobs/index.asp')">New York</a></td>
					<td><a href="javascript:popit('https://www.employri.org/')">Rhode Island</a></td>
					<td><a href="javascript:popit('http://www.vec.virginia.gov/vecportal/')">Virginia</a></td>
				</tr>
				<tr>
					<td><a href="javascript:popit('http://www.jobs.state.ak.us/employer.htm')">Alaska</a></td>
					<td><a href="javascript:popit('http://www.dol.state.ga.us/js/job_info_system.htm')">Georgia</a></td>
					<td><a href="javascript:popit('https://focuscareer.ky.gov/career/login.aspx')">Kentucky</a></td>
					<td><a href="javascript:popit('http://jobs.mo.gov/')">Missouri</a></td>
					<td><a href="javascript:popit('http://www.ncesc1.com/individual/jobSearch/jobSearchMain.asp')">North Carolina</a></td>
					<td><a href="javascript:popit('https://jobs.scworks.org/')">South Carolina</a></td>
					<td><a href="javascript:popit('https://fortress.wa.gov/esd/worksource/Employment.aspx')">Washington</a></td>
				</tr>
				<tr>
					<td><a href="javascript:popit('https://www.azjobconnection.gov/ders/ea/wcmrs/skillmatch/employer_sm/emp_employeroverview_dsp.cfm')">Arizona</a></td>
					<td><a href="javascript:popit('http://www.dol.guam.gov/index.php?option=com_jobline')">Guam</a></td>
					<td><a href="javascript:popit('https://www.voshost.com/')">Louisiana</a></td>
					<td><a href="javascript:popit('https://jobs.mt.gov/jobs/login.seek')">Montana</a></td>
					<td><a href="javascript:popit('http://jobsnd.com/')">North Dakota</a></td>
					<td><a href="javascript:popit('http://dlr.sd.gov/')">South Dakota</a></td>
					<td><a href="javascript:popit('https://www.dcnetworks.org/')">Washington DC</a></td>
				</tr>
				<tr>
					<td><a href="javascript:popit('https://www.arjoblink.arkansas.gov/ada/default.cfm')">Arkansas</a></td>
					<td><a href="javascript:popit('https://www.hirenethawaii.com/default.asp')">Hawaii</a></td>
					<td><a href="javascript:popit('https://gateway.maine.gov/dol/mjb/jobseeker/jobseekerwelcome.aspx')">Maine</a></td>
					<td><a href="javascript:popit('http://dol.nebraska.gov/')">Nebraska</a></td>
					<td><a href="javascript:popit('https://ohiomeansjobs.com/omj/')">Ohio</a></td>
					<td><a href="javascript:popit('https://ecmats.tn.gov/eCMATS/')">Tennessee</a></td>
					<td><a href="javascript:popit('http://www.wvcommerce.org/App_Media/assets/html/job-seekers.html')">West Virginia</a></td>
				</tr>
				<tr>
					<td><a href="javascript:popit('http://www.caljobs.ca.gov/')">California</a></td>
					<td><a href="javascript:popit('http://labor.idaho.gov/DNN/Default.aspx?alias=labor.idaho.gov/dnn/idl&AspxAutoDetectCookieSupport=1')">Idaho</a></td>
					<td><a href="javascript:popit('https://mwejobs.maryland.gov/')">Maryland</a></td>
					<td><a href="javascript:popit('http://www.nevadajobconnect.com/')">Nevada</a></td>
					<td><a href="javascript:popit('https://servicelink.oesc.state.ok.us/ada/default.cfm?')">Oklahoma</a></td>
					<td><a href="javascript:popit('https://wit.twc.state.tx.us/WORKINTEXAS/wtx?pageid=APP_HOME&cookiecheckflag=1')">Texas</a></td>
					<td><a href="javascript:popit('https://jobcenterofwisconsin.com/')">Wisconsin</a></td>
				</tr>
				<tr>
					<td><a href="javascript:popit('http://www.connectingcolorado.com/')">Colorado</a></td>
					<td><a href="javascript:popit('http://www.ides.illinois.gov/page.aspx?item=2375')">Illinois</a></td>
					<td><a href="javascript:popit('https://web.detma.org/JobQuest/Default.aspx')">Massachusetts</a></td>
					<td><a href="javascript:popit('https://nhworksjobmatch.nhes.nh.gov/')">New Hampshire</a></td>
					<td><a href="javascript:popit('http://www.emp.state.or.us/jobs/')">Oregon</a></td>
					<td><a href="javascript:popit('https://jobs.utah.gov/jsp/utahjobs/seeker/search/search.do')">Utah</a></td>
					<td><a href="javascript:popit('https://www.wyomingatwork.com/')">Wyoming</a></td>
				</tr>
				<tr>
					<td><a href="javascript:popit('http://connecticut.us.jobs/index.asp')">Connecticut</a></td>
					<td><a href="javascript:popit('https://www.indianacareerconnect.com/')">Indiana</a></td>
					<td><a href="javascript:popit('https://www.michworks.org/mtb/user/MTB_EMPL.EntryMainPage')">Michigan</a></td>
					<td><a href="javascript:popit('http://jobs4jersey.com/')">New Jersey</a></td>
					<td><a href="javascript:popit('https://www.cwds.state.pa.us/cwdsonline/Admin/ViewHomePage/PublicHomePage.aspx?2tg3Jcc@N1tfjDy@2Yw1binkQQZAsXkPkB7vPukNm@tNjejXx4vRF2z@pPr43gkyX8XK6V0P_XU7rZ419zO_aw0TxtBr7hRrvmrb9KrjRyg-wrHM7k0lHHJUAxnrf1n0DKsgQyNYfjwS5_wxKkGR0_1K0O7IMg70')">Pennsylvania</a></td>
					<td><a href="javascript:popit('https://www.vermontjoblink.com/ada/')">Vermont</a></td>
					<td><a href="javascript:popit('')"></a></td>
				</tr>
				<tr>
					<td><a href="javascript:popit('https://joblink.delaware.gov/ada/')">Delaware</a></td>
					<td><a href="javascript:popit('https://www1.iowajobs.org/jobs/login.seek')">Iowa</a></td>
					<td><a href="javascript:popit('https://www.minnesotaworks.net/')">Minnesota</a></td>
					<td><a href="javascript:popit('https://www.jobs.state.nm.us/')">New Mexico</a></td>
					<td><a href="javascript:popit('http://www.puertoricotrabaja.com/LoadPage/es-PR/MyHomePage')">Puerto Rico</a></td>
					<td><a href="javascript:popit('http://www.vidol.gov/advertisement_vacan.php')">Virgin Islands</a></td>
					<td><a href="javascript:popit('')"></a></td>
				</tr>
			</table> 

		</div>
	</ul>



</div><!-- end <div class="container"> -->
