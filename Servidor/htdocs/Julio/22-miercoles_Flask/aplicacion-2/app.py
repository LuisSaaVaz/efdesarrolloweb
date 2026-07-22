from flask import Flask, render_template, request
import mysql.connector

servidor = Flask(__name__) # Viene siendo el start de Apache

# Crear la DDBB
ddbb = mysql.connector.connect(
    host = "10.10.10.160",
    user = "clase",
    password = "1234",
    database = "martes21"
)

conexion = ddbb.cursor()

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
    
    conexion.execute(sql)

    # Si hago Insert, Update o Delete hay que hacer commit a la DDBB
    ddbb.commit()

    # Voy a tabla.html
    return tabla()

def search(tabla):
    sql = f"SELECT * FROM {tabla}"

    conexion.execute(sql)

    return conexion.fetchall()

# Arrancar el servidor
servidor.run()