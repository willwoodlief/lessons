<form action="" method="post" class="eltdf-buy-item-form">
	<input name="add-to-cart" type="hidden" value="<?php echo get_the_ID(); ?>" />
    <input name="quantity" type="hidden" value="1" />
    <input name="go_to_checkout" type="hidden" value="1" />
	<?php
	if ($width && $height) {
		$style = " style='width: $width ; height:  $height ; ' ";
	} else {
		$style = '';
	}
	?>
	<button type="submit" class="eltdf-btn eltdf-btn-medium eltdf-btn-solid eltdf-btn-default "
		<?= $style ?>  name="ws-add-to-cart">
		<span class="eltdf-btn-text"  <?= $style ?> > <?= $button_text ?></span>
	</button>
</form>