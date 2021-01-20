<?php
require_once "konekcija.php";
header('Content-Type:application/json');

    if(isset($_POST["unesiPitanje"])){
        $kod=200;
        $mail=$_POST["mail"];
        $naslov=$_POST["naslov"];
        $poruka=$_POST["poruka"];
        $regEmail="/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
        $regNaslov="/^[\w\s]+$/";
        $greska=0;
        if(!preg_match($regEmail,$mail)){
            $greska++;
            $data="E-mail nije u dobrom formatu";
        }
        if(!preg_match($regNaslov,$naslov)){
            $greska++;
            $data="Naslov nije u redu";
        }
        if(count($poruka)<2){
            $greska++;
            $data="Poruka mora imati bar tri reči";
        }
        if($greska==0){
            $poruka=implode(" ",$poruka);
            $insert="INSERT INTO poruke VALUES(null,:mail,:naslov,:poruka)";
            $priprema=$konekcija->prepare($insert);
            $priprema->bindParam(":mail",$mail);
            $priprema->bindParam(":naslov",$naslov);
            $priprema->bindParam(":poruka",$poruka);
            try{
                $priprema->execute();
                $poruka="Uspešno ste poslali poruku";
                $kod=201;
            }
            catch(PDOException $e){
                $poruka="Nema veze sa serverom";
                $kod=500;
            }
        }
    }
    else{
        $kod=404;
    }

echo json_encode($poruka);
http_response_code($kod);
?>