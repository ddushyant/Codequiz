<?php
class LogOut {
    public function post(){
        session_destroy();
    
        header("location: http://web.njit.edu/~arm32/client/index.php");
        exit();
    }
}
?>
