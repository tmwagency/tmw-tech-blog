<?php
route::any('(\d*)', 'main_controller->home', '$1');
route::any('(\d{4})/(\d\d)/(.+)', 'main_controller->article', array('$1', '$2', '$3') );
route::any('code', 'main_controller->code');
route::any('code/(.+)', 'main_controller->code_article', '$1');
route::any('team', 'main_controller->team');
route::any('work', 'main_controller->work');

route::error('404', 'error');
route::error('500', 'error');
