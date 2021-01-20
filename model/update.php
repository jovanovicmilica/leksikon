<?php
    require_once "konekcija.php";
    if(isset($_POST['promeniDevojcica'])){
        if(isset($_FILES['devojcica'])){
            $slika=$_FILES['devojcica'];
            $fileName = $slika['name'];
            $tmpName = $slika['tmp_name'];
            $velicina = $slika['size'];
            $tip = $slika['type'];
            $greska = $slika['error']; 
            $uploadfolder = "../img/"; 
            $greske=0;
            $tipFajla=strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
            $maksimalnaVelicina=2*1024*1024;
            if($velicina>$maksimalnaVelicina){
                $greske=1;
                echo "Fajl ima vise od $maksimalnaVelicina MB";
            }
            if($tipFajla!="jpg" && $tipFajla!="png" && $tipFajla!="jpeg" && $tipFajla!="gif"){
                echo "Fajl mora biti slika";
                $greske=1;
            }
            if($greske==0){
                $filePath = $fileName;
                $rezultat=move_uploaded_file($tmpName,$filePath);
                if(!$rezultat){
                    echo "Greska";
                }
                else{
                    $updateSlike="UPDATE slike SET src=:src WHERE idSlike=:id";
                    $id=1;
                    $priprema=$konekcija->prepare($updateSlike);
                    $priprema->bindParam(":src",$filePath);
                    $priprema->bindParam(":id",$id);
                    try{
                        $priprema->execute();
                        header("location:http://localhost/leksikon/index.php?page=sviLeksikoni&strana=1");
                    }
                    catch(PDOException $e){
                        echo "Nema veze sa serverom";
                    }
                }
            }
        }
        else{
            echo "niste izabrali sliku";
        }
    }
    if(isset($_POST['promeniDecak'])){
        if(isset($_FILES['decak'])){
            $slika=$_FILES['decak'];
            $fileName = $slika['name'];
            $tmpName = $slika['tmp_name'];
            $velicina = $slika['size'];
            $tip = $slika['type'];
            $greska = $slika['error']; 
            $uploadfolder = "img/"; 
            $greske=0;
            $tipFajla=strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
            $maksimalnaVelicina=2*1024*1024;
            if($velicina>$maksimalnaVelicina){
                $greske=1;
                echo "Fajl ima vise od $maksimalnaVelicina MB";
            }
            if($tipFajla!="jpg" && $tipFajla!="png" && $tipFajla!="jpeg" && $tipFajla!="gif"){
                echo "Fajl mora biti slika";
                $greske=1;
            }
            if($greske==0){
                $filePath = $fileName;
                $rezultat=move_uploaded_file($tmpName,$filePath);
                if(!$rezultat){
                    echo "Greska";
                }
                else{
                    $updateSlike="UPDATE slike SET src=:src WHERE idSlike=:id";
                    $id=2;
                    $priprema=$konekcija->prepare($updateSlike);
                    $priprema->bindParam(":src",$filePath);
                    $priprema->bindParam(":id",$id);
                    try{
                        $priprema->execute();
                        header("location:http://localhost/leksikon/index.php?page=sviLeksikoni&strana=1");
                    }
                    catch(PDOException $e){
                        echo "Nema veze sa serverom";
                    }
                }
            }
        }
        else{
            echo "niste izabrali sliku";
        }
    }
    else{
        echo "NEMATE PRISTUP";
    }
?>