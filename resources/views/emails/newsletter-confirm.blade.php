<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmation newsletter</title>
</head>
<body style="margin:0;padding:0;font-family:Georgia,serif;background:#f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f4f4;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <tr>
                        <td style="padding:28px 28px 8px;">
                            <h1 style="margin:0;font-size:22px;color:#141414;">Confirmez votre inscription</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 28px 24px;color:#444;font-size:16px;line-height:1.55;">
                            <p style="margin:0 0 16px;">Merci de votre intérêt pour la newsletter du ministère Alliance.</p>
                            <p style="margin:0 0 24px;">Cliquez sur le bouton ci-dessous pour valider votre adresse e-mail et recevoir nos actualités.</p>
                            <p style="margin:0 0 28px;text-align:center;">
                                <a href="{{ $confirmUrl }}" style="display:inline-block;background:#c8922a;color:#fff;text-decoration:none;font-weight:700;font-size:15px;padding:14px 28px;border-radius:6px;text-transform:uppercase;letter-spacing:0.06em;">Confirmer mon inscription</a>
                            </p>
                            <p style="margin:0;font-size:13px;color:#666;">Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :<br><a href="{{ $confirmUrl }}" style="color:#c8922a;word-break:break-all;">{{ $confirmUrl }}</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 28px 28px;border-top:1px solid #eee;font-size:12px;color:#999;">
                            Si vous n’avez pas demandé cette inscription, ignorez simplement ce message.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
