<?php 

namespace App\Http\Middleware;

class CorsMiddleware {

  public function handle($request, \Closure $next){
    $response = $next($request);

    $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
    $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
    $response->header('Access-Control-Allow-Origin', '*');
    $response->header('Cache-Control', 'no-cache, no-store, max-age=-1');

    return $response;
  }
}