<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Jadwal Pernikahan</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h2 style="color: #2d3748; text-align: center;">🎉 Jadwal Pernikahan Telah Di Perbaharui 🎉</h2>

        <p style="font-size: 16px; color: #4a5568;">Berikut adalah detail baru jadwal pernikahan Anda:</p>

        <table style="width: 100%; margin-top: 20px; font-size: 16px;">
            <tr>
                <td style="padding: 8px 0;"><strong>Tanggal:</strong></td>
                <td style="padding: 8px 0;">
                    {{ \Carbon\Carbon::parse($schedule->marriage_date)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Waktu:</strong></td>
                <td style="padding: 8px 0;">{{ \Carbon\Carbon::parse($schedule->marriage_time)->format('H:i') }} WITA
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Tempat:</strong></td>
                <td style="padding: 8px 0;">{{ $schedule->marriage_venue }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Penghulu:</strong></td>
                <td style="padding: 8px 0;">{{ $schedule->user->name }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px; font-size: 16px; color: #2d3748;">
            Mohon hadir tepat waktu sesuai jadwal yang telah ditentukan. Jika ada perubahan atau pertanyaan, silakan
            hubungi pihak yang berwenang.
        </p>

        <p style="margin-top: 40px; font-size: 14px; color: #718096;">Terima kasih telah menggunakan layanan kami.</p>
    </div>
</body>

</html>
