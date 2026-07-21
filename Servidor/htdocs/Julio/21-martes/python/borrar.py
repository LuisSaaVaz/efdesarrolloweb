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

sql = "SELECT id_cli FROM clientes WHERE ape_cli= 'Saavedra'"
conexion.execute(sql)
id = conexion.fetchall()[0][0]

sql2 = f"DELETE FROM clientes WHERE id_cli = {id}"

conexion.execute(sql2)

ddbb.commit()