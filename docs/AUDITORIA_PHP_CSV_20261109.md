# Ad Infinitum — auditoría PHP 8 y CSV (9 de noviembre de 2026)

## Alcance

Restauración **incremental** del portal D&D 4.ª edición sin rehacer el sitio de 2015. Cambios en la rama `audit/php-modern-and-csv-20261109`, revisados mediante el PR #5. No se ha modificado `main` ni desplegado en la Raspberry.

## Datos históricos examinados

La exportación privada de 8-11-2026 contiene **45 CSV**, **625 columnas** y **11.691 registros** en total. Se verificó con un lector CSV respetando el separador `;`, las comillas escapadas y los saltos de línea internos:

- **0** registros con un número de campos distinto del encabezado.
- **0** CSV con comillas sin cerrar.
- **0** IDs repetidos o no positivos en las tablas que disponen de columna `id`.
- `dnd_creature_powers` y `dnd_name_list` tienen cabeceras pero **ninguna fila**.
- **No están incluidas** `main_users` ni `main_visitors`. No se extrapola su estructura.
- Estos CSV son material **histórico**, no un respaldo que deba cargarse en producción; contienen contenido personal y posiblemente contenido protegido.

Los JSON `docs/db-schema-csv-20261108-*.json` conservan **solo nombres de tablas y columnas**, nunca filas, alias personales ni credenciales.

## Ajustes realizados en la rama

1. Diez secciones clásicas (artículos, trasfondos, diseños, razas, clases, rituales, personajes, PNJ, grupos y cronología) distinguen filas con un contador numérico y **validan un ID entero positivo antes de ejecutar SQL**. Un ID ausente o inválido no produce consulta de detalle.
2. Diez secciones apoyadas en tarjetas (criaturas, vehículos, rasgos, objetos, poderes, dotes, objetos mágicos, encantamientos, encuentros y aflicciones) vuelven a mostrar su catálogo cuando no hay ID válido.
3. Diez tarjetas utilizan recuentos numéricos de filas en lugar de comparaciones `0 != ""`, cuyo comportamiento cambió en PHP 8.
4. `enchantment_card.php` tolera la ausencia de la columna histórica `page` con un valor opcional.
5. `mysql_compat.php` mantiene el resultado histórico `false` ante fallos SQL cuando MySQLi usa excepciones (comportamiento predeterminado desde PHP 8.1).
6. Las pruebas en `tools/` comprueban contratos de esquema, columnas leídas, rutas de catálogo con IDs vacíos/incorrectos, resultados SQL vacíos, las rutas públicas ya rehabilitadas y Miniaturas.

## Cobertura automática

El flujo `.github/workflows/php-compatibility.yml` comprueba **PHP 8.2, 8.3, 8.4 y 8.5**, recorre todos los PHP con `php -l`, valida las 45 cabeceras históricas y ejecuta las regresiones sin conectar a MariaDB. En particular:

- `php tools/check_db_csv_contract.php`: tablas y campos declarados en `content/stone.php`.
- `php tools/check_db_csv_field_reads.php`: referencias literales `$dataResult["columna"]` en 30 controladores y tarjetas.
- `php tools/test_catalog_routes_runtime.php`: 50 combinaciones de catálogo en 10 secciones con ID vacío o incorrecto.
- `php tools/test_legacy_catalog_runtime.php`: 50 casos de listados con tablas vacías o entradas no válidas.
- `php tools/test_public_sections_runtime.php`: secciones públicas incluidas en la reparación anterior.
- Regresiones de Miniaturas existentes: runtime, acceso privado, migración simulada e imágenes.

Los cuatro entornos CI deben mostrar **success** en el commit exacto que se integre.

## Pendiente para validar producción

La sintaxis y los mocks **no prueban** que todos los listados y fichas funcionen contra MariaDB real. Quedan por ejecutar pruebas de extremo a extremo en una **copia o entorno de ensayo** de la base actual: rutas `/dnd/`, listados, fichas existentes e inexistentes, imágenes, Miniaturas y consultas SQL reales, sin escribir en tablas ni recuperar credenciales obsoletas.

La exportación CSV no incluye tipos SQL, índices, claves foráneas, vistas, permisos ni diferencias posteriores al 8-11-2026. La autenticación nueva se abordará **en otro cambio**, sin reactivar `main_users` ni formularios heredados y sin tomar por vigentes las credenciales históricas. Este PR **no cambia el archivo de conexión** `content/rosetta.php`.

No declarar la aplicación totalmente compatible ni fusionar/desplegar a ciegas basándose solo en CI. No efectuar migraciones SQL ni editar datos de producción en esta fase.
