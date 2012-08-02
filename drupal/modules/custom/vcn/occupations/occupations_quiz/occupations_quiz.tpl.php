<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php $getpath = base_path() . drupal_get_path('module','occupations_quiz');  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html class="dj_gecko dj_ff3 dj_contentbox"><head>



 




     
        <title>Interest Assessment - Virginia Education Wizard</title>  
         <meta http-equiv="X-UA-Compatible" content="IE=7">  
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" charset="utf-8"> 
        <meta name="verify-v1" content="5gJi1mFErnUFI9x9ZOK8c0QG7WlyXF6WdWgHY11h5h0=">
<link rel="stylesheet" type="text/css" href="<?php echo $getpath; ?>/custom.css">
    
<link rel="stylesheet" type="text/css" href="<?php echo $getpath; ?>/combined.css" charset="utf-8">


<style>ul#TopNav li a, ul#TopNav li div#nav-search {}</style>

	
		
<script type="text/javascript">
var rpcCollegeUrl = "/vccs/json/CollegeSearch.action"; //college rpc url
var isAuth = false; //is user atuthorized
var WebRoot = '/vccs/';
djConfig = 
{
		
isDebug: false,
debugAtAllCosts: false,
bindEncoding: "UTF-8",
parseOnLoad:true,
preventBackButtonFix: false
}
</script>	
   
<script type="text/javascript" src="<?php echo $getpath; ?>/dojo.js"></script>
	
        
	<meta name="WizardModule" content="career">
    <meta name="action" content="Career">
    <meta name="subnav" content="true">
    <meta name="subnavSel" content="assess">
  <script type="text/javascript" src="<?php echo $getpath; ?>/swfobject.js"></script>
     <style type="text/css">
    @import "css/subland_1.css";
 



#startAssess {	position: absolute;margin-top: 120px;z-index: 951;margin-left: 251px;}
#act_link {color: #FFFFFF;text-decoration: none;}
#subhead{width: 909px;display:none;}
#instruct b {color: #92D050;}
.dijitDialog {width:490px;}

</style>
   
    
                  
<script async="true" src="<?php echo $getpath; ?>/ga.js"></script></head><body class="tundra">	

   
	
  
   <div class="Hide508">
   	<a href="#BodySection">Click here to skip navigation</a>
   </div>
   
<div id="Body">	
  <div id="TopHeadLinks"></div>				
  <table id="BodyTbl" border="0" cellpadding="0" cellspacing="0">
		<tbody><tr id="trBorderTop">
			<td id="hrTopL"></td>
			<td id="hrTop" width="100%"></td>
			<td id="hrTopR"></td>
		</tr>
		<tr id="trCnt" class="trHidden">
			<td class="BorderLeftH">&nbsp;</td>
		  <td class="HeadCell">
				<div style="display: none;" id="headProfile" class="HeadCnt">
					<div class="HeadCntIn">
						<div class="dijitContentPane" role="group" title="" widgetid="cpProfile" dojotype="dijit.layout.ContentPane" id="cpProfile" style="height: 400px;"></div>
					</div>
				</div>
				<div style="display: none;" id="headLogin" class="HeadCnt">
					<div class="HeadCntIn">									
						<div>
					  		<div style="float: right; text-align: right;">		
								<a href="javascript://" title="Close the profile window" class="nl" onclick="fWipeCnt('headLogin');return false;"><img src="<?php echo $getpath; ?>/btnPfClose.png" alt="Close" border="0" width="20" height="20"></a>
							</div>
							<h2>Login</h2>
						</div>
					  	<div id="LoginBody">					  	
						  	<p>Don't have a Wizard account?  <a href="https://www.vawizard.org/vccs/StartSignUp.action">Create an Account</a></p>					  						  
						    <form id="Login" name="Login" action="/vccs/Login.action" method="post">					    						    						    	
						    	<input name="currentAction" value="CareerAssessInterests" id="Login_currentAction" type="hidden">
						    	<input name="queryStr" value="" id="Login_queryStr" type="hidden">
						    	<input name="method" value="" id="Login_method" type="hidden">
						  		Username:<input name="username" id="Login_username" type="text">&nbsp;&nbsp;
						  		Password:<input name="password" id="Login_password" type="password">&nbsp;<input id="Login__login" value="Login" name="method:login" type="submit">
								<p>Forgot your password?&nbsp;<a href="https://www.vawizard.org/vccs/ForgotPass.action">Reset your password</a></p>    	
							</form>




						</div>															
					</div>
				</div>
				<div style="display: none;" id="headContent" class="HeadCnt">
				<div class="HeadCntIn">				

					
				  </div>
				</div>
				
		  </td>
			<td class="BorderRightH">&nbsp;</td>
		</tr>		
		
		<tr>
			<td class="BorderLeft">&nbsp;</td>
			<td class="BodyCell" valign="top">
				
				
				
					
					
				
				<div id="BodyContent">
				  <div class="ColCont">
				    <div>


				      <div style="padding-top: 0pt;" class="TopRndFrame"><!--<b class="niftycorners" style="margin-left: -1px; margin-right: -1px; background: none repeat scroll 0% 0% rgb(255, 255, 255); margin-bottom: -4px;"><b style="background-color: rgb(241, 241, 241); border-color: rgb(248, 248, 248);" class="r1"></b><b style="background-color: rgb(241, 241, 241); border-color: rgb(248, 248, 248);" class="r2"></b><b style="background-color: rgb(241, 241, 241); border-color: rgb(248, 248, 248);" class="r3"></b><b style="background-color: rgb(241, 241, 241); border-color: rgb(248, 248, 248);" class="r4"></b></b>
			<div style="padding-top: 0pt;" class="TopRndFrameIn"><b class="niftycorners" style="margin-left: -15px; margin-right: -15px; background: none repeat scroll 0% 0% rgb(241, 241, 241); margin-bottom: 10px;"><b style="background-color: rgb(255, 255, 255); border-color: rgb(248, 248, 248);" class="r1"></b><b style="background-color: rgb(255, 255, 255); border-color: rgb(248, 248, 248);" class="r2"></b><b style="background-color: rgb(255, 255, 255); border-color: rgb(248, 248, 248);" class="r3"></b><b style="background-color: rgb(255, 255, 255); border-color: rgb(248, 248, 248);" class="r4"></b></b>
			
				<table style="margin-bottom: 10px;" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody><tr>
						<td width="50%">
                        
            <table>
            <tbody><tr><td>            
	<div class="VoteUp"></div> = Like,</td><td><div class="VoteUnk"></div>= Unsure,</td><td><div class="VoteDown"></div>= Dislike</td>
            </tr>
            </tbody></table>					
	
						
						</td>
						<td align="right" width="50%">
							Keyboard: L=Like, U=Unsure, D=Dislike
						</td>
					</tr>
				</tbody></table>-->
				        
				     <id style= "font-size: 14px";>Select the Like(Thumbs Up), Unsure(?) or Dislike(Thumbs Down) options for each of the following statements, to learn more about the type of HealthCare Career you are suited to..  
					
				        <div class="AssessProg" id="dProg">
				          <span id="dProgLbl" style="z-index: 100; position: relative;">You have answered 0 of 10 questions.</span>					
				          <div id="dProgBar" class="AssessProgBar" style="width: 0%;"></div>					
			            </div>
				        <div id="qContMain">
				         <div style="opacity: 1;" id="qCont"><div class="AssessQ CurrentQ"><span class="AssessResp" id="qAns0">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Do you like to care for people and/or animals? </span></div><div class="AssessQ"><span class="AssessResp" id="qAns1">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Can you handle high stress situations? </span></div><div class="AssessQ"><span class="AssessResp" id="qAns2">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Are you okay with sitting at a desk, or in an office, every day?</span></div><div class="AssessQ"><span class="AssessResp" id="qAns3">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Can you work with blood?</span></div><div class="AssessQ"><span class="AssessResp" id="qAns4">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Can you handle more than one task at the same time? </span></div><div class="AssessQ"><span class="AssessResp" id="qAns5">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Are you comfortable in a position of authority?</span></div><div class="AssessQ"><span class="AssessResp" id="qAns6">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">How about working long hours, maybe sometimes late at night?</span></div><div class="AssessQ"><span class="AssessResp" id="qAns7">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Do you like having lots of hands-on times with patients? </span></div><div class="AssessQ"><span class="AssessResp" id="qAns8">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Can you work well with other Healthcare professionals? </span></div><div class="AssessQ"><span class="AssessResp" id="qAns9">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span><span class="Qinner">Can you work on computers for a long enough time? </span></div></div>
				</div>
				<div class="BtnArea" style="display:none">
				          <table cellpadding="0" cellspacing="0" width="100%">
				            <tbody><tr>
				              
				              
				              
				              <td align="left" width="50%"><input style="display: none;" alt="Back" src="<?php echo $getpath; ?>/btn-back.png" id="backBtn" value="Back" onclick="showLastPage()" type="image">
  </td>
				              <td align="right" width="50%"><input alt="Next" src="<?php echo $getpath; ?>/btn-next.png" id="nextBtn" value="Next" onclick="showNextPage()" type="image">
  </td>
				              
				              
				              
				              </tr>
			                </tbody></table>		
			            </div>
				        
			          </div>
			        </div>
			      </div>    	
    	
    </div>    
    
    <div>
      <form id="CareerAssessResult" name="CareerAssessResult" action="" method="POST">
	  <input name="primaryCat" value="" id="pCat" type="hidden">
        <input name="secondaryCat" value="" id="sCat" type="hidden">
        <!-- input id="btnResult" value="Submit" type="submit"-->
        <!-- Adding button in the quiz section -->
       <input id="btnResult" value="See Results" type="submit"  style="display:none;" />
	    
	<div id="seeresultsoff">
		<img src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_quiz/see_results_bw2.jpg" />
	</div>
	<div id="seeresultson">
		<input type="image" src="<?php echo base_path(); ?>sites/all/modules/custom/vcn/occupations/occupations_quiz/see_results.jpg" />
	</div>
      </form>




    </div>
    
    
    <div style="display: none;">
    	<span class="AssessResp" id="tempAnswer">
			<a href="javascript://" class="VoteUp"><span class="Hide508">U</span></a>
			<a href="javascript://" class="VoteUnk"><span class="Hide508">?</span></a>
			<a href="javascript://" class="VoteDown"><span class="Hide508">D</span></a>						
		</span>
    </div>
    <!--  Place at bottom of page  -->
<!------------------------------------------------------------------------>
<!-- Copy this section of code when implementing CodeBaby content -->
    <script type="text/javascript" src="<?php echo $getpath; ?>/combined.pack" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $getpath; ?>/interest.pack" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo $getpath; ?>/sam3.pack" charset="utf-8"></script>
  
 <script language="JavaScript1.2" type="text/javascript">
            
       
        function initCodeBabyContent() {
            
            // set up the codebaby object
            setupCodeBaby();
            
            // add listeners
            sceneGroupListener = new CBSceneGroupListener();
            projectListener = new CBProjectListener();
            codebaby.addListener(sceneGroupListener);
            codebaby.addListener(projectListener);
                       
            // load codebaby content
            codebaby.load();
            
        }
        
    </script>
    
    
<script type="text/javascript" src="<?php echo $getpath; ?>/career.pack" charset="utf-8"></script> 

    <script language="JavaScript1.2" type="text/javascript">
var show='off';

function ginnyhelp(){

if (show =='off') {
dojo.byId('ghelpimage').src="images/btn-ginny_help_grey.png";
dojo.query('#subhead').style('display', 'Block');
initCodeBabyContent();
playcb("CD_Intro_Interest","CD_Intro_Interest","Y");
show='on';
} else {
codebaby.sendEvents("hide");
dojo.byId('ghelpimage').src="images/btn-ginny_help.png";
dojo.query('#subhead').style('display', 'none');
show='off';
}

}
</script>
     <script language="javascript">
    var arrTxt=new Array();
    var arrQ=new Array();
    var _curQ = new Object();
    var _qCont;
    var prog;
    var curIdx;
    var qPerPage=10;
    var totalPages;
    var totalQuestions;
    var curPage=0;
   	var priCat=null;
   	var validAnsCnt=0;
    // Adding button in the quiz section 
   	document.getElementById('seeresultson').style.display = "none";
    function keyDownHandler(event)
    {
    	//save question answer
    	var cc = event.charCode;
    	var result = "";    	
    	switch (cc)
    	{
    		case 68:
    		case 100:
    			result = "D";
    			break;
    		case 76:
    		case 108:
    			result="L";
    			break;
    		case 85:
    		case 117:
    			result="U";
    			break;
    	}       
    	
    	processResult(curIdx, result); 
    }
    
    function processResult(idx, result)
    { 
        var i= idx+ qPerPage *(curPage-1) ;
			
    	if (result.length > 0 && i < arrQ.length)
    	{  
    		var oldAnswer = arrQ[i].Answer;
    	    arrQ[i].Answer = result;
           
			//dojo.addClass(_curQ[idx],'DoneQ');
			dojo.animateProperty({
				node: _curQ[idx],
				duration: 400,
				properties: {
					backgroundColor: { start: '#f5f5f5', end: '#CCFFCC' }
				}
			}).play();	       
	    
	    	setAnswer(idx, result);
	    	if (oldAnswer.length == 0) curIdx++;	    	
		}
		
		//count number of answered questions
		var aCnt=0;
		for (var j = 0; j < totalQuestions; j++)
		{
			if (arrQ[j].Answer && arrQ[j].Answer.length > 0) { aCnt++; }
		}		
		
		if (aCnt==10) {
			var cls=0; var nur=0; var thr=0; var sts=0; var den=0;
			for (var j = 0; j < totalQuestions; j++) {
			
				if (arrQ[j].Answer && arrQ[j].Answer.length > 0) { 
						if (j==0) {
							if (arrQ[j].Answer=="L") {
								nur+=4;
								thr+=4;
																
							}
							if (arrQ[j].Answer=="U") {
								thr+=2;
								nur+=2;
								
							}
							if (arrQ[j].Answer=="D") {
								cls-=4;
								sts-=4;
								den-=3;
							}						
						}
						if (j==1) {
							if (arrQ[j].Answer=="L") {
								nur+=4;
								thr+=2;
								sts+=3;
								den+=2;
							}
							if (arrQ[j].Answer=="U") {
								nur+=2;
								thr+=1;
								sts+=1;
								den+=1;
								
							}
							if (arrQ[j].Answer=="D") {
								cls-=4;
							}						
						}
						if (j==2) {
							if (arrQ[j].Answer=="L") {
								den+=6;
								sts+=2;
							}
							if (arrQ[j].Answer=="U") {
								den+=3;
								sts+=1;
							}
							if (arrQ[j].Answer=="D") {
								nur-=4;
								thr-=4;
								cls-=4;
							}		
			
						}
						if (j==3) {
							if (arrQ[j].Answer=="L") {
								cls+=3;
								nur+=6;
								thr+=2;
								sts+=1;
							}
							if (arrQ[j].Answer=="U") {
								cls+=1;
								nur+=2;
								thr+=1
							}
							if (arrQ[j].Answer=="D") {
								den-=8;
								
							}						
						}
						if (j==4) {
							if (arrQ[j].Answer=="L") {
								den+=4;
								cls+=3;
								nur+=2;
								thr=+1;
								sts+=1;
							}
							if (arrQ[j].Answer=="U") {
								nur+=1;
								cls+=1;
								den+=2;
							}
													
						}
						if (j==5) {
							if (arrQ[j].Answer=="L") {
							    cls+=1;
								nur+=2;
								thr+=4;
								sts+=2;
								den+=1;
							}
							if (arrQ[j].Answer=="U") {
								nur+=1;
								thr+=2;
								sts+=1;								
							}
													
						}
						if (j==6) {
							if (arrQ[j].Answer=="L") {
								cls+=1;
								nur+=4;
								sts+=1;
							}
							if (arrQ[j].Answer=="U") {
								nur+=2;
							}
							if (arrQ[j].Answer=="D") {
								thr-=4;
								den-=4;
							}						
						}
						if (j==7) {
							if (arrQ[j].Answer=="L") {
								nur+=2;
								thr+=4;
								sts+=1;
								den+=1;
							}
							if (arrQ[j].Answer=="U") {
								nur+=1;
								thr+=2;
							}
							if (arrQ[j].Answer=="D") {
								cls-=4;
							}						
						}
						if (j==8) {
							if (arrQ[j].Answer=="L") {
								cls+=1;
								nur+=4;
								thr+=3;
								sts+=1;
								den+=3;
								
							}
							if (arrQ[j].Answer=="U") {
								nur+=2;
								thr+=2;
								den+=1;
							}
													
						}
						if (j==9) {
							if (arrQ[j].Answer=="L") {
								cls+=3;
								thr+=1;
								sts+=2;
								den+=3;
								nur-=4;
								
							}
							if (arrQ[j].Answer=="U") {
								cls+=1;
								den+=1;
								sts+=1;
							}
								
						}
						var category = 1;
						if (nur>category)
							category=8;
						if (thr>category)
							category=14;
						if (sts>category)
							category=13;
						if (den>category)
							category=6;
							
						if (cls==12 && nur==24 && thr== 13 && sts==14 && den==20) {
						   alert('You have selected that you like everything.');
						  // return;
						}
						else {
						   document.CareerAssessResult.action = "<?php echo base_path(); ?>careergrid/group_id/"+category;
						   // Adding button in the quiz section 
							document.getElementById('seeresultsoff').style.display = "none";
							document.getElementById('seeresultson').style.display = "block";
							prog.Set(aCnt+1);
							return false;						   
						}
				
				}
			}
			//alert(cls+' '+nur+' '+thr+' '+sts+' '+den+' / '+category); 
		}
		prog.Set(aCnt+1);
		// removed this if condition in the process of Adding button in the quiz section 
		//if (cls==12 && nur==24 && thr== 13 && sts==14 && den==20) 
		//{
		//  return;
		//}
		//if at end of page or end of questions, goto next page
		if (curIdx > (qPerPage-1) || i >= arrQ.length)
		{

			//goto next page
			showNextPage();
		}
		
		hiliteCurrentQ();
    }
    
    function setAnswer(idx, ans)
    {
    	if (ans.length==0) return;
    	
    	var cur = _curQ[idx];
    	
    	dojo.removeClass(cur,'CurrentQ');
    	dojo.addClass(cur,'DoneQ');
    	dojo.removeClass(cur.Response.VoteDown, 'VoteDownSel');
    	dojo.removeClass(cur.Response.VoteUp,'VoteUpSel');
    	dojo.removeClass(cur.Response.VoteUnk,'VoteUnkSel');
    	
    	switch (ans)
    	{
    		case "D":
    			dojo.addClass(cur.Response.VoteDown, 'VoteDownSel');
    			break;
    		case "L":
    			dojo.addClass(cur.Response.VoteUp,'VoteUpSel');
    			break;
    		case "U":
    			dojo.addClass(cur.Response.VoteUnk,'VoteUnkSel');
    			break;    		
    	}
 
    	validAnsCnt++;
    }       
    
    function initTxt()
    {  
    	 
            arrTxt[1]= new Object();
              arrTxt[1].Category = 'R';
              arrTxt[1].Text=  'Do you like to care for people and/or animals?';
	     
              arrTxt[2]= new Object();
              arrTxt[2].Category = 'R';
              arrTxt[2].Text=  'Can you handle high stress situations?';
	     
              arrTxt[3]= new Object();
              arrTxt[3].Category = 'I';
              arrTxt[3].Text=  'Are you okay with sitting at a desk, or in an office, every day?';
	     
              arrTxt[4]= new Object();
              arrTxt[4].Category = 'I';
              arrTxt[4].Text=  'Can you work with blood?';
	     
              arrTxt[5]= new Object();
              arrTxt[5].Category = 'A';
              arrTxt[5].Text=  'Can you handle more than one task at the same time?';
	     
              arrTxt[6]= new Object();
              arrTxt[6].Category = 'A';
              arrTxt[6].Text=  'Are you comfortable in a position of authority?';
	     
              arrTxt[7]= new Object();
              arrTxt[7].Category = 'S';
              arrTxt[7].Text=  'How about working long hours, maybe sometimes late at night?';
	     
              arrTxt[8]= new Object();
              arrTxt[8].Category = 'S';
              arrTxt[8].Text=  'Do you like having lots of hands-on times with patients?';
	     
              arrTxt[9]= new Object();
              arrTxt[9].Category = 'E';
              arrTxt[9].Text=  'Can you work well with other Healthcare professionals?';
	     
              arrTxt[10]= new Object();
              arrTxt[10].Category = 'E';
              arrTxt[10].Text=  'Can you work on computers for a long enough time?';
	     
    }
    
    function setupQuestions()
    {
    	for (var i=0; i < arrTxt.length-1; i++)
    	{
    		arrQ[i] = new Object();
    		arrQ[i].Text = arrTxt[i+1].Text;
    		arrQ[i].Category = arrTxt[i+1].Category;
    		arrQ[i].Answer = '';
    	}    
    	
    	totalQuestions = arrQ.length;
    	totalPages = Math.ceil(arrQ.length/qPerPage);    
    }
    
    function setupContainer()
    {
    	_qCont = dojo.byId('qCont');
		
		prog = new Object();
		prog.Label = dojo.byId('dProgLbl');
		prog.Bar  = dojo.byId('dProgBar');
		
		prog.Set = function(pnum)
		{
			var pct = Math.round( ( (pnum-1) / totalQuestions) * 100.0 );		
			this.Label.innerHTML = 'You have answered ' + (pnum -1) + ' of ' +  totalQuestions + ' questions.';
			if (!this.Bar.lastPct) this.Bar.lastPct = 0;
			
			dojo.animateProperty({
				node: this.Bar,
				duration: 250,
				properties: {
					width: { start: this.Bar.lastPct, end: pct, units: "%" }
				}
			}).play();
			
			//this.Bar.style.width = pct + '%';
			this.Bar.lastPct = pct;
		};
		
		//setup keydown
		dojo.connect(document,'keypress', keyDownHandler);
		
		prog.Set(1);    	
	}
    
    function showNextPage()
    {    	
        q = qPerPage;
        
        if(curPage== totalPages-1)
    	{ 
    	     q = totalQuestions - qPerPage *(totalPages-1);
    	}
        
    	if(curPage== totalPages)
    	{ 
			gotoResult();
			return;
    	}
    	else
    	{
    	   //create questions
	    	var newQ=new Array();
	    	curIdx = -1;
	    	for (var i = 0; i < q; i++)
	    	{
	    		var idx = i+ qPerPage*curPage ;
	    		    	
	    		var dQ = document.createElement('div');    	
	    		dojo.addClass(dQ,'AssessQ');
	    		
	    		//setup responses
	    		var sResp = setupVote(i);    		
	    		
	    		//setup question text
	    		var sQ = document.createElement('span');
	    		dojo.addClass(sQ,'Qinner');
	    		
	    		
	    		dQ.appendChild(sResp);
	    		dQ.appendChild(sQ);
				sQ.innerHTML = arrQ[idx].Text;
	    		dQ.Response = sResp;
	    			
	    		_curQ[i] = dQ; 
	    		newQ[i] = dQ;	
	    		
				setAnswer(i, arrQ[idx].Answer);
				
				//set current to first unanswered question
				if (curIdx == -1 && arrQ[idx].Answer.length == 0)
				{
					curIdx = i;
				} 		
	    	}
	    	
	    	if (curIdx==-1) curIdx=0;

	    	dojo.fx.chain([
				dojo.fadeOut({node: _qCont, onEnd: function() { dojox.data.dom.replaceChildren(_qCont, newQ); } }),				
				dojo.fadeIn({node: _qCont})
	    	]).play();
	    		    	
	    	//dojox.data.dom.replaceChildren(_qCont, newQ);

			if(curPage==0) 
	    	{
	    	   dojo.byId('backBtn').style.display="none";
	    	}
	    	else
	    	{
	    	   dojo.byId('backBtn').style.display="block";
	    	}
	    		    	
	    	curPage++;  	    	
	    		    	
			hiliteCurrentQ();
	   }
    	
    }
    
 
    function showLastPage()
    {   
    	curPage--;
    	    	
    	//create questions
    	var newQ=new Array();
    	curIdx=-1;
    	for (var i = 0; i < qPerPage; i++)
    	{
    		var idx = i+ qPerPage*(curPage-1) ;
    		    	
    		var dQ = document.createElement('div');    	
    		dojo.addClass(dQ,'AssessQ');    		
    		
    		//setup responses
    		var sResp = setupVote(i);    		
    		
    		//setup question text
    		var sQ = document.createElement('span');
    		dojo.addClass(sQ,'Qinner');
    		
    		
    		dQ.appendChild(sResp);
    		dQ.appendChild(sQ);
			sQ.innerHTML = arrQ[idx].Text;
    		dQ.Response = sResp;
    			
    		_curQ[i] = dQ;
    		newQ[i] = dQ;
    		
    		setAnswer(i, arrQ[idx].Answer);
    		
    		//set current to first unanswered question
			if (curIdx == -1 && arrQ[idx].Answer.length == 0)
			{
				curIdx = i;
			} 
    	}
    	if (curIdx==-1) curIdx=0;
    	
    	dojox.data.dom.replaceChildren(_qCont, newQ);
    	
    	//prog.Set(curPage);  
    	
    	if(curPage==1) 
    	{
    	   dojo.byId('backBtn').style.display="none";
    	}   
    	    	 	   	
	   	hiliteCurrentQ();		
    }
    
    function setupVote(qNum)
    {    	
    	var cont = dojo.clone(dojo.byId('tempAnswer'));
    	cont.id = 'qAns' + qNum;
    
    	cont.VoteUp = dojo.query("a.VoteUp", cont)[0];
    	cont.VoteDown = dojo.query("a.VoteDown", cont)[0];
    	cont.VoteUnk = dojo.query("a.VoteUnk", cont)[0];
    	
    	cont.BtnEvts=new Array();
    	cont.BtnEvts[0] = dojo.connect(cont.VoteUp,'click',function(idx, evt){ processResult(qNum, 'L'); });
    	cont.BtnEvts[1] = dojo.connect(cont.VoteDown,'click',function(idx, evt){ processResult(qNum, 'D'); });
    	cont.BtnEvts[2] = dojo.connect(cont.VoteUnk,'click',function(idx, evt){ processResult(qNum, 'U'); });    	
    	
    	return cont;
    }
    
  
    function add_assess(primaryCat, secondaryCat) {   

         dojo.byId('pCat').value=primaryCat;
         dojo.byId('sCat').value=secondaryCat;
         dojo.byId('btnResult').click();





















    }  
       
    //count the answers
    function getLargest(p)
    {    
    	var arrCat = new Array('R', 'I', 'A', 'S', 'E', 'C');
    	var res = new Object();
    	var i;
    	//init scores 	
    	for (i=0; i < arrCat.length; i++) res[arrCat[i]] = 0;
        
        //count likes
        for (i=0; i < totalQuestions; i++)
    	{      		    	
    	    if(arrQ[i].Answer == "L")    	    
    	    	res[arrQ[i].Category] = res[arrQ[i].Category] + 1;
    	}                  
    
    	var maxScore=0;
    	var maxType = "";
    	//find largest score
    	for (i=0; i < arrCat.length; i++)
    	{
    		if (res[arrCat[i]] > maxScore && arrCat[i] != p)
    		{
    			maxType = arrCat[i];
    			maxScore = res[arrCat[i]];
    		}    		
    	}
        
        return maxType;
    }
       
    function gotoResult() 
    {  
 
 		if (validAnsCnt < 6)
 		{
 			alert('You have answered less than 6 questions. The Wizard may not be able to determine accurate career interests with this little information. You must back and answer additional questions before viewing your results.');
			return;
 		} 
 
        primaryCat = getLargest("p"); //calc score
        
        //check to make sure we got a good score
        if (primaryCat==null || primaryCat=="")
        {
        	alert('You did not indicate enough interests to generate accurate results.  Please go back and select at least 1 task that you would like performing.');
        	return;  
        }
        
        secondaryCat = getLargest(primaryCat);
        add_assess(primaryCat, secondaryCat); //save to profile
    }  
 
	function hiliteCurrentQ()
    {    	
    	dojo.addClass(_curQ[curIdx],'CurrentQ');
    }

   
     dojo.addOnLoad(function() {

    initTxt();
    setupQuestions();
    setupContainer();
    showNextPage();
    
    });
	</script>
        
<script type="text/javascript">
var player = null;
function playerReady(thePlayer) {
	player = window.document[thePlayer.id];
}

		  
 function createPlayer() {
            var flashvars = {
                    file:"/wiz-videos/interest_instruct.flv", 
                    autostart:"true"
            }
            var params = {
                    allowfullscreen:"true", 
                    allowscriptaccess:"always"
            }
            var attributes = {
                    id:"ply",  
                    name:"ply"
            }
            swfobject.embedSWF("scripts/shadowbox/player.swf", "placeholder", "470", "377", "9.0.115", false, flashvars, params, attributes);
        }


var player = dojo.byId('ply');



dojo.addOnLoad(function() {  
dojo.query("#video_dia").instantiate(dijit.Dialog, { delay:3200 });
dojo.connect(dijit.byId("video_dia"), 'onCancel', function() { dijit.byId('video_dia').setContent('<div id="placeholder"></div>') } );
initCodeBabyContent(); 
 });
</script>
  
		  </div>			
			</td>
			<td class="BorderRight">&nbsp;</td>
		</tr>
		<tr>
			<td id="hrBomL"></td>
			<td id="hrBom"></td>
			<td id="hrBomR"></td>
		</tr>
</tbody></table>
</div>


<script language="JavaScript" type="text/javascript">
  dojo.registerModulePath("customdojo", "<?php echo $getpath; ?>");
  var lnkRptUrl = "/vccs/json/LinkReport.action";	
</script>




<script type="text/javascript" src="<?php echo $getpath; ?>/combined_002.pack" charset="utf-8"></script>
 





<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-6438572-1']);
_gaq.push(['_trackPageview']);



(function() {
var ga = document.createElement('script');
ga.src = ('https:' == document.location.protocol ?
    'https://ssl' : 'http://www') +
    '.google-analytics.com/ga.js';
ga.setAttribute('async', 'true');
document.documentElement.firstChild.appendChild(ga);
})();
</script>



<div title="" style="visibility: hidden; position: absolute; top: -9999px;" widgetid="dlgLnkRpt" id="dlgLnkRpt" aria-labelledby="dlgLnkRpt_title" role="dialog" class="dijitDialog printhide dijitContentPane" tabindex="-1" wairole="dialog" waistate="labelledby-dlgLnkRpt_title">
	<div title="Link Report" dojoattachpoint="titleBar" class="dijitDialogTitleBar">
	<span dojoattachpoint="titleNode" class="dijitDialogTitle" id="dlgLnkRpt_title">Link Report</span>
	<span dojoattachpoint="closeButtonNode" class="dijitDialogCloseIcon" dojoattachevent="onclick: onCancel, onmouseenter: _onCloseEnter, onmouseleave: _onCloseLeave" title="Cancel">
		<span dojoattachpoint="closeText" class="closeText" title="Cancel">x</span>
	</span>
	</div>
		<div dojoattachpoint="containerNode" class="dijitDialogPaneContent">	
</div>
</div><div title="" style="visibility: hidden; position: absolute; top: -9999px;" widgetid="video_dia" id="video_dia" aria-labelledby="video_dia_title" role="dialog" class="dijitDialog dijitContentPane" tabindex="-1" wairole="dialog" waistate="labelledby-video_dia_title">
	<div dojoattachpoint="titleBar" class="dijitDialogTitleBar">
	<span dojoattachpoint="titleNode" class="dijitDialogTitle" id="video_dia_title"></span>
	<span dojoattachpoint="closeButtonNode" class="dijitDialogCloseIcon" dojoattachevent="onclick: onCancel, onmouseenter: _onCloseEnter, onmouseleave: _onCloseLeave" title="Cancel">
		<span dojoattachpoint="closeText" class="closeText" title="Cancel">x</span>
	</span>
	</div>
		<div dojoattachpoint="containerNode" class="dijitDialogPaneContent">
<div id="placeholder"></div>
</div>
</div></body></html>