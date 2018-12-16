//Funksjon for å sjekke at passordene ved endring av passord er like
//Man får ikke til å velge to ulike passord. Grønn tekst viser om passordene er like, rød tekst om de er ulike.

var check = function() {
  if (document.getElementById('nyttpassord').value ==
    document.getElementById('bekreftpassord').value) {
    document.getElementById('melding').style.color = 'green';
    document.getElementById('melding').innerHTML = 'Passordene er like';
  } else {
    document.getElementById('melding').style.color = 'red';
    document.getElementById('melding').innerHTML = 'Passordene er ikke like';
  }
}
