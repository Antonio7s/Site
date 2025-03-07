<?php

namespace App\Http\Requests\Auth; // Namespace corrigido!

use Illuminate\Foundation\Auth\EmailVerificationRequest as BaseRequest;
use Illuminate\Support\Facades\Auth;

class EmailVerificationRequest extends BaseRequest
{
    public function authorize()
    {
        $clinica = Auth::guard('clinic')->user();

        if (!$clinica || 
            !hash_equals((string) $clinica->getKey(), (string) $this->route('id')) ||
            !hash_equals(sha1($clinica->getEmailForVerification()), (string) $this->route('hash'))) 
        {
            return false;
        }

        return true;
    }
}