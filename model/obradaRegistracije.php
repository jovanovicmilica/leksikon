<?php
    require_once "konekcija.php";
    header('Content-Type:application/json');
    if(isset($_POST['dugme'])){
        $ime=$_POST['imeSv'];
        $prezime=$_POST['prezimeSv'];
        $mail=$_POST['mailSv'];
        $pass=$_POST['passSv'];
        $passConf=$_POST['passConfSv'];
        $pol=$_POST['polSv'];
        
        $regIme="/^[A-Z][a-z]{2,39}$/";
        $regPrezime="/^[A-Z][a-z]{2,49}$/";
        $regEmail="/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
        $regPass="/^.{4,50}$/";
        $greske=[];
        if(!preg_match($regIme,$ime)){
            array_push($greske,"Ime mora početi velikim slovom");
        }
        if(!preg_match($regPrezime,$prezime)){
            array_push($greske,"Prezime mora početi velikim slovom");
        }
        if(!preg_match($regEmail,$mail)){
            array_push($greske,"Format e-maila: milica.jovanovic.88.18@ict.edu.rs");
        }
        if(!preg_match($regPass,$pass) && strlen($pass)<8){
            array_push($greske,"Lozinka mora imati barem 8 karaktera");
        }
        if($passConf!=$pass){
            array_push($greske,"Lozinke se ne poklapaju");
        }
        if($pol == null){
            array_push($greske, "Morate izabrati pol");
        }
        if(count($greske)==0){
            //echo "OK";
            $dohvatiPol="SELECT idPol FROM pol WHERE naziv=:nazivPola";
            $priprema=$konekcija->prepare($dohvatiPol);
            $priprema->bindParam(":nazivPola",$pol);
            $dohvatiIdPola=$priprema->execute();
            $idPol=$priprema->fetch();
            $polid= $idPol['idPol'];

            $insert="INSERT INTO korisnici VALUES(NULL,:ime,:prezime,:mail,:pass,:aktivan,:kod,:datum,:idUloge,:idPol)";
            $pass=md5($pass);
            $datum=date("Y-m-d H:i:s");
            $aktivan=1;
            $uloga=1;
            $kod=md5(time().md5($mail));
            $priprema2=$konekcija->prepare($insert);
            $priprema2->bindParam(":ime",$ime);
            $priprema2->bindParam(":prezime",$prezime);
            $priprema2->bindParam(":mail",$mail);
            $priprema2->bindParam(":pass",$pass);
            $priprema2->bindParam(":datum",$datum);
            $priprema2->bindParam(":aktivan",$aktivan);
            $priprema2->bindParam(":idUloge",$uloga);
            $priprema2->bindParam(":kod",$kod);
            $priprema2->bindParam(":idPol",$polid);
            try{
                $uspesno=$priprema2->execute();
                $kod=201;
                /*mail($mail,"Registracija","http://localhost/leksikon/index.php?page=login&kod=".$kod);*/
                $poruka="Uspešno ste se registrovali";
            }
            catch(PDOException $e){
                $kod=200;
                $poruka="Već postoji korisnik s tom e-mail adresom";
            }
        }
        else{
            $kod=422;
        }
        
    }
    else{
        $kod=404;
    }
    echo json_encode($poruka);
    http_response_code($kod);
?>