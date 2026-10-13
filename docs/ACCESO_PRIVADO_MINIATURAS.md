# Acceso privado a Miniaturas

**No reactivar** el acceso de 2015 (`main_users`, `content/user/check_person.php`, `content/user/add_db.php`).
La nueva pantalla reutiliza el estilo visual del sitio, no sus usuarios ni sus contraseñas.

## URL

`http://192.168.1.80/dnd/miniatures/admin/` (acceso solo desde `192.168.1.0/24` y localhost).

## Instalación de la nueva cuenta (una vez)

En la Raspberry:

```bash
cd /mnt/ssd/html/dnd
git pull --ff-only origin main
sudo php tools/setup_miniatures_admin.php
```

El asistente solicita *Persona* y una *Llave* nueva (mínimo 14 caracteres), oculta su escritura y guarda solamente su hash de contraseña en `/mnt/ssd/dnd-miniatures-auth.php`, **fuera** del directorio web `/mnt/ssd/html`. El fichero se crea con permisos `0640` y grupo `www-data`. **No revelar ni subir esta información a GitHub.**

Para cambiar la contraseña sin borrar el acceso actual:

```bash
cd /mnt/ssd/html/dnd
sudo php tools/setup_miniatures_admin.php --reset
```

El restablecimiento guarda una copia privada del hash anterior, accesible solo por `root`, y activa un hash nuevo. No muestra ni publica contraseñas.

Si la cuenta existe pero el formulario rechaza el acceso, diagnosticar **sin revelar claves**:

```bash
cd /mnt/ssd/html/dnd
sudo -u www-data php tools/check_miniatures_access.php
sudo -u www-data php tools/check_miniatures_access.php --verify
```

El segundo comando pregunta la Persona y la Llave de manera interactiva, ocultando la Llave. Si ambas pruebas son correctas y el navegador sigue rechazando el inicio de sesión, pedir el **mensaje exacto** del formulario para distinguir sesión, CSRF, restricciones LAN y navegador. Abrir la URL `/dnd/miniatures/admin/` en ventana privada; no usar la antigua sección `/user/`.


## Estado inicial del alta

El formulario de alta de Miniaturas está **desactivado** hasta que `dnd_miniatures.id` tenga PRIMARY KEY AUTO_INCREMENT en la base real. La comprobación previa confirmó que faltan ambos; no se modifican con este commit.

**Se requiere aprobación expresa del autor y una copia de seguridad privada verificada antes del ALTER TABLE.** No confundir un rollback por Git con un rollback de datos.

Una vez preparada la tabla y los permisos de `www-data` para `media/figurine`, el formulario pedirá nombre, referencia comercial, precio en euros, colección, personaje, descripción y foto JPEG. Publicará ficha e imagen en `/dnd/miniatures/{id}/` usando SQL preparado y validaciones.

## Medidas

- Contraseña verificada por hash, no por comparación de texto SQL.
- Sesión independiente, 30 minutos de inactividad, cambio de ID al identificarse.
- CSRF obligatorio en todos los formularios POST; bloqueo temporal tras varios fallos.
- Subred local y loopback solamente; sin acceso a usuarios históricos.
- Máximo 5 MB para imágenes JPEG y dimensiones limitadas, nombre de archivo aleatorio.
- Consultas preparadas y protección de escritura condicionada al esquema.
- `.htaccess` bloquea acceso HTTP directo a PHP de gestión heredada.
- El inicio de sesión por HTTP está reservado a red local confiable: para acceso desde Internet se requeriría HTTPS y una revisión específica de seguridad.

## Pruebas

```bash
php tools/test_miniatures_admin.php
php -l content/sections/miniatures_admin.php
php tools/check_miniatures_preflight.php
```

No activar el alta ni modificar columnas sin el respaldo y autorización mencionados.
