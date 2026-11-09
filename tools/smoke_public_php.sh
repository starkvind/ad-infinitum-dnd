#!/usr/bin/env bash
# Safe public read-only smoke test for the historical /dnd/ site.
# Usage: bash tools/smoke_public_php.sh https://example.com/dnd/
set -euo pipefail

if [[ $# -ne 1 || ! "$1" =~ ^https?:// ]]; then
  echo "Uso: bash tools/smoke_public_php.sh https://servidor.example/dnd/" >&2
  exit 2
fi
base="${1%/}"
tmp="$(mktemp)"
trap 'rm -f "$tmp"' EXIT

routes=(
  "" "adventures/" "locations/" "classes/" "races/" "feats/"
  "powers/" "traits/" "backgrounds/" "rituals/"
  "players/" "npcs/" "parties/" "timeline/"
  "creatures/" "vehicles/" "items/" "magicitems/"
  "enchantments/" "encounters/" "ailments/" "miniatures/"
  "bibliography/" "articles/" "actions/" "bestiary/"
  "adventures/1/" "miniatures/1/"
)

passed=0
failed=0
for route in "${routes[@]}"; do
  url="$base/$route"
  status="$(curl --location --silent --show-error --connect-timeout 5 --max-time 25 \
    --output "$tmp" --write-out '%{http_code}' "$url")" || status="000"
  if [[ "$status" != "200" ]]; then
    printf 'FALLO HTTP %s: %s\n' "$status" "$url" >&2
    ((failed+=1))
    continue
  fi
  if ! grep -Eqi '<(html|!DOCTYPE html)' "$tmp"; then
    printf 'FALLO HTML vacío o inesperado: %s\n' "$url" >&2
    ((failed+=1))
    continue
  fi
  if grep -Eqi 'Fatal error:|Uncaught (Error|TypeError|mysqli_sql_exception)|Parse error:' "$tmp"; then
    printf 'FALLO PHP visible: %s\n' "$url" >&2
    ((failed+=1))
    continue
  fi
  printf 'OK: %s\n' "$url"
  ((passed+=1))
done
printf 'Comprobadas: %d; correctas: %d; fallidas: %d\n' "${#routes[@]}" "$passed" "$failed"
if ((failed>0)); then
  exit 1
fi
