<?php

namespace DexBarrett\Http\Middleware;

use Closure;
use DexBarrett\Services\Imgur\Imgur;

class ImgurMiddleware
{
    protected $imgur;

    public function __construct(Imgur $imgur)
    {
        $this->imgur = $imgur;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($userToken = $this->imgur->getUserToken()) {
            $this->imgur->authenticate($userToken);
        } else {

            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } 
            
            return redirect()->action('AdminController@showSettings');
                           
        }

        return $next($request);
    }
}
