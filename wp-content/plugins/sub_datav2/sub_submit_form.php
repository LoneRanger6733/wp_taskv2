<?php

if ( isset( $_POST["sub_form"] ))

{ 

    $err_msg='';
    $title_name=$_POST["title"];
    $name = $_POST['sub_name'];
    $email = $_POST['sub_email'];
    $phone = $_POST['sub_phone'];
    $tag_title = $_POST['tag_title'];
    //do Server Side Validation 
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
     {
        $err_msg = "Only letters and space allowed";
        echo '<script> alert("Invalid Name Input"); </script>';
      }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $err_msg='Invalid Email Format';
        echo '<script> alert("Invalid Email Format"); </script>';
    }
    
    if(!is_numeric($phone))
    {
        $err_msg='Invalid Number Format';
        echo '<script> alert("Invalid Number Format"); </script>';
    }

    if($err_msg == '')
    {   
        //Define Table
        $table = $wpdb->prefix."v_sub_tbl";
        $table_cat = $wpdb->prefix."v_cat_tbl";
        
        //Check for data first
        $sub_exist = $wpdb->get_row( "SELECT * FROM $table WHERE sub_email = '$email'");
        $user_id = $sub_exist->id;
        $user_email = $sub_exist->sub_email;
        $cat_exist = $wpdb->get_row( "SELECT * FROM $table_cat where sub_id=$user_id");
        $cat_tag = $cat_exist->cat_tag;

        //echo 'user_id : ' . $user_id;
        //echo 'Cat_id : '.$cat_exist->cat_tag;
       

        if($user_email != $email && $cat_tag != $tag_title){


              $wpdb->insert(
                $table,
                array(
                    'sub_name' => $name,
                    'sub_email' => $email,
                    'sub_phone' => $phone
                )
            );
    
            
    
            $lastid = $wpdb->insert_id;
    
            $wpdb->insert(
                $table_cat,
                array(
                    'sub_id' => $lastid,
                    'cat_tag' => $tag_title
                )
            );
           
            echo '<script> alert("You have subscribed to the course. Welcome."); </script>';
           
           
        }else if ($user_email == $email && $cat_tag == 0) 
        {
          
            $wpdb->insert(
                $table_cat,
                array(
                    'sub_id' => $user_id,
                    'cat_tag' => $tag_title
                )
            );
            echo '<script> alert("You have Subscribed '.$tag_title.'"); </script>';
           
        } else {

            echo '<script> alert("You have already subscribed this course."); </script>';
            
            //exit();
        }


      
        //echo '<script> alert("You have Subscribed"); </script>';


    }

    header("Location: index.php");
    die();
    
}

?>