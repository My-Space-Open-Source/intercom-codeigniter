<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Library for integration with Intercom.IO REST services
 * @author : Team My-Space
 * @version : 0.1
 */

class Intercom {
	public $debug=FALSE;

	function Intercom()
	{
		log_message('Debug', 'Intercom class is loaded.');
	}

	// function __call($name,$arguments)
	// {
	// 	call_user_func_array(array($this->instance, $name), $arguments);
	// }

	/**
	 *	Helper function to perform request to server and return the response
	 */
	private function getResponse($endPoint,$httpMethod,$parameters=NULL){
		$CI = & get_instance();
		$parameters=json_encode($parameters);
		$CI->curl->create('https://api.intercom.io/'.$endPoint);
		$CI->curl->http_login(INTERCOM_APPID,INTERCOM_KEY,'BASIC');
		$CI->curl->options([
			CURLOPT_CUSTOMREQUEST=>$httpMethod,
			CURLOPT_POSTFIELDS=>$parameters,
			CURLOPT_VERBOSE=>$this->debug,
			CURLOPT_FAILONERROR=>FALSE,	
			CURLOPT_RETURNTRANSFER=>TRUE,
			CURLOPT_HTTPHEADER =>[
				'Content-Type: application/json',
				"Accept: application/json",                                   
    			'Content-Length: ' . strlen($parameters)
			],
			// CURLOPT_COOKIE=>implode(';', $cookies),
			CURLOPT_USERAGENT=>"Intercom-CodeIgniter PHP 0.1",
		]);
		log_message('Debug', 'Sending HTTP Request to Intercom.');
		$Result = $CI->curl->execute();
		log_message('Debug', 'HTTP Response received from Intercom.');
		if($this->debug){
			die($parameters.PHP_EOL.$Result.PHP_EOL.print_r($CI->curl->info,TRUE));
		}
		$Result=json_decode($Result,TRUE);
		if($CI->curl->info['http_code']!=200)
			throw new Exception($Result['errors'][0]['message'],$Result['errors'][0]['code']);
		return $Result;
	}
	/**
	 *	Get List of companies
	 * @param page [Required : no] 			what page of results to fetch defaults to first page.
	 * @param per_page [Required : no] 		how many results per page defaults to 50, max is 50.
	 * @param order [Required : no] 		asc or desc. Return the users in ascending or descending order. defaults to desc.
	 * @param sort [Required : no] 			what field to sort the results by. Valid values: created_at, updated_at, signed_up_at.
	 * @param created_since  [Required : no]	limit results to users that were created in that last number of days.
	 */
	function getCompanies($parameters){
		$endPoint='companies';
		if($parameters)
			$endPoint.='?'.http_build_query($parameters, NULL, '&');
		return $this->getResponse($endPoint,'GET');
	}
	/**
	 *	Update specified company record at Intercom
	 */
	function setCompany($company){
		return $this->getResponse('companies','POST',$company);
	}
	/**
	 *	Get List of users
	 * @param page [Required : no] 			what page of results to fetch defaults to first page.
	 * @param per_page [Required : no] 		how many results per page defaults to 50, max is 50.
	 * @param order [Required : no] 		asc or desc. Return the users in ascending or descending order. defaults to desc.
	 * @param sort [Required : no] 			what field to sort the results by. Valid values: created_at, updated_at, signed_up_at.
	 * @param created_since  [Required : no]	limit results to users that were created in that last number of days.
	 */
	function getUsers($parameters=FALSE){
		$endPoint='users';
		if($parameters)
			$endPoint.='?'.http_build_query($parameters, NULL, '&');
		return $this->getResponse($endPoint,'GET');
	}
	/**
	 *	Get specific user
	 */
	function getUser($parameter){
		switch(key($parameter)){
			case 'id':
				$endPoint='users/'.current($parameter);
			break;
			case 'email':
				$endPoint='users?email='.current($parameter);
			break;
			case 'user_id':
				$endPoint='users?user_id='.current($parameter);
			break;
		}
		return $this->getResponse($endPoint,'GET');
	}
	/**
	 *	Update specified company record at Intercom
	 */
	function setUser($user){
		return $this->getResponse('users','POST',$user);
	}
	/**
	 *	Get List of tags
	 * @param page [Required : no] 			what page of results to fetch defaults to first page.
	 * @param per_page [Required : no] 		how many results per page defaults to 50, max is 50.
	 * @param order [Required : no] 		asc or desc. Return the tags in ascending or descending order. defaults to desc.
	 * @param sort [Required : no] 			what field to sort the results by. Valid values: created_at, updated_at, signed_up_at.
	 * @param created_since  [Required : no]	limit results to tags that were created in that last number of days.
	 */
	function getTags($parameters=FALSE){
		$endPoint='tags';
		if($parameters)
			$endPoint.='?'.http_build_query($parameters, NULL, '&');
		return $this->getResponse($endPoint,'GET');
	}
	/**
	 *	Remove specified tag
	 * @param id [Required : yes] 			uniquely identify tag.
	 */
	function removeTag($id){
		$endPoint='tags/'.$id;
		return $this->getResponse($endPoint,'DELETE');
	}
	/**
	 *	Create/Update specified tag on Intercom
	 */
	function setTag($tag){
		return $this->getResponse('tags','POST',$tag);
	}
}