const hoteles = [
  { nombre: "Hotel Brisa Marina", pnpp: 120 },
  { nombre: "Hotel Cumbre Real", pnpp: 250 },
  { nombre: "Hotel Vista al Lago", pnpp: 180 },
  { nombre: "Hotel Oasis Dorado", pnpp: 210 },
  { nombre: "Hotel Espejo de Agua", pnpp: 95 },
  { nombre: "Hotel Senderos del Sol", pnpp: 140 },
  { nombre: "Hotel Refugio Alpino", pnpp: 280 },
  { nombre: "Hotel Gran Plaza", pnpp: 300 },
  { nombre: "Hotel Jardín Secreto", pnpp: 160 },
  { nombre: "Hotel Noche de Estrellas", pnpp: 190 },
  { nombre: "Hotel Horizonte Azul", pnpp: 110 },
  { nombre: "Hotel Camino Real", pnpp: 130 },
  { nombre: "Hotel Puerta del Viento", pnpp: 85 },
  { nombre: "Hotel Luz de Luna", pnpp: 220 },
  { nombre: "Hotel Valle Encantado", pnpp: 150 },
  { nombre: "Hotel Picos Nevados", pnpp: 275 },
  { nombre: "Hotel Costa Serena", pnpp: 175 },
  { nombre: "Hotel Piedra Angular", pnpp: 100 },
  { nombre: "Hotel Bosque Mágico", pnpp: 135 },
  { nombre: "Hotel Paraíso Tropical", pnpp: 240 },
  { nombre: "Hotel Torre Blanca", pnpp: 200 },
  { nombre: "Hotel Faro del Sur", pnpp: 115 },
  { nombre: "Hotel Mar de Cristales", pnpp: 290 },
  { nombre: "Hotel Sueño Real", pnpp: 260 },
  { nombre: "Hotel Arboleda Alta", pnpp: 75 },
  { nombre: "Hotel Vía Láctea", pnpp: 195 },
  { nombre: "Hotel Antiguo Palacio", pnpp: 285 },
  { nombre: "Hotel Rincón Serrano", pnpp: 90 },
  { nombre: "Hotel Aura Dorada", pnpp: 230 },
  { nombre: "Hotel Pradera Verde", pnpp: 60 },
  { nombre: "Hotel Brisas de Invierno", pnpp: 125 },
  { nombre: "Hotel Cielo Abierto", pnpp: 145 },
  { nombre: "Hotel Cumbres Blancas", pnpp: 225 },
  { nombre: "Hotel Edén Urbano", pnpp: 185 },
  { nombre: "Hotel Puerto Seguro", pnpp: 105 },
  { nombre: "Hotel Velo de Novia", pnpp: 215 },
  { nombre: "Hotel Senda de Flores", pnpp: 70 },
  { nombre: "Hotel Amanecer Marino", pnpp: 165 },
  { nombre: "Hotel Monte Sereno", pnpp: 110 },
  { nombre: "Hotel Bahía Serena", pnpp: 190 },
  { nombre: "Hotel Refugio del Viajero", pnpp: 55 },
  { nombre: "Hotel Ciudad de Cristal", pnpp: 255 },
  { nombre: "Hotel Oasis Urbano", pnpp: 155 },
  { nombre: "Hotel Camino de Piedra", pnpp: 80 },
  { nombre: "Hotel Lucero del Norte", pnpp: 205 },
  { nombre: "Hotel Jardín Botánico", pnpp: 130 },
  { nombre: "Hotel Brisa del Valle", pnpp: 95 },
  { nombre: "Hotel Esencia Real", pnpp: 270 },
  { nombre: "Hotel Maravilla Costera", pnpp: 235 },
  { nombre: "Hotel Vistas del Edén", pnpp: 170 },
  { nombre: "Hotel Torre de Marfil", pnpp: 300 },
  { nombre: "Hotel Faro Real", pnpp: 220 },
  { nombre: "Hotel Costa Dorada", pnpp: 180 },
  { nombre: "Hotel Refugio de Montaña", pnpp: 140 },
  { nombre: "Hotel Amanecer Real", pnpp: 250 },
  { nombre: "Hotel Plaza Mayor", pnpp: 265 },
  { nombre: "Hotel Bosque Sagrado", pnpp: 120 },
  { nombre: "Hotel Vista de Águila", pnpp: 295 },
  { nombre: "Hotel Noche Serena", pnpp: 135 },
  { nombre: "Hotel Puerto del Sol", pnpp: 150 },
  { nombre: "Hotel Valle de Sueños", pnpp: 200 },
  { nombre: "Hotel Horizonte Lejano", pnpp: 160 },
  { nombre: "Hotel Rincón de Paz", pnpp: 90 },
  { nombre: "Hotel Ciudad Real", pnpp: 240 },
  { nombre: "Hotel Oasis de Luz", pnpp: 115 },
  { nombre: "Hotel Camino de Estrellas", pnpp: 275 },
  { nombre: "Hotel Velo de Bruma", pnpp: 85 },
  { nombre: "Hotel Pradera de Sol", pnpp: 70 },
  { nombre: "Hotel Cumbres de Oro", pnpp: 290 },
  { nombre: "Hotel Edén Azul", pnpp: 195 },
  { nombre: "Hotel Picos de Plata", pnpp: 260 },
  { nombre: "Hotel Senda Real", pnpp: 105 },
  { nombre: "Hotel Bahía de Plata", pnpp: 230 },
  { nombre: "Hotel Refugio del Sol", pnpp: 125 },
  { nombre: "Hotel Amanecer de Cristal", pnpp: 245 },
  { nombre: "Hotel Plaza Serena", pnpp: 185 },
  { nombre: "Hotel Bosque Real", pnpp: 145 },
  { nombre: "Hotel Vista al Mar", pnpp: 215 },
  { nombre: "Hotel Noche de Paz", pnpp: 95 },
  { nombre: "Hotel Puerto Real", pnpp: 175 },
  { nombre: "Hotel Valle de Oro", pnpp: 280 },
  { nombre: "Hotel Horizonte Real", pnpp: 155 },
  { nombre: "Hotel Rincón de Luz", pnpp: 80 },
  { nombre: "Hotel Ciudad Dorada", pnpp: 300 },
  { nombre: "Hotel Oasis de Paz", pnpp: 110 },
  { nombre: "Hotel Camino de Oro", pnpp: 255 },
  { nombre: "Hotel Velo de Plata", pnpp: 190 },
  { nombre: "Hotel Pradera Real", pnpp: 65 },
  { nombre: "Hotel Cumbres de Cristal", pnpp: 270 },
  { nombre: "Hotel Edén de Luz", pnpp: 205 },
  { nombre: "Hotel Picos de Oro", pnpp: 295 },
  { nombre: "Hotel Senda de Oro", pnpp: 140 },
  { nombre: "Hotel Bahía Dorada", pnpp: 225 },
  { nombre: "Hotel Refugio de Oro", pnpp: 285 },
  { nombre: "Hotel Amanecer Dorado", pnpp: 235 },
  { nombre: "Hotel Plaza Dorada", pnpp: 250 },
  { nombre: "Hotel Bosque de Oro", pnpp: 130 },
  { nombre: "Hotel Vista de Plata", pnpp: 210 },
  { nombre: "Hotel Noche Dorada", pnpp: 165 },
  { nombre: "Hotel Puerto de Oro", pnpp: 240 }
];

var reservas = [];

function pintar(){
    var hotelsList = "";
    
    for (let index = 1; index < hoteles.length; index++) {
        var nombre = hoteles[index].nombre;
        console.log(nombre);
        
        hotelsList += '<li id="' + index + '" class="hotel">' +
            '<img src="https://picsum.photos/200/150?random=' + index + '" alt="Hotel ' + hoteles[index].nombre + '">' +
            '<h3>' + hoteles[index].nombre + '</h3>' +
            '<p>Precio: <span>' + hoteles[index].pnpp + '</span>€/noche</p>' +
            
            // Div contenedor añadido
            '<div class="controles-wrapper">' +
                '<fieldset class="control-group">' +
                    '<legend>Personas</legend>' +
                    '<div>' +
                        '<button class="btn-restar"><i class="fa-solid fa-minus"></i></button>' +
                        '<input type="number" name="personas" value="1" min="1" class="input-noches">' +
                        '<button class="btn-sumar"><i class="fa-solid fa-plus"></i></button>' +
                    '</div>' +
                '</fieldset>' +
                
                '<fieldset class="control-group">' +
                    '<legend>Noches</legend>' +
                    '<div>' +
                        '<button class="btn-restar"><i class="fa-solid fa-minus"></i></button>' +
                        '<input type="number" name="noches" value="1" min="1" class="input-noches">' +
                        '<button class="btn-sumar"><i class="fa-solid fa-plus"></i></button>' +
                    '</div>' +
                '</fieldset>' +
            '</div>' +
            
            '<button class="btn-reservar">Añadir a reservas</button>' +
        '</li>';
    }
    
    $(".hoteles").html(hotelsList);
}

pintar();


$(".btn-reservar").on("click", function(){
    // 1. Comprobación de límite
    if (reservas.length >= 3) {
        document.getElementById("modal-error").showModal();
        return; // Detenemos la ejecución aquí
    }

    // 2. Recogemos los datos
    var li = $(this). parent();
    var nombreHotel = li.find("h3").text();
    var idHotel = li.attr("id")
    var precioHotel = li.find("p span").text();
    var personas = li.find("input[name='personas']").val();
    var noches = li.find("input[name='noches']").val();
    
    // 3. Creamos un objeto con la información
    var nuevaReserva = {
        id: idHotel,
        nombre: nombreHotel,
        precio: precioHotel,
        personas: personas,
        noches: noches
    };

    // 4. Añadimos al array
    reservas.push(nuevaReserva);
    
    // 5. Opcional: Refrescamos la lista de reservas en el DOM
    actualizarListaReservas();
})

function actualizarListaReservas() {
    var reservasHTML = "";

    // Iteramos sobre el array de objetos 'reservas'
    reservas.forEach(function(res) {
        // Calculamos el total aquí mismo o usamos la propiedad si ya la calculaste
        var total = res.personas * res.noches * res.precio;

        reservasHTML += '<li class="reserva-item">' +
            '<article class="card-reserva">' +
                '<header class="card-header">' +
                    '<strong>' + res.nombre + '</strong>' +
                    '<button class="btn-eliminar"><i class="fa-solid fa-trash"></i></button>' +
                '</header>' +
                '<div class="card-body">' +
                    '<p><i class="fa-solid fa-user"></i> ' + res.personas + ' personas</p>' +
                    '<p><i class="fa-solid fa-moon"></i> ' + res.noches + ' noches</p>' +
                '</div>' +
                '<footer class="card-footer">' +
                    '<span class="precio-total">Total: <strong>' + total + '€</strong></span>' +
                '</footer>' +
            '</article>' +
        '</li>';
    });

    $("ul.reservas").html(reservasHTML);
}

function visible() {
    $("aside").toggleClass("invisible");
}