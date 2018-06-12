<?php if ( $enable_category === 'yes' ) {
	$categories = wp_get_post_terms( get_the_ID(), 'course-category' );
	
	if ( ! empty( $categories ) ) { ?>
		<div class="eltdf-cli-category-holder">
			<span aria-hidden="true" class="icon_tag eltdf-category-icon"></span>
			<?php foreach ( $categories as $cat ) { ?>
				<a itemprop="url" class="eltdf-cli-category" href="<?php echo esc_url( get_term_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
			<?php } ?>
		</div>
	<?php } ?>
<?php } ?>