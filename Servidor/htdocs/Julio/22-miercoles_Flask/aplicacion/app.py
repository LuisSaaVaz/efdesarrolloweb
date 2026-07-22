from flask import Flask, render_template, request

servidor = Flask(__name__) # Viene siendo el start de Apache

# Definir RUTAS
@servidor.route("/")
def raiz():
    return render_template("index.html")

@servidor.route("/contact")
def contact():
    return render_template("contacto.html")

servidor.run()