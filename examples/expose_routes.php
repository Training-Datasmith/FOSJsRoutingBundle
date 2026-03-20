<?php

declare(strict_types=1);

/**
 * Example: Expose selected Symfony routes to JavaScript using FOSJsRoutingBundle.
 *
 * Step 1 — Mark routes with `expose: true` in your routing config:
 *
 *   # config/routes.yaml
 *   api_users:
 *     path:     /api/users/{id}
 *     methods:  [GET]
 *     defaults: { _controller: 'App\Controller\UserController::show' }
 *     options:
 *       expose: true
 *
 *   app_home:
 *     path:    /
 *     methods: [GET]
 *     options:
 *       expose: false   # default — not exported
 *
 * Step 2 — Include the JS assets in your template:
 *
 *   <script src="{{ asset('bundles/fosjsrouting/js/router.min.js') }}"></script>
 *   <script src="{{ path('fos_js_routing_js', { callback: 'fos.Router.setData' }) }}"></script>
 *
 * Step 3 — Use in JavaScript:
 *
 *   const url = Routing.generate('api_users', { id: 42 });
 *   // → '/api/users/42'
 *   fetch(url).then(r => r.json()).then(console.log);
 *
 * Step 4 (production) — Pre-dump the route file:
 *
 *   bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
 */

// This file is documentation-only — the actual integration is configured via
// YAML routing config and Twig templates as shown above.
echo "See the inline comments for FOSJsRoutingBundle integration steps." . PHP_EOL;
