<?php

require_once 'const.php';

//load lib
require_once 'lib/helpers-functions.php';

//load shortcodes
require_once 'lib/shortcode-interface.php';
require_once 'lib/shortcodes-functions.php';

//load reviews
require_once 'reviews/reviews-functions.php';

//load post-post-types
require_once 'lib/post-type-interface.php';
require_once 'post-types/post-types-functions.php';
require_once 'post-types/post-types-register.php'; //this has to be loaded last

//load widgets
require_once( 'widgets/widgets-functions.php' );