# Ad Infinitum Legacy (restauración estática)

Restauración mínima y de **solo lectura** de la identidad y una parte del archivo de Ad Infinitum. El PHP original de la raíz se conserva como fuente histórica **no desplegable**. Esta carpeta es una aplicación independiente que no ejecuta PHP, SQL, JavaScript, sesiones ni formularios.

## Fuente de los datos publicados

- Navegación: `content/main/main_menu.php` y `content/main/main_index.php`.
- Estilos: valores de `script/style.css` y `script/section-main.css` reinterpretados para móviles.
- Logotipo: `media/adinfinitumlogo.png` (la única imagen copiada, atribuida al proyecto original; verificar titularidad definitiva antes de difusión).
- Actualizaciones: `dnd_updates`, registros 1 a 10, de un volcado privado recibido el 13/10/2026. Solo fechas/títulos y breve cita de la entrada final.
- Lugares: `dnd_map_locations` IDs 1, 2, 6, 7, 8, 14, 15, 17, 18 y 19. Solo metadatos y el texto breve que existe en ID 1.

El volcado **no se incluye en Git**. La información publicada es un conjunto editorial fijo, sin importador ni dependencia de datos personales. Es un documento histórico; no corrige ni sustituye el canon de Ylat.

## Construcción y pruebas

Desde la raíz del repositorio (Python 3.10+):

```bash
python3 legacy-static/build.py
python3 -m unittest discover -s legacy-static/tests -v
python3 -m http.server 8080 -d legacy-static/dist
```

Abrir `http://localhost:8080/` para una revisión local. **Solo desplegar el directorio `legacy-static/dist/`**, nunca la raíz de este repositorio. El script de construcción contiene una lista blanca de ocho ficheros publicados (incluido el logotipo) y descarta todo lo demás. No sirve la aplicación PHP ni depende de la base de datos.

Ver `SECURITY.md` y `DEPLOY.md` antes de un despliegue. No se declara públicamente disponible hasta verificar una URL HTTPS real.
