<?php

if ( ! is_active_sidebar( 'instagram-widget' ) ) {
	return;
}

?>

<div class="footer-instagram-widget">
	<?php dynamic_sidebar( 'instagram-widget' ); ?>
</div>