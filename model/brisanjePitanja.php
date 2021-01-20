<?php
    require_once "konekcija.php";
    header('Content-Type:application/json');
    if(isset($_POST['bristiPitanje'])){
        $idPitanja=$_POST['idPitanja'];
        $upitBrisi="DELETE FROM pitanja WHERE idPitanja=:id";
        $priprema=$konekcija->prepare($upitBrisi);
        $priprema->bindParam(":id",$idPitanja);
        try{
            $priprema->execute();
            $kod=200;
            $data="Obrisali ste pitanje";
        }
        catch(PDOException $e){
            $kod=500;
            $data="Nema veze sa serverom";
        }
    }
    else{
        $kod=404;
        $data="Nemate pristup";
    }
    echo json_encode($data);
    http_response_code($kod);
?>