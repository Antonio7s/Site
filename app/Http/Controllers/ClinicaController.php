<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinica;
use Illuminate\Support\Facades\Log;

class ClinicaController extends Controller
{
    /**
     * Registra uma nova clínica e redireciona para o upload de documentos.
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $data = $request->validate([
                'name'           => 'required|string|max:255',
                'nome_fantasia'  => 'required|string|max:255',
                'document'       => 'required|string|max:20',
                'email'          => 'required|email|unique:clinicas',
                'password'       => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ]);

            // Criar a clínica no banco de dados
            $clinica = Clinica::create([
                'name'           => $data['name'],
                'nome_fantasia'  => $data['nome_fantasia'],
                'document'       => $data['document'],
                'email'          => $data['email'],
                'password'       => bcrypt($data['password']),
            ]);

            // Autenticar a clínica após o registro
            auth()->guard('clinic')->login($clinica);

            // Define a flag de sucesso na sessão
            session()->flash('registrationSuccess', true);

            // Redireciona para a página de upload de documentos
            return redirect()->route('upload.documents');
        } catch (\Exception $e) {
            // Log do erro
            Log::error('Erro ao registrar clínica: ' . $e->getMessage());

            // Redireciona de volta com uma mensagem de erro
            return back()->withErrors(['error' => 'Erro ao registrar clínica. Tente novamente.']);
        }
    }

    /**
     * Exibe o formulário de upload de documentos.
     */
    public function showUploadForm()
    {
        return view('upload-documents');
    }

    /**
     * Processa o upload de documentos.
     */
    public function storeUpload(Request $request)
    {
        try {
            // Validação do arquivo
            $request->validate([
                'documento' => 'required|file|mimes:pdf,jpg,png|max:2048',
            ]);

            // Salva o arquivo no diretório "public/uploads"
            $path = $request->file('documento')->store('uploads', 'public');

            // Retorna uma mensagem de sucesso
            return back()->with([
                'success' => 'Documento enviado com sucesso!',
                'file_path' => $path,
            ]);
        } catch (\Exception $e) {
            // Log do erro
            Log::error('Erro ao enviar documento: ' . $e->getMessage());

            // Retorna uma mensagem de erro
            return back()->withErrors(['error' => 'Erro ao enviar documento. Tente novamente.']);
        }
    }
}