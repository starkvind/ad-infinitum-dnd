# Restauración PHP 8 — secciones públicas (octubre 2026)

**Objetivo:** restaurar el listado y la ficha de cada sección sin rehacer el portal de 2015. Trabajo directo sobre `main`; sin migraciones SQL, cambios de rutas, CSS ni administración histórica.

## Diagnóstico

`content/main_work.php` recibe `page` como `""` si no figura en la URL. Con PHP 8, tanto `0 != ""` como `"" != 0` son verdaderos; no deben usarse para decidir entre catálogo y ficha.

**Confirmado en código, grupo A (14 archivos):** `location.php`, `player.php`, `class.php`, `article.php`, `action.php`, `background.php`, `book.php`, `builds.php`, `npc.php`, `parties.php`, `ritual.php`, `shop.php`, `race.php` y `timeline.php`. Todos comparaban el entero de `mysql_num_rows()` mediante `$rowsData != ""`.

**Confirmado en código, grupo B (10 archivos más):** `enemy.php`, `vehicle.php`, `trait.php`, `thing.php`, `power.php`, `feat.php`, `item.php`, `enchantment.php`, `encounter.php` y `ailment.php`. Sus entradas `if ($page != 0)` toman el camino de ficha con el valor vacío que facilita el enrutador. Requieren inspeccionar las fichas auxiliares antes de modificar nada.

**Probable / pendiente de revisión:** rutas con consultas de ficha sobre `page` no validado, como algunas páginas históricas que ya usan guardas `> 0`. La seguridad y el tratamiento de IDs inexistentes deben revisarse sección a sección; no aplicar reemplazos indiscriminados.

**Descartado como causa de este fallo:** la condición `$dataRows != 0` de `contents_list.php` (ambos valores son numéricos), las condiciones `$rowsData > 0` de `adventure.php` y `news.php`, y la capa `mysql_compat.php`, cuya función `mysql_num_rows()` devuelve el entero esperado. Tampoco es necesario modificar `index.php`, `.htaccess` ni `RewriteBase /dnd/` para esta reparación.

**Nota de ruta:** `location.php` corresponde a la sección `locations` (plural), accesible desde `/dnd/locations/`.

## Primera tanda integrada

- `content/sections/location.php`, `action.php` y `book.php`: consulta individual exclusivamente con ID entero positivo validado con `FILTER_VALIDATE_INT`; comprobación de resultado real, aviso cuando el ID no es válido o no existe, catálogo sin ID.
- `tools/test_public_sections_runtime.php`: prueba ejecutable con MySQL simulado para catálogo, ficha, ID inexistente, entrada inválida, valor `page[]` y filtro territorial de Lugares.
- `.github/workflows/miniatures-php-checks.yml`: continúa probando Miniaturas y ejecuta las nuevas regresiones en PHP 8.2, 8.3 y 8.4.
- Sin cambios de esquema, administración de Miniaturas ni componentes globales.

## Validación

La primera tanda superó GitHub Actions: [ejecución 38481589449](https://github.com/starkvind/ad-infinitum-dnd/actions/runs/38481589449). Son pruebas aisladas de los controladores; no equivalen a validación sobre MariaDB ni sobre Apache en la Raspberry.

En la Raspberry, comprobar primero que no hay cambios locales:

```bash
cd /mnt/ssd/html/dnd
git status --short
git pull --ff-only origin main
php tools/test_public_sections_runtime.php
php tools/test_miniatures_runtime.php
```

Verificar en navegador los listados `/dnd/locations/`, `/dnd/actions/`, `/dnd/bestiary/` y `/dnd/miniatures/`; abrir al menos una ficha existente por sección y revisar un ID inexistente. No se ha validado producción desde GitHub.

## Tandas pendientes

1. Artículos, Trasfondos, Tiendas y Diseños de clase.
2. Razas, Clases, Rituales.
3. Personajes, PNJ, Grupos, Cronología.
4. Controladores con `$page != 0`, junto con sus ficheros `*_card.php`.

Tratar cada tanda con cambios pequeños, pruebas de comportamiento y comprobación de Miniaturas. No modificar base de datos sin autorización.
