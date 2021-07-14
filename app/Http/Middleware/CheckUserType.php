<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        //$user=Auth::user();
        $user=$request->user();

        /*if($user->type !='admin')
        {
            abort(403,'You are not Admin');
        }*/

        if(! in_array($user->type,$types) )
        {
            abort(403,'You are not Admin');
        }

        return $next($request);

        $response= $next($request);
        $html=$response->content();
        $html=str_ireplace('t-shirt','<span style="color:red">T-shirt</span>',$html);

        return response($html);
    }
}
