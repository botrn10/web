<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckLoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log::info("------- inint ----------");
        if (Auth::check()) {
            $userLogin = Auth::user();
            // dump($userLogin);
            $checkRole = User::where('id', $userLogin->id)
                ->where('status', 2)
                ->whereHas('userType', function ($query) {
                    $query->whereIn('name', [User::ROLE_ADMIN, User::ROLE_SYSTEM]);
                })->first();
            if (empty($checkRole)) {
                return redirect()->route('get_admin.login');
            }
            return $next($request);
        }
        return redirect()->route('get_admin.login');
    }
}
