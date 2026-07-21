# If
x = 5
y = 8

""" if x > y : 
    # Parte positiva
    print("Es mayor")

elif x == y:
    # Otra posibilidad
    print("Es igual")

else:
    # Parte negativa
    print("Es menor") """


""" nombre = input("Escribe tu nombre: ")
sexo = input("Escribe tu sexo h/m: ")

if sexo == "h": 
    # Parte positiva
    print("Bienvenido", nombre)
    print("Bienvenido " + nombre)
    print(f"Bienvenido {nombre}")

elif sexo == "m":
    # Otra posibilidad
    print("Bienvenida", nombre)
    print("Bienvenida " + nombre)
    print(f"Bienvenida {nombre}")

else:
    # Parte negativa
    print("Bienvenide", nombre)
    print("Bienvenide " + nombre)
    print(f"Bienvenide {nombre}") """


nombre = input("Escribe tu nombre: ")
apellidos = input("Escribe tu apellidos: ")
edad = input("Escribe tu edad: ")
ayuntamiento = input("Escribe tu edad: ")

lista = [nombre, apellidos, edad,ayuntamiento]

print(lista)

# Recorrer la lista
for dato in lista:
    print(dato)