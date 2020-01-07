Hello,

this is an automated notification from {{ config('app.name', 'Ilmoin') }}
to let you know that you have been offered a spot to attend {{ $event->name }},
hosted by {{ $event->organization->name }}.

Please confirm your spot by {{ \App\Utils\Date::format($confirm_by) }} at the following address:
{{ url(route('events.confirm', $event)) }}

Best regards,
{{ config('app.name', 'Ilmoin') }}

If you wish to no longer receive these messages, opt-out at
{{ url(route('settings.email')) }}

If you have any questions or feedback, please reply to this email.
