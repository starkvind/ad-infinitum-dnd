#!/usr/bin/env python3
"""Publica solo una lista explícita de HTML, CSS y un logotipo histórico.

Nunca lee SQL, PHP ni otros medios del repositorio. No requiere base de datos.
"""
from pathlib import Path
import shutil

HERE = Path(__file__).resolve().parent
REPO = HERE.parent
DEST = HERE / "dist"
PAGES = (
    "index.html", "actualizaciones.html", "ylat.html",
    "archivo.html", "pendiente.html", "404.html", "styles.css",
)
LOGO = REPO / "media" / "adinfinitumlogo.png"

def build():
    if not LOGO.is_file() or LOGO.is_symlink():
        raise SystemExit("Falta el logotipo original o su ruta es insegura.")
    if DEST.is_symlink():
        raise SystemExit("No se permite un destino simbólico.")
    if DEST.exists():
        shutil.rmtree(DEST)
    DEST.mkdir()
    for filename in PAGES:
        source = HERE / filename
        if not source.is_file() or source.is_symlink():
            raise SystemExit(f"Origen de publicación inválido: {filename}")
        shutil.copyfile(source, DEST / filename)
    assets = DEST / "assets"
    assets.mkdir()
    shutil.copyfile(LOGO, assets / "adinfinitumlogo.png")
    print("Artefacto seguro:", ", ".join(str(p.relative_to(DEST)) for p in sorted(DEST.rglob("*")) if p.is_file()))
if __name__ == "__main__":
    build()
