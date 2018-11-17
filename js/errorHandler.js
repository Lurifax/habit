$('#newHabit').submit(function(){
    if(!$('#newHabit input[type="checkbox"]').is(':checked')){
      alert("Vennligst velg en eller flere dager for habiten.");
      return false;
    }
});
