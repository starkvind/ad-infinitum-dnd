# Ad Infinitum — registro de restauración y MVP de Miniaturas

**Estado:** 13 de octubre de 2026 · plan vigente · trabajo gradual sobre `main` · **sin refactor general**.

## Propósito y límites

Recuperar la web de Ad Infinitum de 2015 como cápsula del tiempo funcional, conservando interfaz, datos, rutas `/dnd/`, comportamiento e identidad visual. No repetir la reconstrucción completa de Heaven's Gate: aquí mandan las **reparaciones pequeñas, verificables y reversibles**.

**MVP prioritario:** poder dar de alta una nueva miniatura (datos + fotografía) y verla automáticamente en `/dnd/miniatures/` y en su ficha `/dnd/miniatures/{id}/`, sin editar código PHP cada vez ni regenerar toda la web. La carga debe ser sencilla desde la Raspberry y no debe exponer operaciones de escritura a visitantes anónimos.

**Fuera del MVP:** rediseño del portal, cambio de framework, normalización integral de 47 tablas, migración masiva de `mysql_*`, refactor total de las 132 piezas PHP, publicación pública de contenidos privados y nuevas funcionalidades de Heaven's Gate.

## Estado comprobado

- Producción: repositorio `starkvind/ad-infinitum-dnd`, rama `main`, desplegada con `git pull --ff-only` en `/mnt/ssd/html/dnd`.
- El usuario confirmó que `/dnd/miniatures/` ya funciona tras integrar el PR #4 (`a47e9e674054d04a96c82d5f38e434640eac6d88`). Se corrigió la comparación problemática de PHP 8 `0 != ""`.
- `content/sections/miniatures.php` consume `dnd_miniatures` y `content/sections/contents_list.php` construye el listado. Las imágenes se buscan en `media/figurine/` y se renderizan con extensión `.jpg`; los alias de `bugbear` y `spirit` se corrigieron en el PR #4.
- En el volcado privado **del 13-10-2026**, `dnd_miniatures` tiene 41 registros y campos: `id`, `url`, `id_mini`, `name`, `price` (entero en céntimos según visualización actual), `collection`, `picture` (nombre base de imagen), `infotext`, `avatar`, `date`. **El DDL del volcado no declara `AUTO_INCREMENT` ni PRIMARY KEY**: hay que contrastar el esquema de la Raspberry antes de cualquier `INSERT`.
- `content/user/management.php` contiene menús para altas de aventuras, rasgos, dotes, lugares y tarjetas, **pero no se ha encontrado una opción equivalente de alta de Miniaturas**. `content/user/add_db.php` tampoco contiene una operación específica de Miniaturas.
- El volcado SQL es una fuente privada para diagnóstico, **no se debe subir al GitHub público**. Los datos y contraseñas históricos requieren protección.

## Trabajo aprobado: tres pasos, nada más

### M1 — Comprobar el contrato de altas (primera tarea)

1. Confirmar sobre la Raspberry, **en solo lectura**, el `SHOW CREATE TABLE dnd_miniatures`, claves/índices y el máximo `id`; **no publicar credenciales ni datos privados**.
2. Confirmar permisos de escritura y copia de seguridad del directorio `media/figurine/` y de la base de datos, antes de permitir altas.
3. Elegir la superficie mínima segura para introducir una miniatura: **importador local por SSH primero** si se desea la vía más corta; formulario protegido para administradores si la comodidad de cargar por navegador es indispensable. No reutilizar el antiguo login/gestor de escrituras sin auditarlo.
4. No modificar registros existentes ni cambiar rutas públicas.

**Hecho cuando:** esquema real confirmado y procedimiento de copia de seguridad/rollback escrito, sin operaciones destructivas.

### M2 — Alta de Miniaturas de extremo a extremo (MVP)

Implementar **una sola vía de alta**, sin generalizarla a otras secciones:

- Datos: nombre, referencia comercial `id_mini`, colección, precio en céntimos, personaje representado, descripción opcional y fotografía JPEG. La miniatura debe conservar su `id` interno para la ficha.
- Validar tipo y tamaño del archivo y generar un nombre seguro en minúsculas; nunca ejecutar archivos subidos ni permitir rutas arbitrarias. Guardar imagen de forma verificable y respaldable.
- Insertar con una consulta preparada (`mysqli`); identificar nuevos `id` sin colisiones, **según el esquema real**. No insertar a ciegas mediante `MAX(id)+1` en un entorno concurrente ni cambiar esquema sin copia y preflight.
- Comprobar `/dnd/miniatures/`, ficha y fotografía **inmediatamente tras el alta**, sin nueva publicación de PHP o `git pull`; el catálogo ya consulta la base de datos al cargar.
- Si se usa formulario web, protegerlo con autenticación de administrador comprobada, CSRF, restricción de permisos y manejo seguro de subida. No habilitar una URL de escritura anónima por comodidad.

**Hecho cuando:** se da de alta una miniatura de prueba, aparece en tabla, se abre su ficha, se ve la imagen, no se alteran las anteriores y se comprueba respaldo/recuperación.

### M3 — Mantenimiento mínimo

Una prueba funcional de catálogo, ficha e imagen y un comando de comprobación HTTP de producción, al estilo del `tools/production_smoke.sh` de Heaven's Gate pero **limitado a Ad Infinitum**. Documentar en README cómo dar de alta, validar y revertir. Corregir únicamente bloqueos encontrados.

**Hecho cuando:** el flujo de alta puede repetirse sin intervención sobre SQL o PHP en cada miniatura y la documentación describe lo que está desplegado.

## Deuda técnica inventariada — solo tocar si bloquea el MVP

| Prioridad | Área | Evidencia concreta | Política |
| --- | --- | --- | --- |
| Bloqueante de escritura | Seguridad de DB, claves y contraseñas | `content/rosetta.php` conserva credenciales heredadas; consultas concatenadas en `content/user/add_db.php`, `check_person.php`, `update_userdata.php`. | Ningún endpoint nuevo escribirá usando ese código sin validación/autorización; rotar credenciales antes de exposición pública. |
| Alta | Comparaciones PHP 8 | `if ($rowsData != "")` aparece aún en clases, lugares, artículos, personajes, NPC, razas, aventuras derivadas y otros módulos; Miniaturas fue el caso resuelto. | Corregir por módulo si se detecta fallo funcional; no refactorizar indiscriminadamente. |
| Alta | Búsqueda | `content/main/main_search.php` usa SQL histórico y `mysql_close()` antes de una operación posterior. | Reparar cuando la búsqueda entre en alcance. |
| Media | Capa MySQL heredada | 346 referencias `mysql_*` detectadas en 70 archivos de la rama de auditoría; capa `content/mysql_compat.php`. | Mantenerla de momento, no reescribir toda la web. |
| Media | Recursos de navegador | jQuery 1.8.2, DataTables 1.9.4, jQuery Tools 1.2.7; falta `script/tooltipster.css` y `s.tooltip.js` está vacío. | Corregir recursos rotos sin rediseñar. |
| Media | Rutas | Configuración histórica de `/dnd/`, HTTP y enlaces externos. | **No alterar `/dnd/`**; probar rutas antes de tocar enlaces. |
| Operativa | Ausencia de documentación | README histórico mínimo; log de ajustes de febrero de 2026 no equivale a pruebas funcionales. | Este documento es registro inicial; mantenerlo conciso y vigente. |

No dar por arreglado un módulo solo porque pasa `php -l`.

## Procedimiento operativo acordado

- Cambios pequeños **directamente sobre `main`**, con commits descriptivos y prueba antes/después del despliegue. Se permite `git pull --ff-only origin main` en `/mnt/ssd/html/dnd`.
- No volver a desplegar ramas de pruebas ni mover `RewriteBase` a `/dnd-php-test/`. La copia de pruebas de la Raspberry se retira **desde la propia Raspberry**.
- Guardar antes de cambios destructivos un backup privado verificable de MySQL y de imágenes; un `git revert` no revierte filas SQL ni archivos añadidos en producción.
- Mantener protegidas contraseñas, configuraciones reales, SQL privados y datos personales. No dar por segura para Internet una aplicación cuyo uso LAN funciona.
- Heaven's Gate es referencia de **disciplina operativa** (pruebas y documentación), no plantilla para un refactor de Ad Infinitum.
- Esta página reemplaza la idea de una migración grande como prioridad inmediata. Revaluar solo tras completar el MVP.

## Próxima acción exacta

**M1:** comprobar esquema real y método de carga seguro, y luego implementar el flujo de alta de una única miniatura. Ninguna modificación de tablas ni activación de formularios de escritura antes de esa comprobación.

## Referencias históricas

- PR #4 — reparación de Miniaturas, fusionado en `main`.
- PR #2 — auditoría PHP y endurecimiento, con trabajo experimental que **no debe fusionarse completo sin revisión**.
- PR #1 — prototipo estático patrimonial, **fuera del alcance del MVP PHP actual**.
- `revive_log.md` — registro de la primera campaña de compatibilidad de febrero de 2026.

