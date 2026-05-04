<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for hola_simpsons_pick_locale().
 *
 * The function is the only piece of testable pure logic in the plugin:
 * given a WordPress user locale string, it returns the closest matching
 * key in the quote-set array. No WordPress runtime, no I/O, no globals
 * touched.
 *
 * Invariants under test:
 *
 *  - Exact-match locales (`es`, `en_US`, `es_ES`, `pt_BR`, `it_IT`) are
 *    returned unchanged.
 *  - Two-letter language codes that match an exact-match key (`es`,
 *    `it`) collapse to that key.
 *  - Two-letter codes whose family has a regional set
 *    (`pt` → `pt_BR`, `en` → `en_US`) get routed to that regional set.
 *  - Locales with no curated set fall back to `es` (LATAM Spanish).
 *  - Pathological inputs (empty string, garbage, very short strings)
 *    don't fatal and fall back to `es`.
 */
class PickLocaleTest extends TestCase {

    public function test_exact_match_es(): void {
        $this->assertSame( 'es', hola_simpsons_pick_locale( 'es' ) );
    }

    public function test_exact_match_en_us(): void {
        $this->assertSame( 'en_US', hola_simpsons_pick_locale( 'en_US' ) );
    }

    public function test_exact_match_es_es(): void {
        $this->assertSame( 'es_ES', hola_simpsons_pick_locale( 'es_ES' ) );
    }

    public function test_exact_match_pt_br(): void {
        $this->assertSame( 'pt_BR', hola_simpsons_pick_locale( 'pt_BR' ) );
    }

    public function test_exact_match_it_it(): void {
        $this->assertSame( 'it_IT', hola_simpsons_pick_locale( 'it_IT' ) );
    }

    public function test_two_letter_es_collapses_to_es(): void {
        // 'es' is itself a key, so the language-only lookup hits it directly.
        $this->assertSame( 'es', hola_simpsons_pick_locale( 'es_AR' ) );
        $this->assertSame( 'es', hola_simpsons_pick_locale( 'es_MX' ) );
    }

    public function test_two_letter_en_routes_to_en_us(): void {
        // 'en' is not itself a key, so the loop finds the first key starting
        // with 'en', which is 'en_US'.
        $this->assertSame( 'en_US', hola_simpsons_pick_locale( 'en_GB' ) );
        $this->assertSame( 'en_US', hola_simpsons_pick_locale( 'en_AU' ) );
    }

    public function test_two_letter_pt_routes_to_pt_br(): void {
        // No 'pt' key, but 'pt_BR' starts with 'pt'.
        $this->assertSame( 'pt_BR', hola_simpsons_pick_locale( 'pt_PT' ) );
    }

    public function test_two_letter_it_routes_to_it_it(): void {
        // 'it' is not a key, but 'it_IT' starts with 'it'.
        $this->assertSame( 'it_IT', hola_simpsons_pick_locale( 'it' ) );
    }

    public function test_unknown_locale_falls_back_to_es(): void {
        $this->assertSame( 'es', hola_simpsons_pick_locale( 'fr_FR' ) );
        $this->assertSame( 'es', hola_simpsons_pick_locale( 'de_DE' ) );
        $this->assertSame( 'es', hola_simpsons_pick_locale( 'ja' ) );
    }

    public function test_empty_string_falls_back_to_es(): void {
        $this->assertSame( 'es', hola_simpsons_pick_locale( '' ) );
    }

    public function test_short_garbage_falls_back_to_es(): void {
        // 'x' has no language family in the data; must not fatal.
        $this->assertSame( 'es', hola_simpsons_pick_locale( 'x' ) );
    }
}
