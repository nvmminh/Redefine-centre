<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Sydney
 */
?>
			</div>
		</div>
	</div><!-- #content -->

	<?php do_action('sydney_before_footer'); ?>

	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<?php get_sidebar('footer'); ?>
	<?php endif; ?>

    <a class="go-top"><i class="fa fa-angle-up"></i></a>
	
	
		
	<footer id="colophon" class="site-footer" role="contentinfo">
	
		<div class="site-info container">
		<p align="center">
		&copy; <?php echo date('Y'); ?> <?php bloginfo('sitename'); ?>.
		<span>|</span>
			<a href="<?php echo esc_url( __( 'https://redefinelifecentre.info', 'sydney' ) ); ?>"><?php printf( __( 'Theme edited by %s', 'Team 22' ), 'Team 22' ); ?></a>
			
		<span>|</span>
		<?php _e('All rights reserved'); ?>.
		</p>
		</div><!-- .site-info -->
	
	</footer><!-- #colophon -->
	
	

	<?php do_action('sydney_after_footer'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
