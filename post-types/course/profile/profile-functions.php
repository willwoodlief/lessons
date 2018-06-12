<?php

if ( ! function_exists( 'eltdf_lms_add_profile_navigation_item' ) ) {
	function eltdf_lms_add_profile_navigation_item( $navigation, $dashboard_url ) {

		$navigation['courses'] = array(
			'url'         => esc_url( add_query_arg( array( 'user-action' => 'courses' ), $dashboard_url ) ),
			'text'        => esc_html__( 'Courses', 'eltdf-lms' ),
			'user_action' => 'courses',
			'icon'        => '<i class="lnr lnr-file-empty"></i>'
		);

		$navigation['course-favorites'] = array(
			'url'         => esc_url( add_query_arg( array( 'user-action' => 'course-favorites' ), $dashboard_url ) ),
			'text'        => esc_html__( 'Courses Wishlist', 'eltdf-lms' ),
			'user_action' => 'course-favorites',
			'icon'        => '<i class="lnr lnr-heart"></i>'
		);

		return $navigation;
	}

	add_filter( 'eltdf_membership_dashboard_navigation_pages', 'eltdf_lms_add_profile_navigation_item', 10, 2 );
}

if ( ! function_exists( 'eltdf_lms_add_profile_navigation_pages' ) ) {
	function eltdf_lms_add_profile_navigation_pages( $pages ) {
		$pages['courses']          = eltdf_lms_cpt_single_module_template_part( 'profile/templates/courses-list', 'course' );
		$pages['course-favorites'] = eltdf_lms_cpt_single_module_template_part( 'profile/templates/favorites-list', 'course' );

		return $pages;
	}

	add_filter( 'eltdf_membership_dashboard_pages', 'eltdf_lms_add_profile_navigation_pages' );
}

if ( ! function_exists( 'eltdf_lms_get_user_orders' ) ) {
	function eltdf_lms_get_user_orders() {
		$customer_orders = array();

		if ( get_current_user_id() > 0 ) {
			$customer_orders = wc_get_orders(
				array(
					'customer' => get_current_user_id()
				)
			);
		}

		return $customer_orders;
	}
}

if ( ! function_exists( 'ecomhub_fi_user_section_progress' ) ) {

	/**
	 * returns 0 based index of section unlocked, as well as the seconds until next unlock
	 * @param string $id
	 *
	 * @return array (last_unlocked_section, next_unlock_span)
	 */
	function ecomhub_fi_user_section_progress( $id = '' ) {
		$id               = $id === '' ? get_the_ID() : $id;
		if (!get_current_user_id()) {
			return ['last_unlocked_section' => -1,'next_unlock_span' => null, 'human' => 'Not Registered'];
		}
		$start_times = get_user_meta( get_current_user_id(), 'ecomhub_fi_user_start_course', true );
		if (!$start_times) {
			$start_times = [];
		}

		if (array_key_exists($id,$start_times)) {
			$start = $start_times[$id];
			$now = time();
			$diff = $now - $start;
			$time_per_section = (60*60 * 24 * 6) + (60*60*4); // 24*6 + 4 days and hours
			$section = intval(floor($diff / $time_per_section));
			$left_over = fmod($diff,$time_per_section);
			$next_time_unlock = ($section +1) * $time_per_section;
			$wait_remaining =  $next_time_unlock - $left_over;

			//get human time span
			//rules
			// if greater than one day , put out number of days
			// if less than a day, put out number of hours
			// hh:mm:ss on the last hour
			// count down timer: MM:SS on the last minute
			//
			if ($wait_remaining > 60*60*24 * 2) {
				$days = intval(floor($wait_remaining/(60*60*24)));
				$human = "$days Days";
			} elseif ($wait_remaining > 60*60*24 * 1) {
				$human = "1 Day";
			} elseif ($wait_remaining > 60*60*24 ) {
				//hours and minutes
				$hours = intval(floor($wait_remaining/(60*60)));
				$minutes = intval(floor($wait_remaining- ($hours*60*60)/60));
				$human = "$hours Hours $minutes $minutes";
			} else {
				//minutes and seconds if just an hour
				$minutes = intval(floor($wait_remaining/60));
				$seconds = intval(floor($wait_remaining-($minutes*60)));
				$human = "$minutes Minutes $seconds Seconds";
			}
			return ['last_unlocked_section' => $section,'next_unlock_span' => $wait_remaining, 'human' => $human];
		} else {
			return ['last_unlocked_section' => -1,'next_unlock_span' => null, 'human' => 'Not Registered'];
		}
	}
}

if ( ! function_exists( 'eltdf_lms_user_has_course' ) ) {
	function eltdf_lms_user_has_course( $id = '' ) {
		$id               = $id === '' ? get_the_ID() : $id;
		$customers_orders = eltdf_lms_get_user_orders();


		foreach ( $customers_orders as $customer_order ) {
			$items = $customer_order->get_items();

			foreach ( $items as $item ) {
				$order_status    = $customer_order->get_status();
				$order_completed = $order_status == 'completed' ? true : false;
				$data            = $item->get_data();
				$product_id      = $data['product_id'];
				// changed by will, when purchased through the rest api of woo, this will not be a Item Course
				//	if ( is_a( $item, 'WC_Order_Item_Course' ) && $product_id == $id && $order_completed ) {
				if (  $product_id == $id && $order_completed ) {

					//check to make sure they have a timestamp for the course
					$start_times = get_user_meta( get_current_user_id(), 'ecomhub_fi_user_start_course', true );
					if (!$start_times) {
						$start_times = [];
					}

					if (!array_key_exists($product_id,$start_times)) {
						$start_times[$product_id] = time();
						update_user_meta( get_current_user_id(), 'ecomhub_fi_user_start_course', $start_times );
					}


					// end changes by will
					return true;
				}
			}
		}
	}
}

if ( ! function_exists( 'eltdf_lms_user_completed_prerequired_course' ) ) {
	function eltdf_lms_user_completed_prerequired_course( $id = '' ) {
		$id                 = $id === '' ? get_the_ID() : $id;
		$user_courses       = get_user_meta( get_current_user_id(), 'eltdf_user_course_status', true );
		$prerequired_course = get_post_meta( $id, 'eltdf_course_prerequired_meta', true );

		if ( isset( $prerequired_course ) && ! empty( $prerequired_course ) ) {
			if ( isset( $user_courses ) && ! empty( $user_courses ) ) {
				if ( ! array_key_exists( $prerequired_course, $user_courses ) ) {
					return false;
				} else if ( $user_courses[ $prerequired_course ] == 'completed' ) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		return true;
	}
}

if ( ! function_exists( 'eltdf_lms_get_user_profile_course_items' ) ) {
	function eltdf_lms_get_user_profile_course_items() {
		$customer_orders = eltdf_lms_get_user_orders();

		$formatted_orders = array();
		if ( ! empty( $customer_orders ) ) {
			foreach ( $customer_orders as $customer_order ) {
				$items = $customer_order->get_items();

				// changed by will, we have to filter a different way

				foreach ( $items as $item_id => $item ) {
					$product_id = $item->get_product_id();
					$post_type = get_post_type($product_id);
					if ( $post_type == "course") {
						$item['order_status'] = $customer_order->get_status();
						array_push( $formatted_orders, $item );
					}
				}

//				foreach ( $items as $item_id => $item ) {
//					if ( is_a( $item, 'WC_Order_Item_Course' ) ) {
//						$item['order_status'] = $customer_order->get_status();
//						array_push( $formatted_orders, $item );
//					}
//				}
				// end changes by will
			}
		}

		return $formatted_orders;
	}
}
