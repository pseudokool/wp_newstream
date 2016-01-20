<?php
	/*
	Plugin Name: News Stream
	Plugin URI:  https://github.com/pseudokool/wp_newstream
	Description: A Wordpress plugin, that displays a feed, using category specific post titles.
	Version:     1.0a
	Author:      pseudokool
	Author URI:  https://github.com/pseudokool
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
		        'iSourceCategory' => '25'
		    );
		    $iSourceCategory = $instance[ 'iSourceCategory' ];
	   
		    // markup for form ?>
		    <p>
		        <label for="<?php echo $this->get_field_id( 'iSourceCategory' ); ?>">Post Sort Order</label>
		        <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'iSourceCategory' ); ?>" name="<?php echo $this->get_field_name( 'iSourceCategory' ); ?>" value="<?php echo esc_attr( $iSourceCategory ); ?>">
		    </p>
		             
		<?php
		}
	     
	    function update( $new_instance, $old_instance ) {
		 
		    $instance = $old_instance;
		    $instance[ 'iSourceCategory' ] = strip_tags( $new_instance[ 'iSourceCategory' ] );
		    return $instance;
		     
		}
	     
	    function widget( $args, $instance ) {

	    	$args = array( 'posts_per_page' => 5, 'category' => 4 );
			$myposts = get_posts( $args );
			
			//print_r($myposts); exit;
			$lies = ''; 

			foreach ( $myposts as $post ) {

				//print_r($post);

				$link = the_content();

				$lies .= '<li>';
				$lies .= '<a target="_blank" href="'.$link.'">'.$post->post_title.'</a>';
				$lies .= '</li>';
			}
				
	       	include('newstream.ui.inc.php');
	    }
	     
	}

	function newstream_register() {
	 
	    register_widget( 'Newstream_Widget' );
	 
	}
	add_action( 'widgets_init', 'newstream_register' );
?>