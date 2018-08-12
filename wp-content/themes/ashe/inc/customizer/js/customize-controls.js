/*
** Scripts within the customizer controls window.
*/

(function( $ ) {
	wp.customize.bind( 'ready', function() {

	/*
	** Reusable Functions
	*/
		// Label
		function ashe_customizer_label( id, title, video ) {

			var video_icon = '';

			if ( video !== '' ) {
				video_icon = '<a href="'+ video +'" target="_blank" title="Video Tutorial">Video Guide <span class="dashicons dashicons-video-alt3 video-tutorial"></span></a>';
			}

			if ( id === 'custom_logo' || id === 'site_icon' || id === 'background_image' ) {
				$( '#customize-control-'+ id ).before('<li class="tab-title customize-control">'+ title + video_icon +'</li>');
			} else {
				$( '#customize-control-ashe_options-'+ id ).before('<li class="tab-title customize-control">'+ title + video_icon +'</li>');
			}
			
		}

		// Checkbox Label
		function ashe_customizer_checkbox_label( id, video ) {

			var id = '#customize-control-ashe_options-'+ id;

			var video_icon = '';

			if ( video !== '' ) {
				video_icon = '<a href="'+ video +'" target="_blank" title="Video Tutorial">Video Guide <span class="dashicons dashicons-video-alt3 video-tutorial"></span></a>';
			}

			$( id ).addClass('tab-title').append( video_icon );

			// on change
			$( id ).find('input[type="checkbox"]').change(function() {
				if ( $(this).is(':checked') ) {
					$(this).closest('li').parent('ul').find('li').not( '.section-meta,.tab-title'+ id ).find('.control-lock').remove();
				} else {
					$(this).closest('li').parent('ul').find('li').not( '.section-meta,.tab-title'+ id ).append('<div class="control-lock"></div>');
				}
			});

			// on load
			if ( ! $( id ).find('input[type="checkbox"]').is(':checked') ) {
				$( id ).closest('li').parent('ul').find('li').not( '.section-meta,.tab-title'+ id ).append('<div class="control-lock"></div>');
			}

		}

		// Select
		function ashe_customizer_select( select, children, value ) {

			// on change
			$( '#customize-control-ashe_options-'+ select ).find('select').change(function() {
				if ( $(this).val() === value ) {
					$(children).show();
				} else {
					$(children).hide();
				}
			});

			// on load
			if ( $( '#customize-control-ashe_options-'+ select ).find('select').val() === value ) {
				$(children).show();
			} else {
				$(children).hide();
			}

		}


	/*
	** Tabs
	*/

		// Colors
		ashe_customizer_label( 'colors_content_accent', 'General', 'https://www.youtube.com/watch?v=cW6qT8OocpE' );
		ashe_customizer_label( 'background_image', 'Body Background', '' );

		// General Layouts
		ashe_customizer_label( 'general_sidebar_width', 'General', 'https://www.youtube.com/watch?v=WhEWOo8PoB0' );
		ashe_customizer_label( 'general_home_layout', 'Page Layouts', '' );
		ashe_customizer_label( 'general_header_width', 'Boxed Controls', '' );

		// Top Bar
		ashe_customizer_checkbox_label( 'top_bar_label', '' );

		// Page Header
		ashe_customizer_checkbox_label( 'header_image_label', 'https://www.youtube.com/watch?v=xH4Z-d_KlQk' );

		// Site Identity
		ashe_customizer_label( 'custom_logo', 'Logo Setup', 'https://www.youtube.com/watch?v=W_IoRYj1pKY' );
		ashe_customizer_label( 'site_icon', 'Favicon', '' );

		// Main Navigation
		ashe_customizer_checkbox_label( 'main_nav_label', '' );

		// Featured Slider
		ashe_customizer_checkbox_label( 'featured_slider_label', 'https://www.youtube.com/watch?v=H9i-cKOey98' );

		// Featured Links
		ashe_customizer_checkbox_label( 'featured_links_label', 'https://www.youtube.com/watch?v=pCtjGwieCoo' );
		ashe_customizer_label( 'featured_links_title_1', 'Featured Link #1', '' );
		ashe_customizer_label( 'featured_links_title_2', 'Featured Link #2', '' );
		ashe_customizer_label( 'featured_links_title_3', 'Featured Link #3', '' );

		// Blog Page
		ashe_customizer_label( 'blog_page_post_description', 'General', 'https://www.youtube.com/watch?v=DgtVfFQo7H8' );
		ashe_customizer_label( 'blog_page_show_categories', 'Post Elements', '' );

		// Single Page
		ashe_customizer_label( 'single_page_show_categories', 'Post Elements', '' );
		ashe_customizer_label( 'single_page_related_title', 'Post Footer', '' );
		
		// Social Media
		ashe_customizer_label( 'social_media_icon_1', 'Social Icon #1', 'https://www.youtube.com/watch?v=yiQLoofNYYs' );
		ashe_customizer_label( 'social_media_icon_2', 'Social Icon #2', '' );
		ashe_customizer_label( 'social_media_icon_3', 'Social Icon #3', '' );
		ashe_customizer_label( 'social_media_icon_4', 'Social Icon #4', '' );

		// Typography
		ashe_customizer_label( 'typography_logo_family', 'Logo', '' );
		ashe_customizer_label( 'typography_nav_family', 'Navigation', '' );

		// Copyright
		ashe_customizer_label( 'page_footer_copyright', 'Copyright', 'https://www.youtube.com/watch?v=NoOQmxSm5rk' );

		// Contditional Logics
		ashe_customizer_select( 'featured_slider_display', '#customize-control-ashe_options-featured_slider_category', 'category' );
		ashe_customizer_select( 'blog_page_post_description', '#customize-control-ashe_options-blog_page_excerpt_length,#customize-control-ashe_options-blog_page_grid_excerpt_length', 'excerpt' );


		// Add bottom space to tabs
		$('.tab-title').prev('li').not('.customize-section-description-container').css( 'padding-bottom', '20px' );


	/*
	** Fixes
	*/
	$('#customize-control-display_header_text').find('input').change(function(){
		var blogname = $('#customize-control-blogname').find('input').val();
		$('#customize-control-blogname').find('input').val( blogname + ' ').trigger('keyup');
		$('#customize-control-blogname').find('input').val( blogname ).trigger('keyup');
	});

	}); // wp.customize ready
})( jQuery );
