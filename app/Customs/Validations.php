<?php

namespace App\Custom;

class Validations
{
	/*
	* function static rules for all rules
	* params none
	*/
	private static function rules()
	{
		return [
			'name' 					=>  'max:50|regex:/(^[a-zA-Z0-9 \-\&]+$)/u',
			'first_name' 			=>  'min:3|max:25|regex:/(^[a-zA-Z0-9 ]+$)/u',
			'alpha' 			    =>  'min:3|max:50|regex:/(^[a-zA-Z ]+$)/u',
			'last_name' 			=>  'max:25|regex:/(^[a-zA-Z0-9 ]+$)/u',
			'photo' 				=>  'image|mimes:jpeg,jpg,png|max:2000',
			'media' 				=>  'image|mimes:jpeg,jpg,png|max:10000',
			'excel' 				=>  'mimes:csv,txt,xlsx|max:500000',
			'pdf' 				    =>  'mimes:pdf|max:500000',
			'phone' 				=>  'min:6|max:10|regex:/^[0-9-]+$/',
			'username'				=>  'min:3|max:50|regex:/^[0-9A-Za-z.\_\-]+$/',
			'dob'					=>  'date_format:"'.env('DATE_FORMAT_PHP', 'm/d/Y').'"',
			'zip'					=>  'min:3|max:10||regex:/(^[a-zA-Z0-9]+$)/u',
			'password'				=>  
			'string|max:25|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Z][A-Za-z\d@$!%*?&]{7,}$/',
			'url'					=>  'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-])\/?$/',
			'integer'	            =>  'max:5|regex:/^[1-9]\d*$/',
			'float' 				=>  'numeric|max:999999.99|regex:/^[0-9.]+$/',
			'amount' 				=>  'numeric|min:1|max:999999.99|regex:/^[0-9.]+$/',
			'quantity' 				=>  'max:6|regex:/^[0-9.]+$/',
			'mobile_number' 	    =>  'min:10|max:10|regex:/^[0-9-]+$/',
			'email'					=>  'string|email|max:100',
			'number'				=>  'numeric',
			'attachment'            =>  'max:10240',
			'date'                  =>  'date',
			'status'                =>  'max:1|regex:/^[0-9]+$/',
			'code'				    =>  'min:4|max:10|regex:/^[0-9A-Za-z.\_\-]+$/',
			'subject'				=>  'min:5|max:50',
		];
	}

	/*
	* function getRule to get from rules() function
	* params string $name, bool $required
	*/
	public static function getRule($name, $required, $nullable)
	{
		return ($required ? 'required|' : '') . ($nullable ? 'nullable|' : '') . (array_key_exists($name, static::rules()) ? static::rules()[$name] : '');
	}
}
