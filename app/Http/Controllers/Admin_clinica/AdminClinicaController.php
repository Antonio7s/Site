<?php

namespace App\Http\Controllers\Admin_clinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clinica;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AdminClinicaController extends Controller
{

    public function edit()
    {
        $clinica = auth('clinic')->user();
        return view('/admin-clinica/sobre/index', compact('clinica'));
    }

    public function update(Request $request)
    {
        $clinica = auth('clinic')->user();

        $validated = $request->validate(
            $this->validationRules($clinica), 
            $this->validationMessages()
        );

        $clinicaData = $this->handleRequestData($request, $clinica);

        if ($request->filled('password')) {
            $clinicaData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('documentos')) {
            if ($clinica->documentos) {
                Storage::disk('public')->delete($clinica->documentos);
            }
            $clinicaData['documentos'] = $request->file('documentos')
                ->store('clinicas/documentos', 'public');
        }

        $clinica->update($clinicaData);

        return redirect()->route('clinica.info.edit')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    private function validationRules(Clinica $clinica)
    {
        return [
            // Dados da Clínica
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'required|string|max:255',
            'cnpj_cpf' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clinicas')->ignore($clinica->id)
            ],
            'telefone' => 'required|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clinicas')->ignore($clinica->id)
            ],
            
            // Endereço
            'cep' => 'required|string|max:10',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:50',
            'bairro' => 'required|string|max:100',
            'cidade' => 'required|string|max:100',
            'uf' => 'required|string|size:2',
            
            // Contatos
            'telefone_local' => 'required|string|max:20',
            'telefone_financeiro' => 'required|string|max:20',
            'celular' => 'required|string|max:20',
            
            // Responsável
            'responsavel_nome' => 'required|string|max:255',
            'rg' => 'required|string|max:20',
            'orgao_emissor' => 'required|string|max:50',
            'data_emissao' => 'required|date_format:d/m/Y',
            'cpf' => [
                'required',
                'string',
                'max:14',
                Rule::unique('clinicas')->ignore($clinica->id)
            ],
            'estado_civil' => 'required|string|max:20',
            
            // Documentos e Segurança
            'documentos' => 'nullable|file|mimes:pdf|max:2048',
            'password' => 'nullable|string|min:8|confirmed'
        ];
    }

    private function validationMessages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser um texto.',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'email' => 'O campo :attribute deve ser um e-mail válido.',
            'unique' => 'Este :attribute já está cadastrado.',
            'date_format' => 'Formato de data inválido (DD/MM/AAAA).',
            'size' => 'O campo :attribute deve ter exatamente :size caracteres.',
            'min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
            'confirmed' => 'A confirmação do :attribute não corresponde.',
            'mimes' => 'O arquivo deve ser do tipo: :values.',
            'file' => 'O campo :attribute deve ser um arquivo.',
            'numeric' => 'O campo :attribute deve ser numérico.',
        ];
    }

    private function handleRequestData(Request $request, Clinica $clinica)
    {
        $data = $request->except([
            '_token', 
            '_method', 
            'password_confirmation', 
            'documentos'
        ]);

        // Formatar data de emissão
        if ($request->data_emissao) {
            $data['data_emissao'] = Carbon::createFromFormat(
                'd/m/Y', 
                $request->data_emissao
            )->format('Y-m-d');
        }

        // Manter documento atual se não for alterado
        if (!$request->hasFile('documentos') && $clinica->documentos) {
            $data['documentos'] = $clinica->documentos;
        }

        return $data;
    }
}