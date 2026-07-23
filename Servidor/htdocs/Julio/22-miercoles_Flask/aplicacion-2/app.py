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

@servidor.route("/tabla")
def tabla():
    return render_template("tabla.html", clientes = search("clientes"))

@servidor.route("/contact")
def contact():
    return render_template("contacto.html")


# Definir RUTAS de Acciones
@servidor.route("/insert", methods=["POST"])
def insert():
    nom = request.form["nombre"]
    apes = request.form["apellidos"]
    age = request.form["edad"]
    
    sql = f"""
    INSERT INTO clientes (nom_cli, ape_cli, edad_cli)
    VALUES ('{nom}', '{apes}', '{age}')
    """
    
    add(sql)

    # Voy a tabla.html
    return tabla()


# Arrancar el servidor
servidor.run()