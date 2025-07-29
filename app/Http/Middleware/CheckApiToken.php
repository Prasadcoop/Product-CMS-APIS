<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use League\OAuth2\Server\Exception\OAuthServerException;

class CheckApiToken
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (UnauthorizedHttpException $e) {
            $previous = $e->getPrevious();

            if ($previous instanceof OAuthServerException) {
                return response()->json([
                    'message' => 'Invalid or expired token.',
                ], 401);
            }

            return response()->json([
                'message' => 'Unauthorized access.',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}