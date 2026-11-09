# Ad Infinitum — D&D 4ª edición

Portal histórico de Ad Infinitum (2015), recuperado para funcionar en PHP moderno sin perder su aspecto original.

**Estado actual:** la sección [Miniaturas](content/sections/miniatures.php) funciona en `/dnd/miniatures/` después de la reparación de PHP 8. La siguiente prioridad es **dar de alta nuevas miniaturas, con imagen, sin editar código ni volver a desplegar**.

- [Plan vigente y MVP de Miniaturas](docs/RESTAURACION_MVP.md)
- [Acceso privado para subir miniaturas](docs/ACCESO_PRIVADO_MINIATURAS.md)
- [Notas históricas de compatibilidad](revive_log.md)

**Despliegue habitual en Raspberry Pi** (cuando un cambio esté comprobado en GitHub):

```bash
cd /mnt/ssd/html/dnd
git pull --ff-only origin main
```

No incluir en GitHub público volcados de base de datos, credenciales, claves ni información privada de usuarios. La compatibilidad de PHP no equivale a una auditoría de seguridad.


## Auditoría de compatibilidad PHP 8 (noviembre de 2026)

La actualización para PHP **8.2–8.5** se prepara en el [PR #5](https://github.com/starkvind/ad-infinitum-dnd/pull/5), inicialmente en borrador. La matriz automatizada verifica sintaxis, rutas, tarjetas, listados y la correspondencia de columnas de 45 CSV históricos, **sin conectar a MariaDB**.

- [Auditoría de código y CSV](docs/AUDITORIA_PHP_CSV_20261109.md)
- [Preparación, pruebas y rollback en Raspberry](docs/DESPLIEGUE_RASPBERRY_PHP8.md)
- Preflight local **sin escrituras SQL**: `bash tools/preflight_raspberry_php8.sh`
- Smoke HTTP posterior al ensayo: `bash tools/smoke_public_php.sh https://DOMINIO/dnd/`

No hay migración de usuarios, reactivación del login de 2015 ni modificación de `content/rosetta.php` en este PR. No fusionar ni desplegar solo por tener CI verde: hace falta ensayo con Apache/PHP y MariaDB reales.
