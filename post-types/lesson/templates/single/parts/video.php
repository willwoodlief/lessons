<?php
$video_type     = get_post_meta( get_the_ID(), "eltdf_lesson_video_type_meta", true );
$has_video_link = get_post_meta( get_the_ID(), "eltdf_lesson_video_custom_meta", true ) !== '' || get_post_meta( get_the_ID(), "eltdf_lesson_video_link_meta", true ) !== '';
?>
<?php if ( $has_video_link ) { ?>
	<div class="eltdf-lesson-video-holder">
		<?php
		if ( $video_type == 'social_networks' ) {
			$videolink = get_post_meta( get_the_ID(), "eltdf_lesson_video_link_meta", true );
			/*


			 */
			$thing =  wp_oembed_get( esc_url($videolink) );
			preg_match("/(?P<first>\<iframe)([\s]*)(?P<last>src.*)/", $thing, $output_array);
			$new_thing = $output_array['first'] . ' onload="ecomhub_fi_initial_vimeo_resize() "  ' .  $output_array['last'];
			echo $new_thing;
			print "\n<script>
                function ecomhub_fi_initial_vimeo_resize() {
                    var height = $('div.eltdf-course-popup-inner').height() - $('div.eltdf-popup-content').position().top;
                    var iframe_height = $('iframe').height();
                 //   if (iframe_height > height - 100) {
                        var width = $('div.eltdf-lesson-video-holder').width() * 0.75;
                        $('iframe').width(width);
                        $('iframe').height(height);
                        console.log('new stuff');
                 //   } 
                    //console.log('frame load finished');
                }
                
                $(function() {
                   // console.log('on load called for me');
                    $( window ).resize(function() {
                       // console.log('resize for me');
                        var height = $('div.eltdf-course-popup-inner').height() - $('div.eltdf-popup-content').position().top;
                        var iframe_height = $('iframe').height();
                        //if (iframe_height > height - 100) {
                            var width = $('div.eltdf-lesson-video-holder').width() * 0.75;
                            $('iframe').width(width);
                            $('iframe').height(height);
                        //}  
                    });
                });
            </script>";
		} else if ( $video_type == 'self' ) {
			$videolink  = get_post_meta(get_the_ID(), "eltdf_lesson_video_custom_meta", true);
			$videoimage = get_post_meta(get_the_ID(), "eltdf_lesson_video_image_meta", true);
			$flashmedia = get_template_directory_uri() . '/assets/js/flashmediaelement.swf';
			?>
			<div class="eltdf-self-hosted-video-holder" style="text-align: center">
				<div class="eltdf-video-wrap">
					<video class="eltdf-self-hosted-video" poster="<?php echo esc_url( $videoimage ); ?>" preload="auto">
						<?php if ( ! empty( $videolink ) ) { ?> <source type="video/mp4" src="<?php echo esc_url( $videolink ); ?>"> <?php } ?>
						<object width="320" height="240" type="application/x-shockwave-flash" data="<?php echo esc_url( $flashmedia ); ?>">
							<param name="movie" value="<?php echo esc_url( $flashmedia ); ?>"/>
							<param name="flashvars" value="controls=true&file=<?php echo esc_url( $videolink ); ?>" />
							<img itemprop="image" src="<?php echo esc_url( $videoimage ); ?>" width="1920" height="800" title="<?php esc_attr_e( 'No video playback capabilities', 'esmarts' ); ?>" alt="<?php esc_html_e( 'Video Thumb', 'esmarts' ); ?>"/>
						</object>
					</video>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>