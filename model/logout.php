<?php
if(isset($_SESSION['korisnik'])){
    session_destroy();
header("Location:index.php??page=sviLeksikoni&strana=1");
}
    
?>