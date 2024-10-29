<?php

function rpi_get_fields_number() {
	global $rpi_options;
	$fields_number = (!empty($rpi_options['number_of_fields']) ? $rpi_options['number_of_fields'] : '4') ;
return $fields_number ;
}

function rpi_get_amend_field_input ($i, $current_value, $user_id) {
	//amends in rpi_user_profile_field
	global $rpi_settings_dropdown ;
	$label_id = 'rpi_label'.$i ;
	//now decide whether to show text/email, dropdown field, or website
		$name1 = 'field'.$i ;
		$item1='rpi_settings_dropdown['.$name1.']' ;
		$value = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : 0) ;
			//if zero then a text field
			if ($value==0) {
			$field= '<input type="text" name="rpi_label'.$i.'" id="rpi_label'.$i.'" value="'.$current_value.'" />' ;
			}
			//if 1 then a dropdown field
			if ($value==1) {
				//display the dropdown list
				$field = rpi_get_display_dropdown_options ($i, $current_value) ;
			}
			//if 2 then an email field
			if ($value==2) {
				//display same as text field - output will make it clickable
				$field= '<input type="text" name="rpi_label'.$i.'" id="rpi_label'.$i.'" value="'.$current_value.'" />' ;
			}
			//if 3 then a wesbite field
			if ($value==3) {
				//display the website options
				$field = rpi_get_display_website_options ($i, $current_value, $user_id) ;
			}
			
			
			
			
return $field ;
}



function rpi_get_display_dropdown_options ($i,$current_value) {
	//explode the options
	global $rpi_settings_dropdown;
	$list_options = explode("\n", $rpi_settings_dropdown['fieldlist'.$i]);
	$total_options = count ($list_options) ;
	$list='<select name="rpi_label'.$i.'">' ;
	if (!empty ($current_value)) {
	 $list.='<option selected value="'.$current_value.'">'.$current_value.'</option>' ;
	}
	//array starts at zero, so start there until $total options-1
	$j=0 ;
	while ($j<= ($total_options-1))   {
		$list.=	'<option value="'.$list_options[$j].'">'.$list_options[$j].'</option>' ;
		$j++ ;
	}
	$list.=	'</select>' ;
return $list ;
}

function rpi_get_display_website_options ($i,$current_value, $user_id) {
	global $rpi_options ;
	global $rpi_settings_dropdown ;
	$name1 = 'rpi_label'.$i.'url' ;
	$current_url_value = get_user_meta( $user_id, 'rpi_label'.$i.'url',  true);
	$field = $rpi_options['item'.$i.'_label'] ;
	$field= '<input type="text" name="rpi_label'.$i.'" id="rpi_label'.$i.'" value="'.$current_value.'" />' ;
	$name1 = 'item'.$i.'_website_label' ;
	$field .= '</div><div>' ;
	$label = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : 'Enter site URL') ;
	$field.= '<label for="rpi_label'.esc_html($i).'">'.esc_html($label).'</label>' ;
	$field .= '<input type="text" name="rpi_label'.$i.'url" id="rpi_label'.$i.'url" value="'.$current_url_value.'" />' ;
	$name1 = 'field'.$i ;
	$item1='rpi_settings_dropdown['.$name1.']' ;
	$value = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : 0) ;
	$name1 = 'item'.$i.'_website_helptext' ;
	$value1 = (!empty($rpi_settings_dropdown[$name1]) ? $rpi_settings_dropdown[$name1] : 'Enter the full site URL e.g. "https://mysite.com"') ;
	$field.= '<br/><label class="description" for="rpi_settings_dropdown[item_website_label]">'.esc_html($value1).'</label>' ;
return $field ;
}




