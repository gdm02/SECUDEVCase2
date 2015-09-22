<?php
	class pager {
		public function __construct ( $num_results = null, $limit = null, $page = null ) {
			if ( !is_null( $num_results ) && !is_null ( $limit ) && !is_null( $page ) ) {
				$this->num_results = $num_results;
				$this->limit = $limit;
				$this->page = $page;
				$this->run();
			}
		}
		
		public function __set ( $name, $value ) {
			switch ( $name ) {
				case 'menu_link_suffix':
				case 'num_results':
				case 'menu_link':
				case 'css_class':
				case 'num_pages':
				case 'offset':
				case 'limit':
				case 'page':
				$this->$name = $value;
				break;
				
				default: throw new \Exception ("Unable to set $name");
			}
		}
		
		public function __get ( $name ) {
			switch ( $name ) {
				case 'menu_link_suffix':
				case 'num_results':
				case 'menu_link':
				case 'css_class':
				case 'num_pages':
				case 'offset':
				case 'limit':
				case 'page':
				$this->$name = $value;
				break;
				
				default: throw new \Exception ("Unable to set $name");
			}
		}
		
		public function run() {
			$this->num_pages = ceil($this->num_results / $this->limit);
			$this->page = max($this->page, 1);
			$this->page = min($this->page, $this->num_pages);
			
			$this->offset = ( $this->page - 1 ) * $this->limit;
		}
		
		public function __toString() {
			$menu = '<ul';
			$menu .= isset( $this->css_class ) ? ' class="'.$this->css_class.'"' : '';
			$menu .= '>';

			/*** if this is page 1 there is no previous link ***/
			if($this->page != 1) {
					$menu .= '<li><a href="'.$this->menu_link.'/'.( $this->page - 1 );
					$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
					$menu .= '">PREV</a></li>';
			}

			/*** loop over the pages ***/
			for( $i = 1; $i <= $this->num_pages; $i++ )  {
					if( $i == $this->page ) {
							$menu .= '<li class="active"><a href="'.$this->menu_link.'/'.$i;
							$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
							$menu .= '">'.$i.'</a></li>';
					}
					else {
							$menu .= '<li><a href="'.$this->menu_link.'/'.$i;
							$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
							$menu .= '">'.$i.'</a></li>';
					}
			}

			/*** if we are on the last page, we do not need the NEXT link ***/
			if( $this->page < $this->num_pages ) {
					$menu .= '<li><a href="'.$this->menu_link.'/'.( $this->page + 1 );
					$menu .= isset( $this->menu_link_suffix ) ? $this->menu_link_suffix : '';
					$menu .= '">Next</a></li>';
			}
			return $menu;
		}
	}
?>