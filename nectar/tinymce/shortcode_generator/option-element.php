<?php 
	
function nectar_option_element( $name, $attr_option, $type, $shortcode ){
	
	$option_element = null;
	
	(isset($attr_option['desc']) && !empty($attr_option['desc'])) ? $desc = '<p class="description">'.$attr_option['desc'].'</p>' : $desc = '';
		
	switch( $attr_option['type'] ){
		
	case 'radio':
	    
		$option_element .= '<div class="label"><strong>'.$attr_option['title'].': </strong></div><div class="content">';
	    foreach( $attr_option['opt'] as $val => $title ){
	    
		(isset($attr_option['def']) && !empty($attr_option['def'])) ? $def = $attr_option['def'] : $def = '';
		
		 $option_element .= '
			<label for="shortcode-option-'.$shortcode.'-'.$name.'-'.$val.'">'.$title.'</label>
		    <input class="attr" type="radio" data-attrname="'.$name.'" name="'.$shortcode.'-'.$name.'" value="'.$val.'" id="shortcode-option-'.$shortcode.'-'.$name.'-'.$val.'"'. ( $val == $def ? ' checked="checked"':'').'>';
	    }
		
		$option_element .= $desc . '</div>';
		
	    break;
		
	case 'checkbox':
		
		$option_element .= '<div class="label"><label for="' . $name . '"><strong>' . $attr_option['title'] . ': </strong></label></div>    <div class="content"> <input type="checkbox" class="' . $name . '" id="' . $name . '" />'. $desc. '</div> ';
		
		break;	
	
	case 'select':
		
		$option_element .= '
		<div class="label"><label for="'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		
		<div class="content"><select id="'.$name.'">';
			$values = $attr_option['values'];
			foreach( $values as $value ){
		    	$option_element .= '<option value="'.$value.'">'.$value.'</option>';
			}
		$option_element .= '</select>' . $desc . '</div>';
		
		break;
	
	case 'regular-select':
		
		$option_element .= '
		<div class="label"><label for="'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		
		<div class="content"><select id="'.$name.'">';
			$values = $attr_option['values'];
			foreach( $values as $k => $v ){
		    	$option_element .= '<option value="'.$k.'">'.$v.'</option>';
			}
		$option_element .= '</select>' . $desc . '</div>';
		
		break;
		
	case 'icons':
		
		$option_element .= '

		<div class="icon-option">';
			$values = $attr_option['values'];
			foreach( $values as $value ){
		    	$option_element .= '<i class="'.$value.'"></i>';
			}
		$option_element .= $desc . '</div>';
		
		break;
		
	case 'custom':
 
		if( $name == 'tabs' ){
			$option_element .= '
			<div class="shortcode-dynamic-items" id="options-item" data-name="item">
				<div class="shortcode-dynamic-item">
					<div class="label"><label><strong>Title: </strong></label></div>
					<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
					<div class="label"><label><strong>Tab Content: </strong></label></div>
					<div class="content"><textarea class="shortcode-dynamic-item-text" type="text" name="" /></textarea></div>
				</div>
			</div>
			<a href="#" class="btn yellow remove-list-item">'.__('Remove Tab', NECTAR_THEME_NAME ). '</a> <a href="#" class="btn yellow add-list-item">'.__('Add Tab', NECTAR_THEME_NAME ).'</a>';
			
		}

		if( $name == 'toggles' ){
			$option_element .= '
			
			<div class="shortcode-dynamic-items" id="options-item" data-name="item">
			
				<div class="label"><label><strong>Turn into accordion?</strong>:</label></div>
				<div class="content">
					<input id="shortcode-option-carousel" class="accordion" type="checkbox" name="accordion">
				</div>
				<div class="clear"></div>

				<div class="shortcode-dynamic-item">
					<div class="label"><label><strong>Title: </strong></label></div>
					<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
					<div class="label"><label><strong>Tab Content: </strong></label></div>
					<div class="content"><textarea class="shortcode-dynamic-item-text" type="text" name="" /></textarea></div>
				</div>
			</div>
			<a href="#" class="btn yellow remove-list-item">'.__('Remove Toggle', NECTAR_THEME_NAME ). '</a> <a href="#" class="btn yellow add-list-item">'.__('Add Toggle', NECTAR_THEME_NAME ).'</a>';
			
		}  
		
		elseif( $name == 'bar_graph' ){
			$option_element .= '
			<div class="shortcode-dynamic-items" id="options-item" data-name="item">
				<div class="shortcode-dynamic-item">
					<div class="label"><label><strong>Title: </strong></label></div>
					<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
					<div class="label"><label><strong>Bar Percent: </strong></label></div>
					<div class="content dd-percent"><input class="shortcode-dynamic-item-input percent" data-slider="true"  data-slider-range="1,100" data-slider-step="1" type="text" name=""  value="" /></div><div class="clear no-border"></div>
					<div class="label"><label><strong>Color: </strong></label></div>
					<div class="content">
						<select class="dynamic-select" id="color">
							<option value="Accent-Color">Accent-Color</option>
							<option value="Extra-Color-1">Extra-Color-1</option>
							<option value="Extra-Color-2">Extra-Color-2</option>
							<option value="Extra-Color-3">Extra-Color-3</option>
						</select>
					</div>
				</div>
			</div>
			<a href="#" class="btn yellow remove-list-item">'.__('Remove Bar', NECTAR_THEME_NAME ). '</a> <a href="#" class="btn yellow add-list-item">'.__('Add Bar', NECTAR_THEME_NAME ).'</a>';
			
		} 
		
		elseif( $name == 'testimonials' ){
			$option_element .= '
			
			<div class="label"><label for="shortcode-option-autorotate"><strong>Autorotate?: </strong></label></div>
			<div class="content"><input class="attr" type="text" data-attrname="autorotate" value="" />If you would like this to autorotate, enter the rotation speed in <b>miliseconds</b> here. i.e 5000</div>
			
			<div class="clear"></div>
			
			<div class="shortcode-dynamic-items testimonials" id="options-item" data-name="testimonial">
				<div class="shortcode-dynamic-item">
					<div class="label"><label><strong>Name: </strong></label></div>
					<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
					<div class="label"><label><strong>Quote: </strong></label></div>
					<div class="content"><textarea class="quote" name="quote"></textarea></div>
				</div>
			</div>

			<a href="#" class="btn yellow remove-list-item">'.__('Remove Testimonial', NECTAR_THEME_NAME ). '</a> <a href="#" class="btn yellow add-list-item">'.__('Add Testimonial', NECTAR_THEME_NAME ).'</a>';
			
		} 
		
		elseif( $name == 'image' ){
			$option_element .= '
				<div class="shortcode-dynamic-item" id="options-item" data-name="image-upload">
					<div class="label"><label><strong> '.$attr_option['title'].' </strong></label></div>
					<div class="content">
					
					 <input type="hidden" id="options-item"  />
			         <img class="redux-opts-screenshot" id="image_url" src="" />
			         <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);"class="redux-opts-upload button-secondary" rel-id="">' . __('Upload', NECTAR_THEME_NAME) . '</a>
			         <a href="javascript:void(0);" class="redux-opts-upload-remove" style="display: none;">' . __('Remove Upload', NECTAR_THEME_NAME) . '</a>';
					
					if(!empty($desc)) $option_element .= $desc;
					
					$option_element .='
					</div>
				</div>';
		}

		elseif( $name == 'poster' ){
			$option_element .= '
				<div class="shortcode-dynamic-item" id="options-item" data-name="image-upload">
					<div class="label"><label><strong> '.$attr_option['title'].' </strong></label></div>
					<div class="content">
					
					 <input type="hidden" id="options-item"  />
			         <img class="redux-opts-screenshot" id="poster" src="" />
			         <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);"class="redux-opts-upload button-secondary" rel-id="">' . __('Upload', NECTAR_THEME_NAME) . '</a>
			         <a href="javascript:void(0);" class="redux-opts-upload-remove" style="display: none;">' . __('Remove Upload', NECTAR_THEME_NAME) . '</a>';
					
					if(!empty($desc)) $option_element .= $desc;
					
					$option_element .='
					</div>
				</div>';
		}

		elseif( $name == 'color' ){
			
			if(get_bloginfo('version') >= '3.5') {
	           $option_element .= '
	           <div class="label"><label><strong>Background Color: </strong></label></div>
			   <div class="content"><input type="text" value="" class="popup-colorpicker" style="width: 70px;" data-default-color=""/></div>';
	        } else {
	           $option_element .='You\'re using an outdated version of WordPress. Please update to use this feature.';
	        }	
				
		}
		
		elseif( $name == 'clients' ){
			$option_element .= '
			<div class="shortcode-dynamic-items clients" id="options-item" data-name="item">
			    
				<div class="label"><label><strong>Columns</strong>:</label></div>
				<div class="content">
					<label for="shortcode-option-button-2-col" class="inline">Two</label>
					<input id="shortcode-option-button-2-col" class="attr" type="radio" value="2" name="client_columns[]" data-attrname="columns">
					<label for="shortcode-option-button-3-col" class="inline">Three</label>
					<input id="shortcode-option-button-3-col" class="attr" type="radio" value="3" name="client_columns[]" data-attrname="columns">
					<label for="shortcode-option-button-4-col" class="inline">Four</label>
					<input id="shortcode-option-button-4-col" class="attr" type="radio" value="4" name="client_columns[]" data-attrname="columns">
					<label for="shortcode-option-button-5-col" class="inline">Five</label>
					<input id="shortcode-option-button-5-col" class="attr" type="radio" value="5" name="client_columns[]" data-attrname="columns">
					<label for="shortcode-option-button-6-col" class="inline">Six</label>
					<input id="shortcode-option-button-6-col" class="attr" type="radio" value="6" name="client_columns[]" data-attrname="columns">
				</div>
				
				<div class="clear"></div>
				
				<div class="label"><label><strong>Fade In One by One?</strong>:</label></div>
				<div class="content">
					<input id="shortcode-option-carousel" class="fade_in_animation" type="checkbox" name="fade_in_animation">
				</div>
				
				<div class="clear"></div>
				
				<div class="label"><label><strong>Turn Into Carousel?</strong>:</label></div>
				<div class="content">
					<input id="shortcode-option-carousel" class="carousel" type="checkbox" name="carousel">
				</div>
				
				<div class="clear"></div>
				
				<div class="shortcode-dynamic-item">
					<div class="label"><label><strong>Client Image: </strong></label></div>
					<div class="content">
					
					 <input type="hidden" id="options-item"  />
			         <img class="redux-opts-screenshot" id="redux-opts-screenshot-" src="" />
			         <a data-update="Select File" data-choose="Choose a File" href="javascript:void(0);"class="redux-opts-upload button-secondary" rel-id="">' . __('Upload', NECTAR_THEME_NAME) . '</a>
			         <a href="javascript:void(0);" class="redux-opts-upload-remove" style="display: none;">' . __('Remove Upload', NECTAR_THEME_NAME) . '</a>
					
					</div>
					<div class="clear"></div>
					<div class="label"><label><strong>Client URL</strong> (optional):</label></div>
					<div class="content"><input class="shortcode-dynamic-item-input" type="text" name="" value="" /></div>
					
				</div>
			</div>
			<a href="#" class="btn yellow remove-list-item">'.__('Remove Client', NECTAR_THEME_NAME ). '</a> <a href="#" class="btn yellow add-list-item">'.__('Add Client', NECTAR_THEME_NAME ).'</a>';
			
		} 
		
		elseif( $type == 'checkbox' ){
			$option_element .= '<div class="label"><label for="' . $name . '"><strong>' . $attr_option['title'] . ': </strong></label></div>    <div class="content"> <input type="checkbox" class="' . $name . '" id="' . $name . '" />' . $desc . '</div> ';
		} 
	
		
		break;
		
	case 'textarea':
		$option_element .= '
		<div class="label"><label for="shortcode-option-'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		<div class="content"><textarea data-attrname="'.$name.'"></textarea> ' . $desc . '</div>';
		break;
			
	case 'text':
	default:
	    $option_element .= '
		<div class="label"><label for="shortcode-option-'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		<div class="content"><input class="attr" type="text" data-attrname="'.$name.'" value="" />' . $desc . '</div>';
	    break;
    }
	
	$option_element .= '<div class="clear"></div>';
    
    return $option_element;
}

?>