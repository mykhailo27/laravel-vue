<x-mail::message>
# Dear {{ $recipient_name }},

@lang You are invited to join {{ $company_name }}. @endlang


@if($password_reset_route)
@lang Since this is your first time to join the platform, you need to set your password before visiting
        {{ $company_name }}.
@endlang

<x-mail::button url="{{ $password_reset_route }}">
    Set Password
</x-mail::button>
@endif

@lang You can visit company you are invited to with the link below. @endlang

<x-mail::button url="{{ $visit_company_route }}">
    Visit Company
</x-mail::button>

Thanks, <br>
{{ config('app.name') }}
</x-mail::message>

