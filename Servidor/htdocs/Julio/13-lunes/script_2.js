async function mostrar(){
    var datos = await $.post("1.php",{})
    return datos
}

var pintar = async (etiqueta) => {
    await mostrar().then(
        res =>{
            var productos = JSON.parse(res)
            productos.forEach(producto => {
                console.log(producto.titulo_pro)
                etiqueta.append("<p>" + producto["titulo_pro"] + ", " + producto.precio_pro +".</p>")
            });
        }
    ).catch((error)=>{
        alert(error)
    })
}