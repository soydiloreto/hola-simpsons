<?php
/*
Plugin Name: Hola Simpsons
Plugin URI: https://pablodiloreto.com/hola-simpsons/
Description: The best quotes from 'The Simpsons' in your WordPress Admin area. Las mejores frases de 'Los Simspons' en tu administrador de WordPress.
Author: Pablo Ariel Di Loreto
Version: 1.3.1
Requires at least: 5.1.2
Requires PHP: 7.0
Tested up to: 6.9.4
Author URI: https://pablodiloreto.com/hola-simpsons/
Text Domain: hola-simpsons
*/

function hola_simpsons_get_quotes() {
	/** These are the quotes to Hola Simpsons */
	$quotes = "No hay nada mejor que la cerveza para darle a uno esa falsa sensación de bienestar (Homero)
	Si ambicionas poco, nadie te estorbará (Marge)
Marge, este matrimonio es una sociedad: cuando caes, yo te levanto, y cuando no puedes terminar un sandwich… yo me como ese sandwich (Homero)
¿Cuál es el motivo para ir? Vamos a terminar de nuevo aquí de todos modos (Homero)
Su vida fue tuvo éxitos desenfrenados hasta que se dio cuenta que era un Simpson (Lisa)
Si yo me muriera, reencarnarí­a en mariposa, nadie sospecharí­a de una mariposa (Bart)
Normalmente no rezo, pero si estás ahí­, por favor, sálvame Superman (Homero)
Por favor, no me coma señor extraterrestre, tengo una esposa y tres hijos…, cómaselos a ellos (Homero)
Oye, Otto, ¡tengo un examen hoy y no estoy listo! ¿Podrías estrellar el autobús o algo? (Bart)
¡Oh, no! ¡Elecciones! ¿Es uno de esos días en que cierran las tabernas, no es cierto? Barney Gómez
Lisa, los vampiros son seres inventados, como los duendes, los gremlins y los esquimales (Homero)
¡Bart, deja de molestar a Satanás! (Marge)
Puede tener todo el dinero del mundo, pero hay algo que nunca podrá comprar… Un dinosaurio (Homero)
Hoy no va a llegar el fin del mundo, tan solo 100 años más de calentamiento global y ¡adiós! (Lisa)
Trabajo mucho y quiero a mis hijos, ¿por qué voy a pasar la mitad del domingo oyendo que me voy a ir al infierno? (Homero)
Ahí va el último hilo persistente de mi heterosexualidad (Patty)
¡Televisión! ¡Maestra! ¡Madre! Amor secreto (Homero)
Bueno, es la 1 de la mañana. Mejor me voy a casa y comparto un poco con los chicos (Homero)
Pero mi mamá dice que soy cool (Milhouse)
Dios, Dios, Dios, Dios. Bailé con un gay (Homero)
Sin tele y sin cerveza Homero pierde la cabeza (Homero)
Cállate, cerebro. Ahora tengo amigos, ya no te necesito (Lisa)
Espero que me entiendas, estoy demasiado tensa como para que me guste (Marge)
Solo porque no me importa no significa que no lo entienda (Homero)
¿No es agradable que odiemos la misma cosa? (Skinner)
Si me necesitas, voy a estar en el refigerador (Homero)
¿Donuts? Te dije que no me gustaba la comida étnica (Burns)
¿Cuándo voy a aprender? La solución a todos los problemas de la vida no está en el fondo de una botella. ¡Está en la TV! (Homero)
¡Multiplícate por cero! (Bart)
¡Ay, caramba! (Bart)
Holilla vecinirijillo (Ned Flanders)
Los niños son nuestro futuro… a menos que los detengamos a tiempo (Homero)
¡En esta casa obedecemos las leyes de la termodinámica! (Homero)
El primer paso para fracasar es intentarlo (Homero)
Si algo es difícil de hacer, entonces no vale la pena hacerlo (Homero)
Hijos, lo intentaron y fallaron miserablemente. La lección es: jamás lo intenten (Homero)
Si no te gusta tu trabajo no haces huelga, vas cada día y lo haces muy mal. Ese es el estilo americano (Homero)
El alcohol: la causa y solución a todos los problemas de la vida (Homero)
Todo me sale Milhouse (Milhouse)
Hola-holita, vecinito (Flanders)
Pero Dios es mi personaje favorito de la Biblia (Homero)";

	// Here we split it into lines.
	$quotes = explode( "\n", $quotes );

	// And then randomly choose a line.
	return wptexturize( $quotes[ mt_rand( 0, count( $quotes ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later.
function hola_simpsons() {
	$chosen = hola_simpsons_get_quotes();
	$lang   = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = ' lang="en"';
	}

	printf(
		'<p id="simpsons"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
		__( 'Quote from The Simpsons:', 'hola-simpsons' ),
		$lang,
		$chosen
	);
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'hola_simpsons' );

// We need some CSS to position the paragraph.
function hola_simpsons_css() {
	echo "
	<style type='text/css'>
	#simpsons {
		float: right;
		padding: 5px 10px;
		margin: 0;
		font-size: 12px;
		line-height: 1.6666;
	}
	.rtl #simpsons {
		float: left;
	}
	.block-editor-page #simpsons {
		display: none;
	}
	@media screen and (max-width: 782px) {
		#simpsons,
		.rtl #simpsons {
			float: none;
			padding-left: 0;
			padding-right: 0;
		}
	}
	</style>
	";
}

add_action( 'admin_head', 'hola_simpsons_css' );
