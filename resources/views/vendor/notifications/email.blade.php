<x-mail::message>
{{-- Saudação --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# 😱 Opa! Algo deu errado!
@else
# 👋 Olá, seja bem-vindo!
@endif
@endif

{{-- Linhas de introdução --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Botão de ação --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
🚀 {{ $actionText }}
</x-mail::button>
@endisset

{{-- Linhas finais --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Despedida --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Atenciosamente, <br>
**Equipe {{ config('app.name') }}** 🚀
@endif

{{-- Subcopy (caso o botão não funcione) --}}
@isset($actionText)
<x-slot:subcopy>
Se o botão acima não funcionar, copie e cole o link abaixo no seu navegador:  
🔗 [{{ $displayableActionUrl }}]({{ $actionUrl }})
</x-slot:subcopy>
@endisset
</x-mail::message>
