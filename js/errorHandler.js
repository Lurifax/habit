//Denne feilmeldingen brukes om brukeren prøver å lagre en ny habit
//uten å velge noen dager for habiten

$('#newHabit').submit(function(){
    if(!$('#newHabit input[type="checkbox"]').is(':checked')){
      alert("Vennligst velg en eller flere dager for habiten.");
      return false;
    }
});
