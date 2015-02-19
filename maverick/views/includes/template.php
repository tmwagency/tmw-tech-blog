<?php
include MAVERICK_VIEWSDIR .'includes/html_start.php';

include MAVERICK_VIEWSDIR .'includes/masthead.php';
include MAVERICK_VIEWSDIR .'includes/footer.php';

include MAVERICK_VIEWSDIR . data::get('page') . '.php';

include MAVERICK_VIEWSDIR .'includes/html_end.php';
