<?php

// This file contains separate configuration for the shortcodes generator (it affects only the backend!)

	$krown_shortcodes['tabs'] = array(
	    'params' => array(
	    	'type' => array(
	            'type' => 'select',
	            'label' => __('Type', 'krown'),
	            'desc' => __('The type (style) of the tabs.', 'krown'),
				'options' => array(
					'horizontal' => 'Horizontal',
					'vertical' => 'Vertical'
				)
			)
	    ),
	    'no_preview' => true,
	    'shortcode' => '[krown_tabs type={{type}}] {{child_shortcode}} [/krown_tabs]',
	    'popup_title' => __('Insert Tab', 'krown'),
	    'child_shortcode' => array(
	        'params' => array(
	            'title' => array(
	                'std' => 'Title',
	                'type' => 'text',
	                'label' => __('Tab Title', 'krown'),
	                'desc' => __('Title of the tab.', 'krown'),
	            ),
	            'icon' => array(
	                'std' => '',
	                'type' => 'text',
	                'label' => __('Tab Icon', 'krown'),
	                'desc' => __('Icons will appear only in the vertical tabs. A full list of icons <a href="http://demo.krownthemes.com/help/krown-shortcodes-fonts/" target="_blank">can be found here</a>.', 'krown'),
	            ),
	            'content' => array(
	                'std' => '',
	                'type' => 'textarea',
	                'label' => __('Tab Content', 'krown'),
	                'desc' => __('Add the tab content.', 'krown')
	            )
	        ),
	        'shortcode' => '[krown_tabs_section title="{{title}}" icon="{{icon}}"] {{content}} [/krown_tabs_section]',
	        'clone_button' => __('Add Tab', 'krown')
	    )
	);

	$krown_shortcodes['button'] = array(
		'no_preview' => true,
		'params' => array(
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Button URL', 'krown'),
				'desc' => __('Add the button\'s url eg http://example.com.', 'krown')
			),
			'target' => array(
				'type' => 'select',
				'label' => __('Button Target', 'krown'),
				'desc' => __('_self = open in same window. _blank = open in new window.', 'krown'),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'label' => array(
				'std' => 'Button Text',
				'type' => 'text',
				'label' => __('Button\'s Text', 'krown'),
				'desc' => __('Add the button\'s text.', 'krown'),
			)
		),
		'shortcode' => '[krown_button url="{{url}}" size="{{size}}"  target="{{target}}" label="{{label}}"]',
		'popup_title' => __('Insert Button', 'krown')
	);
	
?>