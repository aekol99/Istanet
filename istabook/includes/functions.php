<?php
// Start Check If Current Page
function isPage($_page){
	global $page;
	if ($_page == $page) {
		return 'active';
	}else {
		return '';
	}
}
// End Check If Current Page

function isActive($_tab, $_identifier){
	global $page;
	if ($page == 'settings') {
		return ($_identifier == $_tab) ? 'setting-active' : '';
	}
	return ($_identifier == $_tab) ? 'is-active' : 'not-active';
}
