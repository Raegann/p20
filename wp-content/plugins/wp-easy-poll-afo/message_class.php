<?php
if(!class_exists('message_class')){
class message_class {
	
	function __construct(){
		if(!session_id()){
			@session_start();
		}
	}
	
	function add_message($msg,$class = 'updated'){
		$_SESSION['msg'] = $msg;
		$_SESSION['msg_class'] = $class;
	}
	function view_message(){
		if(isset($_SESSION['msg']) and $_SESSION['msg']){
			echo '<div class="'.$_SESSION['msg_class'].'">'.$_SESSION['msg'].'</div>';
			unset($_SESSION['msg']);
			unset($_SESSION['msg_class']);
		}
	}
}
}
?>