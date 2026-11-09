# Despliegue controlado de Ad Infinitum en Raspberry Pi — PHP 8

**Estado:** procedimiento preparado, **NO ejecutado** sobre la Raspberry. Aplicable a la rama de auditoría del PR #5 tras su fusión aprobada en `main`.

## Alcance y prohibiciones

- Conservar el portal histórico, la ruta pública **`/dnd/`**, archivos e imágenes existentes, y la base MariaDB actual.
- **No** importar CSV históricos, migrar tablas, modificar el esquema ni reactivar formularios de autenticación de 2015.
- No cambiar la conexión de base de datos `content/rosetta.php` en este PR; el sistema de autenticación nuevo se implementará y probará **por separado**. Las claves antiguas no forman parte de las pruebas.
- No copiar volcados SQL, cuentas, credenciales o backups al directorio público ni a GitHub.
- Una suite PHP CLI que pasa no demuestra todavía que Apache/PHP-FPM, MariaDB o el dominio público funcionen.

## 1. Requisitos previos

1. Comprobar que **todos** los jobs del PR #5 están verdes **en el SHA final**, tanto los de PHP 8.2, 8.3, 8.4 y 8.5 como los de Miniaturas.
2. Confirmar versión de **PHP CLI y PHP del servidor web** (pueden ser distintas). La matriz validada comprende PHP **8.2 a 8.5**. Comprobar módulos `mysqli` y `fileinfo`.
3. Confirmar una forma segura de conectar la aplicación a la MariaDB **real** y el estado de índices/permisos del esquema; no usar como fuente de verdad los 45 CSV del 8-11-2026.
4. Revisar que el repositorio de producción `/mnt/ssd/html/dnd` no tenga cambios locales: `git status --short`.
5. Crear y **verificar una copia recuperable** de los archivos no versionados, imágenes (incluido `media/figurine/`), esquema/datos de MariaDB y estado Git. Utilizar el sistema privado de backups ya establecido. Nunca asumir que `git revert` restaura fotos, filas o configuración privada.
6. Preparar **cómo consultar logs** de Apache/PHP y un camino de rollback antes de publicar.

## 2. Ensayo aislado sin tocar producción

Clonar o preparar un worktree del commit del PR en una carpeta **fuera** de `/mnt/ssd/html/dnd`. No cambiar `.htaccess`, `RewriteBase /dnd/` ni conectar ese árbol a la web de producción.

Desde la copia de ensayo:

```bash
bash tools/preflight_raspberry_php8.sh
```

El preflight verifica versión y módulos de PHP CLI, sintaxis PHP, contratos de columnas, regresiones de listados y Miniaturas. No hace `ALTER`, `INSERT`, `UPDATE`, `DELETE` ni conexiones reales a MariaDB. Requiere un árbol Git limpio y Python 3.

Las comprobaciones HTTP requieren **un vhost de ensayo que realmente soporte las rutas `/dnd/` y tenga una base de prueba accesible**. No basta `php -S` ni sirven los mocks SQL de CI como sustitutos.

## 3. Publicación, solo después del ensayo

Con PR aprobado, CI verde, respaldo verificado y autorización de despliegue:

```bash
cd /mnt/ssd/html/dnd
git status --short
git rev-parse HEAD             # Guardar el SHA anterior
git fetch origin
git pull --ff-only origin main
bash tools/preflight_raspberry_php8.sh
```

El despliegue habitual en `/mnt/ssd/html/dnd` se mantiene; **no** aplicar una rama de auditoría directamente sobre el portal de producción. Los cambios de PHP serán efectivos al cargarse de nuevo la página; según el caché OPcache y la configuración PHP-FPM/Apache puede ser necesario invalidar caché mediante el procedimiento de operaciones del servidor.

Después, desde la Raspberry y usando la URL correcta del vhost:

```bash
bash tools/smoke_public_php.sh https://DOMINIO-DE-ENSAYO-O-PRODUCCION/dnd/
```

El smoke verifica **28 rutas GET públicas**: listados y dos IDs conocidos. Valida HTTP 200, HTML y ausencia de trazas fatales visibles. **No escribe en la base**. Tener en cuenta que un HTTP 200 no valida por sí solo el contenido ni descarta avisos ocultos en logs.

Verificar manualmente fichas y listados de Aventuras, Personajes, Razas, Clases, Poderes, Dotes, Criaturas, Cronología, Lugares y Miniaturas, incluyendo al menos una imagen y un ID inexistente. Revisar logs de Apache/PHP y tiempos de respuesta antes de considerar finalizado el despliegue.

## 4. Reversión

- **Antes de desplegar**: registrar el SHA exacto actual y conservar backups privados verificables.
- **Si falla la validación**: detener la publicación y **revertir el cambio desde GitHub en `main`**, usando el método correspondiente a cómo se fusionó el PR (reversión del commit squash o del merge, con padre principal correcto). Volver a ejecutar `git pull --ff-only origin main` y el smoke después de la reversión.
- **En una incidencia inmediata que requiera restauración local**: seguir el procedimiento operativo aprobado de rollback de código utilizando el SHA previo, bajo supervisión; no aplicar `git reset --hard` a ciegas ni asumir que revierte la BD o las fotos.
- Si el problema implica MariaDB o archivos no versionados, restaurarlos **solo con el procedimiento específico de backup**, no con Git.

## 5. Condiciones para marcar la migración como validada

CI completo en el SHA de fusión, pruebas CLI en el servidor, comprobación HTTP y funcional real, imágenes, logs sin errores bloqueantes, backup/rollback confirmado y ausencia de cambios inesperados en MariaDB. Hasta entonces, **estado: listo para ensayo, NO certificado en producción**.
