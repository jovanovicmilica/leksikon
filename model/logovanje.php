<?php
    header('Content-Type:application/json');
    require_once "konekcija.php";
    if(isset($_POST['dugmeLog'])){
        $mail=$_POST['mail'];
        $pass=$_POST['pass'];

        $regEmail="/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
        $regPass="/^.{4,50}$/";

        $greske=[];
        if(!preg_match($regEmail,$mail)){
            array_push($greske,"Format e-maila: milica.jovanovic.88.18@ict.edu.rs");
        }
        if(!preg_match($regPass,$pass) && strlen($pass)<8){
            array_push($greske,"Lozinka mora imati barem 8 karaktera");
        }
        if(count($greske)==0){
            $upit="SELECT k.idKorisnika AS idKorisnika,k.ime,k.prezime,k.idPol,k.email,k.pass,k.idKorisnika,u.naziv AS nazivUloge FROM korisnici k INNER JOIN uloga u ON k.idUloge=u.idUloge WHERE email=:mail AND pass=:pass AND aktivan=:aktivan";
            $pass=md5($pass);
            $aktivan=1;
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":mail",$mail);
            $priprema->bindParam(":pass",$pass);
            $priprema->bindParam(":aktivan",$aktivan);
            $priprema->execute();
            if($priprema->rowCount()==1){
                $korisnik=$priprema->fetch();
                $_SESSION['korisnik']=$korisnik;
                $kod=201;
                $data="OK";
            }
            else{
                $kod=404;
                $data = "Korisnik nije pronadjen!";
            }
        }
        else{
            $kod=404;
        }
    }
    else{
        $kod=403;
        $data = "Nemate pristup stranici";
    }
    echo json_encode($data);
    http_response_code($kod);
?>