-- 1. Todos los clientes con provincia
SELECT * FROM clientes
    INNER JOIN direcciones
        USING(dni)
    INNER JOIN provincias
       USING(idprovincia);

SELECT * FROM clientes CL
    INNER JOIN direcciones DI
        ON CL.dni = DI.dni
    INNER JOIN provincias PR
        ON DI.idprovincia = PR.idprovincia;

-- 2. Todos los clientes con tarjeta visa
SELECT * FROM clientes
    INNER JOIN tarjetas
        USING(dni)
    INNER JOIN tipotarjeta
       USING(idtipotar)
    WHERE tipotarjeta.tipo="VISA";

SELECT * FROM clientes CL
    INNER JOIN tarjetas TA
        ON CL.dni = TA.dni
    INNER JOIN tipotarjeta TT
        ON TA.idtipotar = TT.idtipotar
    WHERE TT.tipo="VISA";

-- 3. Todos los clientes con tarjeta mastercard y de pontevedra
SELECT clientes.nombre, provincias.provincia FROM clientes
    INNER JOIN direcciones
        USING(dni);
    INNER JOIN provincias
       USING(idprovincia)
    INNER JOIN tarjetas
        USING(dni)
    INNER JOIN tipotarjeta
       USING(idtipotar)
    WHERE tipotarjeta.tipo="MASTERCARD" AND provincias.provincia="Pontevedra";

SELECT CL.nombre FROM clientes CL
    INNER JOIN direcciones DI
        ON CL.dni = DI.dni
    INNER JOIN provincias PR
        ON DI.idprovincia = PR.idprovincia
    INNER JOIN tarjetas TA
        ON CL.dni = TA.dni
    INNER JOIN tipotarjeta TT
        ON TA.idtipotar = TT.idtipotar;
    WHERE tipotarjeta.tipo="MASTERCARD" AND PR.provincia="Pontevedra";

-- 4. Todos los productos con precio mayor a 50€
SELECT * FROM productos
    WHERE precio>50;

-- 5. Todos los productos con precio mayor a 50€ vendidos a clientes de Coruña
SELECT * FROM productos
    INNER JOIN productosenfacturas
        USING(idproducto);
    INNER JOIN facturas
       USING(nfac)
    INNER JOIN direcciones
        USING(iddir)
    INNER JOIN provincias
       USING(idprovincia)
    WHERE precio>50 AND provincias.provincia="A Coruña";

SELECT * FROM productos PRO
    INNER JOIN productosenfacturas PEF
        ON PRO.idproducto = PEF.idproducto
    INNER JOIN facturas FA
        ON PEF.nfac = FA.nfac
    INNER JOIN direcciones DI
        ON FA.iddir = DI.iddir
    INNER JOIN provincias PR
        ON DI.idprovincia = PR.idprovincia;
    WHERE precio>50 AND PR.provincia="A Coruña";

-- 6. Nombre de los clientes de Pontevedra que le compraron a los proveedores de Lugo un pantalon XS pagado con VISA
SELECT clientes.nombre FROM clientes
    LEFT JOIN direcciones
        USING(dni);
    INNER JOIN provincias
       USING(idprovin)
    INNER JOIN facturas
        USING(dni)
    INNER JOIN tarjetas
       USING(idtar)
    INNER JOIN tipotarjeta
       USING(idtipotar)
    INNER JOIN productosenfacturas
       USING(nfac)
    INNER JOIN productos
       USING(idproducto)
    INNER JOIN tallas
       USING(idtalla)
    INNER JOIN proveedores
       USING(idproveedor)
    WHERE provincias.provincia="Pontevedra" 
        AND productos.nombre="pantalon" 
        AND tipotarjeta.tipo="VISA" 
        AND idproveedor IN (
            SELECT idproveedor FROM proveedores
                INNER JOIN provincias
                WHERE provincias.provincia="Lugo"
        );

SELECT * FROM productos PRO
    INNER JOIN productosenfacturas PEF
        ON PRO.idproducto = PEF.idproducto
    INNER JOIN facturas FA
        ON PEF.nfac = FA.nfac
    INNER JOIN direcciones DI
        ON FA.iddir = DI.iddir
    INNER JOIN provincias PR
        ON DI.idprovincia = PR.idprovincia;
    WHERE precio>50 AND PR.provincia="A Coruña";