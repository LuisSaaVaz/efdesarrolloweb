async function mostrar(){
    var datos = await $.post("1.php",{})
    return datos
}

/* mostrar().then(function(todo){
    alert(todo)
}) */

mostrar().then(todo => {
    alert(todo)
}).catch(alert("Error"))