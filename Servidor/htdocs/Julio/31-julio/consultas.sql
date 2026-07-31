SELECT * FROM clientes
    INNER JOIN facturas
        USING(dni); -- Cuando el atributo se llama igual

SELECT * FROM clientes
    INNER JOIN facturas
        ON clientes.dni = facturas.dni;

SELECT * FROM clientes CL
    INNER JOIN facturas FA
        ON CL.dni = FA.dni;

SELECT * FROM clientes CL
    INNER JOIN facturas FA
        USING(dni)
    INNER JOIN productosenfacturas
        USING(nfac)

