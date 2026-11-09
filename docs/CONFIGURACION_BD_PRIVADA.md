# Conexión MariaDB privada (requisito antes de desplegar)

La rama de auditoría elimina las credenciales SQL escritas en `content/rosetta.php`.
**No integrar en `main` ni ejecutar `git pull` en producción hasta preparar este archivo.**
La aplicación mostrará HTTP 503 si la configuración privada no existe o MariaDB rechaza la conexión.

En la Raspberry, cuya instalación habitual está en `/mnt/ssd/html/dnd`, crear fuera de la raíz pública el archivo `/mnt/ssd/private/ad-infinitum-db.php`. Ejemplo de estructura (sustituir todos los marcadores por valores válidos y nuevos):

```php
<?php
return [
    'host' => 'localhost',
    'user' => 'USUARIO_APP',
    'password' => 'CONTRASEÑA_NUEVA',
    'database' => 'DB2243630',
    'port' => 3306,
];
```

El proceso de PHP (normalmente `www-data`) debe poder leerlo, pero otros usuarios no. Crear el directorio fuera de `/mnt/ssd/html`, asignar propietario y permisos restrictivos, y comprobar permisos de lectura reales de PHP-FPM/Apache. Si se instala en otra ruta, establecer `AD_INFINITUM_DB_CONFIG` como ruta absoluta desde la configuración del servicio web (comprobar que PHP-FPM transmite dicha variable) o adaptar el destino privado antes del despliegue.

**Seguridad:** las credenciales anteriores aparecieron en código GitHub público y pueden persistir en el historial aun tras eliminarlas de `main`. Rotarlas en MariaDB y revocar la cuenta anterior si sigue activa. No incluir usuarios, contraseñas ni copias de seguridad en incidencias, logs públicos o commits. Mantener permisos mínimos en el usuario SQL de lectura y usar una identidad separada para operaciones administrativas cuando corresponda.

### Validación de despliegue

1. Crear y verificar el archivo privado **antes** de integrar los commits.
2. Probar que el usuario de PHP puede leerlo y que el servidor conecta con el esquema correcto.
3. Validar `php tools/check_db_csv_contract.php` y los tests de GitHub Actions en la rama.
4. Desplegar mediante el procedimiento habitual con copia de seguridad y comprobar `/dnd/`, listados, fichas, miniaturas e imágenes.
5. Ante HTTP 503 tras desplegar, comprobar el archivo privado, permisos y acceso MariaDB; revertir el commit si fuera necesario. No se han realizado operaciones sobre la base de datos real.

**Limitación:** los 45 CSV privados del 8-11-2026 permiten verificar encabezados históricos, pero no sustituyen una prueba contra las tablas, índices, vistas, tipos y datos actuales de MariaDB.
