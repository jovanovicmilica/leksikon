<?php
    require_once "model/konekcija.php";
?>
<!--INSERT NOVOG PITANJA-->
<div class="adm">

<form class="forma">

<p>Unesi novo pitanje:</p>
<input type="text" id="pitanje">
<br>
<button type="button" id="unosPitanja">Potvrdi</button>
<p id="porukaInsert"></p>
</form>


</div>
<div class="adm">
<p>Brisanje pitanja</p>
<form action="">
<select id="selPitanje" class="sel">
<option value="0">Izaberi</option>
<?php
    $dohvatiPitanja="SELECT * FROM pitanja";
    $pitanje=$konekcija->query($dohvatiPitanja)->fetchAll();
    foreach($pitanje as $p):
?>
    <option value="<?=$p['idPitanja']?>"><?=$p['tekst']?></option>
<?php
    endforeach;
?>
</select>
<button id="brisipitanje" class="pogledaj" type="button">Izbrisi</button>
</form>
<p id="pitanjeBrisi"></p>
</div>
<!--UPDATE SLIKE-->
<div class="adm">
    <p>Promena slike</p>
    <form class="forma" enctype="multipart/form-data" action="model/update.php" method="post">
        <input type="file" name="devojcica" id="devojcica">
        <button type="submit" name="promeniDevojcica" id="promeniDevojcica" class="pogledaj">Promeni devojčicu</button>
        <br>
        <input type="file" name="decak" id="decak">
        <button class="pogledaj" type="submit" id="promeniDecak" name="promeniDecak">Promeni dečaka</button>
    </form>


</div>

<!--PREGLED LEKSIKONA I BRISANJE POTPISNIKA-->
<div id="delete">

<p>Korisnici</p>
<form action="">
<table cellspacing="0">
    <thead>
        <th>E-mail</th><th>Korisničko ime</th><th>Leksikoni</th>
    </thead>
    
<tbody>

<?php
$dohvatiLeksikone="SELECT k.*,n.korIme,n.idLeksikona FROM korisnici k LEFT OUTER JOIN napravileksikon n ON k.idKorisnika=n.idVlasnika";
$leks=$konekcija->query($dohvatiLeksikone)->fetchAll();
foreach($leks as $l):
?>
<tr>
    <td><?=$l['email']?></td>
    <td><?=$l['korIme']?></td>
    <td class="pogl">
        <?php
            if($l['korIme']!=""):
        ?>
            <button type="button" class="pogledaj btnPogledaj" value="<?=$l['idLeksikona']?>">Pogledaj</button>
        <?php

            endif;
        ?>
    </td>
</tr>
<?php
endforeach;
?>
</tbody>
</table>
</form>

<div id="leksikonKor">
    
</div>
</div>

<div class="adm adm5">
    <p>Poruke</p>
    <table cellspacing="0">
        <thead><th>E-mail</th><th>Naslov</th><th>Poruka</th></thead>
    <tbody>
<?php
    $dohvatiPoruke="SELECT * FROM poruke";
    $poruka=$konekcija->query($dohvatiPoruke)->fetchAll();
    foreach($poruka as $p):
    ?>
        <tr>
            <td><?=$p['email']?></td>
            <td><?=$p['naslov']?></td>
            <td><?=$p['tekst']?></td>
        </tr>
<?php
    endforeach;
?>
</tbody>
</table>
</div>