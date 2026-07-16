// Función para renderizar la tabla común
function mostrar(tabla) {
    $.get("PHP/search.php", { tipo: tabla }, function(datos) {
        var tbody = $("#tabla-body");
        tbody.empty(); // Vaciamos filas anteriores

        datos.forEach(function(item) {
            var fila = `<tr>
                <td>${item.id}</td>
                <td>${item.nombre}</td>
                <td>${item.descripcion}</td>
                <td>${item.precio} €</td>
                <td id="${item.id}">
                    <button type="button" class="btn btn-warning editar" aria-label="Close">
                        <i class="fa-solid fa-pen-to-square" style="color: white;"></i>
                    </button>
                    <button type="button" class="btn btn-danger borrar" aria-label="Close">
                        <i class="fa-solid fa-trash" style="color: white;"></i>
                    </button>
                </td>
            </tr>`;
            tbody.append(fila);
        });
    }, "json").fail(function() {
        console.error("Error al cargar los datos de la tabla: " + tabla);
    });
}

// Función encargada de cambiar visualmente y lógicamente la app
function cambiarCategoria(categoria) {
    categoriaActual = categoria;

    // Gestionar pestañas de navegación activas
    $(".nav-link").removeClass("active");
    
    if (categoria === "bebidas") {
        $("#btn-bebidas").addClass("active");

        // Configurar formulario
        $("#form-titulo").text("Insertar Bebida");
        $("#input-tipo").val("bebidas");
        $("#btn-submit").removeClass("btn-success").addClass("btn-primary").text("Guardar Bebida");

        // Configurar tabla
        $("#tabla-titulo").text("Lista de Bebidas");
    } else {
        $("#btn-postres").addClass("active");

        // Configurar formulario
        $("#form-titulo").text("Insertar Postre");
        $("#input-tipo").val("postres");
        $("#btn-submit").removeClass("btn-primary").addClass("btn-success").text("Guardar Postre");

        // Configurar tabla
        $("#tabla-titulo").text("Lista de Postres");
    }

    // Cargar los datos correspondientes en la tabla común
    mostrar(categoria);
}