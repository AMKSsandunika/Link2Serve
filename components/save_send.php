<?php

if (isset($_POST['save'])) {
   if ($user_id != '') {
       $save_id = create_unique_id();
       
       // Check if saving property or job
       if (isset($_POST['property_id'])) {
           $property_id = $_POST['property_id'];
           $property_id = filter_var($property_id, FILTER_SANITIZE_STRING);
           
           $verify_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
           $verify_saved->execute([$property_id, $user_id]);
           
           if ($verify_saved->rowCount() > 0) {
               $remove_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id = ? AND user_id = ?");
               $remove_saved->execute([$property_id, $user_id]);
               $success_msg[] = 'removed from saved!';
           } else {
               $insert_saved = $conn->prepare("INSERT INTO `saved`(id, property_id, user_id) VALUES(?,?,?)");
               $insert_saved->execute([$save_id, $property_id, $user_id]);
               $success_msg[] = 'listing saved!';
           }
       } elseif (isset($_POST['job_id'])) {
           $job_id = $_POST['job_id'];
           $job_id = filter_var($job_id, FILTER_SANITIZE_STRING);
           
           $verify_saved = $conn->prepare("SELECT * FROM `saved` WHERE job_id = ? and user_id = ?");
           $verify_saved->execute([$job_id, $user_id]);
           
           if ($verify_saved->rowCount() > 0) {
               $remove_saved = $conn->prepare("DELETE FROM `saved` WHERE job_id = ? AND user_id = ?");
               $remove_saved->execute([$job_id, $user_id]);
               $success_msg[] = 'removed from saved!';
           } else {
               $insert_saved = $conn->prepare("INSERT INTO `saved`(id, job_id, user_id) VALUES(?,?,?)");
               $insert_saved->execute([$save_id, $job_id, $user_id]);
               $success_msg[] = 'listing saved!';
           }
        } elseif (isset($_POST['courier_id'])) {
            $courier_id = $_POST['courier_id'];
            $courier_id = filter_var($courier_id, FILTER_SANITIZE_STRING);
            
            $verify_saved = $conn->prepare("SELECT * FROM `saved` WHERE courier_id = ? and user_id = ?");
            $verify_saved->execute([$courier_id, $user_id]);
            
            if ($verify_saved->rowCount() > 0) {
                $remove_saved = $conn->prepare("DELETE FROM `saved` WHERE courier_id = ? AND user_id = ?");
                $remove_saved->execute([$courier_id, $user_id]);
                $success_msg[] = 'removed from saved!';
            } else {
                $insert_saved = $conn->prepare("INSERT INTO `saved`(id, courier_id, user_id) VALUES(?,?,?)");
                $insert_saved->execute([$save_id, $courier_id, $user_id]);
                $success_msg[] = 'listing saved!';
            }  
            
        }elseif (isset($_POST['bike_id'])) {
            $bike_id = $_POST['bike_id'];
            $bike_id = filter_var($bike_id, FILTER_SANITIZE_STRING);
            
            $verify_saved = $conn->prepare("SELECT * FROM `saved` WHERE bike_id = ? and user_id = ?");
            $verify_saved->execute([$bike_id, $user_id]);
            
            if ($verify_saved->rowCount() > 0) {
                $remove_saved = $conn->prepare("DELETE FROM `saved` WHERE bike_id = ? AND user_id = ?");
                $remove_saved->execute([$bike_id, $user_id]);
                $success_msg[] = 'removed from saved!';
            } else {
                $insert_saved = $conn->prepare("INSERT INTO `saved`(id, bike_id, user_id) VALUES(?,?,?)");
                $insert_saved->execute([$save_id, $bike_id, $user_id]);
                $success_msg[] = 'listing saved!';
            }
        }   elseif (isset($_POST['course_id'])) {
            $course_id = $_POST['course_id'];
            $course_id = filter_var($course_id, FILTER_SANITIZE_STRING);
            
            $verify_saved = $conn->prepare("SELECT * FROM `saved` WHERE course_id = ? and user_id = ?");
            $verify_saved->execute([$course_id, $user_id]);
            
            if ($verify_saved->rowCount() > 0) {
                $remove_saved = $conn->prepare("DELETE FROM `saved` WHERE course_id = ? AND user_id = ?");
                $remove_saved->execute([$course_id, $user_id]);
                $success_msg[] = 'removed from saved!';
            } else {
                $insert_saved = $conn->prepare("INSERT INTO `saved`(id, course_id, user_id) VALUES(?,?,?)");
                $insert_saved->execute([$save_id, $course_id, $user_id]);
                $success_msg[] = 'listing saved!';
            }    
        

       } else {
           $warning_msg[] = 'No property or job ID found!';
       }
   } else {
       $warning_msg[] = 'please login first!';
   }
}

if (isset($_POST['send'])) {
   if ($user_id != '') {
       $request_id = create_unique_id();

       if (isset($_POST['property_id'])) {
           $property_id = $_POST['property_id'];
           $property_id = filter_var($property_id, FILTER_SANITIZE_STRING);

           $select_receiver = $conn->prepare("SELECT user_id FROM `property` WHERE id = ? LIMIT 1");
           $select_receiver->execute([$property_id]);
           $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
           $receiver = $fetch_receiver['user_id'];

           $verify_request = $conn->prepare("SELECT * FROM `requests` WHERE property_id = ? AND sender = ? AND receiver = ?");
           $verify_request->execute([$property_id, $user_id, $receiver]);

           if ($verify_request->rowCount() > 0) {
               $warning_msg[] = 'Request sent already!';
           } else {
               $send_request = $conn->prepare("INSERT INTO `requests`(id, property_id, sender, receiver) VALUES(?,?,?,?)");
               $send_request->execute([$request_id, $property_id, $user_id, $receiver]);
               $success_msg[] = 'Request sent successfully!';
           }
       } elseif (isset($_POST['job_id'])) {
           $job_id = $_POST['job_id'];
           $job_id = filter_var($job_id, FILTER_SANITIZE_STRING);

           $select_receiver = $conn->prepare("SELECT user_id FROM `job` WHERE id = ? LIMIT 1");
           $select_receiver->execute([$job_id]);
           $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
           $receiver = $fetch_receiver['user_id'];

           $verify_request = $conn->prepare("SELECT * FROM `requests` WHERE job_id = ? AND sender = ? AND receiver = ?");
           $verify_request->execute([$job_id, $user_id, $receiver]);

           if ($verify_request->rowCount() > 0) {
               $warning_msg[] = 'Request sent already!';
           } else {
               $send_request = $conn->prepare("INSERT INTO `requests`(id, job_id, sender, receiver) VALUES(?,?,?,?)");
               $send_request->execute([$request_id, $job_id, $user_id, $receiver]);
               $success_msg[] = 'Request sent successfully!';
           }

        } elseif (isset($_POST['courier_id'])) {
            $courier_id = $_POST['courier_id'];
            $courier_id = filter_var($courier_id, FILTER_SANITIZE_STRING);
 
            $select_receiver = $conn->prepare("SELECT user_id FROM `courier` WHERE id = ? LIMIT 1");
            $select_receiver->execute([$courier_id]);
            $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
            $receiver = $fetch_receiver['user_id'];
 
            $verify_request = $conn->prepare("SELECT * FROM `requests` WHERE courier_id = ? AND sender = ? AND receiver = ?");
            $verify_request->execute([$courier_id, $user_id, $receiver]);
 
            if ($verify_request->rowCount() > 0) {
                $warning_msg[] = 'Request sent already!';
            } else {
                $send_request = $conn->prepare("INSERT INTO `requests`(id, courier_id, sender, receiver) VALUES(?,?,?,?)");
                $send_request->execute([$request_id, $courier_id, $user_id, $receiver]);
                $success_msg[] = 'Request sent successfully!';
            }    

        } elseif (isset($_POST['course_id'])) {
            $course_id = $_POST['course_id'];
            $course_id = filter_var($course_id, FILTER_SANITIZE_STRING);
 
            $select_receiver = $conn->prepare("SELECT user_id FROM `course` WHERE id = ? LIMIT 1");
            $select_receiver->execute([$course_id]);
            $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
            $receiver = $fetch_receiver['user_id'];
 
            $verify_request = $conn->prepare("SELECT * FROM `requests` WHERE course_id = ? AND sender = ? AND receiver = ?");
            $verify_request->execute([$course_id, $user_id, $receiver]);
 
            if ($verify_request->rowCount() > 0) {
                $warning_msg[] = 'Request sent already!';
            } else {
                $send_request = $conn->prepare("INSERT INTO `requests`(id, course_id, sender, receiver) VALUES(?,?,?,?)");
                $send_request->execute([$request_id, $course_id, $user_id, $receiver]);
                $success_msg[] = 'Request sent successfully!';
            }    

       } elseif (isset($_POST['bike_id'])) {
        $bike_id = $_POST['bike_id'];
        $bike_id = filter_var($bike_id, FILTER_SANITIZE_STRING);

        $select_receiver = $conn->prepare("SELECT user_id FROM `bike` WHERE id = ? LIMIT 1");
        $select_receiver->execute([$bike_id]);
        $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
        $receiver = $fetch_receiver['user_id'];

        $verify_request = $conn->prepare("SELECT * FROM `requests` WHERE bike_id = ? AND sender = ? AND receiver = ?");
        $verify_request->execute([$bike_id, $user_id, $receiver]);

        if ($verify_request->rowCount() > 0) {
            $warning_msg[] = 'Request sent already!';
        } else {
            $send_request = $conn->prepare("INSERT INTO `requests`(id, bike_id, sender, receiver) VALUES(?,?,?,?)");
            $send_request->execute([$request_id, $bike_id, $user_id, $receiver]);
            $success_msg[] = 'Request sent successfully!';
        }

     } else {
           $warning_msg[] = 'No ID found!';
       }
   } else {
       $warning_msg[] = 'Please login first!';
   }
}
       

?>