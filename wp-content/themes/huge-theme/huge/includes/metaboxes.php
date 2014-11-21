<?php

// This file contains sidebar information.

add_action( 'admin_init', 'rb_meta_boxes' );

//global $sidebars_array;

function rb_meta_boxes() {

/*---------------------------------
    INIT SOME USEFUL VARIABLES
    ------------------------------------*/


  /*
  $sidebars = ot_get_option('rb_sidebars');
  $sidebars_array = array();
  $sidebars_k = 0;
  if(!empty($sidebars)){
      foreach($sidebars as $sidebar){
          $sidebars_array[$sidebars_k++] = array(
              'label' => $sidebar['title'],
              'value' => $sidebar['id']
          );
      }
  }
  */

  $krown_project_media = array(
    'id'        => 'krown_project_media',
    'title' => 'Project Media',
    'desc' => 'This field controls the <strong>media of the project</strong>. The galleries are managed via the basic WordPress gallery so it\'s easy for you to just drag & drop images into the library and create your gallery directly from here. If you want videos, when you upload a picture (which will be the video poster), you can also see fields for controlling the video. Just fill them as the instructions there and you\'ll have video slides.',
    'pages' => array( 'portfolio' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
          'label' => 'Gallery slider',
          'id' => 'pp_gallery_slider',
          'type' => 'gallery',
          'desc' => 'Click Create Slider to create your gallery for slider.',
          'post_type' => 'post'
          )
        )
    );


  $krown_gallery_media = array(
    'id'        => 'krown_project_media',
    'title' => 'Gallery Options',
    'desc' => 'This field controls the <strong>media of the page</strong>. The galleries are managed via the basic WordPress gallery so it\'s easy for you to just drag & drop images into the library and create your gallery directly from here.',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
          'label' => 'Gallery',
          'id' => 'pp_gallery_slider',
          'type' => 'gallery',
          'desc' => 'Click Create Slider to create your gallery for slider.',
          'post_type' => 'post'
          ),

        array(
          'label' => 'Thumbnails ratio',
          'id' => 'thumbs_ratio',
          'type' => 'radio',
          'desc' => 'Choose a ratio for the thumbnails inside the gallery grid.',
          'std' => 'ratio_4-3',
          'choices' => array(
            array(
                'value' => 'ratio_4-3',
                'label' => '4:3'
                ),
            array(
                'value' => 'ratio_16-9',
                'label' => '16:9'
                ),
            array(
                'value' => 'ratio_16-10',
                'label' => '16:10'
                ),
            array(
                'value' => 'ratio_1-1',
                'label' => '1:1'
                )
            )
          )

        )
    );



$krown_slideshow_media = array(
    'id'        => 'krown_slideshow_media',
    'title' => 'Slideshow Options',
    'desc' => '',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(

        array(
            'id'          => 'krown_slideshow_slider',
            'label'       => 'Slider',
            'desc'        => '',
            'std'         => '',
            'type'        => 'list-item',
            'class'       => '',
            'settings'    => array(
                array(
                    'label'       => 'Image',
                    'id'          => 'image',
                    'type'        => 'upload',
                    'desc'        => 'Upload an image for this slide. Be sure to upload only optimized JPG files with a width of max 1600px (solely for performance issues).',
                    'std'         => '',
                    'rows'        => '',
                    'post_type'   => '',
                    'taxonomy'    => '',
                    'class'       => ''
                    ),

                    array(
                      'label' => 'HTML Object #1',
                      'id' => 'img_obj1',
                      'type' => 'textarea',
                      'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
                      'std' => ''
                    ),

                    array(
                      'label' => 'HTML Object #2',
                      'id' => 'img_obj2',
                      'type' => 'textarea',
                      'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
                      'std' => ''
                    ),

                    array(
                      'label' => 'HTML Object #3',
                      'id' => 'img_obj3',
                      'type' => 'textarea',
                      'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
                      'std' => ''
                    )

                )
            )

            )
);



$krown_single_media = array(
    'id'        => 'krown_single_media',
    'title' => 'Page Options',
    'desc' => '',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(

        array(
          'label' => 'Background',
          'id' => 'krown_single_image_back',
          'type' => 'upload',
          'desc' => 'Upload a large image which will serve as the background (will be croped and resized to fill the screen).',
          'std' => ''
        ),

        array(
          'label' => 'HTML Object #1',
          'id' => 'krown_single_image_obj1',
          'type' => 'textarea',
          'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
          'std' => ''
        ),

        array(
          'label' => 'HTML Object #2',
          'id' => 'krown_single_image_obj2',
          'type' => 'textarea',
          'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
          'std' => ''
        ),

        array(
          'label' => 'HTML Object #3',
          'id' => 'krown_single_image_obj3',
          'type' => 'textarea',
          'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
          'std' => ''
        ),

    )
);



$krown_single_media_2 = array(
    'id'        => 'krown_single_media_2',
    'title' => 'Page Options',
    'desc' => '',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(

        array(
          'label' => 'Video File',
          'id' => 'krown_single_image_video',
          'type' => 'upload',
          'desc' => 'Upload or link to a .mp4 video file.',
          'std' => ''
        ),

        array(
          'label' => 'Video Post',
          'id' => 'krown_single_image_poster',
          'type' => 'upload',
          'desc' => 'Most devices (as in tablets or phones) don\t support video autoplay. You need to upload a poster image for such cases.',
          'std' => ''
        ),

        array(
          'label' => 'HTML Object #1',
          'id' => 'krown_single_image_obj1',
          'type' => 'textarea',
          'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
          'std' => ''
        ),

        array(
          'label' => 'HTML Object #2',
          'id' => 'krown_single_image_obj2',
          'type' => 'textarea',
          'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
          'std' => ''
        ),

        array(
          'label' => 'HTML Object #3',
          'id' => 'krown_single_image_obj3',
          'type' => 'textarea',
          'desc' => 'Write some text for the first animated object. It can be HTML and you can use anything from headings to paragraphs or even more images.',
          'std' => ''
        ),

    )
);

$krown_gallery_project_media = array(
    'id'        => 'krown_project_media',
    'title' => 'Project Options',
    'desc' => 'This field controls the <strong>media of the project</strong>. The galleries are managed via the basic WordPress gallery so it\'s easy for you to just drag & drop images into the library and create your gallery directly from here.',
    'pages' => array( 'gallery' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
          'label' => 'Gallery',
          'id' => 'pp_gallery_slider',
          'type' => 'gallery',
          'desc' => 'Click Create Slider to create your gallery for slider.',
          'post_type' => 'post'
          ),

        array(
          'label' => 'Resize rule',
          'id' => 'krown_project_slider_style',
          'type' => 'radio',
          'desc' => 'Choose how will the images in this gallery resize according to the screen size.',
          'std' => 'fill',
          'choices' => array(
            array(
                'value' => 'fill',
                'label' => 'Fill'
                ),
            array(
                'value' => 'centered',
                'label' => 'Fit'
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
            'id'          => 'krown_project_captions',
            'label'       => 'Image captions',
            'desc'        => 'Show/hide individual image captions.',
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
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Background Settings</span>',
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
            'id'          => '_me_desc_5',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Custom URL</span>',
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



$krown_page_header = array(
    'id'        => 'krown_page_header',
    'title' => 'Page Header',
    'desc' => '',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
          'label' => 'Enable custom header',
          'id' => 'krown_custom_header_set',
          'type' => 'radio',
          'std' => 'wout-custom-header',
          'desc' => 'Enable the custom header for the current page (which involves a parallax image and a subtitle).',
          'choices' => array(
            array(
                'value' => 'w-custom-header',
                'label' => 'Enabled'
                ),
            array(
                'value' => 'wout-custom-header',
                'label' => 'Disabled'
                )
            )
          ),

        array(
          'label' => 'Background',
          'id' => 'krown_custom_header_img',
          'type' => 'upload',
          'desc' => 'Upload an image for the custom header. It needs to be wide and at least 300px tall (eg. 1200x350).',
          ),

        array(
          'label' => 'Text color',
          'id' => 'krown_custom_header_color',
          'type' => 'colorpicker',
          'desc' => 'Choose a color for the title and subtitle text.',
          'std' => '#FFF'
          ),

        array(
          'label' => 'Subtitle',
          'id' => 'krown_custom_header_subtitle',
          'type' => 'text',
          'desc' => 'Write a subtitle which will appear below the title.',
          )

        )
);




$krown_contact_meta = array(
    'id'        => 'krown_contact_meta',
    'title' => 'Page Options',
    'desc' => 'Use the following fields to configure this page\'s map. If you choose to hide the map, you could use a static image, just like in any other page, however, if you choose to show the map, the static image will no longer appear.',
    'pages' => array( 'page' ),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
          'label' => 'Enable map',
          'id' => 'krown_show_map',
          'type' => 'radio',
          'desc' => '',
          'std' => 'wout-custom-header-map',
          'choices' => array(
            array(
                'value' => 'w-custom-header-map',
                'label' => 'Enabled'
                ),
            array(
                'value' => 'wout-custom-header-map',
                'label' => 'Disabled'
                )
            )
          ),
        array(
          'label' => 'Map zoom level',
          'id' => 'krown_map_zoom',
          'type' => 'text',
          'desc' => 'Should be a number between 1 and 21.',
          'std' => '16'
          ),
        array(
          'label' => 'Map style',
          'id' => 'krown_map_style',
          'type' => 'radio',
          'desc' => '',
          'std' => 'true',
          'choices' => array(
            array(
                'value' => 'true',
                'label' => 'Greyscale'
                ),
            array(
                'value' => 'false',
                'label' => 'Default'
                )
            )
          ),
        array(
          'label' => 'Map latitude',
          'id' => 'krown_map_lat',
          'type' => 'text',
          'desc' => 'Enter a latitude coordinate for the map\'s center (your POI).',
          'std' => ''
          ),
        array(
          'label' => 'Map longitude',
          'id' => 'krown_map_long',
          'type' => 'text',
          'desc' => 'Enter a longitude coordinate for the map\'s center (your POI).',
          'std' => ''
          ),
        array(
          'label' => 'Show marker',
          'id' => 'krown_map_marker',
          'type' => 'radio',
          'desc' => '',
          'std' => 'true',
          'choices' => array(
            array(
                'value' => 'true',
                'label' => 'Show'
                ),
            array(
                'value' => 'false',
                'label' => 'Hide'
                )
            )
          ),
        array(
          'label' => 'Marker image',
          'id' => 'krown_map_img',
          'type' => 'upload',
          'desc' => 'Upload an image which will be the marker on your map.',
          'std' => ''
          )
        )
);

/*---------------------------------
    SIDEBARS - In all kinds of pages
------------------------------------

  $rb_meta_box_sidebar = array(
    'id'        => 'rb_meta_box_sidebar',
    'title'     => 'Layout',
    'desc'      => 'If you select a layout with a sidebar, please choose a sidebar from the list below. Sidebars can be created in the Theme Options and configured in the Theme Widgets.',
    'pages'     => array( 'page' ),
    'context'   => 'side',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'id'          => 'krown_sidebar_layout',
        'label'       => 'Layout type',
        'desc'        => '',
        'std'         => 'full-width',
        'type'        => 'radio_image',
        'class'       => ''
        ),
      array(
        'id'          => 'krown_sidebar_set',
        'label'       => 'Select sidebar',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'class'       => '',
        'choices'    => $sidebars_array
        )
      )
    );



/*---------------------------------
    SIDEBARS + COLUMNS - Only for blog
------------------------------------

  $rb_meta_box_blog = array(
    'id'        => 'rb_meta_box_blog',
    'title'     => 'Layout',
    'desc'      => 'If you select a layout with a sidebar, you need to configure the blog sidebar within the widgets panel. The number of columns is valid only for the blog without a sidebar. Blog pages with sidebars will always have a single column.',
    'pages'     => array( 'page' ),
    'context'   => 'side',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'id'          => 'rb_meta_box_sidebar_layout',
        'label'       => 'Layout type',
        'desc'        => '',
        'std'         => 'full-width',
        'type'        => 'radio_image',
        'class'       => ''
        ),
      array(
        'id'          => 'rb_meta_box_blog_columns',
        'label'       => 'Columns',
        'desc'        => '',
        'std'         => 'blog-cols-one',
        'type'        => 'radio',
        'class'       => '',
        'choices'    => array(
            array(
              'label' => 'One Column',
              'value' => 'blog-cols-one'
            ),
            array(
              'label' => 'Two Columns',
              'value' => 'blog-cols-two'
            ),
            array(
              'label' => 'Three Columns',
              'value' => 'blog-cols-three'
            )
          )
        )
      )
);*/

/*---------------------------------
    MEDIA - According to post formats
    ------------------------------------*/

    $krown_post_media = array(
        'id'        => 'krown_post_media',
        'title'     => 'Post Media / Content',
        'desc'      => '',
        'pages'     => array( 'post'),
        'context'   => 'normal',
        'priority'  => 'high',
        'fields'    => array(
          array(
            'id'      => '_desc',
            'label'   => '',
            'desc'    => 'Each post format allows for some media (or other kind of) content. Use the fields bellow to configure this post properly.' ,
            'std'     => '',
            'type'    => 'textblock',
            'class'   => '',
            'choices' => array()
            ),

          /* Gallery type */

          array(
            'id'          => 'krown_post_gallery',
            'label'       => 'Gallery',
            'desc'        => 'If this is a <strong>gallery post</strong>, you should configure your gallery(slider) with the default WordPress gallery (create a gallery at the top) and paste the shortcode here.',
            'std'         => '',
            'type'        => 'text',
            'class'       => '',
            ),

          /* Link type */

          array(
            'id'          => 'krown_post_link',
            'label'       => 'Link',
            'desc'        => 'If this is an <strong>link post</strong>, just paste your link inside here.',
            'std'         => '',
            'type'        => 'text',
            'class'       => '',
            ),

          /* Image type */

          array(
            'id'          => 'krown_post_image',
            'label'       => 'Image',
            'desc'        => 'If this is an <strong>image post</strong>, you should upload an image in this filed.',
            'std'         => '',
            'type'        => 'upload',
            'class'       => '',
            ),

          /* Quote type */

          array(
            'id'          => '_desc_2',
            'label'       => 'Quote',
            'desc'        => 'If this is an <strong>quote post</strong>, configure it in the fields below.',
            'std'         => '',
            'type'        => 'textblock-titled',
            'class'       => '',
            ),

          array(
            'id'          => 'krown_post_quote_1',
            'label'       => 'Quote - Content',
            'desc'        => '',
            'std'         => '',
            'type'        => 'textarea',
            'class'       => '',
            ),

          array(
            'id'          => 'krown_post_quote_2',
            'label'       => 'Quote - Source',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'class'       => '',
            ),

          /* Video type */

          array(
            'id'      => '_desc_3',
            'label'   => 'Video',
            'desc'    => 'If this is a <strong>video post</strong>, use the following fileds to configure it. You can either have a self hosted video (based on an mp4 file) or an embedded one (via iframe).',
            'std'     => '',
            'type'    => 'textblock-titled',
            'class'   => '',
            'choices' => array()
            ),

          /* Embedded video type */

          array(
            'id'      => 'krown_post_video_1',
            'label'   => 'Embedded Video',
            'desc'    => 'Paste the video embedding code (entire iframe code) inside this field.',
            'std'     => '',
            'type'    => 'textarea',
            'class'   => '',
            'choices' => array()
            ),

          /* Self hosted video type */

          array(
            'id'      => 'krown_post_video_2',
            'label'   => 'Self Hosted Video - MP4',
            'desc'    => 'Upload an .mp4 video file or paste a link to one.',
            'std'     => '',
            'type'    => 'upload',
            'class'   => '',
            'choices' => array()
            ),

          array(
            'id'      => 'krown_post_video_3',
            'label'   => 'Self Hosted Video - Poster',
            'desc'    => 'Upload a poster image for the player or paste a link to one.',
            'std'     => '',
            'type'    => 'upload',
            'class'   => '',
            'choices' => array()
            ),


          /* Audio type */

          array(
            'id'      => 'krown_post_audio',
            'label'   => 'Audio',
            'desc'    => 'If this is an <strong>audio post</strong>, you sould upload an mp3 file in this field.',
            'std'     => '',
            'type'    => 'upload',
            'class'   => '',
            'choices' => array()
            )

          )
);

$krown_project_options = array(
    'id'        => 'krown_project_options',
    'title'     => 'Project Options',
    'desc'      => 'Please use the following fields to configure this project. You can change them at any time later.',
    'pages'     => array( 'portfolio' ),
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
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Background Settings</span>',
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
            'id'          => '_me_desc',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Modal Window Settings</span>',
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
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Full (Horizontal) Meta</span>',
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
            'id'          => '_me_desc_3',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Full (Horizontal) Settings</span>',
            'desc'        => 'In the Full (Horizontal) projects the slider has two options: either fill the entire screen (or slider area for modal windows) or keep it\'s max size and be centered (useful if you want to display transparent png files against a certain background.',
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
            'id'          => '_me_desc_5',
            'label'       => '<span style="display: block; color: rgb(26, 141, 247); font-size: 1.1em ! important; margin-bottom: -20px; background: none repeat scroll 0% 0% rgb(255, 255, 255);">Custom URL</span>',
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


    /*---------------------------------
        INIT METABOXES
        ------------------------------------*/

        $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 'no');
        $template_file = $post_id != 'no' ? get_post_meta($post_id,'_wp_page_template',TRUE) : 'no';

        if($template_file == 'template-single-gallery.php') {
            ot_register_meta_box($krown_gallery_media);
        } else if($template_file == 'template-slideshow.php'){
            ot_register_meta_box($krown_slideshow_media);
        } else if($template_file == 'template-single-image.php'){
            ot_register_meta_box($krown_single_media);
        } else if($template_file == 'template-single-video.php'){
          ot_register_meta_box($krown_single_media_2);
        } else if($template_file == 'template-contact.php') {
            ot_register_meta_box($krown_contact_meta);
            ot_register_meta_box($krown_page_header);
        } else if($template_file == 'no' || $template_file == 'default'){
          ot_register_meta_box($krown_page_header);
      }

      ot_register_meta_box($krown_post_media);
      ot_register_meta_box($krown_project_media);
      ot_register_meta_box($krown_gallery_project_media);
      ot_register_meta_box($krown_project_options);

  }

  ?>