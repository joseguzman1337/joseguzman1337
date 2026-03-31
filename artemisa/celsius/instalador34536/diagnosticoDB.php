<?
die("No se usa por ahora. Habria que terminarlo");
//TODO terminar
"SELECT p.Id FROM pedidos as p WHERE p.Id IN (SELECT ph.Id FROM pedhist as ph)
UNION
SELECT ph2.Id FROM pedhist as ph2 WHERE ph2.Id IN (SELECT p2.Id FROM pedidos as p2)

SELECT p.Id FROM pedidos as p WHERE p.Id IN (SELECT pa.Id FROM pedanula as pa)
UNION
SELECT pa2.Id FROM pedanula as pa2 WHERE pa2.Id IN (SELECT p2.Id FROM pedidos as p2)

SELECT ph.Id FROM pedhist as ph WHERE ph.Id IN (SELECT pa.Id FROM pedanula as pa)
UNION
SELECT pa2.Id FROM pedanula as pa2 WHERE pa2.Id IN (SELECT ph2.Id FROM pedhist as ph2)
"
?>