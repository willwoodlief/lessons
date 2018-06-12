<?php
$show_members = get_post_meta( get_the_ID(), 'eltdf_course_members_meta', true );

function eltdf_lms_retrieve_user_ids_from_a_course_id( $course_id ) {
	global $wpdb;
	
	$p    = $wpdb->prefix . "posts";
	$pm   = $wpdb->prefix . "postmeta";
	$woi  = $wpdb->prefix . "woocommerce_order_items";
	$woim = $wpdb->prefix . "woocommerce_order_itemmeta";
	
	$orders_statuses = "'wc-completed', 'wc-processing', 'wc-on-hold'";
	
	if ( eltdf_lms_is_wpml_installed() ) {
		$lang = ICL_LANGUAGE_CODE;
		
		$sql = "SELECT DISTINCT $pm.meta_value
				FROM $p, $pm, $woi, $woim
		        LEFT JOIN {$wpdb->prefix}icl_translations icl_t ON icl_t.element_id = $p.ID
				WHERE $p.post_type = 'shop_order'
				AND $p.post_status IN ( $orders_statuses )
				AND $p.ID = $woi.order_id
				AND $p.ID = $pm.post_id
				AND $pm.meta_key = '_customer_user'
				AND $pm.meta_value > '0'
				AND $woi.order_item_id = $woim.order_item_id
				AND $woi.order_item_type = 'course'
				AND $woim.meta_value LIKE '$course_id'
		        AND icl_t.language_code='{$lang}'
				ORDER BY $pm.meta_value DESC";
		
		$user_ids = $wpdb->get_col( $sql );
	} else {
		$sql = "SELECT DISTINCT $pm.meta_value
				FROM $p, $pm, $woi, $woim
				WHERE $p.post_type = 'shop_order'
				AND $p.post_status IN ( $orders_statuses )
				AND $p.ID = $woi.order_id
				AND $p.ID = $pm.post_id
				AND $pm.meta_key = '_customer_user'
				AND $pm.meta_value > '0'
				AND $woi.order_item_id = $woim.order_item_id
				AND $woi.order_item_type = 'course'
				AND $woim.meta_value LIKE '$course_id'
				ORDER BY $pm.meta_value DESC";
		
		$user_ids = $wpdb->get_col( $sql );
	}
	
	return $user_ids;
}

if ( $show_members === 'yes' && eltdf_lms_is_woocommerce_installed() ) {
	$user_ids = eltdf_lms_retrieve_user_ids_from_a_course_id( get_the_ID() );
	?>
	<div class="eltdf-course-members">
		<div class="eltdf-course-members-heading">
			<h4 class="eltdf-course-members-title"><?php esc_html_e('Members', 'eltdf-lms'); ?></h4>
			<p class="eltdf-course-members-description"><?php esc_html_e('Our course begins with the first step for generating great user experiences: understanding what people do, think, say, and feel. In this module, you’ll learn how to keep an open mind while learning.', 'eltdf-lms') ?></p>
		</div>
		<div class="eltdf-course-members-items">
			<h5 class="eltdf-course-members-items-heading"><?php esc_html_e('Total numbers of students in course', 'eltdf-lms'); ?></h5>
			<ul>
				<?php
				if ( ! empty( $user_ids ) ) {
					foreach ( $user_ids as $id ) { ?>
						<li>
							<span class="eltdf-course-member-item">
								<span class="eltdf-course-member-image">
									<?php echo get_avatar( $id, 70 ); ?>
								</span>
								<span class="eltdf-course-member-content">
									<span class="eltdf-course-member-author-title"><?php echo esc_html( get_the_author_meta( 'display_name', $id ) ); ?></span>
									<span class="eltdf-course-member-author-position"><?php echo esc_html( get_the_author_meta( 'position', $id ) ); ?></span>
								</span>
								<span class="eltdf-course-member-description">
									<?php echo esc_html( strip_tags( get_the_author_meta( 'description', $id ) ) ); ?>
								</span>
							</span>
						</li>
					<?php }
				}
				?>
			</ul>
		</div>
	</div>
<?php }