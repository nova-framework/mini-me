<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	'accepted'			=> __d('core', 'The :attribute must be accepted.'),
	'active_url'		=> __d('core', 'The :attribute is not a valid URL.'),
	'after'				=> __d('core', 'The :attribute must be a date after :date.'),
	'alpha'				=> __d('core', 'The :attribute may only contain letters.'),
	'alpha_dash'		=> __d('core', 'The :attribute may only contain letters, numbers, and dashes.'),
	'alpha_num'			=> __d('core', 'The :attribute may only contain letters and numbers.'),
	'array'				=> __d('core', 'The :attribute must be an array.'),
	'before'			=> __d('core', 'The :attribute must be a date before :date.'),

	'between' => array(
		'numeric' 		=> __d('core', 'The :attribute must be between :min and :max.'),
		'file'			=> __d('core', 'The :attribute must be between :min and :max kilobytes.'),
		'string' 		=> __d('core', 'The :attribute must be between :min and :max characters.'),
		'array'			=> __d('core', 'The :attribute must have between :min and :max items.'),
	),

	'boolean'			=> __d('core', 'The :attribute field must be true or false'),
	'confirmed'			=> __d('core', 'The :attribute confirmation does not match.'),
	'date'				=> __d('core', 'The :attribute is not a valid date.'),
	'date_format'		=> __d('core', 'The :attribute does not match the format :format.'),
	'different'			=> __d('core', 'The :attribute and :other must be different.'),
	'digits'			=> __d('core', 'The :attribute must be :digits digits.'),
	'digits_between'	=> __d('core', 'The :attribute must be between :min and :max digits.'),
	'email'				=> __d('core', 'The :attribute format is invalid.'),
	'exists'			=> __d('core', 'The selected :attribute is invalid.'),
	'image'				=> __d('core', 'The :attribute must be an image.'),
	'in'				=> __d('core', 'The selected :attribute is invalid.'),
	'integer'			=> __d('core', 'The :attribute must be an integer.'),
	'ip'				=> __d('core', 'The :attribute must be a valid IP address.'),

	'max' => array(
		'numeric'		=> __d('core', 'The :attribute may not be greater than :max.'),
		'file'			=> __d('core', 'The :attribute may not be greater than :max kilobytes.'),
		'string'		=> __d('core', 'The :attribute may not be greater than :max characters.'),
		'array'			=> __d('core', 'The :attribute may not have more than :max items.'),
	),

	'mimes'				=> __d('core', 'The :attribute must be a file of type: :values.'),
	'min' => array(
		'numeric'		=> __d('core', 'The :attribute must be at least :min.'),
		'file'			=> __d('core', 'The :attribute must be at least :min kilobytes.'),
		'string'  		=> __d('core', 'The :attribute must be at least :min characters.'),
		'array'   		=> __d('core', 'The :attribute must have at least :min items.'),
	),

	'not_in'			=> __d('core', 'The selected :attribute is invalid.'),
	'numeric'			=> __d('core', 'The :attribute must be a number.'),
	'regex'				=> __d('core', 'The :attribute format is invalid.'),
	'required'			=> __d('core', 'The :attribute field is required.'),
	'required_if'		=> __d('core', 'The :attribute field is required when :other is :value.'),
	'required_with'		=> __d('core', 'The :attribute field is required when :values is present.'),
	'required_without'	=> __d('core', 'The :attribute field is required when :values is not present.'),
	'same'				=> __d('core', 'The :attribute and :other must match.'),

	'size' => array(
		'numeric'		=> __d('core', 'The :attribute must be :size.'),
		'file'			=> __d('core', 'The :attribute must be :size kilobytes.'),
		'string'		=> __d('core', 'The :attribute must be :size characters.'),
		'array'			=> __d('core', 'The :attribute must contain :size items.'),
	),

	'unique'			=> __d('core', 'The :attribute has already been taken.'),
	'url'				=> __d('core', 'The :attribute format is invalid.'),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
	),

);
