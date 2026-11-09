#!/usr/bin/env bash
# Comprobación local no destructiva: ejecuta las pruebas offline de Ad Infinitum.
# No importa CSV, no se conecta a MariaDB ni modifica la web o el esquema.
set -Eeuo pipefail
cd "$(dirname "$0")/.."

if ! command -v php >/dev/null 2>&1; then
  echo "ERROR: no se encuentra PHP CLI" >&2
  exit 1
fi
php_id="$(php -r 'echo PHP_VERSION_ID;')"
if ((php_id < 80200 || php_id >= 80600)); then
  echo "ERROR: PHP CLI fuera de la matriz comprobada (8.2 a 8.5)." >&2
  php -v | head -n 1
  exit 1
fi
echo "PHP CLI: $(php -r 'echo PHP_VERSION;')"

for extension in mysqli fileinfo; do
  if ! php -r 'exit(extension_loaded($argv[1]) ? 0 : 1);' "$extension"; then
    echo "ERROR: falta extensión PHP: $extension" >&2
    exit 1
  fi
done

if git rev-parse --show-toplevel >/dev/null 2>&1; then
  echo "HEAD: $(git rev-parse --short HEAD)"
  if ! git diff --quiet || ! git diff --cached --quiet; then
    echo "ERROR: existen modificaciones locales en archivos versionados." >&2
    git status --short >&2
    exit 1
  fi
  if [[ -n "$(git ls-files --others --exclude-standard)" ]]; then
    echo "AVISO: hay archivos no versionados (pueden ser imágenes subidas). Conservarlos y revisarlos."
  fi
fi

echo "Comprobando sintaxis de todos los PHP..."
find . -type f -name '*.php' -not -path './.git/*' -print0 |
  xargs -0 -r -n 1 php -l >/dev/null
echo "OK: sintaxis"

echo "Comprobando la estructura histórica (sin datos ni conexión)..."
php tools/check_db_csv_contract.php
php tools/check_db_csv_field_reads.php

echo "Ejecutando pruebas de ejecución con MySQL simulado..."
php tools/test_public_sections_runtime.php >/dev/null
php tools/test_legacy_catalog_runtime.php >/dev/null
php tools/test_catalog_routes_runtime.php >/dev/null
php tools/test_shared_list_runtime.php >/dev/null
php tools/test_miniatures_runtime.php >/dev/null
php tools/test_miniatures_admin.php >/dev/null
php tools/test_miniatures_migration.php >/dev/null

if command -v python3 >/dev/null 2>&1; then
  python3 tools/test_miniatures.py >/dev/null
else
  echo "ERROR: Python 3 requerido para la regresión de imágenes." >&2
  exit 1
fi

bash -n tools/smoke_public_php.sh
echo "OK: pruebas offline superadas."
echo "PENDIENTE: revisar versión PHP del servidor web, MariaDB real, URL, imágenes y logs antes de publicar."
