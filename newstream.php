<?php
	/*
	Plugin Name: News Stream
	Plugin URI:  http://pseudokool.github.io/wp_newstream/
	Description: A Wordpress plugin, that displays a feed, using category specific post titles.
	Version:     1.0a
	Author:      pseudokool
	Author URI:  https://github.com/pseudokool

	Newstream is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 2 of the License, or
	any later version.
	 
	Newstream is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.
	 
	You should have received a copy of the GNU General Public License
	along with Newstream. If not, see {License URI}.
	*/

	defined( 'ABSPATH' ) or die( 'issec.out' );
	
	class Newstream_Widget extends WP_Widget {
     
	    function __construct() {

	    	parent::__construct(
         
		        // base ID of the widget
		        'newstream_Widget',
		         
		        // name of the widget
		        __('Newstream', 'Newstream' ),
		         
		        // widget options
		        array (
		            'description' => __( 'Newstream.', 'pseudokool' )
		        )
		         
		    );
	    }
	     
	    function form( $instance ) {
 
		    $defaults = array(
		        'iSourceCategory' => '0'
		    );
		    $iSourceCategory = $instance[ 'iSourceCategory' ];
	   
		    // markup for form 
		    ?>
		    
		    <p>
		        <label for="<?php echo $this->get_field_id( 'iSourceCategory' ); ?>">Category</label>
		        
		    	<select class="widefat" id="<?php echo $this->get_field_id( 'iSourceCategory' ); ?>" name="<?php echo $this->get_field_name( 'iSourceCategory' ); ?>">
		    		<?php

		    			$args = array(
						  'orderby' => 'name',
						  'order' => 'ASC'
						  );
						$all_the_categs = get_categories($args);

			    		foreach ( $all_the_categs as $acateg ) {

			    			$selected = ( $acateg->term_id == $iSourceCategory )? 'selected' : '';

			    			echo '<option '.$selected.' value="'.$acateg->term_id.'">'.$acateg->name.'</a>';

						}		    		
						
					?>
		    	</select>	
		    </p>
		             
			<?php
		}
	     
	    function update( $new_instance, $old_instance ) {
		 
		    $instance = $old_instance;
		    $instance[ 'iSourceCategory' ] = strip_tags( $new_instance[ 'iSourceCategory' ] );

		    return $instance;
		     
		}
	     
	    function widget( $args, $instance ) {

	    	$args = array( 'posts_per_page' => 50, 'category' => $instance['iSourceCategory'], 'order' => 'DESC', 'orderby' => 'date');
			$all_the_posts = get_posts( $args );
			
			//print_r($myposts); exit;
			$lies = ''; 

			foreach ( $all_the_posts as $apost ) {

				$lies .= '<li>';
				$lies .= '<a target="_blank" href="'.$apost->post_content.'">'.$apost->post_title.'</a>';
				$lies .= '</li>';

			}
				
	       	include('includes/newstream.ui.inc.php');
	    }
	     
	}

	function newstream_register() {
	 
	    register_widget( 'Newstream_Widget' );
	 
	}
	add_action( 'widgets_init', 'newstream_register' );
?>