# Ad Infinitum — D&D 4ª edición

Portal histórico de Ad Infinitum (2015), recuperado para funcionar en PHP moderno sin perder su aspecto original.

**Estado actual:** la sección [Miniaturas](content/sections/miniatures.php) funciona en `/dnd/miniatures/` después de la reparación de PHP 8. La siguiente prioridad es **dar de alta nuevas miniaturas, con imagen, sin editar código ni volver a desplegar**.

- [Plan vigente y MVP de Miniaturas](docs/RESTAURACION_MVP.md)
- [Notas históricas de compatibilidad](revive_log.md)

**Despliegue habitual en Raspberry Pi** (cuando un cambio esté comprobado en GitHub):

```bash
cd /mnt/ssd/html/dnd
git pull --ff-only origin main
```

No incluir en GitHub público volcados de base de datos, credenciales, claves ni información privada de usuarios. La compatibilidad de PHP no equivale a una auditoría de seguridad.
