<?php
	function strip($var) {
		$allowed = '<div><span><pre><p><br><hr><hgroup><h1><h2><h3><h4><h5><h6>
	            <ul><ol><li><dl><dt><dd><strong><em><b><i><u>
	            <abbr><address><blockquote><area><audio><video><img>
	            <caption><table><tbody><td><tfoot><th><thead><tr>
	            ';
		//return preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', 
					//strip_tags(trim($var), $allowed));
		$string = strip_tags(trim($var), $allowed);
		$dom = new DOMDocument();
		$dom->loadHTML($string);
		$allowed_attributes = array('src');
		foreach($dom->getElementsByTagName('*') as $node){
			for($i = $node->attributes->length -1; $i >= 0; $i--){
				$attribute = $node->attributes->item($i);
				if(!in_array($attribute->name,$allowed_attributes)) $node->removeAttributeNode($attribute);
			}
		}
		return ($dom->saveHTML());
		//return strip_tags(trim($var), $allowed);
		
	}
	function sanitize_html($string){
		$dom = new DOMDocument();
		$dom->loadHTML($string);
		$allowed_attributes = array('src');
		foreach($dom->getElementsByTagName('*') as $node){
			for($i = $node->attributes->length -1; $i >= 0; $i--){
				$attribute = $node->attributes->item($i);
				if(!in_array($attribute->name,$allowed_attributes)) $node->removeAttributeNode($attribute);
			}
		}
		return ($dom->saveHTML());
	}
	function clean_data($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>