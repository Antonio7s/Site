<?php   

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Acrescentado: se a propriedade redirectTo estiver definida na request, redireciona para ela
        if (isset($request->redirectTo) && $request->redirectTo) {
            return redirect()->intended($request->redirectTo);
        }

        return $this->redirectUser();
    }

    /**
     * Redirect user based on role.
     */
    public function redirectUser(): RedirectResponse
    {
        // Verifica se o usuário está autenticado
        if (Auth::check()) {
            // Obtém o usuário autenticado
            $user = Auth::user();

            // Se for admin, redireciona para o painel administrativo
            if ($user->access_level=='admin') {
                return redirect()->route('admin.dashboard.admin'); // Garante que vá para /admin/dashboard
            } 

            // Se não for admin, redireciona para o perfil do usuário
            return redirect()->route('profile.edit');
        }

        // Caso o usuário não esteja autenticado, redireciona para a página de login
        return redirect()->route('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

