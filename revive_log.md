# Revive Log

## 2026-02-21 10:52:45
- Inicio Fase 1 de compatibilidad PHP moderna.
- Creado content/mysql_compat.php con wrappers mysql_* sobre mysqli_*.
- Actualizado content/rosetta.php para cargar capa de compatibilidad y usar utf8mb4.
- Reemplazados content/user/rosetta.php y script/rosetta.php por bridges a content/rosetta.php.

## 2026-02-21 10:56:03
- Corregidos usos eliminados en PHP 7+: eregi_replace a preg_replace.
- Corregidos indices de superglobal para PHP 8 ($_SERVER["REMOTE_ADDR"]).
- Endurecido combat.php para evitar fatales por arrays no inicializados.
- Ajustada carga de stone.php en content/rosetta.php con __DIR__.

## 2026-02-21 11:07:30
- Corregidos Undefined offset en parser de ficha.
- content/sections/player.php: parseo defensivo de atributos con explode(..., 2) y ?? "".
- content/sections/player_get_info.php: explode(..., 2) + isset(...) en todos los tags.

## 2026-02-21 11:36:06
- Pasada global de notices en power_card.php, content_classlink.php, article.php, contents_tabs.php, contents_list.php, adventure.php, content_origin.php.
- Se anadieron defaults de variables e includes robustos con __DIR__.

## 2026-02-21 11:37:11
- Ajuste en content/sections/adventure.php para evitar bloqueo por originCanon cuando falta metadata de origen.

## 2026-02-21 11:52:10
- Nueva pasada de correccion de notices reportados por QA manual.
- contents_list.php: defaults para fullList, shopCoin, hideAdventureColumn, page.
- timeline.php: defaults para eventType, dataSearchSQL, ostName, ostYtLink.
- location.php: defaults para eventAdventure, ostName, ostYtLink.
- contents_tabs.php: defaults para placeKingdom y enemyElite.
- enemy_card.php: defensas para level, session level, senses y jumpOnResistances.
- enemy_attacks.php: parseo defensivo de arrays de ataques.
- class.php: defaults para dontShowClassFeatures y traitsRows.
- combat.php: cabecera y meta charset cambiadas a UTF-8.

## 2026-02-21 12:04:22
- Corregido error SQL en /encounters/ (content/sections/encounter.php).
- La consulta ahora normaliza userLevelCheck:
  - si empieza por AND u OR, se convierte en WHERE 1=1 ...
  - si no empieza por WHERE, se antepone WHERE
- Includes de encounter.php normalizados con __DIR__.
- revive_log.md normalizado sin caracteres de control.

## 2026-02-21 12:14:24
- encounter_card.php: correccion de offsets y countables en parseo de criaturas y tesoro.
- Se aplico parseo defensivo con explode(..., 2), defaults y validaciones para cantidades o ids vacios.
- Se reemplazo count(encounterLoot) por count(arrayLoot).
- Se inicializaron magicName, thingName y objectType por iteracion de loot para evitar arrastres.

## 2026-02-21 12:15:20
- Corregido notice en main_top_menu.php:
  - default global para showBackButton (content/main/main_top_menu.php).

## 2026-02-21 12:16:50
- Corregidos notices en content/sections/feat_card.php (featSpecific, powerInPlayer, featLevelLearned).
- Se anadieron defaults defensivos para featId, featSlot y playerFeatLink.
- Includes de feat_card.php normalizados con __DIR__ en content/sections/feat.php y content/sections/player.php.

## 2026-02-21 12:30:42
- trait_card.php: defaults defensivos para traitId, powerInPlayer y traitSlot para evitar notices en vista normal y en ficha de jugador.
- trait.php: includes normalizados con __DIR__ (trait_card.php, contents_tabs.php, content_classlink.php, contents_list.php).
- class.php: saneado de nombres con str_replace("\0", "", ...) en className, buildName, traitName y traitName2 para mitigar truncados por bytes NUL en textos.
## 2026-02-21 12:34:08
- class.php: anadida funcion dyd_safe_label() para sanear nombres (control chars/NUL) y reconstruirlos desde url cuando name llega con 1 solo caracter.
- class.php: aplicado fallback de etiqueta segura en className, buildName, traitName y traitName2.
- Objetivo: evitar que en Clases se muestren iniciales sueltas (ej. c, c, l, p) cuando el campo name este degradado.
- trait_card.php: aplicado tambien dyd_safe_label() para mostrar nombre completo desde url si name llega abreviado.
## 2026-02-21 12:41:21
- class.php: anadido modo de depuracion activable con ?debug=class.
- El panel muestra:
  - datos crudos de clase (name/url/class_features)
  - SQL de rasgos y numero de filas
  - listado de builds y rasgos con name_raw, name_safe y metadatos hex/longitud
- Objetivo: diagnosticar por que algunos nombres se pintan como iniciales (c, c, l, p).
## 2026-02-21 12:47:00
- Inicializado repositorio Git en la carpeta del proyecto.
- Configurado safe.directory para resolver el bloqueo de ownership en la ruta de red.
- Creado README.md y realizado commit inicial: "first commit".
- Rama renombrada a main.
- Remoto origin configurado: https://github.com/starkvind/ad-infinitum-dnd.git
- Push completado: origin/main.
