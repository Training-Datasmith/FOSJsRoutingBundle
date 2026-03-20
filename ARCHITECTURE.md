# FOSJsRoutingBundle Architecture

## Purpose

A Symfony bundle that exposes selected server-side routes to JavaScript, enabling
client-side route generation with the same named routes defined in PHP.

## Directory Structure

```
src/ (root namespace FOSJsRoutingBundle)
  FOSJsRoutingBundle.php                     — bundle entry point
  DependencyInjection/
    FOSJsRoutingExtension.php                — loads configuration
    Configuration.php                        — defines `fos_js_routing` config tree
  Controller/
    Controller.php                           — HTTP endpoint: serves route data as JSON/JS
  Command/
    DumpCommand.php                          — console: writes route data to a static file
    RouterDebugExposedCommand.php            — console: lists all exposed routes
  Extractor/
    ExposedRoutesExtractorInterface.php      — contract for extracting exposed routes
    ExposedRoutesExtractor.php               — extracts routes marked with `expose: true`
  Response/
    RoutesResponse.php                       — value object wrapping the routes payload
  Serializer/
    Normalizer/
      RouteCollectionNormalizer.php          — serialises a RouteCollection to array
      RoutesResponseNormalizer.php           — serialises a RoutesResponse
    Denormalizer/
      RouteCollectionDenormalizer.php        — reconstructs a RouteCollection from array
  Util/
    CacheControlConfig.php                  — helper for HTTP cache headers
Resources/
  config/
    routing/routing.php  — exposes the routes endpoint URL
    services.php         — service definitions
    controllers.php      — controller service definition
    serializer.php       — normalizer/denormalizer service definitions
  public/
    js/                  — the client-side fos_js_routing.js library
Tests/
  …
```

## Key Design Decisions

- **Explicit opt-in**: routes must be annotated with `expose: true` (or the
  `expose` route option) to appear in the generated payload — no routes are
  exposed by default.
- **HTTP and dump modes**: routes can be served dynamically via a Symfony
  controller (suited for dev) or pre-dumped to a static JS file (suited for prod).
- **Serializer integration**: Symfony Serializer normalizers/denormalizers handle
  the RouteCollection ↔ JSON representation, keeping the controller thin.

## Extension Points

- Implement `ExposedRoutesExtractorInterface` to customise which routes are
  exported (e.g. by domain, prefix, custom attribute).
- Configure `host`, `locale`, and `cache_control` via `fos_js_routing` config.

## Dependency Flow

```
Browser JS (fos_js_routing.js) ──GET──► Controller::indexAction
                                            └── ExposedRoutesExtractor
                                                  └── Symfony\Router
                                                        → RoutesResponse → JSON
```
