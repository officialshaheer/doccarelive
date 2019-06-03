<?php 

	// Authenticate user login
	function auth_login() {
		if( ! isset( $_COOKIE['userid']  ) ) {
        	header('Location: ' . PATH . '/login.php');
	        exit();
	    } 
	    $flag = true;
	    if( $_COOKIE['type'] == 'admin' && dirname($_SERVER['SCRIPT_NAME']) != DIRECTORY . '/admin' ) {
	        $flag = false;
	    }
	    if( $_COOKIE['type'] == 'doctor' && dirname($_SERVER['SCRIPT_NAME']) != DIRECTORY . '/doctor') {
	        $flag = false;
	    }
	    if( $_COOKIE['type'] == 'patient' && dirname($_SERVER['SCRIPT_NAME']) != DIRECTORY . '/patient') {
	        $flag = false;
	    }
	    if( $_COOKIE['type'] == 'employee' && dirname($_SERVER['SCRIPT_NAME']) != DIRECTORY . '/employee') {
	        $flag = false;
	    }
	    if( !$flag ) {
	        echo 'You have no permission to view this page';
	        exit();
	    }
	}

	// get logged user type
	function user_type() {
		return $_COOKIE['type'];
	}


?>