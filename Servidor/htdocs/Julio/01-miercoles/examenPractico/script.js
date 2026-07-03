$("button").on("click", function () {
    var nom = $("input[name=nombre]").val().trim();
    var nomList = nom.split(" ");
    var nombresMayusculas = nomList.map(function(item) {
        if (item=="de" || item=="del") {
            return item
        } else {
            return item.charAt(0).toUpperCase() + item.slice(1).toLowerCase();
        }
    });
    var nombreCapitalizado = nombresMayusculas.join(" ");
    var edad = parseInt($("input[name=edad]").val());
    var sex = $("select").val();

    if (nom === "" || edad === "") {
        $("#modalError")[0].showModal();
        return; // Detiene la ejecución
    }

    var stringSex="";
    if(edad > 17){
        stringSex = "Tienes " + edad + " años y puedes tener sexo porque eres mayor de edad. "
        if(sex == "nada"){
            stringSex += "Es una pena que tengas " + sex + " de sexo.";
        } else if(sex == "poco"){
            stringSex += "Tienes " + sex + " sexo y deberias tener más.";
        } else {
            stringSex += "Tienes " + sex + " sexo, pero no te pases.";
        }
    } else {
        stringSex = "Tienes " + edad + " años y no puedes tener sexo porque eres menor de edad. "
        if(sex == "nada"){
            stringSex += "Haces bien en no tener " + sex + ".";
        } else {
            stringSex += "No deberias tener " + sex + ".";
        }
    }

    var claseEdad = (edad >= 18) ? "verde" : "rojo";

    $("p").hide().html("Hola, " + nombreCapitalizado + ". ").append("<span class='" + claseEdad + "'></span>").fadeIn(500);
    $("span").hide().html(stringSex).fadeIn(500);

    $("input[name=nombre]").val("");
        $("input[name=nombre]").focus();
    $("input[name=edad]").val("");
    $("select").val("mucho");

})

$("#cerrarModal").on("click", function() {
    $("#modalError")[0].close();
});

// Cuando el usuario haga clic en cualquier input, ocultamos el mensaje anterior
$("input, select").on("input change", function() {
    $("p").fadeOut(200);
});