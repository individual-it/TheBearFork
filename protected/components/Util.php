<?php
	
/*  The Bear - a giant downlaoder
 
  Copyright (C) 2011 Behdad Kh.
 
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
 
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  
  http://sourceforge.net/projects/thebear/
  
*/
	
	class Util {
		
		// convert byte to human readbale value
		public static function byteToHR($value) {
			$return = null ;
			$units = array('B', 'K', 'M', 'G', 'T');
     		for ($i = 0; $value > 1024; $i++) { $value /= 1024; }
     		$return = round($value, 1).$units[$i];
			return $return ;
		}
		
		// convert human readable value to bytes
		public static function HRToByte($value) {
			// when M or K suffix do not exist, it's in bytes
			if (is_numeric($value))
				return $value ;
			
			$result = null;
			$unit=$value[strlen($value)-1] ;
			$value=substr($value,0,strpos($value,$unit));
			
			if($unit=='M')
				$result = sprintf('%d',$value * 1024 * 1024) ;
			else if ($unit=='K')
				$result = sprintf('%d',$value * 1024) ;
			else
				$result = $value ;
				
			return $result ;
		}
		
		public static function flattenArray($array) {
			$result = array();
			
			foreach($array as $key =>$val) 
				if (!is_array($val))
					$result = array_merge($result,array($key=>$val));
				else
					$result = array_merge($result,self::flattenArray($val));
					
			return $result;
		}
	}

?>
