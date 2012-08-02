<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

  <?php
 	$pg        = isset($pg) ? $pg : 1;
 	$total_pgs = isset($total_pgs) ? $total_pgs : 1;
 	$prevpg    = ( $total_pgs - 1 > 0 ) ? $pg - 1 : false;
 	$nextpg    = ( $total_pgs > $pg )   ? $pg + 1 : false;
    $pagination= false;
 
 	if ($prevpg)
 	{
 		$pagination .=  '<a class="page prev" href="" alt="next" onclick="return selectTrainingPage(\'';
 		$pagination .= $prevpg;
 		$pagination .= "'" . ');"></a>';
 	}
    
    
    for ($i=1; $i<=($total_pgs); $i++) {
		$selected = ($i == $pg) ? 'selected' : false;
  		$href="";
  		$onclick = "return selectTrainingPage('$i');";
  				
		if ($selected) {
			$pagination .= '<span class="page selected">'.$i.'</span>';
		}
		elseif ($i < 10 OR $total_pgs < 26 ) {
 		
           $pagination .= '<a class="page" onclick="'.$onclick.'" href="#" alt="page '.$i.'">'.$i.'</a>';
   		}
     	elseif ($i == 10)
     	{
         	$pagination .= '<span class="page ellipses"> ... </span>';
         	if ($i < $total_pgs -10 OR  $i > $pg)
         	{
          		$i = $total_pgs - 10;
          	}
        	else 
         	{
         		$i = $pg-1;
         	} 
     	}
     	elseif ($pg < 10 AND $i < $pg + 10)
     	{
       		$pagination .= '<a class="page" onclick="'.$onclick.'" href="#" alt="page '.$i.'">'.$i.'</a>';
       	}  
      	elseif ($pg > 10 AND $i < $pg + 10)
     	{
            $pagination .= '<a class="page" onclick="'.$onclick.'" href="#" alt="page '.$i.'">'.$i.'</a>';
       	} 
 	    elseif ($pg < 10 AND $i > $pg+10 ) {
    		$pagination .= '<a class="page $selected" onclick="'.$onclick.'" href="#" alt="page '.$i.'">'.$i.'</a>';
    		$pg = $total_pgs+1;
     	} 
        elseif ($pg > 10 AND $i > $pg+10 ) {
    		$pagination .=  '<a class="page $selected" onclick="'.$onclick.'" href="#" alt="page '.$i.'">&#9654;</a>';
    		$pg = $total_pgs+2;
     	}

 	}
 	if ($nextpg)
 	{
 		$pagination .=  '<a class="page next" href="" alt="next" onclick="return selectTrainingPage(\'';
 		$pagination .= $nextpg;
 		$pagination .= "'" . ');"></a>';
 	}
	return $pagination;
 ?>