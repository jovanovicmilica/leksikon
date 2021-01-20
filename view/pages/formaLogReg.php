<?php
?>
<div class="forma strana">
    <h2>Registruj se</h2>
<form id="formareg">
    <span>Ime</span>
    <input type="text" name="ime" id="ime">
    <p id="greskaime"></p>
    <span>Prezime</span>
    <input type="text" name="prezime" id="prezime">
    <p id="greskaprezime"></p>
    <p>Pol:</p>
    <input type="radio" name="rb" value="m">Muški
    <br>
    <input type="radio" name="rb" value="z">Ženski
    <p id="greskapol"></p>
    <span>E-mail</span>
    <input type="text" name="mail" id="mail">
    <p id="greskamail"></p>
    <span>Lozinka</span>
    <input type="password" name="pass" id="pass">
    <p id="greskapass"></p>
    <span>Potvrdi lozinku</span>
    <input type="password" name="passConf" id="passConf">
    <p id="greskapassconf"></p>
    <br><br>
    <button type="button" name="btnReg" id="btnReg">Registruj se</button>
</form>
<div>
<p id="poruka"></p>
</div>
</div>
<div class="forma strana">
    <h2>Uloguj se</h2>
<form action="#" method="#" id="formalog">
    <span>E-mail</span>
    <input type="text" name="mailLog" id="mailLog">
    <br>
    <span>Lozinka</span>
    <input type="password" name="passLog" id="passLog">
    <br><br>
    <button type="button" name="btnLog" id="btnLog">Uloguj se</button>
</form>
<div>
<p id="porukaLog"></p>
</div>
</div>
