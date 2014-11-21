<?php

// load wordpress
require_once('get_wp.php');

class krown_shortcodes
{
	var	$conf;
	var	$popup;
	var	$params;
	var	$shortcode;
	var $cparams;
	var $cshortcode;
	var $popup_title;
	var $no_preview;
	var $has_child;
	var	$output;
	var	$errors;

	// --------------------------------------------------------------------------

	function __construct( $popup )
	{	
		if( file_exists( dirname(__FILE__) . '/config.php' ) )
		{
			$this->conf = dirname(__FILE__) . '/config.php';
			$this->popup = $popup;
			
			$this->formate_shortcode();
		}
		else
		{
			$this->append_error('Config file does not exist');
		}
	}
	
	// --------------------------------------------------------------------------
	
	function formate_shortcode()
	{
		// get config file
		require_once( $this->conf );
		
		if( isset( $krown_shortcodes[$this->popup]['child_shortcode'] ) )
			$this->has_child = true;
		
		if( isset( $krown_shortcodes ) && is_array( $krown_shortcodes ) )
		{
			// get shortcode config stuff
			$this->params = isset( $krown_shortcodes[$this->popup]['params'] ) ? $krown_shortcodes[$this->popup]['params'] : 'no-param';
			$this->shortcode = $krown_shortcodes[$this->popup]['shortcode'];
			$this->popup_title = $krown_shortcodes[$this->popup]['popup_title'];
			
			// adds stuff for js use			
			$this->append_output( "\n" . '<div id="_krown_shortcode" class="hidden">' . $this->shortcode . '</div>' );
			$this->append_output( "\n" . '<div id="_krown_popup" class="hidden">' . $this->popup . '</div>' );
			
			if( isset( $krown_shortcodes[$this->popup]['no_preview'] ) && $krown_shortcodes[$this->popup]['no_preview'] )
			{
				//$this->append_output( "\n" . '<div id="_krown_preview" class="hidden">false</div>' );
				$this->no_preview = true;		
			}
			
			// filters and excutes params

			if ( $this->params != 'no-param' ) {

				foreach ( $this->params as $pkey => $param ) {
					// prefix the fields names and ids with krown_
					$pkey = 'krown_' . $pkey;
					
					// popup form row start
					$row_start  = '<tbody>' . "\n";
					$row_start .= '<tr class="form-row clearfix">' . "\n";
					$row_start .= '<td class="label">' . $param['label'] . '</td>' . "\n";
					$row_start .= '<td class="field">' . "\n";
					$row_start .= '<span class="krown-form-desc">' . $param['desc'] . '</span>' . "\n";
					
					// popup form row end
					$row_end   = '</td>' . "\n";
					$row_end   .= '</tr>' . "\n";					
					$row_end   .= '</tbody>' . "\n";
					
					switch( $param['type'] )
					{
						case 'text' :
							
							// prepare
							$output  = $row_start;
							$output .= '<input type="text" class="krown-form-text krown-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
							$output .= $row_end;
							
							// append
							$this->append_output( $output );
							
							break;
							
						case 'textarea' :
							
							// prepare
							$output  = $row_start;
							$output .= '<textarea rows="10" cols="30" name="' . $pkey . '" id="' . $pkey . '" class="krown-form-textarea krown-input">' . $param['std'] . '</textarea>' . "\n";
							$output .= $row_end;
							
							// append
							$this->append_output( $output );
							
							break;
							
						case 'select' :
							
							// prepare
							$output  = $row_start;
							$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="krown-form-select krown-input">' . "\n";
							
							foreach( $param['options'] as $value => $option )
							{
								$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}
							
							$output .= '</select>' . "\n";
							$output .= $row_end;
							
							// append
							$this->append_output( $output );
							
							break;
							
						case 'checkbox' :
							
							// prepare
							$output  = $row_start;
							$output .= '<label for="' . $pkey . '" class="krown-form-checkbox">' . "\n";
							$output .= '<input type="checkbox" class="krown-input" name="' . $pkey . '" id="' . $pkey . '" ' . ( $param['std'] ? 'checked' : '' ) . ' />' . "\n";
							$output .= ' ' . $param['checkbox_text'] . '</label>' . "\n";
							$output .= $row_end;
							
							// append
							$this->append_output( $output );
							
							break;
					}
				}

			}
			
			// checks if has a child shortcode
			if( isset( $krown_shortcodes[$this->popup]['child_shortcode'] ) )
			{
				// set child shortcode
				$this->cparams = $krown_shortcodes[$this->popup]['child_shortcode']['params'];
				$this->cshortcode = $krown_shortcodes[$this->popup]['child_shortcode']['shortcode'];
			
				// popup parent form row start
				$prow_start  = '<tbody>' . "\n";
				$prow_start .= '<tr class="form-row has-child clearfix">' . "\n";
				$prow_start .= '<td><a href="#" id="form-child-add" class="button-secondary">' . $krown_shortcodes[$this->popup]['child_shortcode']['clone_button'] . '</a>' . "\n";
				$prow_start .= '<div class="child-clone-rows">' . "\n";
				
				// for js use
				$prow_start .= '<div id="_krown_cshortcode" class="hidden">' . $this->cshortcode . '</div>' . "\n";
				
				// start the default row
				$prow_start .= '<div class="child-clone-row">' . "\n";
				$prow_start .= '<ul class="child-clone-row-form">' . "\n";
				
				// add $prow_start to output
				$this->append_output( $prow_start );
				
				foreach( $this->cparams as $cpkey => $cparam )
				{
				
					// prefix the fields names and ids with krown_
					$cpkey = 'krown_' . $cpkey;
					
					// popup form row start
					$crow_start  = '<li class="child-clone-row-form-row">' . "\n";
					$crow_start .= '<div class="child-clone-row-label">' . "\n";
					$crow_start .= '<label>' . $cparam['label'] . '</label>' . "\n";
					$crow_start .= '</div>' . "\n";
					$crow_start .= '<div class="child-clone-row-field">' . "\n";
					$crow_start	.= '<span class="child-clone-row-desc">' . $cparam['desc'] . '</span>' . "\n";
					
					// popup form row end
					$crow_end   = '</div>' . "\n";
					$crow_end   .= '</li>' . "\n";
					
					switch( $cparam['type'] )
					{
						case 'text' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="krown-form-text krown-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'textarea' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '" id="' . $cpkey . '" class="krown-form-textarea krown-cinput">' . $cparam['std'] . '</textarea>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'select' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<select name="' . $cpkey . '" id="' . $cpkey . '" class="krown-form-select krown-cinput">' . "\n";
							
							foreach( $cparam['options'] as $value => $option )
							{
								$coutput .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}
							
							$coutput .= '</select>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'checkbox' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<label for="' . $cpkey . '" class="krown-form-checkbox">' . "\n";
							$coutput .= '<input type="checkbox" class="krown-cinput" name="' . $cpkey . '" id="' . $cpkey . '" ' . ( $cparam['std'] ? 'checked' : '' ) . ' />' . "\n";
							$coutput .= ' ' . $cparam['checkbox_text'] . '</label>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
					}
				}
				
				// popup parent form row end
				$prow_end    = '</ul>' . "\n";		// end .child-clone-row-form
				$prow_end   .= '<a href="#" class="child-clone-row-remove">Remove</a>' . "\n";
				$prow_end   .= '</div>' . "\n";		// end .child-clone-row
				
				
				$prow_end   .= '</div>' . "\n";		// end .child-clone-rows
				$prow_end   .= '</td>' . "\n";
				$prow_end   .= '</tr>' . "\n";					
				$prow_end   .= '</tbody>' . "\n";
				
				// add $prow_end to output
				$this->append_output( $prow_end );
			}			
		}
	}
	
	// --------------------------------------------------------------------------
	
	function append_output( $output )
	{
		$this->output = $this->output . "\n" . $output;		
	}
	
	// --------------------------------------------------------------------------
	
	function reset_output( $output )
	{
		$this->output = '';
	}
	
	// --------------------------------------------------------------------------
	
	function append_error( $error )
	{
		$this->errors = $this->errors . "\n" . $error;
	}
}

?>