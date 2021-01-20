$("#btnReg").click(function(){
    var ime=document.getElementById("ime").value;
    var prezime=document.getElementById("prezime").value;
    var mail=document.getElementById("mail").value;
    var pass=document.getElementById("pass").value;
    var passConf=document.getElementById("passConf").value;
    var pol=$('input[name="rb"]:checked').val()

    var regIme=/^[A-Z][a-z]{2,39}$/;
    var regPrezime=/^[A-Z][a-z]{2,49}$/;
    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regPass=/^.{8,50}$/;

    var greske=0;
    if(!regIme.test(ime)){
        $("#greskaime").html("Ime mora početi velikim slovom");
        greske++;
        
    }
    else{
        $("#greskaime").html("");
    }
    if(!regPrezime.test(prezime)){
        $("#greskaprezime").html("Prezime mora početi velikim slovom");
        greske++;
    }
    else{
        $("#greskaprezime").html("");
    }
    if(!regEmail.test(mail)){
        $("#greskamail").html("Format e-maila: milica.jovanovic.88.18@ict.edu.rs");
        greske++;
    }
    else{
        $("#greskamail").html("");
    }
    if(!regPass.test(pass)){
        $("#greskapass").html("Lozinka mora imati barem 8 karaktera");
        greske++;
    }
    else{
        $("#greskapass").html("");
    }
    if(passConf!=pass){
        $("#greskapassconf").html("Lozinke se ne poklapaju");
        greske++;
    }
    else{
        $("#greskapassconf").html("");
    }
    if(pol == null){
        $("#greskapol").html("Pol nije izabran")
        greske++;
    }
    else{
        $("#greskapol").html("")
    }
    if(greske==0){
        $.ajax({
            url:"model/obradaRegistracije.php",
            method:"post",
            dataType:"json",
            data:{
                imeSv:ime,
                prezimeSv:prezime,
                mailSv:mail,
                passSv:pass,
                passConfSv:passConf,
                polSv:pol,
                dugme:true
            },
            success:function(data){
                document.getElementById("poruka").innerHTML=data;
            },
            error:function(xhr){
                if(xhr.status == 500)
                document.getElementById("poruka").innerHTML="Postoji nalog sa tim email-om";
                if(xhr.status == 503)
                document.getElementById("poruka").innerHTML="Server trenutno nije dostupan. Pokušajte kasnije.";
            }
        })
    }
    else{
        return false;
    }
    
})

$("#btnLog").click(function(){
    var mailLog=$("#mailLog").val();
    var passLog=$("#passLog").val();

    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regPass=/^.{8,50}$/;

    if(!regEmail.test(mailLog)){
        document.getElementById("porukaLog").innerHTML="E-mail nije u dobrom formatu"
        return false
    }
    if(!regPass.test(passLog)){
        document.getElementById("porukaLog").innerHTML="Lozinka nije u dobrom formatu"
        return false
    }
    $.ajax({
        url:'model/logovanje.php',
        method:"POST",
        dataType:"json",
        data:{
            "mail":mailLog,
            "pass":passLog,
            "dugmeLog":true
        },
        success:function(data){
            document.getElementById("porukaLog").innerHTML=data;
            window.location="index.php?page=sviLeksikoni&strana=1";
        },
        error:function(xhr){
            if(xhr.status == 404)
                {
                    document.getElementById("porukaLog").innerHTML="Pogrešni parametri za logovanje, probajte ponovo.";
                }
                if(xhr.status == 500) document.getElementById("porukaLog").innerHTML="Server trenutno nije dostupan. Pokušajte kasnije.";
        }
    })
})

$("#btnNapravi").click(function(){
    var korIme=$("#username").val()
    var lozinka=$("#pristupnaLoz").val()

    var regKorIme=/^[\d\w]{3,50}$/;
    var regLozinka=/^.{8,50}$/;
    var greska=0;

    if(!regKorIme.test(korIme) || !regLozinka.test(lozinka)){
        $("#greskaLeksikon").html("Korisničko ime mora imati najmanje 3 karaktera, a lozinka najmanje 8");
        greska++;
    }
    if(greska!=0){
        return false;
    }
    else{
        $.ajax({
            url:'model/napraviLeksikon.php',
            method:"POST",
            dataType:"json",
            data:{
                "korIme":korIme,
                "pristupnaLoz":lozinka,
                "dugmeNapravi":true
            },
            success:function(data){
                document.getElementById("greskaLeksikon").innerHTML=data;
                location.reload();
            },
            error:function(xhr){
                if(xhr.status == 500){
                    document.getElementById("greskaLeksikon").innerHTML="Server trenutno nije dostupan. Pokušajte kasnije.";
                }
            }
        })
    }
})
var pitanje=document.getElementsByClassName("tekstPitanja");
for(let i=0;i<pitanje.length;i++){
    if(pitanje[i].innerText=="Kako se zove?"){
        pitanje[i].nextElementSibling.setAttribute("readonly",true)
        pitanje[i].nextElementSibling.classList.add("disable")
        pitanje[i].classList.add("sivTekst")
    }
}

var izmeniSimpatijaPolje=document.getElementsByName("cbSimpatija");
for(let i of izmeniSimpatijaPolje){
    i.addEventListener("change",function(){
        if(i.value=="da"){
            for(let i=0;i<pitanje.length;i++){
                if(pitanje[i].innerText=="Kako se zove?"){
                    pitanje[i].nextElementSibling.removeAttribute("readonly")
                    pitanje[i].classList.remove("sivTekst")
                    pitanje[i].nextElementSibling.value=""
                    pitanje[i].nextElementSibling.classList.remove("sivTekst")
                }
            }
        }
        else{
            for(let i=0;i<pitanje.length;i++){
                if(pitanje[i].innerText=="Kako se zove?"){
                    pitanje[i].nextElementSibling.setAttribute("readonly",true)
                    pitanje[i].classList.add("sivTekst")
                    pitanje[i].nextElementSibling.value="/"
                    pitanje[i].nextElementSibling.classList.add("sivTekst")
                }
            }
        }
    })
}
$("#popuni").click(function(){
    var inputi=$("input:text");
    var simpatija=$('input[name="cbSimpatija"]:checked')
    var datumRodjenja=document.querySelector("input[type='date']")
    var regOdgovori=/^(\/|[\w\d\s\?\,]+)$/;
    var greska=0;
    var vrednost;
    var idPitanja;
    var niz=[];
    var idLeksikona=$("#idLeksikona").val();
    for(let i=0;i<inputi.length;i++){
        if(!regOdgovori.test(inputi[i].value)){
            greska++;
        }
        else{
            vrednost=inputi[i].value;
            idPitanja=inputi[i].id;
            niz.push({[idPitanja]:vrednost});
        }
    }
    if(datumRodjenja.value==""){
        greska++
    }
    else{
        idPitanja=datumRodjenja.id;
        vrednost=datumRodjenja.value
        niz.push({[idPitanja]:vrednost})
    }
    if(simpatija.val() == null){
        greska++;
    }
    else{
        idPitanja=simpatija.attr("id");
        vrednost=simpatija.val();
        niz.push({[idPitanja]:vrednost})
    }
    if(greska!=0){
        document.getElementById("porukaPopuniLeks").innerHTML="Niste ispravno popunili leksikon, pogledajte uputstvo na početnoj strani"
        return false;
    }
    $.ajax({
        url:'model/upisodgovora.php',
        method:"POST",
        dataType:"json",
        data:{
            "podaci":niz,
            "leksikon":idLeksikona,
            "popuni":true
        },
        success:function(data){
            if(data=="Uspešno ste popunili leksikon"){
                window.location="index.php?page=sviLeksikoni&strana=1";
            }
            else{
                document.getElementById("porukaPopuniLeks").innerHTML+=data;
            }
        },
        error:function(xhr){
            if(xhr.status == 404)
                 {
                 document.getElementById("porukaPopuniLeks").innerHTML="Greska.";
                 }
             if(xhr.status == 500) document.getElementById("porukaPopuniLeks").innerHTML="Server trenutno nije dostupan. Pokušajte kasnije.";
        }
    })
})

$(".dugmeSifra").click(function(){
    var inputSifra=this.previousElementSibling.value
    var idLeksikona=this.value
    var regLozinka=/^.{8,50}$/;
    var dugme=this
    var poruka=dugme.nextElementSibling
    greska=0;
    if(!regLozinka.test(inputSifra)){
        this.nextElementSibling.innerHTML="Lozinka nije u dobrom formatu"
        greska++
    }
    else{
        this.nextElementSibling.innerHTML=""
        greska=0
    }
    if(greska!=0){
        return false
    }
    $.ajax({
        url:'model/proveraPristupnaLozinka.php',
        method:"POST",
        dataType:"json",
        data:{
            "idLeks":idLeksikona,
            "inpSifra":inputSifra,
            "dugmeLoz":true
        },
        success:function(data){
            poruka.innerText+=data;
            if(data=="Odvedi na leksikon"){
                window.location="index.php?idLeks="+idLeksikona+"&tacno";
            }
        },
        error:function(xhr){
            console.log(xhr)
            if(xhr.status == 404)
                {
                    poruka.innerText="Morate se ulogovati.";
                }
            if(xhr.status == 500) poruka.innerText.innerHTML="Server trenutno nije dostupan. Pokušajte kasnije.";
        }
    })
})

$("#glasaj").click(function(){
    var odgovori=$('input[name="anketa"]:checked').val()
    var idAnkete=$("#idAnkete").val()
    if(odgovori!=null){
        $("#anketaPoruka").html("")
        $.ajax({
            url:'model/obradaAnkete.php',
            method:"POST",
            dataType:"json",
            data:{
                "idOdgovora":odgovori,
                "idAnkete":idAnkete,
                "dugmeGlasaj":true
            },
            success:function(data){
                document.getElementById("anketaPoruka").innerHTML=data;
            },
            error:function(xhr){
                if(xhr.status == 500) {
                    $("#anketaPoruka").html("Nema veze sa serverom,pokušajte kasnije")
                }
            }
        })
    }
    else{
        $("#anketaPoruka").html("Niste izabrali")
    }
})

$("#rezultat").click(function(){
    var idAnkete=$("#idAnkete").val()
    $.ajax({
        url:'model/rezultatiAnkete.php',
        method:"POST",
        dataType:"json",
        data:{
            "idAnkete":idAnkete,
            "dugmeGlasaj":true
        },
        success:function(data){
            $("#anketaPoruka").html(data)
        },
        error:function(xhr){
            if(xhr.status == 500) {
                $("#anketaPoruka").html("Nema veze sa serverom,pokušajte kasnije")
            }
        }
    })
})

$("#unosPitanja").click(function(){
    var pitanje=$("#pitanje").val()
    $.ajax({
        url:'model/novoPitanje.php',
        method:"POST",
        dataType:"json",
        data:{
            "pitanje":pitanje,
            "dodajPitanje":true
        },
        success:function(data){
            $("#porukaInsert").html(data)
        },
        error:function(xhr){
            if(xhr.status == 500) {
                $("#porukaInsert").html("Nema veze sa serverom,pokušajte kasnije")
            }
        }
    })
})

$(".btnPogledaj").click(function(){
    var idLeksikona=this.value
    $.ajax({
        url:'model/pogledajLeksikone.php',
        method:"POST",
        dataType:"json",
        data:{
            "idLeks":idLeksikona,
            "pogledaj":true
        },
        success:function(data){
            //$("#leksikonKor").html(data)
            if(data!="Nema potpisanih korisnika"){
                ispisLeksikona(data);
            }
            else{
                $("#leksikonKor").html(data)
            }
        },
        error:function(xhr){
            if(xhr.status == 500) {
                $("#leksikonKor").html("Nema veze sa serverom,pokušajte kasnije")
            }
        }
    })
})

function ispisLeksikona(data){
    ispis='';
    data.forEach(element => {
        console.log(element)
        ispis+="<div class='prikaz5'>"
        element.forEach(el => {
        ispis+=`<span>${el.tekst} : ${el.tekstOdgovora}</span><br/>`
        ispis+=`<input type='hidden' value='${el.idP}'>`
        });
        ispis+="<button class='pogledaj btnbrisi'>Obrisi</button></div><p id='brisanje'></p>"
    });
    $("#leksikonKor").html(ispis)

    $(".btnbrisi").click(function(){
        var idPotp=this.previousElementSibling.value
        $.ajax({
            url:'model/brisanje.php',
            method:"POST",
            dataType:"json",
            data:{
                "idPotpisnika":idPotp,
                "brisi":true
            },
            success:function(data){
                $("#brisanje").html(data);
            },
            error:function(xhr){
                if(xhr.status == 500) {
                    $("#brisanje").html("Nema veze sa serverom,pokušajte kasnije")
                }
            }
        })
    })
}
$("#brisipitanje").click(function(){
    var pitanje=$("#selPitanje")
    if(pitanje.val()==0){
        $("#pitanjeBrisi").html("Niste izabrali pitanje");
    }
    else{
        $.ajax({
            url:'model/brisanjePitanja.php',
            method:"POST",
            dataType:"json",
            data:{
                "idPitanja":pitanje.val(),
                "bristiPitanje":true
            },
            success:function(data){
                $("#pitanjeBrisi").html(data);
            },
            error:function(xhr){
                if(xhr.status == 500) {
                    $("#pitanjeBrisi").html("Nema veze sa serverom,pokušajte kasnije")
                }
            }
        })
    }
})

$("#posaljiPoruku").click(function(){
    var mail=$("#mailPor").val();
    var naslov=$("#tekstPoru").val()
    var poruka=$("#por").val()
    var regEmail=/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
    var regNaslov=/^[\w\s]+$/;
    var greska=0;
    if(!regEmail.test(mail)){
        $("#greskePor").html("E-mail nije u dobrom formatu");
        greska++;
    }
    else{
        $("#greskePor").html()
    }
    if(!regNaslov.test(naslov)){
        $("#greskePor").html("Naslov nije u dobrom formatu");
        greska++;
    }
    else{
        $("#greskePor").html()
    }
    poruka=poruka.split(" ")
    console.log(poruka)
    if(poruka.length<2){
        $("#greskePor").html("Poruka mora imati barem 3 reci");
        greska++;
    }
    if(greska==0){
        $.ajax({
            url:'model/unesiPoruku.php',
            method:"POST",
            dataType:"json",
            data:{
                "mail":mail,
                "poruka":poruka,
                "naslov":naslov,
                "unesiPitanje":true
            },
            success:function(data){
                $("#greskePor").html(data);
            },
            error:function(xhr){
                if(xhr.status == 500) {
                    $("#greskePor").html("Nema veze sa serverom,pokušajte kasnije")
                }
            }
        })
    }
})