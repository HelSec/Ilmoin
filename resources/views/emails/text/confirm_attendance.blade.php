Hello,

this is an automated notification from {{ config('app.name', 'Ilmoin') }}
to let you know that you have been offered a spot to attend {{ $event->name }},
hosted by {{ $event->organization->name }}.

Please confirm your spot by {{ \App\Utils\Date::format($confirm_by) }} at the following address:
{{ url(route('events.confirm', $event)) }}

Best regards,
{{ config('app.name', 'Ilmoin') }}

If you have any questions or feedback, please reply to this email.
