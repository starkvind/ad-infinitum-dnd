<?php
/*
	*--------------------------------------------------------------------------*
	| Documento para definir las variables en Rasgos, Dotes y Objetos mágicos. |
	*--------------------------------------------------------------------------*
	MODELOS
		- Se definen de tal manera "CODIGO:BONIFICADOR:CONDICION" sin las comillas y separados por punto y coma (;).
		- El bonificador se encuentra en el centro. Si hay varios bonificadores, como varios idiomas, razas o lo que sea, se ha de separar por una coma (,).
		- Haremos un archivo .php para definir los bonificadores; de las tablas sólo obtendremos los códigos.
	*--------------------------------------------------------------------------*
	| ATAQUE Y DAÑO															   |
	*--------------------------------------------------------------------------* 
		[ATTACK]			> Bonificador a todas las tiradas de ataque.
		[DAMAGE]			> Bonificador a todas las tiradas de daño.
		[ATK_DMG]			> Bonificador a todas las tiradas de ataque y daño.
		-----------------------------------------------------------------------
		[MELEE_ATK]			> Bonificador a las tiradas de ataque cuerpo a cuerpo.
		[RANGED_ATK]		> Bonificador a las tiradas de ataque a distancia.
		[SPELL_ATK]			> Bonificador a las tiradas de ataque con hechizos (que no tengan la palabra clave "Arma").
		-----------------------------------------------------------------------
		[MELEE_DMG]			> Bonificador a las tiradas de daño cuerpo a cuerpo.
		[RANGED_DMG]		> Bonificador a las tiradas de daño a distancia.
		[SPELL_DMG]			> Bonificador a las tiradas de daño con hechizos (que no tengan la palabra clave "Arma").
		-----------------------------------------------------------------------
		[powersource_ATK]	> Bonificador a las tiradas de ataque si la palabra clave "powersource" está en el poder.
		[powersource_DMG] 	> Bonificador a las tiradas de daño si la palabra clave "powersource" está en el poder.
		[ATWILL_ATK]		> Bonificador a las tiradas de ataque si el poder es "A voluntad".
		[ATWILL_DMG]		> Bonificador a las tiradas de daño si el poder es "A voluntad".
	*--------------------------------------------------------------------------*
	| DEFENSAS																   |
	*--------------------------------------------------------------------------* 
		[AC]				> Bonificador a la CA.
		[FOR]				> Bonificador a Fortaleza
		[REF]				> Bonificador a Reflejos.
		[WIL]				> Bonificador a Voluntad.
		-----------------------------------------------------------------------
		[ALL_NO_AC]			> Bonificador a todas las defensas excepto CA.
		[ALL_DEF]			> Bonificador a todas las defensas.
		-----------------------------------------------------------------------
		[USE_stat_FOR_CA]	> Utiliza el stat definido (FUE,CON,SAB,CAR) para la CA en lugar de los predefinidos (DES o INT).
	*--------------------------------------------------------------------------*
	| SALUD																	   |
	*--------------------------------------------------------------------------* 
		[HP]				> Bonificador a los pg.
		[SURGES]			> Bonificador a los esfuerzos curativos.
		[SURGE_VALUE]		> Bonificador al valor de esfuerzo curativo; se suma cuando está ya definido.
	*--------------------------------------------------------------------------*
	| RESISTENCIAS 															   |
	*--------------------------------------------------------------------------* 
		[RST_DAMAGE_type]	> Resiste el daño definido. Si el valor se define en negativo (-5, etc) significa que el personaje será DÉBIL al daño definido.
		[RESIST_ALL]		> Resiste todo daño recibido.
		-----------------------------------------------------------------------
			=> ACID 		> Resistencia al daño por ácido.
			=> COLD			> Resistencia al daño por frío.
			=> FIRE			> Resistencia al daño por fuego.
			=> POISON		> Resistencia al daño por veneno.
			=> RADIANT		> Resistencia al daño radiante.
			=> NECROTIC		> Resistencia al daño necrótico.
			=> LIGHTNING	> Resistencia al daño relampagueante.
			=> THUNDER		> Resistencia al daño atronador.
			=> FORCE		> Resistencia al daño por fuerza.
			=> PSYCHIC		> Resistencia al daño psíquico.
	*--------------------------------------------------------------------------*
	| PODERES Y DOTES														   |
	*--------------------------------------------------------------------------*
		[ADD_POWER]			> Añade el poder con la ID definida en el bonificador. También se puede usar una URL.
		[ADD_FEAT]			> Añade la dote con la ID definida en el bonificador. También se puede usar una URL.
		[RACEFEATS]			> El personaje puede elegir dotes de las razas definidas en el bonificador.
	*--------------------------------------------------------------------------*
	| HABILIDADES															   |
	*--------------------------------------------------------------------------*
		[SKILL_TRAINED]		> Añade entrenamiento en la habilidad definida en el bonificador.
		[SKILLBONUS_skill]	> Bonificador a la habilidad definida. Se debe usar su nombre en castellano o su url.
	*--------------------------------------------------------------------------*
	| BONIFICADORES VARIOS													   |
	*--------------------------------------------------------------------------*
		[WEAPON_PROF]		> Añade competencia con las armas seleccionadas.
		[SPEED]				> Bonificador al valor de velocidad.
		[INITIATIVE]		> Bonificador al valor de iniciativa.
		[SAVING_THROWS]		> Bonificador a las tiradas de salvación.
		[LANGUAGE]			> Añade el idioma con ID definida en el bonificador. También se puede usar una URL.
		[MOD_ORIGIN]		> Añade el origen definido en el bonificador como texto. Se pude poner cualquier texto.
	*--------------------------------------------------------------------------*
	| BONIFICADORES															   |
	*--------------------------------------------------------------------------*
		base/number					< El bonificador es lo que es; debe ser un número.
		heroic|paragon|epic			< El bonificador aplica el primer valor en niveles 1-10, el segundo en niveles 11-20, y el último en niveles 21-30.
		base+halflevel				< El bonificador es el número base + la mitad del nivel del personaje.
		STAT_modifier				< El bonificador es el valor del STAT definido (FUE,CON,DES,INT,SAB,CAR).
	*--------------------------------------------------------------------------*
	| CONDICIONES															   |
	*--------------------------------------------------------------------------*
		at_level_X					< Añade el bonificador si el personaje es de nivel X o más.
		with_X_weapon				< Añade el bonificador si lleva en la mano principal el arma X. Utilizar la URL del objeto.
		with_one_handed_weapons		< Añade el bonificador si el personaje lleva en la mano principal un arma a una mano.
		with_two_handed_weapons		< Añade el bonificador si el personaje lleva en la mano principal un arma a dos manos.
		only_blade_in_hand			< El bonificador se aplica si llevas hojas pesadas o ligeras en la mano hábil y tienes la mano torpe libre.
		no_armor					< Añade el bonificador si no llevamos ningún tipo de armadura ni escudo.
		no_heavy_armor				< Añade el bonificador sin armadura pesada para Bárbaros y alguna que otra clase más.
		base_bonus_per_tier			< Se añade el mismo bonificador por cada rango de juego (Heroico, Parangón, Épico).
		if_bloodied					< El bonificador se aplica si está maltrecho el pj.
	
*/
?>