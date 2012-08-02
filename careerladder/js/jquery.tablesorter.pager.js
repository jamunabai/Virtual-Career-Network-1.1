/*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ 

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
			function moveToTwelvePage(table) {
				var c = table.config;
				c.page = 11;
				moveToPage(table);
			}

			function moveToThirteenPage(table) { 
				var c = table.config;
				c.page = 12;
				moveToPage(table);
			}
			function moveToFourteenPage(table) {
				var c = table.config;
				c.page = 13;
				moveToPage(table);
			}
			function moveToFifteenPage(table) {
				var c = table.config;
				c.page = 14;
				moveToPage(table);
			}
			function moveToSixteenPage(table) {
				var c = table.config;
				c.page = 15;
				moveToPage(table);
			}
			function moveToSeventeenPage(table) {
				var c = table.config;
				c.page = 16;
				moveToPage(table);
			}
			function moveToEightteenPage(table) {
				var c = table.config;
				c.page = 17;
				moveToPage(table);
			}			
			function moveToNineteenPage(table) {
				var c = table.config;
				c.page = 18;
				moveToPage(table);
			}			
			function moveToTwentyPage(table) {
				var c = table.config;
				c.page = 19;
				moveToPage(table);
			}
			function moveToTwentyonePage(table) {
				var c = table.config;
				c.page = 20;
				moveToPage(table);
			}
			function moveToTwentytwoPage(table) {
				var c = table.config;
				c.page = 21;
				moveToPage(table);
			}	
			function moveToTwentythreePage(table) {
				var c = table.config;
				c.page = 22;
				moveToPage(table);
			}		
			function moveToTwentyfourPage(table) {
				var c = table.config;
				c.page = 23;
				moveToPage(table);
			}	
			function moveToTwentyfivePage(table) {
				var c = table.config;
				c.page = 24;
				moveToPage(table);
			}			
			function moveToTwentysixPage(table) {
				var c = table.config;
				c.page = 25;
				moveToPage(table);
			}		
			function moveToTwentysevenPage(table) {
				var c = table.config;
				c.page = 26;
				moveToPage(table);
			}		
			function moveToTwentyeightPage(table) {
				var c = table.config;
				c.page = 27;
				moveToPage(table);
			}			
			function moveToTwentyninePage(table) {
				var c = table.config;
				c.page = 28;
				moveToPage(table);
			}		
			function moveToThirtyPage(table) {
				var c = table.config;
				c.page = 29;
				moveToPage(table);
			}		
			function moveToThirtyonePage(table) {
				var c = table.config;
				c.page = 30;
				moveToPage(table);
			}		
			function moveToThirtytwoPage(table) {
				var c = table.config;
				c.page = 31;
				moveToPage(table);
			}		
			function moveToThirtythreePage(table) {
				var c = table.config;
				c.page = 32;
				moveToPage(table);
			}	
			function moveToThirtyfourPage(table) {
				var c = table.config;
				c.page = 33;
				moveToPage(table);
			}				
			function moveToThirtyfivePage(table) {
				var c = table.config;
				c.page = 34;
				moveToPage(table);
			}	
			function moveToThirtysixPage(table) {
				var c = table.config;
				c.page = 35;
				moveToPage(table);
			}		
			function moveToThirtysevenPage(table) {
				var c = table.config;
				c.page = 36;
				moveToPage(table);
			}		
			function moveToThirtyeightPage(table) {
				var c = table.config;
				c.page = 37;
				moveToPage(table);
			}	
			function moveToThirtyninePage(table) {
				var c = table.config;
				c.page = 38;
				moveToPage(table);
			}			
			function moveToFourtyPage(table) {
				var c = table.config;
				c.page = 39;
				moveToPage(table);
			}		
			function moveToFourtyonePage(table) {
				var c = table.config;
				c.page = 40;
				moveToPage(table);
			}		
			function moveToFourtytwoPage(table) {
				var c = table.config;
				c.page = 41;
				moveToPage(table);
			}			
			function moveToFourtythreePage(table) {
				var c = table.config;
				c.page = 42;
				moveToPage(table);
			}	
			function moveToFourtyfourPage(table) {
				var c = table.config;
				c.page = 43;
				moveToPage(table);
			}			
			function moveToFourtyfivePage(table) {
				var c = table.config;
				c.page = 44;
				moveToPage(table);
			}			
			function moveToFourtysixPage(table) {
				var c = table.config;
				c.page = 45;
				moveToPage(table);
			}	
			function moveToFourtysevenPage(table) {
				var c = table.config;
				c.page = 46;
				moveToPage(table);
			}		
			function moveToFourtyeightPage(table) {
				var c = table.config;
				c.page = 47;
				moveToPage(table);
			}		
			function moveToFourtyninePage(table) {
				var c = table.config;
				c.page = 48;
				moveToPage(table);
			}			
			function moveToFiftyPage(table) {
				var c = table.config;
				c.page = 49;
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
				size: 5,
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
				cssTwelve: '.twelve',
				cssThirteen: '.thirteen',
				cssFourteen: '.fourteen',
				cssFifteen: '.fifteen',
				cssSixteen: '.sixteen',
				cssSeventeen: '.seventeen',
				cssEightteen: '.eightteen',
				cssNineteen: '.nineteen',
				cssTwenty: '.twenty',	
				
				cssTwentyone: '.twentyone',
				cssTwentytwo: '.twentytwo',
				cssTwentythree: '.twentythree',
				cssTwentyfour: '.twentyfour',
				cssTwentyfive: '.twentyfive',
				cssTwentysix: '.twentysix',
				cssTwentyseven: '.twentyseven',
				cssTwentyeight: '.twentyeight',
				cssTwentynine: '.twentynine',
				cssThirty: '.thirty',	
				
				cssThirtyone: '.thirtyone',
				cssThirtytwo: '.thirtytwo',
				cssThirtythree: '.thirtythree',
				cssThirtyfour: '.thirtyfour',
				cssThirtyfive: '.thirtyfive',
				cssThirtysix: '.thirtysix',
				cssThirtyseven: '.thirtyseven',
				cssThirtyeight: '.thirtyeight',
				cssThirtynine: '.thirtynine',
				cssFourty: '.fourty',
				
				cssFourtyone: '.fourtyone',
				cssFourtytwo: '.fourtytwo',
				cssFourtythree: '.fourtythree',
				cssFourtyfour: '.fourtyfour',
				cssFourtyfive: '.fourtyfive',
				cssFourtysix: '.fourtysix',
				cssFourtyseven: '.fourtyseven',
				cssFourtyeight: '.fourtyeight',
				cssFourtynine: '.fourtynine',
				cssFifty: '.fifty',		
				
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
					$(config.cssTwelve,pager).click(function() {
						moveToTwelvePage(table);
						return false;
					});			

					$(config.cssThirteen,pager).click(function() {
						moveToThirteenPage(table);
						return false;
					});

					$(config.cssFourteen,pager).click(function() {
						moveToFourteenPage(table);
						return false;
					});		

					$(config.cssFifteen,pager).click(function() {
						moveToFifteenPage(table);
						return false;
					});					
					
					
					$(config.cssSixteen,pager).click(function() {
						moveToSixteenPage(table);
						return false;
					});
										
					$(config.cssSeventeen,pager).click(function() {
						moveToSeventeenPage(table);
						return false;
					});
										
					$(config.cssEightteen,pager).click(function() {
						moveToEightteenPage(table);
						return false;
					});
										
					$(config.cssNineteen,pager).click(function() {
						moveToNineteenPage(table);
						return false;
					});
										
					$(config.cssTwenty,pager).click(function() {
						moveToTwentyPage(table);
						return false;
					});
										
					$(config.cssTwentyone,pager).click(function() {
						moveToTwentyonePage(table);
						return false;
					});
										
					$(config.cssTwentytwo,pager).click(function() {
						moveToTwentytwoPage(table);
						return false;
					});
										
					$(config.cssTwentythree,pager).click(function() {
						moveToTwentythreePage(table);
						return false;
					});
										
					$(config.cssTwentyfour,pager).click(function() {
						moveToTwentyfourPage(table);
						return false;
					});
					
					$(config.cssTwentyfive,pager).click(function() {
						moveToTwentyfivePage(table);
						return false;
					});
					
					$(config.cssTwentysix,pager).click(function() {
						moveToTwentysixPage(table);
						return false;
					});			

					$(config.cssTwentyseven,pager).click(function() {
						moveToTwentysevenPage(table);
						return false;
					});

					$(config.cssTwentyeight,pager).click(function() {
						moveToTwentyeightPage(table);
						return false;
					});		

					$(config.cssTwentynine,pager).click(function() {
						moveToTwentyninePage(table);
						return false;
					});		

					$(config.cssThirty,pager).click(function() {
						moveToThirtyPage(table);
						return false;
					});
										
					$(config.cssThirtyone,pager).click(function() {
						moveToThirtyonePage(table);
						return false;
					});
										
					$(config.cssThirtytwo,pager).click(function() {
						moveToThirtytwoPage(table);
						return false;
					});
					
					$(config.cssThirtythree,pager).click(function() {
						moveToThirtythreePage(table);
						return false;
					});
					
					$(config.cssThirtyfour,pager).click(function() {
						moveToThirtyfourPage(table);
						return false;
					});			

					$(config.cssThirtyfive,pager).click(function() {
						moveToThirtyfivePage(table);
						return false;
					});

					$(config.cssThirtysix,pager).click(function() {
						moveToThirtysixPage(table);
						return false;
					});		

					$(config.cssThirtyseven,pager).click(function() {
						moveToThirtysevenPage(table);
						return false;
					});					
					
					
					$(config.cssThirtyeight,pager).click(function() {
						moveToThirtyeightPage(table);
						return false;
					});
										
					$(config.cssThirtynine,pager).click(function() {
						moveToThirtyninePage(table);
						return false;
					});
										
					$(config.cssFourty,pager).click(function() {
						moveToFourtyPage(table);
						return false;
					});
										
					$(config.cssFourtyone,pager).click(function() {
						moveToFourtyonePage(table);
						return false;
					});
										
					$(config.cssFourtytwo,pager).click(function() {
						moveToFourtytwoPage(table);
						return false;
					});
										
					$(config.cssFourtythree,pager).click(function() {
						moveToFourtythreePage(table);
						return false;
					});
										
					$(config.cssFourtyfour,pager).click(function() {
						moveToFourtyfourPage(table);
						return false;
					});
										
					$(config.cssFourtyfive,pager).click(function() {
						moveToFourtyfivePage(table);
						return false;
					});
										
					$(config.cssFourtysix,pager).click(function() {
						moveToFourtysixPage(table);
						return false;
					});
					
					$(config.cssFourtyseven,pager).click(function() {
						moveToFourtysevenPage(table);
						return false;
					});
					
					$(config.cssFourtyeight,pager).click(function() {
						moveToFourtyeightPage(table);
						return false;
					});			

					$(config.cssFourtynine,pager).click(function() {
						moveToFourtyninePage(table);
						return false;
					});

					$(config.cssFifty,pager).click(function() {
						moveToFiftyPage(table);
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