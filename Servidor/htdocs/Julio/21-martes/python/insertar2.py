# pip install mysql-connector-python

import mysql.connector

# Crear la DDBB
ddbb = mysql.connector.connect(
    host = "10.10.10.160",
    user = "clase",
    password = "1234",
    database = "martes21"
)

conexion = ddbb.cursor()

nombre = input("Escribe tu nombre: ")
apellidos = input("Escribe tu apellidos: ")
edad = input("Escribe tu edad: ")

sql = f"""
INSERT INTO clientes (nom_cli, ape_cli, edad_cli)
VALUES ('{nombre}', '{apellidos}', '{edad}')
"""

conexion.execute(sql)

# Si hago Insert, Update o Delete hay que hacer commit a la DDBB
ddbb.commit()

print( f"Se grabó: {nombre}, {apellidos} y {edad}")