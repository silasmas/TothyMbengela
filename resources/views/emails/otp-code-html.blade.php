<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: system-ui, sans-serif; line-height: 1.5; color: #333;">
    <p>{{ $intentLabel }}</p>
    <p style="font-size: 24px; font-weight: bold; letter-spacing: 0.2em;">{{ $code }}</p>
    <p style="font-size: 13px; color: #666;">Ce code expire dans 15 minutes. Si vous n’êtes pas à l’origine de cette demande, ignorez ce message.</p>
    <p>— {{ config('app.name') }}</p>
</body>
</html>
