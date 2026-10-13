# Despliegue aislado y rollback

**Estado inicial:** instalación pública pendiente. No hay credenciales SSH, hostname, DNS ni configuración de alojamiento acreditadas en este trabajo. Este documento no autoriza tocar WordPress o `/mnt/ssd/html/hg`.

## Compilar en una estación aislada / CI

```bash
git clone https://github.com/starkvind/ad-infinitum-dnd.git
cd ad-infinitum-dnd
git checkout main                  # tras aprobar y fusionar el PR
python3 legacy-static/build.py
python3 -m unittest discover -s legacy-static/tests -v
find legacy-static/dist -type f -print
```

**Advertencia:** el repositorio completo puede conservar secretos históricos. Clonarlo solo en un entorno controlado. Para el servidor final, **enviar exclusivamente el contenido de `legacy-static/dist/`**, nunca el checkout ni el SQL. No cargar ningún dump en la web.

## Método A: GitHub Pages

Se incluye `.github/workflows/ad-infinitum-legacy-pages.yml` como despliegue exclusivamente manual (`workflow_dispatch`) desde `main`. Activar GitHub Pages como **GitHub Actions** en el repositorio, revisar los permisos y aprobar el PR. Después, ejecutar manualmente el workflow. Validar la URL de Pages entregada por GitHub y sus encabezados/HTTPS; no asignar un dominio inventado. No se considera desplegado por el mero hecho de ejecutar un workflow.

## Método B: Nginx + SSH (servidor propio)

Requiere que un administrador establezca **HOST**, **DOMAIN**, **DEPLOY_USER** y los permisos sobre el vhost; las siguientes órdenes son el procedimiento preciso una vez definidos esos valores. Ejecutarlas **desde la estación de compilación** (no desde el directorio web de WordPress).

```bash
export HOST="HOST_REAL"
export DOMAIN="DOMINIO_REAL"
export DEPLOY_USER="USUARIO_SSH_REAL"
export RELEASE="$(git rev-parse --short HEAD)-legacy"
ssh "$DEPLOY_USER@$HOST" "mkdir -p /srv/ad-infinitum/releases/$RELEASE"
rsync -a --chmod=D755,F644 legacy-static/dist/ "$DEPLOY_USER@$HOST:/srv/ad-infinitum/releases/$RELEASE/"
ssh "$DEPLOY_USER@$HOST" "ln -sfn releases/$RELEASE /srv/ad-infinitum/current.next && mv -Tf /srv/ad-infinitum/current.next /srv/ad-infinitum/current"
```

El administrador crea previamente la raíz `/srv/ad-infinitum` propiedad del usuario de despliegue, instala un **vhost independiente** basado en `nginx.conf.example` (copiarlo fuera del docroot), emite certificado TLS para DOMAIN mediante su ACME habitual y recarga Nginx tras `nginx -t`. El host real, DNS A/AAAA y SNI deberán verificarse previamente. No se configura PHP-FPM ni proxy hacia el PHP antiguo.

**Comprobación externa obligatoria:**

```bash
curl -I --fail --proto '=https' "https://$DOMAIN/"
curl -I --proto '=https' "https://$DOMAIN/ruta-inexistente"
curl -I --proto '=https' "https://$DOMAIN/content/rosetta.php"
curl -I --proto '=https' "https://$DOMAIN/.git/config"
```

Aceptar solo 200 para la portada, 404 para la ruta inventada y 403/404 para rutas internas; inspeccionar visualmente en móvil y escritorio y comprobar certificado válido. Si un host comparte hardware, no cambiar otros vhosts ni `/mnt/ssd/html/hg`.

**Rollback:** comprobar cuál es el release anterior y atomizar el enlace simbólico (no borrar el release vigente antes de verificar).

```bash
ssh "$DEPLOY_USER@$HOST" "ls -la /srv/ad-infinitum/releases"
# Después de elegir un RELEASE_ANTERIOR real:
ssh "$DEPLOY_USER@$HOST" "ln -sfn releases/RELEASE_ANTERIOR /srv/ad-infinitum/current.next && mv -Tf /srv/ad-infinitum/current.next /srv/ad-infinitum/current"
```

No ejecutar estos comandos con valores de ejemplo. Documentar fecha, responsable y revisión del cambio en el entorno privado de operaciones.
