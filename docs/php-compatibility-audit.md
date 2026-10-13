# Ad Infinitum: auditoría técnica de primera etapa (13/10/2026)

**Estado: rama de diagnóstico y correcciones preliminares. NO AUTORIZADO PARA DESPLIEGUE PHP.**

## Qué se ha comprobado

- Repositorio: 803 archivos, 131 PHP; base original preservada en `main`.
- `revive_log.md`: reparaciones de compatibilidad de febrero de 2026, sin auditoría integral.
- La base privada aportada tiene 47 tablas y **no forma parte de este repositorio**. El código mantiene dependencias de datos, sesiones y bibliotecas `mysql_*` a través de `content/mysql_compat.php`.
- Se encontraron contraseñas/credenciales integradas en la configuración histórica (`content/rosetta.php`). **No se reprodujeron sus valores**. El fichero se deja intacto en esta fase para no romper la configuración existente, pero debe tratarse como comprometido, incluyendo el historial Git.
- `content/user/check_person.php` compara credenciales dentro de SQL concatenado y `content/user/update_userdata.php` realiza modificaciones SQL con entrada externa. Ambas vías requieren retirar funciones o reescribirlas y auditar permisos, antes de exponer PHP.
- `index.php` tenía `display_errors=1` y `content/sections/class.php` activaba información de depuración por `?debug=class`.
- El `.htaccess` original dejaba pasar ficheros PHP existentes directamente, sin pasar por el router.

## Cambios mínimos en esta rama

1. Se desactiva la salida pública de errores, se establecen cabeceras básicas de protección y se escapa el título de página.
2. Se deshabilita la consulta pública a depuración SQL de clases.
3. Se bloquea acceso HTTP directo a PHP internos y a `combat.php` desde Apache, sin alterar `RewriteBase /dnd/` ni las rutas históricas. **No sustituye a la desactivación de endpoints y a permisos de BBDD de solo lectura.**
4. Se incorpora comprobación en CI de sintaxis de **todos** los ficheros PHP sobre 8.2, 8.3 y 8.4 y pequeñas pruebas de regresión de barreras. La comprobación solo analiza ficheros: no usa red, base de datos ni ejecuta la aplicación.

## Bloqueos reales

- **No exponer PHP/SQL heredado:** SQL dinámico, autenticación en claro, HTML de BBDD, escritura y administración sin auditoría completa, secretos posiblemente en el historial.
- **Sin conectividad acreditada:** no contamos con permisos de servidor SSH, DNS, vhost o despliegue. No se ha observado la web arrancar.
- **Sin prueba funcional de BBDD:** el volcado privado no debe subirse a Actions; primero importar **en entorno aislado**, con usuario BBDD de solo lectura, nunca sobre una instancia pública.
- GitHub Pages **no ejecuta PHP ni SQL**. Para el archivo público gratuito, la ruta segura es la restauración estática ya preparada en el PR #1.
- Los derechos editoriales de material D&D, imágenes y material de jugadores requieren aprobación antes de ampliar la publicación.

## Próximo hito técnico

Ejecutar la aplicación en una red local de pruebas, tras externalizar y rotar credenciales y desconectar rutas peligrosas, corregir advertencias/fallos reales y capturar respuestas de portada y navegación sin exponer datos de usuarios. A partir de ahí validar por qué rutas seguir, o convertir contenido autorizado de SQL a HTML estático.
