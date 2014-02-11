<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('Thai_date') ) 
{
	function Thai_date($daytime)
	{
		//2013-5-29 01:01:01
		if($daytime!="")
		{

			$daytimeArr = explode(" ", $daytime);
			//date 
			$day= explode("-", $daytimeArr[0]);
			$thyear ="0".$day[0];
			if(strlen($day[1])==1)
			{
				$month = "0".$day[1];
			}
			else
			{
				$month = $day[1];
			}

			if(strlen($day[2])==1)
			{
				$thday = "0".$day[2];
			}
			else
			{
				$thday = $day[2];
			}

		    //$thMonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน",
		     //                "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		    
		    $thMonth = array("","ม.ค.","ก.พ.","มี.ค.","ม.ย.","พ.ค.","มิ.ย.",
		                     "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

		    if(substr($month, 0,1)==0)
		    {
		    	$month=substr($month,1);
		    }


		    $thyear +=543;
		    $Resultday = $thday." ".$thMonth[$month]." ".$thyear;  

		    //time
		    $time = explode(":", $daytimeArr[1]);
		   	$thtime = $time[0].".".$time[1]." น.";

		    return $arrayName = array('date' => $Resultday,'time' => $thtime);;
		}
		else
		{
			return "";
		}
	}
}
if ( !function_exists('generate_password') ) 
{
	function generate_password($length=6) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$password = '';
		for ( $i = 0; $i < $length; $i++ ){
			$password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $password;
	}
}
if ( !function_exists('img_resize') ) 
{
	function img_resize($url=null,$height=null,$width=null) {
		return $url;
	}
}