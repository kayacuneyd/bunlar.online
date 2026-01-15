<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen font-['Inter'] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center">
        <h1 class="text-xl font-semibold text-gray-900 mb-2"><?= esc($profile->display_name) ?></h1>
        <p class="text-gray-500 text-sm mb-6">@<?= esc($profile->username) ?></p>

        <img src="<?= profile_qr_url($profile->username) ?>"
             alt="QR Code"
             class="mx-auto mb-6 rounded-lg shadow-sm">

        <p class="text-gray-600 text-sm mb-6">
            Bu QR kodu tarayarak profile ulasabilirsiniz.
        </p>

        <div class="space-y-3">
            <a href="<?= profile_qr_url($profile->username) ?>"
               download="<?= $profile->username ?>-qr.png"
               class="block w-full py-3 px-4 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-colors font-medium">
                PNG Olarak Indir
            </a>

            <a href="/<?= esc($profile->username) ?>"
               class="block w-full py-3 px-4 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                Profile Git
            </a>
        </div>
    </div>
</body>
</html>
