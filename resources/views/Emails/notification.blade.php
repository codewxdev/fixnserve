{{-- resources/views/emails/notification.blade.php --}}

@component('mail::message')
    # {{ $type->name ?? 'Notification' }}

    {!! nl2br(e($content)) !!}

    @if (isset($actionUrl) && isset($actionText))
        @component('mail::button', ['url' => $actionUrl])
            {{ $actionText }}
        @endcomponent
    @endif

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
