<?php
/**
 * Plugin Name: Hola Simpsons
 * Plugin URI: https://pablodiloreto.com/hola-simpsons/
 * Description: The best quotes from 'The Simpsons' in your WordPress Admin area. Las mejores frases de 'Los Simspons' en tu administrador de WordPress.
 * Author: Pablo Ariel Di Loreto
 * Version: 1.4.1
 * Requires at least: 5.1.2
 * Requires PHP: 7.0
 * Tested up to: 6.9
 * Author URI: https://pablodiloreto.com/hola-simpsons/
 * Text Domain: hola-simpsons
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package HolaSimpsons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Curated quote sets keyed by WordPress locale.
 *
 * Each value is a newline-separated block of quotes; the renderer
 * splits on "\n" and picks one at random. Locales currently covered:
 * Latin American Spanish (default and fallback), original English,
 * European Spanish, Brazilian Portuguese, and Italian.
 *
 * @return array<string, string> Locale-key => quote-block map.
 */
function hola_simpsons_quotes_data() {
	return array(
		// Español neutro / LATAM (default).
		'es'    => 'No hay nada mejor que la cerveza para darle a uno esa falsa sensación de bienestar (Homero)
Si ambicionas poco, nadie te estorbará (Marge)
Marge, este matrimonio es una sociedad: cuando caes, yo te levanto, y cuando no puedes terminar un sandwich… yo me como ese sandwich (Homero)
¿Cuál es el motivo para ir? Vamos a terminar de nuevo aquí de todos modos (Homero)
Su vida fue tuvo éxitos desenfrenados hasta que se dio cuenta que era un Simpson (Lisa)
Si yo me muriera, reencarnaría en mariposa, nadie sospecharía de una mariposa (Bart)
Normalmente no rezo, pero si estás ahí, por favor, sálvame Superman (Homero)
Por favor, no me coma señor extraterrestre, tengo una esposa y tres hijos…, cómaselos a ellos (Homero)
Oye, Otto, ¡tengo un examen hoy y no estoy listo! ¿Podrías estrellar el autobús o algo? (Bart)
¡Oh, no! ¡Elecciones! ¿Es uno de esos días en que cierran las tabernas, no es cierto? (Barney Gómez)
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
Si me necesitas, voy a estar en el refrigerador (Homero)
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
Pero Dios es mi personaje favorito de la Biblia (Homero)',

		// Original English. High-confidence iconic quotes from the show.
		'en_US' => "D'oh! (Homer)
Eat my shorts! (Bart)
Ay, caramba! (Bart)
Don't have a cow, man! (Bart)
Mmm, donuts. (Homer)
Mmm, beer. (Homer)
Why you little…! (Homer)
Excellent. (Mr. Burns)
Release the hounds. (Mr. Burns)
Okily-dokily! (Ned Flanders)
Hi-diddly-ho, neighborino! (Ned Flanders)
Cowabunga! (Bart)
Woo-hoo! (Homer)
I, for one, welcome our new insect overlords. (Kent Brockman)
Worst. Episode. Ever. (Comic Book Guy)
Stupid sexy Flanders! (Homer)
I am so smart! S-M-R-T! (Homer)
Trying is the first step toward failure. (Homer)
Kids are the best, Apu. You can teach them to hate the things you hate. (Homer)
To alcohol! The cause of, and solution to, all of life's problems. (Homer)
In this house we obey the laws of thermodynamics! (Homer)
You don't make friends with salad. (Homer)
Ha-ha! (Nelson)
Me fail English? That's unpossible! (Ralph)
My cat's breath smells like cat food. (Ralph)",

		// Spain dub (es_ES). En España es 'Homer', no 'Homero', y muchas frases tienen su propia versión.
		'es_ES' => '¡Mosquis! (Homer)
¡Multiplícate por cero! (Bart)
¡Cómete mis pantalones! (Bart)
¡Ay, caramba! (Bart)
Hola, holita, vecinino. (Ned Flanders)
Excelente. (Sr. Burns)
Mmm… donuts. (Homer)
Mmm… cerveza. (Homer)
¡Serás…! (Homer)
A trabajar es a lo único que voy a la fábrica. (Homer)
Los niños son lo mejor, Apu. Puedes enseñarles a odiar las cosas que tú odias. (Homer)
El alcohol: la causa de, y solución a, todos los problemas de la vida. (Homer)
Intentar es el primer paso para el fracaso. (Homer)
En esta casa obedecemos las leyes de la termodinámica. (Homer)
Suelta a los perros. (Sr. Burns)
¡Ja, ja! (Nelson)',

		// Brazilian Portuguese dub (pt_BR). 'Os Simpsons' has a strong dub tradition in Brazil.
		'pt_BR' => "D'oh! (Homer)
Coma minhas calcinhas! (Bart)
Ai, caramba! (Bart)
Não tenha uma vaca, cara! (Bart)
Mmm… rosquinhas. (Homer)
Mmm… cerveja. (Homer)
Seu pequeno…! (Homer)
Excelente. (Sr. Burns)
Soltem os cães. (Sr. Burns)
Olá, vizinhozinho! (Ned Flanders)
Cabungaaa! (Bart)
Oba! (Homer)
Tentar é o primeiro passo rumo ao fracasso. (Homer)
Ao álcool! A causa e a solução de todos os problemas da vida. (Homer)
Nesta casa obedecemos às leis da termodinâmica! (Homer)
Ha-ha! (Nelson)",

		// Italian dub (it_IT). 'I Simpson' has a beloved Italian dub.
		'it_IT' => "D'oh! (Homer)
Ciucciati il calzino! (Bart)
Ay, caramba! (Bart)
Non farti venire un colpo, amico! (Bart)
Mmm… ciambelle. (Homer)
Mmm… birra. (Homer)
Brutto…! (Homer)
Eccellente. (Sig. Burns)
Liberate i mastini. (Sig. Burns)
Salve, vicinissimo! (Ned Flanders)
All'alcool! La causa di, e la soluzione a, tutti i problemi della vita. (Homer)
Provarci è il primo passo verso il fallimento. (Homer)
In questa casa obbediamo alle leggi della termodinamica! (Homer)
Ah-ah! (Nelson)",
	);
}

/**
 * Pick the closest matching quote-set key for a given WP user locale.
 *
 * Tries an exact match first (e.g. `es_ES` => `es_ES`), then collapses
 * to a two-letter language match (`es_AR` => `es`), then scans for any
 * key whose two-letter prefix matches (`pt_PT` => `pt_BR`). Falls back
 * to `es` (LATAM Spanish) if nothing matches.
 *
 * @param string $user_locale WordPress user locale, e.g. `en_GB`.
 * @return string A key present in hola_simpsons_quotes_data().
 */
function hola_simpsons_pick_locale( $user_locale ) {
	$data = hola_simpsons_quotes_data();

	if ( isset( $data[ $user_locale ] ) ) {
		return $user_locale;
	}

	$lang = substr( $user_locale, 0, 2 );

	if ( isset( $data[ $lang ] ) ) {
		return $lang;
	}

	foreach ( array_keys( $data ) as $key ) {
		if ( substr( $key, 0, 2 ) === $lang ) {
			return $key;
		}
	}

	return 'es';
}

/**
 * Pick one random quote from the set matching the current user's locale.
 *
 * Returns the texturised quote text alongside the locale key it was
 * pulled from, so the renderer can emit a proper `lang` attribute when
 * the quote language differs from the UI language.
 *
 * @return array{text: string, lang: string} Quote text + locale key.
 */
function hola_simpsons_get_quotes() {
	$locale       = get_user_locale();
	$picked       = hola_simpsons_pick_locale( $locale );
	$data         = hola_simpsons_quotes_data();
	$quotes_block = $data[ $picked ];

	$quotes = explode( "\n", $quotes_block );

	$chosen = $quotes[ wp_rand( 0, count( $quotes ) - 1 ) ];

	return array(
		'text' => wptexturize( $chosen ),
		'lang' => $picked,
	);
}

/**
 * Render the random quote inside an `admin_notices`-hooked paragraph.
 *
 * Output is fully escaped: the screen-reader label uses esc_html__,
 * the optional lang attribute uses esc_attr, and the quote body
 * (sourced from the in-file constant array, never user input) goes
 * through esc_html after wptexturize so any future contribution to
 * the quote sets cannot smuggle markup into the admin chrome.
 *
 * @return void
 */
function hola_simpsons() {
	$result       = hola_simpsons_get_quotes();
	$quote_text   = $result['text'];
	$quote_locale = $result['lang'];
	$quote_lang   = substr( $quote_locale, 0, 2 );
	$user_lang    = substr( get_user_locale(), 0, 2 );

	if ( $user_lang !== $quote_lang ) {
		printf(
			'<p id="simpsons"><span class="screen-reader-text">%s </span><span dir="ltr" lang="%s">%s</span></p>',
			esc_html__( 'Quote from The Simpsons:', 'hola-simpsons' ),
			esc_attr( $quote_lang ),
			esc_html( $quote_text )
		);
	} else {
		printf(
			'<p id="simpsons"><span class="screen-reader-text">%s </span><span dir="ltr">%s</span></p>',
			esc_html__( 'Quote from The Simpsons:', 'hola-simpsons' ),
			esc_html( $quote_text )
		);
	}
}

add_action( 'admin_notices', 'hola_simpsons' );

/**
 * Print the inline stylesheet for the admin quote chrome.
 *
 * Inlined in `admin_head` rather than enqueued via wp_enqueue_style:
 * the rule set is twenty lines and shipping it through the asset
 * pipeline would 5x the plugin surface area for no practical benefit.
 *
 * @return void
 */
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
