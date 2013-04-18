<?php  
/* 
Plugin Name: CSS3 Accordion
Description: CSS3 Accordions in Wordpress
Author: Brian Crigler 
Author URI: briancrigler@hotmail.com
Version: 0.1 Beta 
*/  
function css_accord_scripts() {
	if (!is_admin()) {
	//register
	wp_register_script('css_accord-script', plugins_url('js/modernizr.custom.29473.js', __FILE__), array( 'modernizer'));

	//enqueue
	wp_enqueue_script('css_accord-script');
	}
}

function css_accord_styles() {
	//register
	wp_register_style('css_styles', plugins_url('css/style.css', __FILE__));
	
	//enqueue
	wp_enqueue_style('css_styles');
}

function accord_function($type='accord_function') {
    $args = array('post_type' => 'accordion', 'posts_per_page' => 1000000);
    $result = '<section class="ac-container">';
    //the loop
    $loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();
        $postid = get_the_ID();
		$result .= '<div>';
	    $result .= '<input id="ac-'.$postid.'" name="accordion-'.$postid.'" type="checkbox" />';
        $result .= '<label for="ac-'.$postid.'">'.get_the_title().'</label>';
        $result .= '<article class="ac-small"><p>'.get_the_excerpt().'</p></article>';
		$result .='</div>';
    }
    
    $result .='</section>';
    return $result;
}

function accord_init() {
	add_shortcode('accordions', 'accord_function');
	$args = array(
		'public' => true,
		'label' => 'CSS3 Accordions',
		'supports' => array(
			'title',
			'editor'
		)
	);
	register_post_type('accordion', $args);
}
//Hooks
add_action('init', 'accord_init');
add_action('wp_print_scripts', 'css_accord_scripts');
add_action('wp_print_styles', 'css_accord_styles');
?>