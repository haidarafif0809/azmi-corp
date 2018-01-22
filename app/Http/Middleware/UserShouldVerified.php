<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class UserShouldVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          $response = $next($request);
            if (Auth::check() && !Auth::user()->konfirmasi_admin) {
              Auth::logout();
              Session::flash("flash_notification", [
                "level"   => "warning",
                "message" => "Akun Anda belum aktif. Silahkan minta ke admin untuk Aktivasi" ]);
               return redirect('/login');
            }
          return $response;
    }
}
