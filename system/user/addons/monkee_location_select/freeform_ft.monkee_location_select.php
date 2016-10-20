<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monkee_location_select_freeform_ft extends Freeform_base_ft {
	public 	$info 	= array(
		'name' 			=> 'Monk-ee Location Select',
		'version' 		=> '3.0.0', //Modified Freeform Country/Province/State Select 5.1.0
		'description' 		=> 'Modified version of the default Location Select fieldtypes (State Select, Country Select, etc).'
	);

	private $states = array();
	private $provinces = array();
	private $countries = array();
	private $ukcounties = array();
	
	public $field_content_types 	= array(
		'states',
		'provinces',
		'ukcounties',
		'countries'
	);
	
	public $javascript_events = array(
		'none',
		'onblur',
		'onchange',
		'onclick',
		'oncontextmenu',
		'ondblclick',
		'onfocus',
		'onfocusin',
		'onfocusout',
		'oninput',
		'oninvalid',
		'onkeydown',
		'onkeypress',
		'onkeyup',
		'onmousedown',
		'onmouseenter',
		'onmouseleave',
		'onmousemove',
		'onmouseover',
		'onmouseout',
		'onmouseup',
		'onreset',
		'onsearch',
		'onselect',
		'onsubmit'
	);


	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	null
	 */

	public function __construct () {
		parent::__construct();
		
		

		$this->info['name'] 		= lang('monkloc_default_field_name');
		$this->info['description'] 	= lang('monkloc_default_field_desc');
		
		// -------------------------------------
		//	parse states
		// -------------------------------------

		$states 	= array_map(
			'trim',
			preg_split(
				'/[\n\r]+/',
				lang('list_of_us_states'),
				-1,
				PREG_SPLIT_NO_EMPTY
			)
		);

		//need matching key => value pairs for the select values to be correct
		//for the output value we are removing the ' (AZ)' code for the value and the 'Arizona' code for the key
		foreach ($states as $key => $value)
		{
			$this->states[
				preg_replace('/[\w|\s]+\(([a-zA-Z\-_]+)\)$/', "$1", $value)
			] = preg_replace('/\s+\([a-zA-Z\-_]+\)$/', '', $value);
		}
		
		// -------------------------------------
		//	parse provinces
		// -------------------------------------

		$provinces 	= array_map(
			'trim',
			preg_split(
				'/[\n\r]+/',
				lang('list_of_canadian_provinces'),
				-1,
				PREG_SPLIT_NO_EMPTY
			)
		);

		//need matching key => value pairs for the select values to be correct
		//for the output value we are removing the ' (MB)' code for the value and the 'Manitoba' code for the key
		foreach ($provinces as $key => $value)
		{
			$this->provinces[
				preg_replace('/[\w|\s]+\(([a-zA-Z\-_]+)\)$/', "$1", $value)
			] = preg_replace('/\s+\([a-zA-Z\-_]+\)$/', '', $value);
		}
		
		// -------------------------------------
		//	parse uk counties
		// -------------------------------------

		$ukcounties 	= array_map(
			'trim',
			preg_split(
				'/[\n\r]+/',
				lang('list_of_uk_counties'),
				-1,
				PREG_SPLIT_NO_EMPTY
			)
		);

		//need matching key => value pairs for the select values to be correct
		//for the output value we are removing the ' (MB)' code for the value and the 'Manitoba' code for the key
		foreach ($ukcounties as $key => $value)
		{
			$this->ukcounties[
				preg_replace('/[\w|\s]+\(([a-zA-Z\-_]+)\)$/', "$1", $value)
			] = preg_replace('/\s+\([a-zA-Z\-_]+\)$/', '', $value);
		}
	}
	//END __construct
	
	// --------------------------------------------------------------------

	/**
	 * Get countries
	 *
	 * @access	public
	 * @return	mixed
	 */

	public function get_countries()
	{
		$cache = new Freeform_cacher(func_get_args(), __FUNCTION__, __CLASS__);
		if ($cache->is_set()){ return $cache->get(); }

		$output = array();

		// --------------------------------------------
		// Get countries from config
		// --------------------------------------------

		$countries_file = APPPATH . 'config/countries.php';

		if (is_file($countries_file))
		{
			include_once $countries_file;

			if ( ! empty( $countries ) )
			{
				$output = $countries;
			}
			
			foreach ($output as $key => $value) {
				$output_rev[strtoupper($key)] = $value;
			}
		}

		return $cache->set($output_rev);
	}
	// End get countries
	
	// --------------------------------------------------------------------

	/**
	 * Display Field
	 *
	 * @access	public
	 * @param	string 	saved data input
	 * @param  	array 	input params from tag
	 * @param 	array 	attribute params from tag
	 * @return	string 	display output
	 */

	public function display_field ($data = '', $params = array(), $attr = array())
	{
		if ($this->settings['field_content_type'] == 'states') {
			$list_items = $this->states;
			if ($data == '' and !isset($params['default_value'])) { $data = $this->settings['default_state']; }
		} else if ($this->settings['field_content_type'] == 'provinces') {
			$list_items = $this->provinces;
			if ($data == '' and !isset($params['default_value'])) { $data = $this->settings['default_province']; }
		} else if ($this->settings['field_content_type'] == 'ukcounties') {
			$list_items = $this->ukcounties;
			if ($data == '' and !isset($params['default_value'])) { $data = $this->settings['default_ukcounty']; }
		} else if ($this->settings['field_content_type'] == 'countries') {
			$list_items = $this->get_countries();
			if ($data == '' and !isset($params['default_value'])) { $data = $this->settings['default_country']; }
		}
		
		if ($this->settings['blank_line'] == 'y') {
			$list_items_temp = array(' ' => '');
			foreach ($list_items as $key => $value) {
				$list_items_temp[$key] = $value;
			}
			$list_items = $list_items_temp;
		}
		
		$field_options['id'] = 'freeform_' . $this->field_name;
		if ($this->settings['enable_autofocus'] == 'true') { $field_options['autofocus'] = ''; }
		if ($this->settings['field_title_text'] != '') { $field_options['title'] = $this->settings['field_title_text']; }
		
		if ($this->settings['css_content'] == "true" or $this->settings['css_name'] == "true" or $this->settings['css_type'] == "true" or $this->settings['css_custom'] != '') {
			$class = '';
			if ($this->settings['css_content'] == "true") {
				$class .= $this->settings['field_content_type']; 
			}
			if ($this->settings['css_name'] == "true") { 
				if (isset($class) and $class != '') { $class .= ' '; }
				$class .= $this->field_name; 
			}
			if ($this->settings['css_type'] == "true") {
				if (isset($class) and $class != '') { $class .= ' '; }
				$class .= lang('monkloc_default_field_type'); 
			}
			if ($this->settings['css_custom']!= '') {
				if (isset($class) and $class != '') { $class .= ' '; }
				$class .= $this->settings['css_custom'];
			}
			$field_options['class'] = $class;
		}
		
		if ($this->settings['custom_param_1'] != '') { $field_options[$this->settings['custom_param_1']] = $this->settings['custom_value_1']; }
		if ($this->settings['custom_param_2'] != '') { $field_options[$this->settings['custom_param_2']] = $this->settings['custom_value_2']; }
		if ($this->settings['custom_param_3'] != '') { $field_options[$this->settings['custom_param_3']] = $this->settings['custom_value_3']; }
		if ($this->settings['custom_param_4'] != '') { $field_options[$this->settings['custom_param_4']] = $this->settings['custom_value_4']; }
		if ($this->settings['custom_param_5'] != '') { $field_options[$this->settings['custom_param_5']] = $this->settings['custom_value_5']; }
		
		if ($this->settings['js_confirm'] == "true" and $this->settings['js_event'] != "none" and $this->settings['js_action'] != '') { $field_options[$this->settings['js_event']] = stripslashes($this->settings['js_action']); }

		
		return form_dropdown(
			$this->field_name,
			$list_items,
			(isset($list_items[$data]) ? array($data) : NULL),
			$this->stringify_attributes(array_merge(
				$field_options,
				$attr
			))
		);
		
	}
	//END display_field


	// --------------------------------------------------------------------

	/**
	 * Display Field Settings
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */

	public function validate ($data)
	{
		$data = trim($data);

		$return = TRUE;

		if ($data != '' AND ! array_key_exists($data, $this->states))
		{
			$return = lang('monkloc_invalid_state');
		}

		return $return;
	}
	//END validate


	// --------------------------------------------------------------------

	/**
	 * Save Field Data
	 *
	 * @access	public
	 * @param	string 	data to be inserted
	 * @param	int 	form id
	 * @return	string 	data to go into the entry_field
	 */

	public function save ($data)
	{
		$data = trim($data);
		return $this->validate($data) ? $data : '';
	}
	//END save
	
	// --------------------------------------------------------------------

	/**
	 * Display Field Settings
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */

	public function display_settings ($data = array())
	{
		$content_type 	= isset($data['field_content_type']) ?
							$data['field_content_type'] :
							'states';
		
		$output = "<select name=\"field_content_type\">\n";
		foreach ($this->field_content_types as $type)
		{
			$output .= "<option value=\"" . $type . "\"";
			if ($content_type == $type) { $output .= " selected"; }
			$output .= ">" . lang($type) . "</option>\n";
		}
		$output .= "</select>\n";
		
		ee()->table->add_row(
			lang('monkloc_field_content_type', 'field_content_type') .
				'<div class="subtext">' .
					lang('monkloc_field_content_type_desc') .
				'</div>',
			$output
		);
		
		//blank line
		$blank_line			= ( ! isset($data['blank_line']) OR
						$data['blank_line'] == '') ?
							'n' :
							$data['blank_line'];

		ee()->table->add_row(
			lang('monkloc_blank_line', 'blank_line') .
			'<div class="subtext">' .
				lang('monkloc_blank_line_desc') .
			'</div>',
			form_hidden('blank_line', 'n') .
			form_checkbox(array(
				'id'	=> 'blank_line',
				'name'	=> 'blank_line',
				'value'		=> 'y',
				'checked' 	=> $blank_line == 'y'
			)) .
			'&nbsp;&nbsp;' .
			lang('monkloc_blank_line', 'blank_line')
		);
		
		//default value
		$default_state		= ( ! isset($data['default_state']) OR
						$data['default_state'] == '') ?
						'' :
						$data['default_state'];
						
		$default_province		= ( ! isset($data['default_province']) OR
						$data['default_province'] == '') ?
						'' :
						$data['default_province'];
						
		$default_ukcounty		= ( ! isset($data['default_ukcounty']) OR
						$data['default_ukcounty'] == '') ?
						'' :
						$data['default_ukcounty'];
						
		$default_country		= ( ! isset($data['default_country']) OR
						$data['default_country'] == '') ?
						'' :
						$data['default_country'];
						
		$list_items = $this->states;
		$list_items_temp = array(' ' => '');
		foreach ($list_items as $key => $value) {
			$list_items_temp[$key] = $value;
		}
		$list_states = $list_items_temp;
		
		$list_items = $this->provinces;
		$list_items_temp = array(' ' => '');
		foreach ($list_items as $key => $value) {
			$list_items_temp[$key] = $value;
		}
		$list_provinces = $list_items_temp;
		
		$list_items = $this->ukcounties;
		$list_items_temp = array(' ' => '');
		foreach ($list_items as $key => $value) {
			$list_items_temp[$key] = $value;
		}
		$list_ukcounties = $list_items_temp;
		
		$list_items = $this->get_countries();
		$list_items_temp = array(' ' => '');
		foreach ($list_items as $key => $value) {
			$list_items_temp[$key] = $value;
		}
		$list_countries = $list_items_temp;
		
		$output = "<p><label for 'default_state'>".lang('states')."</label><br />\n";
		$output .= form_dropdown('default_state', $list_states, (isset($list_states[$default_state]) ? array($default_state) : NULL),
			$this->stringify_attributes(array_merge(
				array('id' => 'default_state')
			))
		);
		
		$output .= "</p><p><label for 'default_state'>".lang('provinces')."</label><br />\n";
		$output .= form_dropdown('default_province', $list_provinces, (isset($list_provinces[$default_province]) ? array($default_province) : NULL),
			$this->stringify_attributes(array_merge(
				array('id' => 'default_province')
			))
		);
		
		$output .= "</p><p><label for 'default_ukcounty'>".lang('ukcounties')."</label><br />\n";
		$output .= form_dropdown('default_ukcounty', $list_ukcounties, (isset($list_ukcounties[$default_ukcounty]) ? array($default_ukcounty) : NULL),
			$this->stringify_attributes(array_merge(
				array('id' => 'default_ukcounty')
			))
		);
		
		$output .= "</p><p><label for 'default_country'>".lang('countries')."</label><br />\n";
		$output .= form_dropdown('default_country', $list_countries, (isset($list_countries[$default_country]) ? array($default_country) : NULL),
			$this->stringify_attributes(array_merge(
				array('id' => 'default_country')
			))
		);
		
		$output .= "</p>";
								
		ee()->table->add_row(
			lang('monkloc_default_value', 'default_value') .
				'<div class="subtext">' .
					lang('monkloc_default_value_desc') .
				'</div>',
			$output
		);
		
		//autofocus
		$enable_autofocus 		= ( ! isset($data['enable_autofocus']) OR
						$data['enable_autofocus'] == '') ?
							'false' :
							$data['enable_autofocus'];
							
		ee()->table->add_row(
			lang('monkloc_enable_autofocus', 'enable_autofocus') .
			'<div class="subtext">' .
				lang('monkloc_enable_autofocus_desc') .
			'</div>',
			form_hidden('enable_autofocus', 'n') .
			form_checkbox(array(
				'id'	=> 'enable_autofocus',
				'name'	=> 'enable_autofocus',
				'value'		=> 'true',
				'checked' 	=> $enable_autofocus == 'true'
			)) .
			'&nbsp;&nbsp;' .
			lang('monkloc_enable', 'enable_autofocus')
		);
		
		//title field
		$title_value 		= ( ! isset($data['field_title']) OR
						$data['field_title'] == '') ? 'field_desc' : $data['field_title'];
						
		$title_custom_value 		= ( ! isset($data['field_title_text']) OR
						$data['field_title_text'] == '' OR $title_value != 'field_custom') ?
						'' :
						$data['field_title_text'];
						
		$output = form_radio(array('name' => 'field_title', 'id' => 'field_none', 'value' => 'none', 'checked' => ($title_value == 'none'), 'onclick' => "$('#field_title_custom').attr('disabled', '');"));
		$output .= NBS . NBS . lang('monkloc_field_none', 'field_none') . NBS . NBS . NBS . NBS . "\n";
		
		$output .= form_radio(array('name' => 'field_title', 'id' => 'field_label', 'value' => 'field_label', 'checked' => ($title_value == 'field_label'), 'onclick' => "$('#field_title_custom').attr('disabled', '');"));
		$output .= NBS . NBS . lang('monkloc_field_label', 'field_label') . NBS . NBS . NBS . NBS . "\n";
		
		$output .= form_radio(array('name' => 'field_title', 'id' => 'field_desc', 'value' => 'field_desc', 'checked' => ($title_value == 'field_desc'), 'onclick' => "$('#field_title_custom').attr('disabled', '');"));
		$output .= NBS . NBS . lang('monkloc_field_desc', 'field_desc') . NBS . NBS . NBS . NBS . "\n";
		
		$output .= form_radio(array('name' => 'field_title', 'id' => 'field_custom', 'value' => 'field_custom', 'checked' => ($title_value == 'field_custom'), 'onclick' => "$('#field_title_custom').removeAttr('disabled');"));
		$output .= NBS . NBS . lang('monkloc_field_custom', 'field_custom') . NBS . NBS . NBS . NBS . "\n";
		$output .= "<input type='text' name='field_title_custom' id='field_title_custom' placeholder='" . lang('monkloc_field_title_custom') . "' value='$title_custom_value'";
		if ($title_value != 'field_custom') { $output .= " disabled"; }
		$output .= " />\n";
		
		ee()->table->add_row(
			lang('monkloc_field_title', 'field_title') .
				'<div class="subtext">' .
					lang('monkloc_field_title_desc') .
				'</div>',
			$output
		);
		
		//css class
		$css_content 		= ( ! isset($data['css_content']) OR
						$data['css_content'] == '') ?
							'false' :
							$data['css_content'];
							
		$css_name 		= ( ! isset($data['css_name']) OR
						$data['css_name'] == '') ?
							'false' :
							$data['css_name'];
							
		$css_type 		= ( ! isset($data['css_type']) OR
						$data['css_type'] == '') ?
							'false' :
							$data['css_type'];
							
		$css_custom 		= ( ! isset($data['css_custom']) OR
						$data['css_custom'] == '') ?
						'' :
						$data['css_custom'];
							
		ee()->table->add_row(
			lang('monkloc_css_classes', 'css_classes') .
			'<div class="subtext">' .
				lang('monkloc_css_classes_desc') .
			'</div>',
			form_hidden('css_content', 'n') .
			form_checkbox(array(
				'id'	=> 'css_content',
				'name'	=> 'css_content',
				'value'		=> 'true',
				'checked' 	=> $css_content == 'true'
			)) .
			'&nbsp;&nbsp;' .
			lang('monkloc_css_content', 'css_content') .
			'&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_hidden('css_name', 'n') .
			form_checkbox(array(
				'id'	=> 'css_name',
				'name'	=> 'css_name',
				'value'		=> 'true',
				'checked' 	=> $css_name == 'true'
			)) .
			'&nbsp;&nbsp;' .
			lang('monkloc_css_name', 'css_name') .
			'&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_hidden('css_type', 'n') .
			form_checkbox(array(
				'id'	=> 'css_type',
				'name'	=> 'css_type',
				'value'		=> 'true',
				'checked' 	=> $css_type == 'true'
			)) .
			'&nbsp;&nbsp;' .
			lang('monkloc_css_type', 'css_type') .
			'&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_input(array(
				'name'		=> 'css_custom',
				'id'		=> 'css_custom',
				'value'		=> $css_custom,
				'placeholder'	=> lang('monkloc_css_custom'),
				'maxlength'	=> '250',
				'size'		=> '50',
			))
		);
		
		//custom parameters
		$custom_param_1		= ( ! isset($data['custom_param_1']) OR
						$data['custom_param_1'] == '') ?
							'' :
							$data['custom_param_1'];
							
		$custom_value_1		= ( ! isset($data['custom_value_1']) OR
						$data['custom_value_1'] == '') ?
							'' :
							$data['custom_value_1'];					
							
		$custom_param_2		= ( ! isset($data['custom_param_2']) OR
						$data['custom_param_2'] == '') ?
							'' :
							$data['custom_param_2'];
		
		$custom_value_2		= ( ! isset($data['custom_value_2']) OR
						$data['custom_value_2'] == '') ?
							'' :
							$data['custom_value_2'];
												
		$custom_param_3		= ( ! isset($data['custom_param_3']) OR
						$data['custom_param_3'] == '') ?
							'' :
							$data['custom_param_3'];
		
		$custom_value_3		= ( ! isset($data['custom_value_3']) OR
						$data['custom_value_3'] == '') ?
							'' :
							$data['custom_value_3'];
												
		$custom_param_4		= ( ! isset($data['custom_param_4']) OR
						$data['custom_param_4'] == '') ?
							'' :
							$data['custom_param_4'];
		
		$custom_value_4		= ( ! isset($data['custom_value_4']) OR
						$data['custom_value_4'] == '') ?
							'' :
							$data['custom_value_4'];
												
		$custom_param_5		= ( ! isset($data['custom_param_5']) OR
						$data['custom_param_5'] == '') ?
							'' :
							$data['custom_param_5'];					
		
		$custom_value_5		= ( ! isset($data['custom_value_5']) OR
						$data['custom_value_5'] == '') ?
							'' :
							$data['custom_value_5'];	
		
		ee()->table->add_row(
			lang('monktext_custom_params', 'custom_params') .
			'<div class="subtext">' .
				lang('monktext_custom_params_desc') .
			'</div>',
			'<p>'.
			form_input(array(
				'name'		=> 'custom_param_1',
				'id'		=> 'custom_param_1',
				'value'		=> $custom_param_1,
				'placeholder'	=> lang('monktext_custom_place'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)) . '&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_input(array(
				'name'		=> 'custom_value_1',
				'id'		=> 'custom_value_1',
				'value'		=> $custom_value_1,
				'placeholder'	=> lang('monktext_custom_value'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)) . '</p><p>' .
			form_input(array(
				'name'		=> 'custom_param_2',
				'id'		=> 'custom_param_2',
				'value'		=> $custom_param_2,
				'placeholder'	=> lang('monktext_custom_place'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)) . '&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_input(array(
				'name'		=> 'custom_value_2',
				'id'		=> 'custom_value_2',
				'value'		=> $custom_value_2,
				'placeholder'	=> lang('monktext_custom_value'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)). '</p><p>' .
			form_input(array(
				'name'		=> 'custom_param_3',
				'id'		=> 'custom_param_3',
				'value'		=> $custom_param_3,
				'placeholder'	=> lang('monktext_custom_place'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)) . '&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_input(array(
				'name'		=> 'custom_value_3',
				'id'		=> 'custom_value_3',
				'value'		=> $custom_value_3,
				'placeholder'	=> lang('monktext_custom_value'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)). '</p><p>' .
			form_input(array(
				'name'		=> 'custom_param_4',
				'id'		=> 'custom_param_4',
				'value'		=> $custom_param_4,
				'placeholder'	=> lang('monktext_custom_place'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)) . '&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_input(array(
				'name'		=> 'custom_value_4',
				'id'		=> 'custom_value_4',
				'value'		=> $custom_value_4,
				'placeholder'	=> lang('monktext_custom_value'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)). '</p><p>' .
			form_input(array(
				'name'		=> 'custom_param_5',
				'id'		=> 'custom_param_5',
				'value'		=> $custom_param_5,
				'placeholder'	=> lang('monktext_custom_place'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)) . '&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_input(array(
				'name'		=> 'custom_value_5',
				'id'		=> 'custom_value_5',
				'value'		=> $custom_value_5,
				'placeholder'	=> lang('monktext_custom_value'),
				'maxlength'	=> '250',
				'size'		=> '50',
			)) . '</p>'
		);
		
		//javascript
		$js_confirm	= ( ! isset($data['js_confirm']) OR
						$data['js_confirm'] == '') ?
							'false' :
							$data['js_confirm'];
							
		$js_event 	= isset($data['js_event']) ?
							$data['js_event'] :
							'none';
							
		$js_action 		= ( ! isset($data['js_action']) OR
						$data['js_action'] == '') ?
						'' :
						$data['js_action'];
		
		$output = "<select name=\"js_event\" id=\"js_event\"";
		if ($js_confirm == "false") { $output .= ' disabled'; }
		$output .= ">\n";
		foreach ($this->javascript_events as $event)
		{
			$output .= "<option value=\"" . $event . "\"";
			if ($js_confirm == "true") { if ($js_event == $event) { $output .= " selected"; } }
			$output .= ">" . $event . "</option>\n";
		}
		$output .= "</select>\n";
		
		$text_field = array(
			'name'		=> 'js_action',
			'id'		=> 'js_action',
			'value'		=> $js_action,
			'placeholder'	=> lang('monkloc_js_action'),
			'maxlength'	=> '250',
			'size'		=> '50'
		);
		
		if ($js_confirm == "false") { $text_field['disabled'] = ''; }
		
		ee()->table->add_row(
			lang('monkloc_js_event', 'js_event') .
				'<div class="subtext">' .
					lang('monkloc_js_event_desc') .
				'</div>',
			form_hidden('js_confirm', 'n') .
			form_checkbox(array(
				'id'	=> 'js_confirm',
				'name'	=> 'js_confirm',
				'value'		=> 'true',
				'checked' 	=> $js_confirm == 'true',
				'onclick'	=> "$('#js_event, #js_action').attr('disabled',!$('#js_event').attr('disabled'))"
			)) .
			'&nbsp;&nbsp;' .
			lang('monkloc_js_confirm', 'js_confirm') .
			'<br /><br />' .
			$output .
			'&nbsp;&nbsp;&nbsp;&nbsp;' .
			form_input($text_field)
		);
	}
	//END display_settings
	
	// --------------------------------------------------------------------

	/**
	 * Save Field Settings
	 *
	 * @access	public
	 * @return	string
	 */

	public function save_settings ($data = array())
	{

		//field content type. only valid if in the list
		$field_content_type = ee()->input->get_post('field_content_type');
		$field_content_type = in_array(
			$field_content_type,
			$this->field_content_types) ?
				$field_content_type :
				'any';
				
		$field_title = ee()->input->get_post('field_title');
		if ($field_title == 'field_label') {
			$title = ee()->input->get_post('field_label'); 
		} else if ($field_title == 'field_desc') {
			$title = ee()->input->get_post('field_description'); 
		} else if ($field_title == 'field_custom') {
			$title = ee()->input->get_post('field_title_custom');
		} else {
			$title = '';
		}
				
		return array(
			'field_content_type' => $field_content_type,
			'blank_line' => ee()->input->get_post('blank_line') == 'n' ? 'n' : 'y',
			'default_state' => ee()->input->get_post('default_state'),
			'default_province' => ee()->input->get_post('default_province'),
			'default_ukcounty' => ee()->input->get_post('default_ukcounty'),
			'default_country' => ee()->input->get_post('default_country'),
			'enable_autofocus' => ee()->input->get_post('enable_autofocus') == 'n' ? 'false' : 'true',
			'field_title' => ee()->input->get_post('field_title'),
			'field_title_text' => $title,
			'css_content' => ee()->input->get_post('css_content') == 'n' ? 'false' : 'true',
			'css_name' => ee()->input->get_post('css_name') == 'n' ? 'false' : 'true',
			'css_type' => ee()->input->get_post('css_type') == 'n' ? 'false' : 'true',
			'css_custom' => ee()->input->get_post('css_custom'),
			'custom_param_1' => ee()->input->get_post('custom_param_1'),
			'custom_value_1' => ee()->input->get_post('custom_value_1'),
			'custom_param_2' => ee()->input->get_post('custom_param_2'),
			'custom_value_2' => ee()->input->get_post('custom_value_2'),
			'custom_param_3' => ee()->input->get_post('custom_param_3'),
			'custom_value_3' => ee()->input->get_post('custom_value_3'),
			'custom_param_4' => ee()->input->get_post('custom_param_4'),
			'custom_value_4' => ee()->input->get_post('custom_value_4'),
			'custom_param_5' => ee()->input->get_post('custom_param_5'),
			'custom_value_5' => ee()->input->get_post('custom_value_5'),
			'js_confirm' => ee()->input->get_post('js_confirm') == 'n' ? 'false' : 'true',
			'js_event' => ee()->input->get_post('js_event'),
			'js_action' => ee()->input->get_post('js_action')
		);
	}
	//END save_settings

}
//END class Monkee_location_select_freeform_ft
