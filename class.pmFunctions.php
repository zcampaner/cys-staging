<?php
/**
 * class.DKFSendSMS.pmFunctions.php
 *
 * ProcessMaker Open Source Edition
 * Copyright (C) 2004 - 2008 Colosa Inc.
 * *
 */

////////////////////////////////////////////////////
// DKFSendSMS PM Functions
//
// Copyright (C) 2007 COLOSA
//
// License: LGPL, see LICENSE
////////////////////////////////////////////////////

/**
 * Main responsible for sending text message via InfoBIP API.
 * This automatically strips and validates mobile number formats,
 * thus send via CURL operation and catches return http_code status.
 *
 * @param 			:mobile_number string, :message text
 * @response 		none
 * @return 			boolean
 * @since 			February 25, 2015
 * @author 			Denmark Amano Daya (handsome automation developer), code originated from Sir Jeff Lu
 * @copyright 		Security Bank Corporation
 *
 */
	// $mobile_number = $argv[1];
	// $message	   = $argv[2];

	function DKFSendSMS_doSend($mobile_number, $message)
	{
		$mobile_number = str_replace("+", "", $mobile_number); //get rid of plus sign
    
	    if ((strlen($mobile_number) == 11) && preg_match("/^0(9\d+)/", $mobile_number, $match)) 
	    {
	            $clean_mobile_number = "+63" . $match[1];
	    }
	    if ((strlen($mobile_number) == 12) && preg_match("/^639\d+/", $mobile_number)) 
	    {
	            $clean_mobile_number = "+" . $mobile_number;
	    }

		// Invoke param variable
		$params = '';

	    // Get cURL resource
	    $curl = curl_init();
	    
	    // Set some options - we are passing in a useragent too here
        $data = array(
           'strValidSender' 	=> 'SECURITYBNK',
           'strValidSMSText' 	=> urlencode($message),
           'strGSM'				=> $clean_mobile_number,
           'strDate'			=> ''
		);

	    foreach ($data as $k=>$v) 
	    {
	         $params .= $k . '=' . $v . '&';
		}
		
	    curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER 	=> 1,
			CURLOPT_URL 			=> 'http://10.2.0.149/Infobip_WebService/webservice.asmx/InfoBIPdotnet',
			CURLOPT_POST 			=> 1,
			CURLOPT_HTTPHEADER 		=> array('Content-Type: application/x-www-form-urlencoded'),
			//CURLINFO_HEADER_OUT => true, // enable tracking
			CURLOPT_POSTFIELDS 		=> $params,
		));

		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		$response_info = curl_getinfo($resp);

		// Close request to clear up some resources
		//$headerSent = curl_getinfo($curl, CURLINFO_HEADER_OUT); // request headers
		curl_close($curl);
		
		#return ($response_info['http_code'] == 200 ? true : false); 
	}

	//-----------------------------------------------------*


	

function DKFSendSMS_getMyCurrentDate()
{
	return G::CurDate('Y-m-d');
}

function DKFSendSMS_getMyCurrentTime()
{
	return G::CurDate('H:i:s');
}
