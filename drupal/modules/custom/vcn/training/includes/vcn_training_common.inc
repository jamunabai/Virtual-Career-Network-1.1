<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
/*
 * Common Training functions and rest Class
 */
 
	function vcn_sanity_check ( &$errors, $vars, $valid ) 
	{
   		foreach ($valid as $key=>$type)
		{
			if ($type == 'key')
			{
	 	 		if (!array_key_exists($key,$vars) OR !$vars[$key] ) 
		 		{
 					$errors[] = 'Select a '.vcn_key_labels($key);
					return false;
  				}
			} 
		}
		return true;
	}
	
	function vcn_key_labels ($key)
	{
		$text = '';
		switch ($key)
		{
			case 'program_id':
				$text = 'program';
			break;
 			break;
			case 'cert_id':
				$text = 'certification';
			break;
		 	break;
			case 'licenseid':
				return 'License';
			break;
			case 'vhs':
				$text = 'virtual high school';
			break;
			default:
				$text = $key;
		}
		return  $text ;
	}
 
	
 
 