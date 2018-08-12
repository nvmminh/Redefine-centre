<?php

/*
** Register Theme Customizer
*/
function ashe_customize_register( $wp_customize ) {

/*
** Sanitization Callbacks =====
*/
	// checkbox
	function ashe_sanitize_checkbox( $input ) {
		return $input ? true : false;
	}
	
	// select
	function ashe_sanitize_select( $input, $setting ) {
		
		// get all select options
		$options = $setting->manager->get_control( $setting->id )->choices;
		
		// return default if not valid
		return ( array_key_exists( $input, $options ) ? $input : $setting->default );
	}

	// number absint
	function ashe_sanitize_number_absint( $number, $setting ) {

		// ensure $number is an absolute integer
		$number = absint( $number );

		// return default if not integer
		return ( $number ? $number : $setting->default );

	}

	// textarea
	function ashe_sanitize_textarea( $input ) {

		$allowedtags = array(
			'a' => array(
				'href' 		=> array(),
				'title' 	=> array(),
				'_blank'	=> array()
			),
			'img' => array(
				'src' 		=> array(),
				'alt' 		=> array(),
				'width'		=> array(),
				'height'	=> array(),
				'style'		=> array(),
				'class'		=> array(),
				'id'		=> array()
			),
			'br' 	 => array(),
			'em' 	 => array(),
			'strong' => array()
		);

		// return filtered html
		return wp_kses( $input, $allowedtags );

	}

	// Custom Controls
	function ashe_sanitize_custom_control( $input ) {
		return $input;
	}


/*
** Reusable Functions =====
*/
	// checkbox
	function ashe_checkbox_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;

		if ( $section !== 'header_image' ) {
			$section_id = 'ashe_'. $section;
		} else {
			$section_id = $section;
		}

		if ( $id === 'merge_menu' ) {
			$section_id = 'ashe_responsive';
		} 

		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'		=> $name,
			'section'	=> $section_id,
			'type'		=> 'checkbox',
			'priority'	=> $priority
		) );
	}

	// text
	function ashe_text_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'		=> $name,
			'section'	=> 'ashe_'. $section,
			'type'		=> 'text',
			'priority'	=> $priority
		) );
	}

	// color
	function ashe_color_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ashe_options['. $section .'_'. $id .']', array(
			'label' 	=> $name,
			'section' 	=> 'ashe_'. $section,
			'priority'	=> $priority
		) ) );
	}

	// textarea
	function ashe_textarea_control( $section, $id, $name, $description, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_textarea'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'			=> $name,
			'description'	=> wp_kses_post($description),
			'section'		=> 'ashe_'. $section,
			'type'			=> 'textarea',
			'priority'		=> $priority
		) );
	}

	// url
	function ashe_url_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'		=> $name,
			'section'	=> 'ashe_'. $section,
			'type'		=> 'text',
			'priority'	=> $priority
		) );
	}

	// number absint
	function ashe_number_absint_control( $section, $id, $name, $atts, $transport, $priority ) {
		global $wp_customize;

		if ( $section !== 'title_tagline' && $section !== 'header_image' ) {
			$section_id = 'ashe_'. $section;
		} else {
			$section_id = $section;
		}

		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_number_absint'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'			=> $name,
			'section'		=> $section_id,
			'type'			=> 'number',
			'input_attrs' 	=> $atts,
			'priority'		=> $priority
		) );
	}

	// select
	function ashe_select_control( $section, $id, $name, $atts, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_select'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'			=> $name,
			'section'		=> 'ashe_'. $section,
			'type'			=> 'select',
			'choices' 		=> $atts,
			'priority'		=> $priority
		) );
	}

	// radio
	function ashe_radio_control( $section, $id, $name, $atts, $transport, $priority ) {
		global $wp_customize;

		if ( $section !== 'header_image' ) {
			$section_id = 'ashe_'. $section;
		} else {
			$section_id = $section;
		}

		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_select'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'			=> $name,
			'section'		=> $section_id,
			'type'			=> 'radio',
			'choices' 		=> $atts,
			'priority'		=> $priority
		) );
	}

	// image
	function ashe_image_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
		    'default' 	=> ashe_options( $section .'_'. $id),
		    'type' 		=> 'option',
		    'transport' => $transport,
		    'sanitize_callback' => 'esc_url_raw'
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, 'ashe_options['. $section .'_'. $id .']', array(
				'label'    => $name,
				'section'  => 'ashe_'. $section,
				'priority' => $priority
			)
		) );
	}

	// image crop
	function ashe_image_crop_control( $section, $id, $name, $width, $height, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default' 	=> '',
			'type' 		=> 'option',
			'transport' => $transport,
			'sanitize_callback' => 'ashe_sanitize_number_absint'
		) );
		$wp_customize->add_control(
			new WP_Customize_Cropped_Image_Control( $wp_customize, 'ashe_options['. $section .'_'. $id .']', array(
				'label'    		=> $name,
				'section'  		=> 'ashe_'. $section,
				'flex_width'  	=> true,
				'flex_height' 	=> true,
				'width'       	=> $width,
				'height'      	=> $height,
				'priority' 		=> $priority
			)
		) );
	}

	// Pro Version
	class Ashe_Customize_Pro_Version extends WP_Customize_Control {
		public $type = 'pro_options';

		public function render_content() {
			echo '<span>Want more <strong>'. esc_html( $this->label ) .'</strong>?</span>';
			echo '<a href="'. esc_url($this->description) .'" target="_blank">';
				echo '<span class="dashicons dashicons-info"></span>';
				echo '<strong> '. esc_html__( 'See Ashe PRO', 'ashe' ) .'<strong></a>';
			echo '</a>';
		}
	}

	// Pro Version Links
	class Ashe_Customize_Pro_Version_Links extends WP_Customize_Control {
		public $type = 'pro_links';

		public function render_content() {
			?>
			<ul>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Upgrade', 'ashe' ); ?> <span>*</span></h3>
					<p><?php esc_html_e( 'There are lots of reasons to upgrade to Pro version. Unlimited custom Colors, rich Typography options, multiple variation of Blog Feed layout and way much more. Also Premium Support included.', 'ashe' ); ?></p>
					<a href="<?php echo esc_url('http://wp-royal.com/themes/ashe/customizer/free/upgrade-ashe-pro.html?ref=ashe-free-customizer-about-section-buypro'); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Get Ashe Pro', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Demo Import / Getting Started', 'ashe' ); ?></h3>
					<p><?php esc_html_e( 'All you need for startup: Demo Import, Video Tutorials and more. To see what Ashe theme can offer, please visit a ', 'ashe' ); ?><a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-free/demo/?ref=ashe-free-customizer-about-section-get-started-btn/'); ?>" target="_blank"><?php esc_html_e( 'Demo Preview Page.', 'ashe' ); ?></a></p>
					<a href="<?php echo esc_url(admin_url('themes.php?page=about-ashe')); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Get Started', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Documentation', 'ashe' ); ?></h3>
					<p>
					<?php 
						$theme_data	 = wp_get_theme();
						/* translators: %s theme name */
						printf( esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use %s.', 'ashe' ), esc_html( $theme_data->Name ) );
					?>
					</p>
					<a href="<?php echo esc_url('http://wp-royal.com/themes/ashe/docs/?ref=ashe-free-customizer-about-section-docs-btn/'); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Documentation', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Predefined Styles', 'ashe' ); ?></h3>
					<p>
					<?php /* translators: %s link */
						printf( __( 'Ashe Pro\'s powerful setup allows you to easily create unique looking sites. Here are a few included examples that can be installed with one click in the Pro Version. More details in the <a href="%s" target="_blank" >Theme Documentation</a>', 'ashe' ), esc_url('http://wp-royal.com/themes/ashe/docs/?ref=ashe-free-backend-about-predefined-styles#predefined') );
					?>
					</p>
					<a href="<?php echo admin_url('themes.php?page=about-ashe#ashe-predefined-styles'); ?>" class="button button-primary widefat"><?php esc_html_e( 'Predefined Styles', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Changelog', 'ashe' ); ?></h3>
					<p><?php esc_html_e( 'Want to get the gist on the latest theme changes? Just consult our changelog below to get a taste of the recent fixes and features implemented.', 'ashe' ); ?></p>
					<a href="<?php echo esc_url('https://wp-royal.com/ashe-free-changelog/?ref=ashe-free-customizer-about-section-changelog'); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Changelog', 'ashe' ); ?></a>
				</li>
			</ul>
			<?php
		}
	}	



/*
** Pro Version =====
*/

	// add Colors section
	$wp_customize->add_section( 'ashe_pro' , array(
		'title'		 => esc_html__( 'About Ashe', 'ashe' ),
		'priority'	 => 1,
		'capability' => 'edit_theme_options'
	) );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version_Links ( $wp_customize,
			'pro_version_', array(
				'section'	=> 'ashe_pro',
				'type'		=> 'pro_links',
				'label' 	=> '',
				'priority'	=> 1
			)
		)
	);


/*
** Colors =====
*/

	// add Colors section
	$wp_customize->add_section( 'ashe_colors' , array(
		'title'		 => esc_html__( 'Colors', 'ashe' ),
		'priority'	 => 1,
		'capability' => 'edit_theme_options'
	) );

	// Content Accent
	ashe_color_control( 'colors', 'content_accent', esc_html__( 'Accent', 'ashe' ), 'postMessage', 3 );

	$wp_customize->get_control( 'header_textcolor' )->section = 'ashe_colors';
	$wp_customize->get_control( 'header_textcolor' )->priority = 6;
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	// Header Background
	ashe_color_control( 'colors', 'header_bg', esc_html__( 'Header Background', 'ashe' ), 'postMessage', 9 );
	
	// Body Background
	$wp_customize->get_control( 'background_color' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_color' )->priority = 12;
	$wp_customize->get_control( 'background_color' )->label = 'Body Background';

	$wp_customize->get_control( 'background_image' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_image' )->priority = 15;
	$wp_customize->get_control( 'background_preset' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_preset' )->priority = 18;
	$wp_customize->get_control( 'background_position' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_position' )->priority = 21;
	$wp_customize->get_control( 'background_size' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_size' )->priority = 23;
	$wp_customize->get_control( 'background_repeat' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_repeat' )->priority = 25;
	$wp_customize->get_control( 'background_attachment' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_attachment' )->priority = 27;

	// Pro Version
	$wp_customize->add_setting( 'pro_version_colors', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_colors', array(
				'section'	  => 'ashe_colors',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Colors', 'ashe' ),
				'description' => esc_html( 'wp-royal.com/themes/ashe/customizer/free/colors.html?ref=ashe-free-colors-customizer' ),
				'priority'	  => 100
			)
		)
	);


/*
** General Layouts =====
*/

	// add General Layouts section
	$wp_customize->add_section( 'ashe_general' , array(
		'title'		 => esc_html__( 'General Layouts', 'ashe' ),
		'priority'	 => 3,
		'capability' => 'edit_theme_options'
	) );

	// Sidebar Width
	ashe_number_absint_control( 'general', 'sidebar_width', esc_html__( 'Sidebar Width', 'ashe' ), array( 'step' => '1' ), 'refresh', 3 );

	// Sticky Sidebar
	ashe_checkbox_control( 'general', 'sidebar_sticky', esc_html__( 'Enable Sticky Sidebar', 'ashe' ), 'refresh', 5 );

	// Page Layout Combinations
	$page_layouts = array(
		'col1-rsidebar' => esc_html__( '1 Column', 'ashe' ),
		'list-rsidebar' => esc_html__( 'List Style', 'ashe' ),
	);

	// Blog Page Layout
	ashe_select_control( 'general', 'home_layout', esc_html__( 'Blog Page', 'ashe' ), $page_layouts, 'refresh', 13 );

	$boxed_width = array(
		'full' 		=> esc_html__( 'Full', 'ashe' ),
		'contained' => esc_html__( 'Contained', 'ashe' ),
		'boxed' 	=> esc_html__( 'Boxed', 'ashe' ),
	);

	// Header Width
	ashe_select_control( 'general', 'header_width', esc_html__( 'Header Width', 'ashe' ), $boxed_width, 'refresh', 25 );

	$boxed_width_slider = array(
		'full' => esc_html__( 'Full', 'ashe' ),
		'boxed' => esc_html__( 'Boxed', 'ashe' ),
	);

	// Slider Width
	ashe_select_control( 'general', 'slider_width', esc_html__( 'Featured Slider Width', 'ashe' ), $boxed_width_slider, 'refresh', 27 );
	
	// Featured Links Width
	ashe_select_control( 'general', 'links_width', esc_html__( 'Featured Links Width', 'ashe' ), $boxed_width_slider, 'refresh', 28 );

	// Content Width
	ashe_select_control( 'general', 'content_width', esc_html__( 'Content Width', 'ashe' ), $boxed_width_slider, 'refresh', 29 );

	// Single Content Width
	ashe_select_control( 'general', 'single_width', esc_html__( 'Single Content Width', 'ashe' ), $boxed_width_slider, 'refresh', 31 );

	// Footer Width
	ashe_select_control( 'general', 'footer_width', esc_html__( 'Footer Width', 'ashe' ), $boxed_width, 'refresh', 33 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_general_layouts', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_general_layouts', array(
				'section'	  => 'ashe_general',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Layout Options', 'ashe' ),
				'description' => esc_html( 'wp-royal.com/themes/ashe/customizer/free/general-layouts.html?ref=ashe-free-general-layouts-customizer' ),
				'priority'	  => 100
			)
		)
	);


/*
** Top Bar =====
*/

	// add Top Bar section
	$wp_customize->add_section( 'ashe_top_bar' , array(
		'title'		 => esc_html__( 'Top Bar', 'ashe' ),
		'priority'	 => 5,
		'capability' => 'edit_theme_options'
	) );

	// Top Bar label
	ashe_checkbox_control( 'top_bar', 'label', esc_html__( 'Top Bar', 'ashe' ), 'refresh', 1 );


/*
** Header Image =====
*/

	$wp_customize->get_section( 'header_image' )->priority = 10;

	// Page Header label
	ashe_checkbox_control( 'header_image', 'label', esc_html__( 'Page Header', 'ashe' ), 'refresh', 1 );

	$bg_image_size = array(
		'cover'   => esc_html__( 'Cover', 'ashe' ),
		'initial' => esc_html__( 'Pattern', 'ashe' )
	);

	// Background Image Size
	ashe_radio_control( 'header_image', 'bg_image_size', esc_html__( 'Background Image Size', 'ashe' ), $bg_image_size, 'refresh', 10 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_header', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_header', array(
				'section'	  => 'header_image',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Header Options', 'ashe' ),
				'description' => esc_html( 'wp-royal.com/themes/ashe/customizer/free/header-image2.html?ref=ashe-free-header-customizer' ),
				'priority'	  => 100
			)
		)
	);


/*
** Site Identity =====
*/

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';

	// Logo Width
	ashe_number_absint_control( 'title_tagline', 'logo_width', esc_html__( 'Width', 'ashe' ), array( 'step' => '10' ), 'postMessage', 8 );

	$wp_customize->get_control( 'custom_logo' )->transport = 'selective_refresh';

	// Pro Version
	$wp_customize->add_setting( 'pro_version_logo', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_logo', array(
				'section'	  => 'title_tagline',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Logo Options', 'ashe' ),
				'description' => esc_html( 'http://wp-royal.com/themes/ashe/customizer/free/typography-logo.html?ref=ashe-free-site-identity-customizer' ),
				'priority'	  => 50
			)
		)
	);


/*
** Main Navigation =====
*/

	// add Main Navigation section
	$wp_customize->add_section( 'ashe_main_nav' , array(
		'title'		 => esc_html__( 'Main Navigation', 'ashe' ),
		'priority'	 => 23,
		'capability' => 'edit_theme_options'
	) );

	// Main Navigation
	ashe_checkbox_control( 'main_nav', 'label', esc_html__( 'Main Navigation', 'ashe' ), 'refresh', 1 );

	$main_nav_align = array(
		'left' => esc_html__( 'Left', 'ashe' ),
		'center' => esc_html__( 'Center', 'ashe' ),
		'right' => esc_html__( 'Right', 'ashe' ),
	);

	// Align
	ashe_select_control( 'main_nav', 'align', esc_html__( 'Align', 'ashe' ), $main_nav_align, 'refresh', 7 );

	// Show Search Icon
	ashe_checkbox_control( 'main_nav', 'show_search', esc_html__( 'Show Search Icon', 'ashe' ), 'refresh', 13 );

	// Show Sidebar Icon
	ashe_checkbox_control( 'main_nav', 'show_sidebar', esc_html__( 'Show Sidebar Icon', 'ashe' ), 'refresh', 15 );


/*
** Featured Slider =====
*/

	// add featured slider section
	$wp_customize->add_section( 'ashe_featured_slider' , array(
		'title'		 => esc_html__( 'Featured Slider', 'ashe' ),
		'priority'	 => 25,
		'capability' => 'edit_theme_options'
	) );

	// Featured Slider
	ashe_checkbox_control( 'featured_slider', 'label', esc_html__( 'Featured Slider', 'ashe' ), 'refresh', 1 );

	$slider_display = array(
		'all' 		=> 'All Posts',
		'category' 	=> 'by Post Category'
	);
	 
	// Display
	ashe_select_control( 'featured_slider', 'display', esc_html__( 'Display Posts', 'ashe' ), $slider_display, 'refresh', 2 );

	$slider_cats = array();

	foreach ( get_categories() as $categories => $category ) {
	    $slider_cats[$category->term_id] = $category->name;
	}
	 
	// Category
	ashe_select_control( 'featured_slider', 'category', esc_html__( 'Select Category', 'ashe' ), $slider_cats, 'refresh', 3 );

	// Amount
	ashe_number_absint_control( 'featured_slider', 'amount', esc_html__( 'Number of Slides', 'ashe' ), array( 'step' => '1', 'min' => '1', 'max' => '5' ), 'refresh', 10 );

	// Navigation
	ashe_checkbox_control( 'featured_slider', 'navigation', esc_html__( 'Show Navigation Arrows', 'ashe' ), 'refresh', 25 );

	// Pagination
	ashe_checkbox_control( 'featured_slider', 'pagination', esc_html__( 'Show Pagination Dots', 'ashe' ), 'refresh', 30 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_featured_slider', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_featured_slider', array(
				'section'	  => 'ashe_featured_slider',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Slider Options ', 'ashe' ),
				'description' => esc_html( 'wp-royal.com/themes/ashe/customizer/free/featured-slider.html?ref=ashe-free-featured-slider-customizer' ),
				'priority'	  => 100
			)
		)
	);


/*
** Featured Links =====
*/

	// add featured links section
	$wp_customize->add_section( 'ashe_featured_links' , array(
		'title'		 => esc_html__( 'Featured Links', 'ashe' ),
		'priority'	 => 27,
		'capability' => 'edit_theme_options'
	) );

	// Featured Links
	ashe_checkbox_control( 'featured_links', 'label', esc_html__( 'Featured Links', 'ashe' ), 'refresh', 1 );

	// Link #1 Title
	ashe_text_control( 'featured_links', 'title_1', esc_html__( 'Title', 'ashe' ), 'refresh', 9 );

	// Link #1 URL
	ashe_url_control( 'featured_links', 'url_1', esc_html__( 'URL', 'ashe' ), 'refresh', 11 );

	// Link #1 Image
	ashe_image_crop_control( 'featured_links', 'image_1', esc_html__( 'Image', 'ashe' ), 600, 340, 'refresh', 13 );

	// Link #2 Title
	ashe_text_control( 'featured_links', 'title_2', esc_html__( 'Title', 'ashe' ), 'refresh', 15 );

	// Link #2 URL
	ashe_url_control( 'featured_links', 'url_2', esc_html__( 'URL', 'ashe' ), 'refresh', 17 );

	// Link #2 Image
	ashe_image_crop_control( 'featured_links', 'image_2', esc_html__( 'Image', 'ashe' ), 600, 340, 'refresh', 19 );

	// Link #3 Title
	ashe_text_control( 'featured_links', 'title_3', esc_html__( 'Title', 'ashe' ), 'refresh', 21 );

	// Link #3 URL
	ashe_url_control( 'featured_links', 'url_3', esc_html__( 'URL', 'ashe' ), 'refresh', 23 );

	// Link #3 Image
	ashe_image_crop_control( 'featured_links', 'image_3', esc_html__( 'Image', 'ashe' ), 600, 340, 'refresh', 25 );


/*
** Blog Page =====
*/

	// add Blog Page section
	$wp_customize->add_section( 'ashe_blog_page' , array(
		'title'		 => esc_html__( 'Blog Page', 'ashe' ),
		'priority'	 => 29,
		'capability' => 'edit_theme_options'
	) );

	$post_description = array(
		'none' 		=> esc_html__( 'None', 'ashe' ),
		'excerpt' 	=> esc_html__( 'Post Excerpt', 'ashe' ),
		'content' 	=> esc_html__( 'Post Content', 'ashe' ),
	);

	// Post Description
	ashe_select_control( 'blog_page', 'post_description', esc_html__( 'Post Description', 'ashe' ), $post_description, 'refresh', 3 );

	$post_pagination = array(
		'default' 	=> esc_html__( 'Default', 'ashe' ),
		'numeric' 	=> esc_html__( 'Numeric', 'ashe' ),
	);

	// Post Pagination
	ashe_select_control( 'blog_page', 'post_pagination', esc_html__( 'Post Pagination', 'ashe' ), $post_pagination, 'refresh', 5 );

	// Show Categories
	ashe_checkbox_control( 'blog_page', 'show_categories', esc_html__( 'Show Categories', 'ashe' ), 'refresh', 6 );

	// Show Date
	ashe_checkbox_control( 'blog_page', 'show_date', esc_html__( 'Show Date', 'ashe' ), 'refresh', 7 );

	// Show Comments
	ashe_checkbox_control( 'blog_page', 'show_comments', esc_html__( 'Show Comments', 'ashe' ), 'refresh', 9 );

	// Show Drop Caps
	ashe_checkbox_control( 'blog_page', 'show_dropcaps', esc_html__( 'Show Drop Caps', 'ashe' ), 'refresh', 11 );

	// Show Author
	ashe_checkbox_control( 'blog_page', 'show_author', esc_html__( 'Show Author', 'ashe' ), 'refresh', 16 );

	$related_posts = array(
		'none' 		=> esc_html__( 'None', 'ashe' ),
		'related' 	=> esc_html__( 'Related', 'ashe' )
	);

	// Related Posts Orderby
	ashe_select_control( 'blog_page', 'related_orderby', esc_html__( 'Related Posts - Display', 'ashe' ), $related_posts, 'refresh', 33 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_blog_page', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_blog_page', array(
				'section'	  => 'ashe_blog_page',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Blog Options ', 'ashe' ),
				'description' => esc_html( 'wp-royal.com/themes/ashe/customizer/free/blog-page.html?ref=ashe-free-blog-page-customizer' ),
				'priority'	  => 100
			)
		)
	);



/*
** Single Post =====
*/

	// add single post section
	$wp_customize->add_section( 'ashe_single_page' , array(
		'title'		 => esc_html__( 'Single Post', 'ashe' ),
		'priority'	 => 31,
		'capability' => 'edit_theme_options'
	) );

	// Show Categories
	ashe_checkbox_control( 'single_page', 'show_categories', esc_html__( 'Show Categories', 'ashe' ), 'refresh', 5 );

	// Show Date
	ashe_checkbox_control( 'single_page', 'show_date', esc_html__( 'Show Date', 'ashe' ), 'refresh', 7 );

	// Show Comments
	ashe_checkbox_control( 'single_page', 'show_comments', esc_html__( 'Show Comments', 'ashe' ), 'refresh', 13 );

	// Show Author
	ashe_checkbox_control( 'single_page', 'show_author', esc_html__( 'Show Author', 'ashe' ), 'refresh', 15 );

	// Show Author Description
	ashe_checkbox_control( 'single_page', 'show_author_desc', esc_html__( 'Show Author Description', 'ashe' ), 'refresh', 18 );

	// Related Posts Orderby
	ashe_select_control( 'single_page', 'related_orderby', esc_html__( 'Related Posts - Display', 'ashe' ), $related_posts, 'refresh', 23 );


/*
** Social Media =====
*/

	// add social media section
	$wp_customize->add_section( 'ashe_social_media' , array(
		'title'		 => esc_html__( 'Social Media', 'ashe' ),
		'priority'	 => 33,
		'capability' => 'edit_theme_options'
	) );
	
	// Social Window
	ashe_checkbox_control( 'social_media', 'window', esc_html__( 'Open Social Links in New Window', 'ashe' ), 'refresh', 1 );

	// Social Icons Array
	$social_icons = array(
		'facebook' 				=> '&#xf09a;',
		'facebook-official'		=> '&#xf230;',
		'facebook-square' 		=> '&#xf082;',
		'twitter' 				=> '&#xf099;',
		'twitter-square' 		=> '&#xf081;',
		'google' 				=> '&#xf1a0;',
		'google-plus' 			=> '&#xf0d5;',
		'google-plus-official'	=> '&#xf2b3;',
		'google-plus-square'	=> '&#xf0d4;',
		'linkedin'				=> '&#xf0e1;',
		'linkedin-square' 		=> '&#xf08c;',
		'pinterest' 			=> '&#xf0d2;',
		'pinterest-p' 			=> '&#xf231;',
		'pinterest-square'		=> '&#xf0d3;',
		'behance' 				=> '&#xf1b4;',
		'behance-square'		=> '&#xf1b5;',
		'tumblr' 				=> '&#xf173;',
		'tumblr-square' 		=> '&#xf174;',
		'reddit' 				=> '&#xf1a1;',
		'reddit-alien' 			=> '&#xf281;',
		'reddit-square' 		=> '&#xf1a2;',
		'dribbble' 				=> '&#xf17d;',
		'vk' 					=> '&#xf189;',
		'skype' 				=> '&#xf17e;',
		'film' 					=> '&#xf008;',
		'youtube-play' 			=> '&#xf16a;',
		'youtube' 				=> '&#xf167;',
		'youtube-square' 		=> '&#xf166;',
		'vimeo-square' 			=> '&#xf194;',
		'soundcloud' 			=> '&#xf1be;',
		'instagram' 			=> '&#xf16d;',
		'info' 					=> '&#xf129;',
		'info-circle' 			=> '&#xf05a;',
		'flickr' 				=> '&#xf16e;',
		'rss' 					=> '&#xf09e;',
		'rss-square' 			=> '&#xf143;',
		'heart' 				=> '&#xf004;',
		'heart-o' 				=> '&#xf08a;',
		'github' 				=> '&#xf09b;',
		'github-alt' 			=> '&#xf113;',
		'github-square' 		=> '&#xf092;',
		'stack-overflow' 		=> '&#xf16c;',
		'qq' 					=> '&#xf1d6;',
		'weibo' 				=> '&#xf18a;',
		'weixin' 				=> '&#xf1d7;',
		'xing' 					=> '&#xf168;',
		'xing-square' 			=> '&#xf169;',
		'gamepad' 				=> '&#xf11b;',
		'medium' 				=> '&#xf23a;',
		'map-marker' 			=> '&#xf041;',
		'envelope' 				=> '&#xf0e0;',
		'envelope-o' 			=> '&#xf003;',
		'envelope-square ' 		=> '&#xf199;',
		'etsy' 					=> '&#xf2d7;',
		'snapchat' 				=> '&#xf2ab;',
		'snapchat-ghost' 		=> '&#xf2ac;',
		'snapchat-square'		=> '&#xf2ad;',
		'spotify'				=> '&#xf1bc;',
		'shopping-cart'			=> '&#xf07a;',
		'meetup' 				=> '&#xf2e0;',
		'cc-paypal' 			=> '&#xf1f4;',
		'credit-card' 			=> '&#xf09d;',
	);

	// Social #1 Icon
	ashe_select_control( 'social_media', 'icon_1', esc_html__( 'Select Icon', 'ashe' ), $social_icons, 'refresh', 3 );

	// Social #1 Icon
	ashe_url_control( 'social_media', 'url_1', esc_html__( 'URL', 'ashe' ), 'refresh', 5 );

	// Social #2 Icon
	ashe_select_control( 'social_media', 'icon_2', esc_html__( 'Select Icon', 'ashe' ), $social_icons, 'refresh', 7 );

	// Social #2 Icon
	ashe_url_control( 'social_media', 'url_2', esc_html__( 'URL', 'ashe' ), 'refresh', 9 );

	// Social #3 Icon
	ashe_select_control( 'social_media', 'icon_3', esc_html__( 'Select Icon', 'ashe' ), $social_icons, 'refresh', 11 );

	// Social #3 Icon
	ashe_url_control( 'social_media', 'url_3', esc_html__( 'URL', 'ashe' ), 'refresh', 13 );

	// Social #4 Icon
	ashe_select_control( 'social_media', 'icon_4', esc_html__( 'Select Icon', 'ashe' ), $social_icons, 'refresh', 15 );

	// Social #4 Icon
	ashe_url_control( 'social_media', 'url_4', esc_html__( 'URL', 'ashe' ), 'refresh', 17 );


/*
** Typography =====
*/
	// add Typography section
	$wp_customize->add_section( 'ashe_typography' , array(
		'title'		 => esc_html__( 'Typography', 'ashe' ),
		'priority'	 => 34,
		'capability' => 'edit_theme_options'
	) );

	$font_family = array(
		'Open+Sans' => esc_html__( 'Open Sans', 'ashe' ),
		'Rokkitt' 	=> esc_html__( 'Rokkitt', 'ashe' ),
		'Kalam' 	=> esc_html__( 'Kalam', 'ashe' )
	);

	// Logo Font Family
	ashe_select_control( 'typography', 'logo_family', esc_html__( 'Font Family', 'ashe' ), $font_family, 'refresh', 1 );

	// Navigation Font Family
	ashe_select_control( 'typography', 'nav_family', esc_html__( 'Font Family', 'ashe' ), $font_family, 'refresh', 5 );

	// Italic
	ashe_checkbox_control( 'typography', 'nav_italic', esc_html__( 'Italic', 'ashe' ), 'postMessage', 7 );

	// Uppercase
	ashe_checkbox_control( 'typography', 'nav_uppercase', esc_html__( 'Uppercase', 'ashe' ), 'postMessage', 8 );


	// Pro Version
	$wp_customize->add_setting( 'pro_version_typography', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_typography', array(
				'section'	  => 'ashe_typography',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Typography Options', 'ashe' ),
				'description' => esc_html( 'wp-royal.com/themes/ashe/customizer/free/typography-logo.html?ref=ashe-free-typography-customizer' ),
				'priority'	  => 10
			)
		)
	);



/*
** Page Footer =====
*/

	// add page footer section
	$wp_customize->add_section( 'ashe_page_footer' , array(
		'title'		 => esc_html__( 'Page Footer', 'ashe' ),
		'priority'	 => 35,
		'capability' => 'edit_theme_options'
	) );

	$copyright_description = 'Enter <strong>$year</strong> to update the year automatically and <strong>$copy</strong> for the copyright symbol.<br><br>Example: $year Ashe Theme $copy.';

	// Copyright
	ashe_textarea_control( 'page_footer', 'copyright', esc_html__( 'Your Copyright Text', 'ashe' ), $copyright_description, 'refresh', 3 );

	// Show Scroll-Top Button
	ashe_checkbox_control( 'page_footer', 'show_scrolltop', esc_html__( 'Show Scroll-Top Button', 'ashe' ), 'refresh', 5 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_page_footer', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_page_footer', array(
				'section'	  => 'ashe_page_footer',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Footer Options', 'ashe' ),
				'description' => esc_html( 'wp-royal.com/themes/ashe/customizer/free/page-footer.html?ref=ashe-free-page-footer-customizer' ),
				'priority'	  => 100
			)
		)
	);


/*
** Preloader =====
*/

	// add Preloader section
	$wp_customize->add_section( 'ashe_preloader' , array(
		'title'		 => esc_html__( 'Preloader', 'ashe' ),
		'priority'	 => 45,
		'capability' => 'edit_theme_options'
	) );

	// Preloading Animation
	ashe_checkbox_control( 'preloader', 'label', esc_html__( 'Preloading Animation', 'ashe' ), 'refresh', 1 );


/*
** Responsive =====
*/

	// add Responsive section
	$wp_customize->add_section( 'ashe_responsive' , array(
		'title'		  => esc_html__( 'Responsive', 'ashe' ),
		'description' => esc_html__( 'These options will only apply to Mobile devices.', 'ashe' ),
		'priority'	  => 50,
		'capability'  => 'edit_theme_options'
	) );


	// Merge to Responsive Menu
	ashe_checkbox_control( 'main_nav', 'merge_menu', esc_html__( 'Merge Top and Main Menus', 'ashe' ), 'refresh', 1 );
	
	// Featured Slider
	ashe_checkbox_control( 'responsive', 'featured_slider', esc_html__( 'Show Featured Slider', 'ashe' ), 'refresh', 3 );

	// Featured Links
	ashe_checkbox_control( 'responsive', 'featured_links', esc_html__( 'Show Featured Links', 'ashe' ), 'refresh', 5 );

	// Related Posts
	ashe_checkbox_control( 'responsive', 'related_posts', esc_html__( 'Show Related Posts', 'ashe' ), 'refresh', 7 );
	

}
add_action( 'customize_register', 'ashe_customize_register' );


/*
** Bind JS handlers to instantly live-preview changes
*/
function ashe_customize_preview_js() {
	wp_enqueue_script( 'ashe-customize-preview', get_theme_file_uri( '/inc/customizer/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'ashe_customize_preview_js' );

/*
** Load dynamic logic for the customizer controls area.
*/
function ashe_panels_js() {
	wp_enqueue_style( 'fontawesome', get_theme_file_uri( '/assets/css/font-awesome.css' ) );
	wp_enqueue_style( 'ashe-customizer-ui-css', get_theme_file_uri( '/inc/customizer/css/customizer-ui.css' ) );
	wp_enqueue_script( 'ashe-customize-controls', get_theme_file_uri( '/inc/customizer/js/customize-controls.js' ), array(), '1.0', true );

}
add_action( 'customize_controls_enqueue_scripts', 'ashe_panels_js' );
