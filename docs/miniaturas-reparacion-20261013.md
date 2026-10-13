# Reparación mínima de `/dnd/miniatures/` (13-10-2026)

## Síntoma confirmado
La portada y los menús cargaban, pero la sección Miniaturas aparecía vacía. En PHP 8.2–8.4, `0 != ""` evalúa a `true`; la condición original del listado intentaba mostrar la ficha de un registro inexistente.

## Cambio
- `/dnd/miniatures/`: sin ID se muestra el catálogo, ordenado por nombre.
- `/dnd/miniatures/1/`: se busca un ID numérico, sin concatenar cadenas arbitrarias del visitante al SQL.
- Se escapan etiquetas y atributos HTML en la ficha.
- Se añaden nombres `.jpg` para las dos imágenes `.JPG` existentes en Linux, **sin borrar ni cambiar sus archivos originales**.
- `content/stone.php` y `.htaccess` **no se modifican**: esta reparación es específica de la dirección real `/dnd/` y evita las rutas de prueba `/dnd-php-test/`.
- `main` recibe únicamente esta reparación y las pruebas; quedan aparte las reformas de seguridad generales del PR #2.

## Cómo desplegar en la Raspberry (solo tras pruebas verdes y merge de la PR)
```bash
cd /mnt/ssd/html/dnd
git status --short
git pull --ff-only origin main
php -l content/sections/miniatures.php
curl -sS -o /dev/null -w 'HTTP %{http_code}\n' http://127.0.0.1/dnd/miniatures/
```
Abrir `http://192.168.1.80/dnd/miniatures/` y comprobar que aparece la tabla y que se abre una ficha.

**Límites:** la CI usa simulaciones, no la MySQL de Raspberry. El código histórico aún contiene rutas de escritura y autenticación inseguras en otras partes: no se autoriza exposición pública fuera de LAN.
