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

sql = "SELECT * FROM clientes"

conexion.execute(sql)

clientes = conexion.fetchall()

for cliente in clientes:
    print(cliente[0], cliente[1], cliente[2], cliente[3])