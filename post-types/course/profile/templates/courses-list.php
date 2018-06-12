<?php
$customer_orders = eltdf_lms_get_user_profile_course_items();
?>
<div class="eltdf-lms-profile-courses-holder">
	<?php if ( ! empty( $customer_orders ) ) { ?>
		<?php
		foreach ( $customer_orders as $customer_order ) {
			$id           = $customer_order['product_id'];
			$name         = $customer_order['name'];
			$order_status = $customer_order['order_status'];
			?>
			<div class="eltdf-lms-profile-course-item">
				<div class="eltdf-lms-profile-course-item-image">
					<?php
					if ( has_post_thumbnail( $id ) ) {
						$image = get_the_post_thumbnail_url( $id, 'thumbnail' );
					} else {
						$image = MIKADO_LMS_CPT_URL_PATH . '/course/assets/img/course_featured_image.jpg';
					}
					?>
					<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $id ) ); ?>">
						<img src="<?php echo esc_attr( $image ); ?>" alt="<?php echo esc_attr( 'Course thumbnail', 'eltdf-lms' ) ?>"/>
					</a>
				</div>
				<div class="eltdf-lms-profile-course-item-title">
					<h4>
                        <span class="eltdf-profile-course-title">
                            <?php echo esc_html( $name ); ?>
                        </span>
						<span class="eltdf-profile-course-status">
                        <?php
                        echo esc_html( '(' );
	                        if ( $order_status !== 'completed' ) {
		                        echo wc_get_order_status_name( $order_status );
	                        } else { ?>
		                        <a href="<?php echo get_the_permalink( $id ); ?>">
	                            <?php
	                            $user_current_course_status = eltdf_lms_user_current_course_status( $id );
	                            if ( $user_current_course_status == 'completed' ) {
		                            esc_html_e( 'Retake', 'eltdf-lms' );
	                            } else if ( $user_current_course_status == 'in-progress' ) {
		                            esc_html_e( 'Resume', 'eltdf-lms' );
	                            } else {
		                            esc_html_e( 'Start ', 'eltdf-lms' );
	                            } ?>
	                            </a>
		                        <?php
	                        }
                        echo esc_html( ')' );
                        ?>
                        </span>
					</h4>
				</div>
			</div>
			<?php
		}
	} else { ?>
		<h3><?php esc_html_e( "Your courses list is empty.", 'eltdf-lms' ) ?> </h3>
	<?php } ?>
</div>