<x-mail::message>
# Hey {{ config('mail.from.name') }},

@lang Here is the message from {{ $data['name'] }} whose email is {{ $data['email'] }}! @endlang


@lang {!! $data['message'] !!} @endlang


Thanks,
{{ config('app.name') }}
</x-mail::message>
