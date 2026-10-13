# Migración del ID de Miniaturas (autorizada)

El autor autorizó la operación el 14 de octubre de 2026. Solo afecta a la tabla `dnd_miniatures`: convertir `id` en **PRIMARY KEY AUTO_INCREMENT**, conservando sus 41 registros históricos y sus identificadores.

## En la Raspberry

```bash
cd /mnt/ssd/html/dnd
git pull --ff-only origin main
php tools/migrate_miniatures_id.php
sudo php tools/migrate_miniatures_id.php --apply
php tools/check_miniatures_preflight.php
```

El primer comando PHP es **de solo lectura**. Debe confirmar que los ID son positivos, no se repiten y que la estructura sigue siendo la de 2015. No ejecutar `--apply` si muestra ERROR.

El segundo crea **antes de cambiar nada** un backup SQL privado en `/mnt/ssd/dnd-backups/`, fuera de `/mnt/ssd/html/`, con permisos restrictivos. Comprueba que el fichero puede leerse y muestra su ruta y SHA-256. No subirlo a GitHub.

Solo después efectúa un `ALTER TABLE` para añadir la clave primaria autoincremental. Tiene en cuenta las fechas `0000-00-00` del origen y restaura el modo SQL de la conexión. Comprueba el mismo número de filas, el mismo contenido y los mismos ID tras el cambio.

**Si aparece un ERROR, no repetir `--apply` ni restaurar a ciegas:** conservar el backup y enviar el error para revisión. MariaDB no garantiza rollback automático de operaciones DDL. Para restaurar datos, probar primero el SQL de respaldo en una base aislada, no en producción.

## Después del éxito

Abre `http://192.168.1.80/dnd/miniatures/admin/`. Tras entrar con la cuenta privada, el formulario estará habilitado para introducir nombre, referencia comercial, precio, colección, personaje, descripción y foto JPEG. Guarda una miniatura de prueba y verifica que aparece en la tabla y su ficha sin nuevo `git pull`.

Si aparece un mensaje de permisos para las fotos, será necesario comprobar por separado la escritura de `www-data` en `media/figurine/`.

No se modifican las otras tablas, la autenticación antigua, ni las URLs públicas.
