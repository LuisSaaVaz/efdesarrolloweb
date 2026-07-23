from flask import Flask, render_template, request
from utils.ddbb import *

servidor = Flask(__name__) # Viene siendo el start de Apache

# Definir RUTAS de Renderizar
@servidor.route("/")
def raiz():
    return render_template("index.html")

@servidor.route("/altas")
def altas():
    return render_template("altas.html")

# Definir RUTA para visualizar tablas
""" @servidor.route("/tablas")
def tablas(lista=""):
    if lista == "palabras" or lista == "orquestas":
        # return campos(lista)
        return render_template("tablas.html", tabla = lista, datos = search(lista))

    return render_template("tablas.html", tabla = "palabras", datos = search("palabras"))
 """

# Definir RUTA para visualizar tablas
@servidor.route("/tablas", methods=["GET", "POST"])
def tablas(tabla=None, mensaje=None, tipo_toast=None):
    if request.method == "POST":
        if "tabla" in request.form:
            lista = request.form["tabla"]
        else:
            lista = "palabras"
    elif tabla:
        lista = tabla
    else:
        lista = "palabras"

    return render_template(
        "tablas.html", 
        tabla=lista, 
        datos=search(lista),
        mensaje=mensaje,
        tipo_toast=tipo_toast
    )

# Definir RUTAS de Acciones
@servidor.route('/insert', methods=['POST'])
def insert():
    tabla = request.form['tabla'] # Recibe "palabras" o "orquestas"
    sql = ""
    if tabla == 'palabras':
        espanol = request.form['espanol_pal']
        gallego = request.form['gallego_pal']
        sql = f"""
            INSERT INTO {tabla} (espanol_pal, gallego_pal)
            VALUES ('{espanol}', '{gallego}')
        """
        
    elif tabla == 'orquestas':
        nombre = request.form['nom_orq']
        sql = f"""
            INSERT INTO {tabla} (nom_orq)
            VALUES ('{nombre}')
        """

    else:
        return altas()

    add(sql)
    
    # Voy a tabla.html
    return tablas(tabla)

# --- RUTA ÚNICA PARA BORRAR ---
@servidor.route('/delete', methods=['POST'])
def delete():
    tabla = request.form['tabla']
    id_registro = request.form['id']
    
    # Determinamos el nombre del campo ID según la tabla
    campo_id = "id_pal" if tabla == "palabras" else "id_orq"
    
    sql = f"DELETE FROM {tabla} WHERE {campo_id} = {id_registro}"
    
    try:
        add(sql) # O la función que ejecuta la query
        return tablas(tabla, mensaje="Registro eliminado correctamente", tipo_toast="success")
    except:
        return tablas(tabla, mensaje="Error al eliminar el registro", tipo_toast="danger")


# --- RUTA ÚNICA PARA EDITAR ---
@servidor.route('/update', methods=['POST'])
def update():
    tabla = request.form['tabla']
    id_registro = request.form['id']
    
    if tabla == 'palabras':
        espanol = request.form['espanol_pal']
        gallego = request.form['gallego_pal']
        sql = f"UPDATE palabras SET espanol_pal = '{espanol}', gallego_pal = '{gallego}' WHERE id_pal = {id_registro}"
    else:
        nombre = request.form['nom_orq']
        sql = f"UPDATE orquestas SET nom_orq = '{nombre}' WHERE id_orq = {id_registro}"
        
    try:
        add(sql)
        return tablas(tabla, mensaje="Registro actualizado correctamente", tipo_toast="success")
    except:
        return tablas(tabla, mensaje="Error al actualizar el registro", tipo_toast="danger")


# Arrancar el servidor
servidor.run(debug=True)