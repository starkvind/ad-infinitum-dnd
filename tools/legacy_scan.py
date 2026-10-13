#!/usr/bin/env python3
"""Inventario estático de PHP heredado. Nunca imprime código, secretos ni datos.
No concluye ausencia de vulnerabilidades: identifica señales para auditoría posterior.
"""
from collections import Counter
from pathlib import Path
import re

ROOT = Path(__file__).resolve().parents[1]
php = sorted(ROOT.rglob("*.php"))
patterns = {
    "mysql_legacy": r"\bmysql_(?:query|connect|select_db|fetch_assoc|fetch_array|fetch_row|num_rows|close)\s*\(",
    "mysqli": r"\bmysqli_[a-z_]+\s*\(",
    "sql_write_keywords": r"\b(?:INSERT\s+INTO|UPDATE\s+|DELETE\s+FROM|REPLACE\s+INTO)\b",
    "post_inputs": r"\$_POST\s*\[",
    "get_inputs": r"\$_GET\s*\[",
    "session_start": r"\bsession_start\s*\(",
    "deprecated_removed_apis": r"\b(?:eregi|ereg|split|create_function|each|get_magic_quotes_gpc)\s*\(",
    "debug_functions": r"\b(?:var_dump|print_r|phpinfo)\s*\(",
    "filesystem_writes": r"\b(?:file_put_contents|fwrite|move_uploaded_file|unlink|rename)\s*\(",
    "direct_raw_user_echo": r"\becho\s+\$_(?:GET|POST|REQUEST)\s*\[",
}
totals = Counter()
by_file = Counter()
for file in php:
    data = file.read_text(encoding="utf-8", errors="replace")
    for category, pattern in patterns.items():
        hits = len(re.findall(pattern, data, flags=re.IGNORECASE))
        totals[category] += hits
        if hits:
            by_file[category] += 1

print(f"PHP INVENTARIADOS: {len(php)}")
for category in patterns:
    print(f"{category}: apariciones={totals[category]}; archivos={by_file[category]}")
print("Este inventario detecta indicios; ni los hallazgos ni el lint certifican seguridad.")
if len(php) < 130:
    raise SystemExit("Faltan archivos PHP en el inventario")
