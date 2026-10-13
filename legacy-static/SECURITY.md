# Evaluación de seguridad — 13/10/2026

## Alcance y amenazas

El proyecto legado incluye 131 archivos PHP y código de acceso a MariaDB/MySQL. `revive_log.md` describe ajustes de compatibilidad de febrero de 2026, no una auditoría de seguridad. Se identificaron riesgos en credenciales incrustadas (`content/rosetta.php`), autenticación histórica insegura, SQL concatenado, HTML procedente de BBDD, errores de depuración y rutas de escritura/administración. **La aplicación PHP no es segura para publicarla directamente**.

El volcado privado recuperado el 13/10/2026 contiene 47 tablas, incluyendo `main_users`, `main_visitors`, `main_searches`, `main_topaz`, `dnd_player_characters`, sesiones de combate y movimientos/equipo de personajes. Se confirmaron 15 registros de usuarios con valores de contraseña presentes y sin formato reconocible de hash moderno; además puede contener IP, correos o información personal y confidencial. No se inspeccionaron ni publicaron esos valores. No incorporar el volcado ni derivados completos a GitHub, a artefactos de compilación o a un servidor público.

## Criterio prudente sobre visibilidad de aventuras

La tabla `dnd_adventures` conserva 62 registros: 61 con `visible=0` y uno con `visible=5`. El significado exacto de ese campo **no ha quedado acreditado**; `0` no debe interpretarse automáticamente como oculto ni como público. Por privacidad y derechos se han excluido todas las aventuras de esta primera edición.

## Barreras implementadas en esta restauración

- `build.py` publica exclusivamente páginas HTML, una hoja CSS y el logotipo histórico: no copia PHP, SQL, dependencias JS, backups, usuarios ni imágenes de procedencia dudosa.
- No hay backend, base de datos, login, registro, editor, gestión, combate, formularios ni funciones de escritura.
- Se evita renderizar HTML procedente del SQL; las páginas solo incluyen textos aprobados y escapados.
- CSP restrictiva en meta y CSP/otras cabeceras en el ejemplo Nginx. Ningún recurso remoto es necesario para la interfaz.
- Test de lista blanca de artefactos, enlaces locales, desactivación de superficies activas, privacidad básica, móvil y 404.
- Datos históricos rotulados como archivo, sin convertirlos en canon de Ylat.

## Intervenciones de seguridad fuera del repositorio

1. Revocar/rotar inmediatamente credenciales históricas de BD en el servicio de origen, así como posibles contraseñas reutilizadas. **No introducir sus valores en issues, comentarios, PR ni logs**.
2. Auditar el historial Git: eliminar un secreto del archivo actual no lo elimina de los commits antiguos. Tratar las credenciales históricas como comprometidas. Planificar depuración de historial solo con backup y coordinación, sin reescribirlo en este PR patrimonial.
3. Auditar usuarios y eliminar/anonimizar copias operativas no necesarias; proteger el SQL original en almacenamiento privado cifrado con acceso restringido y calendario de retención.
4. Verificar titularidad del logotipo antes de activar difusión pública. El pie original declara CC BY-NC-SA 3.0 para Ad Infinitum por Maurick Starkvind, pero no concede automáticamente derechos de terceros ni de toda imagen del repositorio.
5. Confirmar que la publicación se hace en un vhost/contenedor propio, HTTPS, usuario sin privilegios y despliegue solo de `dist`; no tocar WordPress ni Heaven's Gate.
6. Verificar infraestructura, DNS y URL pública de extremo a extremo antes de declarar finalizado el despliegue.

## Riesgos pendientes

- Secretos anteriores aún pueden existir en el código o historial Git público (fuera del artefacto).
- Los tests actuales detectan patrones conocidos, no sustituyen un escaneo completo de secretos ni una revisión manual del artefacto.
- Faltan aprobación jurídica/editorial para material reglamentario D&D 4e, otros gráficos y contenido de campañas no visible.
- Las cabeceras HTTP reales, permisos, aislamiento del servidor, certificado, rollback y respuesta pública no están verificados en esta rama.
