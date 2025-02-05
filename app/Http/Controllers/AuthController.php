namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa o Facade Auth
use App\Models\User;
use Illuminate\Support\Facades\Redirect; // Adiciona a facada de redirecionamento

class AuthController extends Controller
{
    // Método de verificação de login
    public function verificarLogin(Request $request)
    {
        // Validação dos dados enviados (garante que email e senha foram informados)
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Tentativa de login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redireciona para a página principal após o login bem-sucedido
            return redirect('/dashboard'); // Substitua '/dashboard' pela rota desejada
        }

        // Se as credenciais forem inválidas
        return back()->withErrors([
            'email' => 'As credenciais fornecidas são inválidas.',
        ]);
    }

    // Método de registro de um novo usuário
    public function register(Request $request)
    {
        // Valida os dados do usuário
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cria o usuário
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // Hash da senha
        ]);

        // Realiza login após o cadastro
        Auth::login($user);

        // Redireciona para a página principal após o cadastro e login
        return redirect('/dashboard'); // Substitua '/dashboard' pela rota desejada
    }
}
