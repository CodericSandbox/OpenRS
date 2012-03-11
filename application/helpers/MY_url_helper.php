<?php
	function url_title($str, $separator = 'dash', $lowercase = FALSE)
	{
//		if (UTF8_ENABLED)
//		{
//		        $CI =& get_instance();
//		        $CI->load->helper('text');
//echo "1".$str."<br>";
//		        $str = utf8_decode($str);
//echo "2".$str."<br>";
//		        $str = preg_replace_callback('/(.)/', 'convert_accented_characters', $str);            
//echo "3".$str."<br>";
//		}
		
		if ($separator == 'dash')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}

		$trans = array(
		        '&\#\d+?;'                    => '',
		        '&\S+?;'                    => '',
		        '\s+|/+'                    => $separator,
		        '[^\p{L}\p{Nd}0-9\-\._]'            => '',
		        $separator.'+'                => $separator,
		        '^[-_]+|[-_]+$'                => '',
		        '\.+$'                        => ''
		);  

		$str = strip_tags($str);
//echo "4".$str."<br>";

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#iu", $val, $str);
		}
echo "5".$str."<br>";

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}
echo "6".$str."<br>";

		return trim(stripslashes($str));
	}
