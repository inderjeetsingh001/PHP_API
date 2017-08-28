<?php

include("Database.php");

switch ($_GET['function']) {
    case 'users_list': users_list();
        break;
        case 'add_user': add_user();
        break;
        case 'edit_user': edit_user();
        break;
        case 'delete_user': delete_user();
        break;
}

//http://localhost/php_api/users.php?function=users_list
function users_list() {

  
        //Accessing Connection details by using Global variable
        $db = $GLOBALS['con'];

        $sql = "SELECT id, first_name, last_name FROM users;";

        if ($result = mysqli_query($db, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {

                    $rows[] = array('data' => $row);
                }
                mysqli_free_result($result);

                $json_op = array(
                    "status_code" => 101,
                    "msg" => "Users List successfully displayed.",
                    "users_list" => $rows
                );
            } else {
           
                $json_op = array(
                    "status_code" => 102,
                    "msg" => "No User available.",
                    "event_list" => []
                );
            }
        

        @mysqli_close($db);
        /* Output header */
        header('Content-type: application/json');
        echo json_encode($json_op);
    }
}

//http://localhost/php_api/users.php?function=add_user
/*
Need to pass three parameter via POST
1. first_name
2. last_name
3. email
*/
function add_user() {
    
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
    
//Validating required fields
    if (!empty($first_name) || !empty($email)) {
        $db = $GLOBALS['con'];

            $sql = "INSERT INTO users (first_name, last_name, email)
                            VALUES ('$first_name','$last_name', '$email');";
          
           if(mysqli_query($db, $sql)){
            $json_op = array(
                "status_code" => 103,
                "msg" => "User added successfully."
            );   
           }
           else
           {
                 $json_op = array(
                     "status_code" => 104,
                     "error" => $db->error,
                "msg" => "Event failed to add."
            ); 
           }

        @mysqli_close($db);
        /* Output header */
        header('Content-type: application/json');
        echo json_encode($json_op);
    }
}

//http://localhost/php_api/users.php?function=edit_user
/*
Need to pass id parameter via POST with all other 3 parameters
id parameter will identify the row to update

1. id
2. first_name
3. last_name
4. email

*/
function edit_user() {

        $id = $_POST['id'];
		$first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
    
    if (!empty($id) || !empty($first_name) || !empty($email)) {
        $db = $GLOBALS['con'];

            $sql = "UPDATE users SET first_name = '$first_name', 
                    last_name = '$last_name', email = '$email'
                      WHERE id = '$id';";
          
           if(mysqli_query($db, $sql)){
            $json_op = array(
                "status_code" => 105,
                "msg" => "User updated successfully."
            );   
           }
           else
           {
                 $json_op = array(
                     "status_code" => 106,
                     "error" => $db->error,
                "msg" => "User failed to update."
            ); 
           }

        @mysqli_close($db);
        /* Output header */
        header('Content-type: application/json');
        echo json_encode($json_op);
    }
}

//http://localhost/php_api/users.php?function=delete_user
/*
Need to pass id parameter via POST 
*/
function delete_user() {

   $id = $_POST['id'];

    
    if (!empty($id)) {
        $db = $GLOBALS['con'];

            $sql = "DELETE FROM users WHERE id = $id;";
          
           if(mysqli_query($db, $sql)){
            $json_op = array(
                "status_code" => 107,
                "msg" => "User deleted successfully."
            );   
           }
           else
           {
                 $json_op = array(
                     "status_code" => 108,
                     "error" => $db->error,
                "msg" => "User failed to delete."
            ); 
           }

        @mysqli_close($db);
        /* Output header */
        header('Content-type: application/json');
        echo json_encode($json_op);
    }
}