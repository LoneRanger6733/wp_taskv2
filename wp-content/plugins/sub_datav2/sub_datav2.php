<?php 
/**
 * Plugin Name: MeSubscribev2
 * Plugin URI: http://localhost/wp_task
 * Description: Subscription Management.
 * Version: 0.0.1
 * Author: Komalavasan
 * Author URI: http://localhost/wp_task
 * License: GPLv2 or later
 *   Text Domain: MeSubscribev2-plugin
 */

 /*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/


defined( 'ABSPATH' ) or die( 'Page not Accessible!' );

if ( ! function_exists( 'add_action' ) ) {
	echo 'Page not Accessible!';
	exit;
}



  add_filter( 'widget_text', 'do_shortcode' );


  add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
    if ( $url_path === 'subscribe' ) {
       // load the file if exists
       $load = locate_template('singular.php', true);
       if ($load) {
          exit(); // just exit if template was found and loaded
       }
    }
  });





  // Function to add button shortcode to posts and pages
function btn_shortcode($atts, $content = null){
	
	// shortcode attributes
    extract( shortcode_atts( array(
        'type'    => '',
        'text'   => ''
	), $atts ) );
  
    $cat_title=$_GET['cat'];

	if ( $type ) {
     
        $link_attr = array(
			'type'   => $type,
			'name' => 'sub_form',
			'value'  => 'Subscribe To '. $cat_title,
			'class'  => 'submitbtn'
		);


		$link_attrs_str = '';
 
        foreach ( $link_attr as $key => $val ) {
 
            if ( $val ) {
 
                $link_attrs_str .= ' ' . $key . '="' . $val . '"';
 
            }
 
        }

 
        return '<input' . $link_attrs_str . '><input type=hidden name="tag_title" value="'.$cat_title.'">';
	
}
}


add_shortcode('btn_sub', 'btn_shortcode');


function form_html()
    {
       $cat_title=$_GET['cat'];
       $form .= '<h4 class="entry-title"> Subscribe To '.$cat_title.'</h1>';
       $form .='<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
       $form .= '<input type="text" name="sub_name"  value="' . ( isset( $_POST["sub_name"] ) ? esc_attr( $_POST["sub_name"] ) : '' ) . '" placeholder ="Name" required/> <br />';
       $form .= '<input type="text" name="sub_email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" value="' . ( isset( $_POST["sub_email"] ) ? esc_attr( $_POST["sub_email"] ) : '' ) . '" placeholder ="Email" required/> <br />';
       $form .= '<input type="text" name="sub_phone" pattern="\d*" value="' . ( isset( $_POST["sub_phone"] ) ? esc_attr( $_POST["sub_phone"] ) : '' ) . '" placeholder ="Phone" required/> <br />';
      
       return $form; 
   }
   

add_shortcode('sub_form', 'form_html');

  // Function to add button shortcode to posts and pages
  function red_shortcode($atts, $content = null){
	
	// shortcode attributes
    extract( shortcode_atts( array(
        'class'    => ''
	), $atts ) );
  
	

	if ( $class ) {
     
        $link_attr = array(
			'href'   => 'subscribe/?cat='.get_the_title(),
			'class'  => $class
		);


		$link_attrs_str = '';
 
        foreach ( $link_attr as $key => $val ) {
 
            if ( $val ) {
 
                $link_attrs_str .= ' ' . $key . '="' . $val . '"';
 
            }
 
        }
   $title=get_the_title();
 
        return '<a ' . $link_attrs_str . '> Subscribe To '.get_the_title().'</a><input type=hidden name="tag_title" value="'.$title.'">';
	
}
}

add_shortcode('btn_red', 'red_shortcode');




include_once 'sub_submit_form.php';
?>