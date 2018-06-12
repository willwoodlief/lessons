<div class="eltdf-rating-form-title-holder">
	<div class="eltdf-comment-form-rating">
		<label><?php esc_html_e( 'Rating', 'eltdf-lms' ) ?><span class="required">*</span></label>
		<span class="eltdf-comment-rating-box">
			<?php for ( $i = 1; $i <= 5; $i ++ ) { ?>
				<span class="eltdf-star-rating" data-value="<?php echo esc_attr( $i ); ?>"></span>
			<?php } ?>
			<input type="hidden" name="eltdf_rating" id="eltdf-rating" value="3">
		</span>
	</div>
</div>