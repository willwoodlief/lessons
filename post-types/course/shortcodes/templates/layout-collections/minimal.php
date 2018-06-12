<?php if ( $enable_image == 'yes' ) { ?>
	<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/image', $item_layout, $params ); ?>
<?php } ?>

<div class="eltdf-cli-text-holder">
	<div class="eltdf-cli-text-inner">
		<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/title', $item_layout, $params ); ?>
		<div class="eltdf-cli-top-info">
			<?php if ( $enable_instructor == 'yes' ) { ?>
				<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/instructor-simple', $item_layout, $params ); ?>
			<?php } ?>
			<?php if ( $enable_price == 'yes' ) { ?>
				<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/price', $item_layout, $params ); ?>
			<?php } ?>
		</div>
	</div>
</div>