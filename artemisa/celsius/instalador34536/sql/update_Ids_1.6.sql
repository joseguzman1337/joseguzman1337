-- actualizacion de ids de eventos. Se hace esto para que no choquen
-- mas los id de eventos, y que las 3 tablas tengan ids unicos
-- Los campos id_eventpo_origen no se actualizan porque tienen todos
-- valor cero. 
UPDATE evanula SET Id = Id + 150000;
UPDATE eventos SET Id = Id + 200000;

-- Update del PIDU
UPDATE paises SET Id = Id +10000;

UPDATE instituciones SET Codigo = Codigo +10000;
UPDATE instituciones SET Codigo_Pais = Codigo_Pais + 10000 WHERE Codigo_Pais <> 0;

UPDATE dependencias SET Id = Id +10000;
UPDATE dependencias SET Codigo_Institucion = Codigo_Institucion + 10000 WHERE Codigo_Institucion <> 0;

UPDATE unidades SET Id = Id +10000;
UPDATE unidades SET Codigo_Institucion = Codigo_Institucion + 10000 WHERE Codigo_Institucion <> 0;
UPDATE unidades SET Codigo_Dependencia = Codigo_Dependencia + 10000 WHERE Codigo_Dependencia <> 0;

UPDATE candidatos SET Codigo_Pais = Codigo_Pais + 10000 WHERE Codigo_Pais <> 0;
UPDATE candidatos SET Codigo_Institucion = Codigo_Institucion + 10000 WHERE Codigo_Institucion <> 0;
UPDATE candidatos SET Codigo_Dependencia = Codigo_Dependencia + 10000 WHERE Codigo_Dependencia <> 0;
UPDATE candidatos SET Codigo_Unidad = Codigo_Unidad + 10000 WHERE Codigo_Unidad <> 0;

UPDATE evanula SET Codigo_Pais = Codigo_Pais + 10000 WHERE Codigo_Pais <> 0;
UPDATE evanula SET Codigo_Institucion = Codigo_Institucion + 10000 WHERE Codigo_Institucion <> 0;
UPDATE evanula SET Codigo_Dependencia = Codigo_Dependencia + 10000 WHERE Codigo_Dependencia <> 0;
UPDATE evanula SET Codigo_Unidad = Codigo_Unidad + 10000 WHERE Codigo_Unidad <> 0;

UPDATE evhist SET Codigo_Pais = Codigo_Pais + 10000 WHERE Codigo_Pais <> 0;
UPDATE evhist SET Codigo_Institucion = Codigo_Institucion + 10000 WHERE Codigo_Institucion <> 0;
UPDATE evhist SET Codigo_Dependencia = Codigo_Dependencia + 10000 WHERE Codigo_Dependencia <> 0;
UPDATE evhist SET Codigo_Unidad = Codigo_Unidad + 10000 WHERE Codigo_Unidad <> 0;

UPDATE eventos SET Codigo_Pais = Codigo_Pais + 10000 WHERE Codigo_Pais <> 0;
UPDATE eventos SET Codigo_Institucion = Codigo_Institucion + 10000 WHERE Codigo_Institucion <> 0;
UPDATE eventos SET Codigo_Dependencia = Codigo_Dependencia + 10000 WHERE Codigo_Dependencia <> 0;
UPDATE eventos SET Codigo_Unidad = Codigo_Unidad + 10000 WHERE Codigo_Unidad <> 0;

UPDATE localidades SET Codigo_Pais = Codigo_Pais + 10000 WHERE Codigo_Pais <> 0;

UPDATE pedanula SET Codigo_Pais_Patente = Codigo_Pais_Patente + 10000 WHERE Codigo_Pais_Patente <> 0;
UPDATE pedanula SET Codigo_Pais_Congreso = Codigo_Pais_Congreso + 10000 WHERE Codigo_Pais_Congreso <> 0;
UPDATE pedanula SET Codigo_Pais_Tesis = Codigo_Pais_Tesis + 10000 WHERE Codigo_Pais_Tesis <> 0;
UPDATE pedanula SET Codigo_Institucion_Tesis = Codigo_Institucion_Tesis + 10000 WHERE Codigo_Institucion_Tesis <> 0;
UPDATE pedanula SET Codigo_Dependencia_Tesis = Codigo_Dependencia_Tesis + 10000 WHERE Codigo_Dependencia_Tesis <> 0;
UPDATE pedanula SET Ultimo_Pais_Solicitado = Ultimo_Pais_Solicitado + 10000 WHERE Ultimo_Pais_Solicitado <> 0;
UPDATE pedanula SET Ultima_Institucion_Solicitado = Ultima_Institucion_Solicitado + 10000 WHERE Ultima_Institucion_Solicitado <> 0;
UPDATE pedanula SET Ultima_Dependencia_Solicitado = Ultima_Dependencia_Solicitado + 10000 WHERE Ultima_Dependencia_Solicitado <> 0;
UPDATE pedanula SET Ultima_Unidad_Solicitado = Ultima_Unidad_Solicitado + 10000 WHERE Ultima_Unidad_Solicitado <> 0;

UPDATE pedhist SET Codigo_Pais_Patente = Codigo_Pais_Patente + 10000 WHERE Codigo_Pais_Patente <> 0;
UPDATE pedhist SET Codigo_Pais_Congreso = Codigo_Pais_Congreso + 10000 WHERE Codigo_Pais_Congreso <> 0;
UPDATE pedhist SET Codigo_Pais_Tesis = Codigo_Pais_Tesis + 10000 WHERE Codigo_Pais_Tesis <> 0;
UPDATE pedhist SET Codigo_Institucion_Tesis = Codigo_Institucion_Tesis + 10000 WHERE Codigo_Institucion_Tesis <> 0;
UPDATE pedhist SET Codigo_Dependencia_Tesis = Codigo_Dependencia_Tesis + 10000 WHERE Codigo_Dependencia_Tesis <> 0;
UPDATE pedhist SET Ultimo_Pais_Solicitado = Ultimo_Pais_Solicitado + 10000 WHERE Ultimo_Pais_Solicitado <> 0;
UPDATE pedhist SET Ultima_Institucion_Solicitado = Ultima_Institucion_Solicitado + 10000 WHERE Ultima_Institucion_Solicitado <> 0;
UPDATE pedhist SET Ultima_Dependencia_Solicitado = Ultima_Dependencia_Solicitado + 10000 WHERE Ultima_Dependencia_Solicitado <> 0;
UPDATE pedhist SET Ultima_Unidad_Solicitado = Ultima_Unidad_Solicitado + 10000 WHERE Ultima_Unidad_Solicitado <> 0;

UPDATE pedidos SET Codigo_Pais_Patente = Codigo_Pais_Patente + 10000 WHERE Codigo_Pais_Patente <> 0;
UPDATE pedidos SET Codigo_Pais_Congreso = Codigo_Pais_Congreso + 10000 WHERE Codigo_Pais_Congreso <> 0;
UPDATE pedidos SET Codigo_Pais_Tesis = Codigo_Pais_Tesis + 10000 WHERE Codigo_Pais_Tesis <> 0;
UPDATE pedidos SET Codigo_Institucion_Tesis = Codigo_Institucion_Tesis + 10000 WHERE Codigo_Institucion_Tesis <> 0;
UPDATE pedidos SET Codigo_Dependencia_Tesis = Codigo_Dependencia_Tesis + 10000 WHERE Codigo_Dependencia_Tesis <> 0;
UPDATE pedidos SET Ultimo_Pais_Solicitado = Ultimo_Pais_Solicitado + 10000 WHERE Ultimo_Pais_Solicitado <> 0;
UPDATE pedidos SET Ultima_Institucion_Solicitado = Ultima_Institucion_Solicitado + 10000 WHERE Ultima_Institucion_Solicitado <> 0;
UPDATE pedidos SET Ultima_Dependencia_Solicitado = Ultima_Dependencia_Solicitado + 10000 WHERE Ultima_Dependencia_Solicitado <> 0;
UPDATE pedidos SET Ultima_Unidad_Solicitado = Ultima_Unidad_Solicitado + 10000 WHERE Ultima_Unidad_Solicitado <> 0;

UPDATE usuarios SET Codigo_Pais = Codigo_Pais + 10000 WHERE Codigo_Pais <> 0;
UPDATE usuarios SET Codigo_Institucion = Codigo_Institucion + 10000 WHERE Codigo_Institucion <> 0;
UPDATE usuarios SET Codigo_Dependencia = Codigo_Dependencia + 10000 WHERE Codigo_Dependencia <> 0;
UPDATE usuarios SET Codigo_Unidad = Codigo_Unidad + 10000 WHERE Codigo_Unidad <> 0;