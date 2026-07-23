import mysql.connector

# __all__ = ['search', 'add']  # Solo expone estas dos funciones al usar import *
# def _funcion_interna() # Cuando el nombre de la funcion empieza por _ se entiende que es para uso interno de este documento

# Crear la DDBB
ddbb = mysql.connector.connect(
    host = "10.10.10.160",
    user = "clase",
    password = "1234",
    database = "jueves23"
)

conexion = ddbb.cursor()

def search(tabla):
    sql = f"SELECT * FROM {tabla}"
    conexion.execute(sql)
    return conexion.fetchall()

def add(sql):
    conexion.execute(sql)
    # Si hago Insert, Update o Delete hay que hacer commit a la DDBB
    ddbb.commit()

def update(sql):
    conexion.execute(sql)
    # Si hago Insert, Update o Delete hay que hacer commit a la DDBB
    ddbb.commit()

def delete(sql):
    conexion.execute(sql)
    # Si hago Insert, Update o Delete hay que hacer commit a la DDBB
    ddbb.commit()