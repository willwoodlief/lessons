<form action="" method="post" class="eltdf-lms-retake-course-form">
	<input type="hidden" name="eltdf_lms_course_id" value="<?php echo get_the_ID(); ?>"/>

    <?php
    if (isset($button_text)) {
	    $text_of_button = $button_text;
    } else {
	    $text_of_button = esc_html__( 'Retake', 'eltdf-lms' );
    }
    ?>

    <?php if ( eltdf_lms_core_plugin_installed() ) {


	    $button_html = esmarts_elated_get_button_html( array(
		    'html_type'  => 'input',
		    'text'       => $text_of_button,
		    'input_name' => 'submit'
	    ) );

	    if (isset($height) && isset($width)) {
		    preg_match("/(?P<first>\<button|\<input)([\s]*)(?P<last>type.*)/", $button_html, $output_array);
		    $button_html = $output_array['first'] . "  style='width: $width ; height:  $height ; '  " .  $output_array['last'];
        }

	    echo $button_html;

	    ?>
	<?php } else {
		if ($width && $height) {
			$style = " style='width: $width ; height:  $height ; ' ";
		} else {
			$style = '';
		}
		?>
		<input name="submit"  <?=  $style ?>type="submit" value="<?php echo $text_of_button; ?>"/>
	<?php } ?>
</form>
