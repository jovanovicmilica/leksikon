<?php
header('Content-Type:application/json');
require_once "konekcija.php";
    if(isset($_POST['dodajPitanje'])){
        $pitanje=$_POST['pitanje'];
        if($pitanje!=""){
            $datum=date("Y-m-d H:i:s");
        $upit="INSERT INTO pitanja VALUES(null,:pitanje,:datum,10)";
        $priprema=$konekcija->prepare($upit);
        $priprema->bindParam(":pitanje",$pitanje);
        $priprema->bindParam(":datum",$datum);
        try{
            $priprema->execute();
            $data="Pitanje je uneto u bazu";
            $kod=201;
        }
        catch(PDOException $e){
            $kod=500;
            $data="Nema veze sa serverom";
        }
        }
        else{
            $kod=200;
            $data="Niste uneli pitanje";
        }
    }
    else{
        $kod=404;
        $data="NEMATE PRISTUP";
    }

    echo json_encode($data);
    http_response_code($kod);
?>