<?php

// BELOW THERE IS NO EDITING NEEDED! just replace "twofolio" with your custom post type

add_action( 'admin_init', 'twofolio_meta' );

function twofolio_meta() {

  $krown_project_media = array(
    'id'        => 'krown_project_media',
    'title' => 'Project Media',
    'desc' => 'This field controls the <strong>media of the project</strong>. The galleries are managed via the basic WordPress gallery so it\'s easy for you to just drag & drop images into the library and create your gallery directly from here. If you want videos, when you upload a picture (which will be the video poster), you can also see fields for controlling the video. Just fill them as the instructions there and you\'ll have video slides.',
    'pages' => array( 'twofolio' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
          'label' => 'Gallery slider (use when Post Type is set to Gallery)',
          'id' => 'pp_gallery_slider',
          'type' => 'gallery',
          'desc' => 'Click Create Slider to create your gallery for slider.',
          'post_type' => 'post'
          )
        )
    );

  $krown_project_options = array(
    'id'        => 'krown_project_options',
    'title'     => 'Project Options',
    'desc'      => 'Please use the following fields to configure this project. You can change them at any time later.',
    'pages'     => array( 'twofolio' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
        array(
            'id'          => 'krown_project_type',
            'label'       => 'Project type',
            'desc'        => '',
            'std'         => 'modal',
            'type'        => 'select',
            'class'       => '',
            'choices'     => array(
                array(
                    'value' => 'vertical',
                    'label' => 'Full (Vertical)'
                    ),
                array(
                    'value' => 'horizontal',
                    'label' => 'Full (Horizontal)'
                    ),
                array(
                    'value' => 'modal',
                    'label' => 'Modal window'
                    ),
                array(
                    'value' => 'photo',
                    'label' => 'Photography'
                    )
                )
            ),
        array(
            'id'          => 'krown_project_share',
            'label'       => 'Sharing buttons',
            'desc'        => 'Show/hide project sharing buttons.',
            'std'         => 'show',
            'type'        => 'radio',
            'class'       => '',
            'choices'     => array(
                array(
                    'value' => 'show',
                    'label' => 'Show'
                    ),
                array(
                    'value' => 'hide',
                    'label' => 'Hide'
                    )
                )
            ),
        array(
            'id'          => '_me_desc_2',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(246, 246, 246);">Background Settings</span>',
            'desc'        => 'The settings below can affect any project type <strong>if you\'re using the centered png files option</strong> instead of full backgrounds. An exception is made by the vertical project for which the background will always be visible.',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => 'large-heading'
            ),
        array(
            'id'          => 'krown_project_n_color',
            'label'       => 'Background color',
            'desc'        => 'Choose a plain hexadecimal color.',
            'std'         => '',
            'type'        => 'colorpicker'
            ),
        array(
            'id'          => 'krown_project_n_gradient',
            'label'       => 'Background gradient',
            'desc'        => 'Paste a css gradient which you can build here: <a href="http://www.colorzilla.com/gradient-editor/" target="_blank">colorzilla.com/gradient-editor/</a>.',
            'std'         => '',
            'type'        => 'textarea-simple'
            ),
        array(
            'id'          => 'krown_project_n_image',
            'label'       => 'Background image',
            'desc'        => 'Upload a large image (will be randomly resized and cropped).',
            'std'         => '',
            'type'        => 'upload'
            ),
        array(
            'id'          => '_me_desc_3',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(246, 246, 246);">Slide Style</span>',
            'desc'        => 'In the Modal and Full (Horizontal) projects the slider has two options: either fill the entire screen (or slider area for modal windows) or keep it\'s max size and be centered (useful if you want to display transparent png files against a certain background.',
                'std'         => '',
                'type'        => 'textblock-titled',
                'class'       => 'large-heading'
                ),
        array(
            'id'          => 'krown_project_slider_style',
            'label'       => 'Fill or Centered',
            'desc'        => '',
            'std'         => 'full',
            'type'        => 'radio',
            'class'       => '',
            'choices'     => array(
                array(
                    'value' => 'full',
                    'label' => 'Full (resize & crop)'
                    ),
                array(
                    'value' => 'centered',
                    'label' => 'Centered (resize but no cropping)'
                    )
                )
            ),
        array(
            'id'          => 'krown_project_slider_align',
            'label'       => 'Centered align',
            'desc'        => 'If you choose the centered slides you should choose an alignment for the slides.',
            'std'         => 'bottom',
            'type'        => 'select',
            'class'       => '',
            'choices'     => array(
                array(
                    'value' => 'top',
                    'label' => 'Top'
                    ),
                array(
                    'value' => 'middle',
                    'label' => 'Middle'
                    ),
                array(
                    'value' => 'bottom',
                    'label' => 'Bottom'
                    )
                )
            ),
        array(
            'id'          => '_me_desc',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(246, 246, 246);">Modal Window Settings</span>',
            'desc'        => 'The settings below are valid only if the current portfolio page has it\'s type set to "Modal window"',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => 'large-heading'
            ),
        array(
            'id'          => 'krown_project_m_width',
            'label'       => 'Window width (px)',
            'desc'        => '',
            'std'         => '940',
            'type'        => 'text'
            ),
        array(
            'id'          => 'krown_project_m_height',
            'label'       => 'Window height (px)',
            'desc'        => '',
            'std'         => '640',
            'type'        => 'text'
            ),
        array(
            'id'          => 'krown_project_m_slider_width',
            'label'       => 'Slider width (px)',
            'desc'        => 'The sider\'s height will be equal to the height of the entire window.',
            'std'         => '640',
            'type'        => 'text'
            ),
        array(
            'id'          => '_me_desc_4',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(246, 246, 246);">Full (Horizontal) Settings</span>',
            'desc'        => 'The meta info below are for the Full (Horizontal) portfolio. The first item will be the project\'s categories.',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => 'large-heading'
            ),
        array(
            'id'          => 'krown_project_meta_2',
            'label'       => 'Client',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text'
            ),
        array(
            'id'          => 'krown_project_meta_3',
            'label'       => 'Date',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text'
            ),
        array(
            'id'          => 'krown_project_meta_4',
            'label'       => 'Skills',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text'
            ),
        array(
            'id'          => '_me_desc_5',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(246, 246, 246);">Custom URL</span>',
            'desc'        => 'If you don\'t want this certain thumbnail to be an actual project, but to open a custom url instead, use the following fields to configure this.',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => ''
            ),
        array(
            'id'          => 'krown_project_custom_url',
            'label'       => 'URL',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text'
            ),
        array(
            'id'          => 'krown_project_custom_target',
            'label'       => 'Target',
            'desc'        => '',
            'std'         => '_self',
            'type'        => 'select',
            'choices'     => array(
                array( 
                    'label' => '_self',
                    'value' => '_self'
                    ),
                array( 
                    'label' => '_blank',
                    'value' => '_blank'
                    )
                )
            )
        )
  );

  ot_register_meta_box($krown_project_media);
  ot_register_meta_box($krown_project_options);

}

?>