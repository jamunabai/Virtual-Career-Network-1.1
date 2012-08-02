/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 

persistedval=sessionStorage.getItem("mykeygrid") ;

var tem_id="";
if (persistedval==1)
	tem_id="one";
if (persistedval==2)
	tem_id="two";
if (persistedval==3)
	tem_id="three";
if (persistedval==4)
	tem_id="four";
if (persistedval==5)
	tem_id="five";
if (persistedval==6)
	tem_id="six";
if (persistedval==7)
	tem_id="seven";
if (persistedval==8)
	tem_id="eight";
if (persistedval==9)
	tem_id="nine";
if (persistedval>=10)
	tem_id="ten";
	
var capital = tem_id.charAt(0).toUpperCase() + tem_id.slice(1);


$(document).ready(function() {
  
  
	if(tem_id!="") {
		bold(tem_id);
	}
	else {
		bold('one');
		
	}
 // moveToTwoPage(table); 
});

function bold(id) {

		//$('#'+id).click();

		var fifty=["one","two","three","four","five","six","seven","eight","nine","ten","eleven","twelve","thirteen","fourteen","fifteen","sixteen","seventeen","eightteen","nineteen","twenty",
		"twentyone","twentytwo","twentythree","twentyfour","twentyfive","twentysix","twentyseven","twentyeight","twentynine","thirty","thirtyone","thirtytwo","thirtythree","thiryfour","thirtyfive",
		"thirtysix","thirtyseven","thirtyeight","thirtynine","fourty","fourtyone","fourtytwo","fourtythree","fourtyfour","fourtyfive","fourtysix","fourtyseven","fourtyeight","fourtynine","fifty","fiftyone"];
		
		var key=0;
		
		var thisv = 0;
		for (var c in fifty) {
			if (fifty[c]==id) {
				thisv = c;
				thisv++;
			}
		}

		var pageinfo = document.getElementById('pagedisplay').value;			
		var pieces=pageinfo.split("/");
		var prevpage=parseInt(pieces[0],10)-1;
		var nextpage=parseInt(pieces[0],10)+1;
		var lastpage=parseInt(pieces[1]);
		var pagesession = parseInt(pieces[0]);

		/*
		To store the page value in the seesion variable "mykey" so that it can be used further
		*/
		var persistedval = '';
		//if (window.sessionStorage){
			sessionStorage.setItem("mykeygrid", thisv) //store data using setItem()
			persistedval=sessionStorage.getItem("mykeygrid") //returns "Some Value"
			//alert(thisv + ' ' + persistedval);
		//}

		for (i=0; i<=lastpage; i++) {
			if(fifty[i]==id || id==i) {
				key=i+1;
				break;
			}
		}		

		if (id!='one')
			document.getElementById('prev').style.display = 'block';

		if (document.getElementById('next'))
			document.getElementById('next').style.display = '';
			
		if (id=='one')
			document.getElementById('prev').style.display = 'none';
		if (key==lastpage && document.getElementById('next'))
			document.getElementById('next').style.display = 'none';

		if (nextpage<=lastpage || (nextpage>lastpage && id!="next")) {

			if (document.getElementById('one'))
				document.getElementById('one').style.color = '#A61E28';
			if (document.getElementById('two'))
				document.getElementById('two').style.color = '#A61E28';
			if (document.getElementById('three'))
				document.getElementById('three').style.color = '#A61E28';
			if (document.getElementById('four'))
				document.getElementById('four').style.color = '#A61E28';
			if (document.getElementById('five'))
				document.getElementById('five').style.color = '#A61E28';
			if (document.getElementById('six'))
				document.getElementById('six').style.color = '#A61E28';
			if (document.getElementById('seven'))
				document.getElementById('seven').style.color = '#A61E28';
			if (document.getElementById('eight'))
				document.getElementById('eight').style.color = '#A61E28';
			if (document.getElementById('nine'))
				document.getElementById('nine').style.color = '#A61E28';
			if (document.getElementById('ten'))
				document.getElementById('ten').style.color = '#A61E28';
				
		}


	/*	if (pagesession == 1)
			document.getElementById(one).style.color = '#A61E28';
		if (pagesession == 2)
			document.getElementById(two).style.color = '#A61E28';
		if (pagesession == 3)
			document.getElementById(three).style.color = '#A61E28';
		if (pagesession == 4)
			document.getElementById(four).style.color = '#A61E28';
		if (pagesession == 5)
			document.getElementById(five).style.color = '#A61E28';
		if (pagesession == 6)
			document.getElementById(six).style.color = '#A61E28';
		if (pagesession == 7)
			document.getElementById(seven).style.color = '#A61E28';
		if (pagesession == 8)
			document.getElementById(eight).style.color = '#A61E28';
		if (pagesession == 9)
			document.getElementById(nine).style.color = '#A61E28';
		if (pagesession >= 10)
			document.getElementById(ten).style.color = '#A61E28';*/
		

		
		if (id=='next') {
			var tp=prevpage;
			
			if (nextpage==1)
				nextpage="one";
			if (nextpage==2)
				nextpage="two";
			if (nextpage==3)
				nextpage="three";
			if (nextpage==4)
				nextpage="four";
			if (nextpage==5)
				nextpage="five";
			if (nextpage==6)
				nextpage="six";
			if (nextpage==7)
				nextpage="seven";
			if (nextpage==8)
				nextpage="eight";
			if (nextpage==9)
				nextpage="nine";
			if (nextpage>=10)
				nextpage="ten";
				
			if (tp==lastpage-2) {
				document.getElementById('next').style.display = 'none';
			} 				
				
			document.getElementById(nextpage).style.color = '#000000';
		}
		else if (id=='prev') {
			var tp=prevpage;
			
			if (prevpage==1)
				prevpage="one";
			if (prevpage==2)
				prevpage="two";
			if (prevpage==3)
				prevpage="three";
			if (prevpage==4)
				prevpage="four";
			if (prevpage==5)
				prevpage="five";
			if (prevpage==6)
				prevpage="six";
			if (prevpage==7)
				prevpage="seven";
			if (prevpage==8)
				prevpage="eight";
			if (prevpage==9)
				prevpage="nine";
			if (prevpage>=10)
				prevpage="ten";		
				
			if (tp==1) {
				prevpage="one";
				document.getElementById('prev').style.display = 'none';
			} 
			document.getElementById(prevpage).style.color = '#000000';
		}
		else {
			 if (document.getElementById(id))
			document.getElementById(id).style.color = '#000000';
		}
		
		setTimeout(function(){changewages(id)},0);


}

(function($) {
	$.extend({
		tablesorterPager: new function() {
			
			function updatePageDisplay(c) {
				var s = $(c.cssPageDisplay,c.container).val((c.page+1) + c.seperator + c.totalPages);	
			}
			
			function setPageSize(table,size) {
				var c = table.config;
				c.size = size;
				c.totalPages = Math.ceil(c.totalRows / c.size);
				c.pagerPositionSet = false;
				moveToPage(table);
				//fixPosition(table);
			}
			
			function fixPosition(table) {
				var c = table.config;
				if(!c.pagerPositionSet && c.positionFixed) {
					var c = table.config, o = $(table);
					if(o.offset) {
						c.container.css({
							top: o.offset().top + o.height() + 'px',
							position: 'absolute'
						});
					}
					c.pagerPositionSet = true;
				}
			}
			
			function moveToFirstPage(table) {
				var c = table.config;
				c.page = 0;
				moveToPage(table);
			}
			
			function moveToLastPage(table) {
				var c = table.config;
				c.page = (c.totalPages-1);
				moveToPage(table);
			}
			
			function moveToNextPage(table) {
				var c = table.config;
				c.page++;
				if(c.page >= (c.totalPages-1)) {
					c.page = (c.totalPages-1);
				}
				moveToPage(table);
			}
			
			function moveToOnePage(table) {
				var c = table.config;
				c.page = 0;
				moveToPage(table);
			}

			function moveToTwoPage(table) {
				var c = table.config;
				c.page = 1;
				moveToPage(table);
			}
			function moveToThreePage(table) {
				var c = table.config;
				c.page = 2;
				moveToPage(table);
			}
			function moveToFourPage(table) {
				var c = table.config;
				c.page = 3;
				moveToPage(table);
			}
			function moveToFivePage(table) {
				var c = table.config;
				c.page = 4;
				moveToPage(table);
			}
			function moveToSixPage(table) {
				var c = table.config;
				c.page = 5;
				moveToPage(table);
			}
			function moveToSevenPage(table) {
				var c = table.config;
				c.page = 6;
				moveToPage(table);
			}			
			function moveToEightPage(table) {
				var c = table.config;
				c.page = 7;
				moveToPage(table);
			}			
			function moveToNinePage(table) {
				var c = table.config;
				c.page = 8;
				moveToPage(table);
			}
			function moveToTenPage(table) {
				var c = table.config;
				c.page = 9;
				moveToPage(table);
			}
			function moveToElevenPage(table) {
				var c = table.config;
				c.page = 10;
				moveToPage(table);
			}
			
			function moveToPrevPage(table) {
				var c = table.config;
				c.page--;
				if(c.page <= 0) {
					c.page = 0;
				}
				moveToPage(table);
			}
						
			
			function moveToPage(table) {
				var c = table.config;
				if(c.page < 0 || c.page > (c.totalPages-1)) {
					c.page = 0;
				}
				
				renderTable(table,c.rowsCopy);
			}
			
			function renderTable(table,rows) {
				
				var c = table.config;
				var l = rows.length;
				var s = (c.page * c.size);
				var e = (s + c.size);
				if(e > rows.length ) {
					e = rows.length;
				}
				
				
				var tableBody = $(table.tBodies[0]);
				
				// clear the table body
				
				$.tablesorter.clearTableBody(table);
				
				for(var i = s; i < e; i++) {
					
					//tableBody.append(rows[i]);
					
					var o = rows[i];
					var l = o.length;
					for(var j=0; j < l; j++) {
						
						tableBody[0].appendChild(o[j]);

					}
				}
				
				//fixPosition(table,tableBody);
				
				$(table).trigger("applyWidgets");
				
				if( c.page >= c.totalPages ) {
        			moveToLastPage(table);
				}
				
				updatePageDisplay(c);
			}
			
			this.appender = function(table,rows) {
				
				var c = table.config;
				
				c.rowsCopy = rows;
				c.totalRows = rows.length;
				c.totalPages = Math.ceil(c.totalRows / c.size);
				
				renderTable(table,rows);
			};
			
			this.defaults = {
				size: 8,
				offset: 0,
				page: 0,
				totalRows: 0,
				totalPages: 0,
				container: null,
				cssNext: '.next',
				
				cssOne: '.one',
				cssTwo: '.two',
				cssThree: '.three',
				cssFour: '.four',
				cssFive: '.five',
				cssSix: '.six',
				cssSeven: '.seven',
				cssEight: '.eight',
				cssNine: '.nine',
				cssTen: '.ten',
				cssEleven: '.eleven',
					
				cssPrev: '.prev',
				cssFirst: '.first',
				cssLast: '.last',
				cssPageDisplay: '.pagedisplay',
				cssPageSize: '.pagesize',
				seperator: "/",
				positionFixed: true,
				appender: this.appender
			};
			
			this.construct = function(settings) {
				
				return this.each(function() {	
					
					config = $.extend(this.config, $.tablesorterPager.defaults, settings);
					
					var table = this, pager = config.container;
				
					$(this).trigger("appendCache");
					
					config.size = parseInt($(".pagesize",pager).val());
					
					if (capital=="One")
						moveToOnePage(table);
					if (capital=="Two")
						moveToTwoPage(table);			
					if (capital=="Three")
						moveToThreePage(table);
					if (capital=="Four")
						moveToFourPage(table);
					if (capital=="Five")
						moveToFivePage(table);
					if (capital=="Six")
						moveToSixPage(table);
					if (capital=="Seven")
						moveToSevenPage(table);
					if (capital=="Eight")
						moveToEightPage(table);
					if (capital=="Nine")
						moveToNinePage(table);
					if (capital=="Ten")
						moveToTenPage(table);						
					
					$(config.cssFirst,pager).click(function() {
						moveToFirstPage(table);
						return false;
					});
					$(config.cssNext,pager).click(function() {
						moveToNextPage(table);
						return false;
					});
										
					$(config.cssOne,pager).click(function() {
						moveToOnePage(table);
						return false;
					});
										
					$(config.cssTwo,pager).click(function() {
						moveToTwoPage(table);
						return false;
					});
										
					$(config.cssThree,pager).click(function() {
						moveToThreePage(table); 
						return false;
					});
										
					$(config.cssFour,pager).click(function() {
						moveToFourPage(table);
						return false;
					});
										
					$(config.cssFive,pager).click(function() {
						moveToFivePage(table);
						return false;
					});
										
					$(config.cssSix,pager).click(function() {
						moveToSixPage(table);
						return false;
					});
										
					$(config.cssSeven,pager).click(function() {
						moveToSevenPage(table);
						return false;
					});
										
					$(config.cssEight,pager).click(function() {
						moveToEightPage(table);
						return false;
					});
										
					$(config.cssNine,pager).click(function() {
						moveToNinePage(table);
						return false;
					});
										
					$(config.cssTen,pager).click(function() {
						moveToTenPage(table);
						return false;
					});
					
					$(config.cssEleven,pager).click(function() {
						moveToElevenPage(table);
						return false;
					});
					
					
					$(config.cssPrev,pager).click(function() {
						moveToPrevPage(table);
						return false;
					});
					$(config.cssLast,pager).click(function() {
						moveToLastPage(table);
						return false;
					});
					$(config.cssPageSize,pager).change(function() {
						setPageSize(table,parseInt($(this).val()));
						return false;
					});
				});
			};
			
		}
	});
	// extend plugin scope
	$.fn.extend({
        tablesorterPager: $.tablesorterPager.construct
	});
	
})(jQuery);				
