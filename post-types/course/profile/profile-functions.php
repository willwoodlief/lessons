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
	 * @param integer $user_id
	 * @param string $id
	 *
	 * @return array section id numbered: {is_readable, is_locked: boolean, human: string of time duration }
	 */
	function ecomhub_fi_user_section_progress( $user_id,$id = '' ) {
		$id               = $id === '' ? get_the_ID() : $id;


		// do the whitelist stuff
		$ecom_fi_options = get_option( 'ecomhub_fi_options' );
		if (!$ecom_fi_options) {
			$whitelist = [];
		} else {
			$whitelist = $ecom_fi_options['time_lock_whitelist'];
		}
		$b_is_whitelisted = false;
		//see if user is on whitelist
		if ($user_id) {
			$user = get_user_by( 'ID', $user_id );
			$user_email = $user->user_email;
			foreach ($whitelist as $test_email) {
				if ($test_email == $user_email) {
					$b_is_whitelisted = true;
					break;
				}
			}
		}


		$start = -1;
		if ($user_id) {
			$start_times = get_user_meta( $user_id, 'ecomhub_fi_user_start_course', true );
			if (!$start_times) {
				$start_times = [];
			}


			if (array_key_exists($id,$start_times)) {
				$start = $start_times[ $id ];
			}
		}


		$ret = [];
		// if start < 0 then is_readable is false and is_locked = true and human is "Need to Purchase"
		// if on whitelist then is_readable is true and is_locked = false and human = ''
		for($u = 0; $u < 100; $u++) {
			$node = ['is_readable'=> false, 'is_locked' => true, 'human'=>"Need to Purchase Course"];
			if ($start < 0 && !$b_is_whitelisted)  {
				$ret[] = $node;
				continue;
			}

			if ($b_is_whitelisted) {
				$node = ['is_readable'=> true, 'is_locked' => false, 'human'=>"On Whitelist"];
				$ret[] = $node;
				continue;
			}

			//if got here then the person has a start timestamp >=0 , make the first two sections unlocked right away
			if ($u < 2) {
				$node = ['is_readable'=> true, 'is_locked' => false, 'human'=>"First two sections unlocked always"];
				$ret[] = $node;
				continue;
			}
			$node = [];
			$section_unlocked_at_week = $u -1 ; // the week after the start timestamp the section is unlocked at,
			// 0 means starting week, 1 is the week after that, 2 is two weeks after that etc



			//so here, we see how many weeks they are along, based on their timestamp
			$seconds_in_a_week = (60*60 * 24 * 7);
			$now = time();
			$diff = $now - $start;
			$weeks_unlocked = ceil($diff/$seconds_in_a_week);
			$is_readable = true;
			$node['debug_start_ts'] = $start;
			$node['debug_start'] = date("D M d, Y G:i",$start);
			$node['debug_weeks_unlocked'] = $weeks_unlocked;
			$node['debug_email'] = $user->user_email;
			$human = '';
			$section_unlocks_at = $start + ($section_unlocked_at_week * $seconds_in_a_week);


			//calculate minimum unlocks
			// the first section to unlock is at Tuesday, June 26, 2018 7:30:30 AM
			$min_section_unlock_time = (($section_unlocked_at_week -1) * $seconds_in_a_week) + 1530016230;

			if ($section_unlocks_at < $min_section_unlock_time) {
				$section_unlocks_at = $min_section_unlock_time;
			}

			$node['debug_course_unlocks_at'] = date("D M d, Y G:i",$section_unlocks_at);
			$total_time_from_now_needed_in_seconds = $section_unlocks_at - $now;
			$node['debug_duration_til_unlock_days'] = $total_time_from_now_needed_in_seconds/(60*60*24);


			if ($total_time_from_now_needed_in_seconds < 0) {
				$is_locked = false;
				$human = "unlocked";
			} else {
				$is_locked = true;

				$seconds_in_a_day = 60*60*24;
				$seconds_in_an_hour = 60*60;
				$seconds_in_a_minute = 60;







				$days = floor($total_time_from_now_needed_in_seconds/$seconds_in_a_day);
				$left_over_from_day = $total_time_from_now_needed_in_seconds - ($days* $seconds_in_a_day);
				$hours = floor($left_over_from_day  /$seconds_in_an_hour);
				$left_over_from_hour =  $total_time_from_now_needed_in_seconds - ($days* $seconds_in_a_day) - ($hours* $seconds_in_an_hour);
				$minutes = floor($left_over_from_hour  /$seconds_in_a_minute);
				$seconds =  $total_time_from_now_needed_in_seconds - ($days* $seconds_in_a_day) - ($hours* $seconds_in_an_hour) - ($minutes * $seconds_in_a_minute);
				if ($days > 0) {
					if ($days == 1) {
						$human .= "$days Day ";
					} else {
						$human .= "$days Days ";
					}
				}

				if ($hours > 0) {
					if ($hours == 1) {
						$human .= "$hours Hour ";
					} else {
						$human .= "$hours Hours ";
					}
				}

				if ($minutes > 0) {
					if ($minutes == 1) {
						$human .= "$minutes Minute ";
					} else {
						$human .= "$minutes Minutes ";
					}
				}

				if ($days == 0 && $hours == 0 ) {
					if ($days == 1) {
						$human .= "$seconds Second ";
					} else {
						$human .= "$seconds Seconds ";
					}
				}
			}
			$node['is_readable'] =  $is_readable;
			$node['is_locked'] = $is_locked;
			$node['human'] = $human;

			$ret[]= $node;
		}

		return $ret;
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
						$start_times[$product_id] = time() ;
						update_user_meta( get_current_user_id(), 'ecomhub_fi_user_start_course', $start_times );
					}


					// end changes by will
					return true;
				}
			}
		}
		return false;
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
					/** @noinspection PhpUndefinedMethodInspection */
					$product_id = $item->get_product_id();
					$post_type  = get_post_type($product_id);
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
