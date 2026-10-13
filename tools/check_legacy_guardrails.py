#!/usr/bin/env python3
"""Pruebas estáticas. NO sustituyen una auditoría de seguridad ni autorizan despliegue."""
from pathlib import Path
import re

ROOT = Path(__file__).resolve().parents[1]
index = (ROOT / "index.php").read_text(encoding="utf-8")
classes = (ROOT / "content/sections/class.php").read_text(encoding="utf-8")
apache = (ROOT / ".htaccess").read_text(encoding="utf-8")

checks = {
    "La salida de errores está desactivada": "ini_set('display_errors', '0')" in index,
    "El panel de debug de clases está desactivado": bool(re.search(r"\$debugClassMode\s*=\s*false\s*;", classes)),
    "El título se escapa para HTML": "htmlspecialchars((string)($finalTitle ??" in index,
    "Cabecera anti-MIME-sniffing": "X-Content-Type-Options: nosniff" in index,
    "Apache no lista directorios": "-Indexes" in apache,
    "Apache bloquea accesos PHP directos": r"\.php(?:/.*)?$ - [F,NC,L]" in apache,
    "La ruta histórica /dnd/ se conserva": "RewriteBase /dnd/" in apache,
    "No hay scripts de SQL en la rama": not any(p.suffix.lower() == ".sql" for p in ROOT.rglob("*") if p.is_file()),
}
for name, ok in checks.items():
    print(f"{'OK' if ok else 'FALLO'}: {name}")
if not all(checks.values()):
    raise SystemExit(1)
