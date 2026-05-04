<?php
/**
 * PHPUnit bootstrap for unit tests.
 *
 * Loads Composer dependencies (PHPUnit, Brain Monkey, Mockery), defines
 * a couple of WordPress functions the plugin file calls at file scope
 * (`add_action`) so requiring the plugin source from tests doesn't
 * blow up, then loads the plugin file itself so its functions are
 * available to test as plain PHP.
 *
 * Unit tests do NOT require a running WordPress installation. The
 * plugin is so small (one file, four functions) that a full
 * brain/monkey lifecycle would be overkill — we just stub the two WP
 * hooks the plugin uses at file scope and let PHPUnit exercise the
 * pure functions directly.
 */

// 1. Composer autoload (PHPUnit, Brain Monkey, Mockery, Tests\ namespace).
require_once __DIR__ . '/../vendor/autoload.php';

// 2. ABSPATH guard — not required by hola-simpsons.php itself, but defining
//    it keeps the bootstrap consistent with WordPress test conventions in
//    case a future helper file is added that does check for it.
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname( __DIR__ ) . '/' );
}

// 3. Minimal stubs for the WordPress functions hola-simpsons.php invokes
//    at file scope. Without these, requiring the plugin file would fatal.
//    The actual hook callbacks are NOT exercised in unit tests — only the
//    pure helper functions are.
if ( ! function_exists( 'add_action' ) ) {
    function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {
        // No-op stub. Unit tests don't exercise the action dispatcher.
        return true;
    }
}

// 4. Load the plugin source so its functions become available to tests.
require_once dirname( __DIR__ ) . '/hola-simpsons.php';
