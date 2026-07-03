var butacasList = ""


for (let index = 1; index <= 52; index++) {;
    butacasList += "<li id=" + index + "><i class='fa-solid fa-couch' style='color: rgb(99, 230, 190);'><p>" + index + "</p></i></li>"
}

$("ul.butacas").html(butacasList)


function visible() {
    $("aside").toggleClass("invisible");
}

var revervas = [];

$("ul.butacas li").on("click", function(){
    $(this).toggleClass("reservada");
    reservar();
})


function reservar (){
    // 1. Buscamos todas las que tienen la clase 'reservada'
    var reservas = $("ul.butacas li.reservada");
    var asideVisible = !$("aside").hasClass("invisible");
    
    if(reservas.length){
        if (!asideVisible) {
            visible();
        }
        var butacasResList = "";
    
        // 2. Usamos el .each correctamente
        reservas.each(function() {
            // Obtenemos el ID de la butaca actual
            var idButaca = $(this).attr("id");
            
            // Creamos el HTML para la lista de reservas
            butacasResList += "<li id='res-" + idButaca + "'>" +  "<i class='fa-solid fa-couch' style='color: red;'>" + "<p>" + idButaca + "</p></i></li>";
        });
    
        // 3. Actualizamos la lista de reservas
        $("ul.reservas").html(butacasResList);

        $("aside h2").text("Total: " + reservas.length * 20)
    } else {
        $("ul.reservas").html("");
        $("aside h2").text("No hay reservas");
        visible();
    }

    
}

// Delegación de eventos para los li dentro de ul.reservas
$(document).on("click", "ul.reservas li", function() {
    var idOriginal = $(this).attr("id").replace("res-", "");
    $("ul.butacas li#" + idOriginal).removeClass("reservada");
    reservar();
});