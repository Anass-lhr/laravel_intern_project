<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #1A1D21; margin: 0; padding: 30px;">
    @php
        $settings = App\Models\Setting::first();
        $primaryColor = $settings->primary_color ?? '#1EB5AD';
    @endphp
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #2A2D35; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <tr>
                        <td style="text-align: center;">
                            <!-- Greeting -->
                            @if (! empty($greeting))
                                <h1 style="font-family: 'Inter', Arial, sans-serif; font-size: 28px; color: {{ $primaryColor }}; text-align: center; margin-bottom: 25px; font-weight: 600;">{{ $greeting }}</h1>
                            @else
                                @if ($level === 'error')
                                    <h1 style="font-family: 'Inter', Arial, sans-serif; font-size: 28px; color: #ef4444; text-align: center; margin-bottom: 25px; font-weight: 600;">@lang('Whoops!')</h1>
                                @else
                                    <h1 style="font-family: 'Inter', Arial, sans-serif; font-size: 28px; color: {{ $primaryColor }}; text-align: center; margin-bottom: 25px; font-weight: 600;">@lang('Hello, Let\'s Secure Your Account!')</h1>
                                @endif
                            @endif

                            <!-- Intro Lines (Message personnalisé) -->
                            <p style="font-family: 'Inter', Arial, sans-serif; font-size: 16px; color: #ffffff; text-align: center; line-height: 1.7; margin: 15px 0;">We have received a request to reset the password for your Business+ Talk account.</p>

                            <!-- Action Button -->
                            @isset($actionText)
                                <div style="text-align: center; margin: 30px 0;">
                                    <a href="{{ $actionUrl }}" style="display: inline-block; padding: 12px 30px; background-color: {{ $primaryColor }}; color: #ffffff; text-decoration: none; border-radius: 8px; font-family: 'Inter', Arial, sans-serif; font-size: 16px; font-weight: 600;">
                                        {{ $actionText }}
                                    </a>
                                </div>
                            @endisset

                            <!-- Outro Lines (Message personnalisé) -->
                            <p style="font-family: 'Inter', Arial, sans-serif; font-size: 16px; color: #ffffff; text-align: center; line-height: 1.7; margin: 15px 0;">This link will expire in 60 minutes. If you did not request a password change, please ignore this email.</p>

                            <!-- Salutation -->
                            @if (! empty($salutation))
                                <p style="font-family: 'Inter', Arial, sans-serif; font-size: 14px; color: #9CA3AF; text-align: center; margin-top: 30px;">{{ $salutation }}</p>
                            @else
                                <p style="font-family: 'Inter', Arial, sans-serif; font-size: 14px; color: #9CA3AF; text-align: center; margin-top: 30px;">@lang('Best regards'),<br>Business+ Talk</p>
                            @endif

                            <!-- Subcopy -->
                            @isset($actionText)
                                <p style="font-family: 'Inter', Arial, sans-serif; font-size: 12px; color: #9CA3AF; text-align: center; margin-top: 25px;">
                                    @lang(
                                        "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below into your web browser:",
                                        [
                                            'actionText' => $actionText,
                                        ]
                                    ) <br>
                                    <span style="word-break: break-all; color: {{ $primaryColor }};">{{ $displayableActionUrl }}</span>
                                </p>
                            @endisset
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>