<?php
    require_once "konekcija.php";
    header('Content-Type:application/json');
    if(isset($_POST['brisi'])){
        $idPopt=$_POST['idPotpisnika'];
        $brisiPotpisnika="DELETE FROM potpisnici WHERE idPotpisnika=:id";
        $priprema=$konekcija->prepare($brisiPotpisnika);
        $priprema->bindParam(":id",$idPopt);
        try{
            $priprema->execute();
            $kod=200;
            $poruka="Uspešno ste obrisali potpisnika";
        }
        catch(PDOException $e){
            $kod=500;
            $poruka="Nema veze sa serverom";
        }
    }
    else{
        $kod=404;
        $poruka="Nemate pristup";
    }


    echo json_encode($poruka);
    http_response_code($kod);
?>