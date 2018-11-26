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
