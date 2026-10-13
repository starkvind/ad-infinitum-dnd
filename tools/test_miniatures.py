#!/usr/bin/env python3
"""Pruebas de regresión de miniaturas, sin acceder a SQL ni a la red."""
from pathlib import Path
import re

root = Path(__file__).resolve().parents[1]
src = (root / "content/sections/miniatures.php").read_text(encoding="utf-8")
checks = {
    "La ruta de catálogo no consulta un ID vacío": 'if ($idGetData !== "" && ctype_digit($idGetData)' in src,
    "La búsqueda convierte el ID a entero": '" WHERE id = ".(int)$idGetData.' in src,
    "La salida HTML de ficha se escapa": "htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE" in src,
    "La imagen del detalle tiene un atributo alt": 'alt=\'".$miniEscape($miniName)' in src,
    "La lista está ordenada por nombre": '" ORDER BY name"' in src,
}
for slug in ("bugbear", "spirit"):
    lowercase = root / "media/figurine" / f"{slug}.jpg"
    historical = root / "media/figurine" / f"{slug}.JPG"
    checks[f"Alias {slug}.jpg coincide con archivo patrimonial"] = (
        lowercase.is_file() and historical.is_file()
        and lowercase.read_bytes() == historical.read_bytes()
    )
for name, passed in checks.items():
    print(f"{'OK' if passed else 'FALLO'}: {name}")
if not all(checks.values()):
    raise SystemExit(1)
