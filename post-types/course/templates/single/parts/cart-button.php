<?php if ( eltdf_lms_core_plugin_installed() ) {
	$cart_url = wc_get_cart_url();
	?>
	<?php echo esmarts_elated_get_button_html( array(
		'text' => esc_html__( 'View Cart', 'eltdf-lms' ),
		'link' => $cart_url
	) ); ?>
<?php } else { ?>
	<a href="<?php echo esc_url( $cart_url ); ?>" class="eltdf-btn eltdf-btn-medium eltdf-btn-solid"><?php echo esc_html__( 'View Cart', 'eltdf-lms' ); ?></a>
<?php } ?>