<?php
	function strip($var) {
		$allowed = '<div><span><pre><p><br><hr><hgroup><h1><h2><h3><h4><h5><h6>
	            <ul><ol><li><dl><dt><dd><strong><em><b><i><u>
	            <abbr><address><blockquote><area><audio><video><img>
	            <caption><table><tbody><td><tfoot><th><thead><tr>
	            ';
	
		return strip_tags($var, $allowed);
	}
?>