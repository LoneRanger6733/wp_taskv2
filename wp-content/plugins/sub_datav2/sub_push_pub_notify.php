<?php

//Publish Button Function
add_action( 'publish_post', 'send_notification' );
function send_notification( $post_id ) {    

$category_detail=get_the_category($post_id);
        echo $category_detail->cat_name;
        foreach($category_detail as $cd){
        $cat_det =  $cd->cat_name;
        echo $cat_det;
        }

global $wpdb;
$table = $wpdb->prefix."v_sub_tbl";
$table_cat = $wpdb->prefix."v_cat_tbl";
$user_list = $wpdb->get_results("SELECT *, CONCAT_WS('', $table.sub_email) AS user_email FROM $table, $table_cat WHERE $table_cat.sub_id = $table.id AND $table_cat.cat_tag='$cat_det'");
foreach ( $user_list as $ulist )
{
$post     = get_post($post_id);
$post_url = get_permalink( $post_id );
$post_title = get_the_title( $post_id ); 

$subject  = 'Post publish notification';
$message  = "NEW Post Alert !<br />";
$message .= "<a href='". $post_url. "'>'".$post_title."'</a>\n\n"; 


wp_mail($ulist->user_email, $subject, $message );

}
       

}


?>