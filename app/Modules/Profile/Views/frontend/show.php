<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($profile->display_name) ?> - bunlar.online">
    <meta property="og:title" content="<?= esc($profile->display_name) ?>">
    <meta property="og:description" content="<?= esc($profile->bio ?: $profile->display_name . ' profil sayfasi') ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:type" content="profile">
    <?php if ($profile->avatar): ?>
    <meta property="og:image" content="<?= profile_avatar_url($profile->avatar) ?>">
    <?php endif; ?>
    <title><?= esc($title) ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <?php
    // Theme styles
    $themes = [
        'minimal' => [
            'bg' => 'bg-gray-50',
            'card' => 'bg-white',
            'text' => 'text-gray-900',
            'subtext' => 'text-gray-600',
            'btn' => 'bg-white hover:bg-gray-100 text-gray-900 border border-gray-200',
            'btnHover' => 'hover:shadow-lg hover:-translate-y-0.5',
        ],
        'dark' => [
            'bg' => 'bg-gray-900',
            'card' => 'bg-gray-800',
            'text' => 'text-white',
            'subtext' => 'text-gray-400',
            'btn' => 'bg-gray-800 hover:bg-gray-700 text-white border border-gray-700',
            'btnHover' => 'hover:shadow-lg hover:-translate-y-0.5',
        ],
        'colorful' => [
            'bg' => 'bg-gradient-to-br from-pink-500 via-purple-500 to-indigo-500',
            'card' => 'bg-white/10 backdrop-blur-lg',
            'text' => 'text-white',
            'subtext' => 'text-white/80',
            'btn' => 'bg-white/20 hover:bg-white/30 text-white border border-white/30 backdrop-blur-sm',
            'btnHover' => 'hover:shadow-lg hover:-translate-y-0.5',
        ],
        'gradient' => [
            'bg' => 'bg-gradient-to-br from-emerald-400 via-cyan-500 to-blue-600',
            'card' => 'bg-white/95',
            'text' => 'text-gray-900',
            'subtext' => 'text-gray-600',
            'btn' => 'bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white',
            'btnHover' => 'hover:shadow-lg hover:-translate-y-0.5',
        ],
    ];
    $theme = $themes[$profile->theme] ?? $themes['minimal'];
    ?>

    <style>
        .link-btn {
            transition: all 0.2s ease;
        }
    </style>

    <?php if ($profile->ga_measurement_id): ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= esc($profile->ga_measurement_id) ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?= esc($profile->ga_measurement_id) ?>');
    </script>
    <?php endif; ?>
</head>
<body class="<?= $theme['bg'] ?> min-h-screen font-sans">
    <div class="min-h-screen flex flex-col items-center justify-start py-8 px-4 sm:py-12">
        <!-- Profile Card -->
        <div class="w-full max-w-md">
            <!-- Avatar & Info -->
            <div class="text-center mb-8">
                <?php if ($profile->avatar): ?>
                <img src="<?= profile_avatar_url($profile->avatar) ?>"
                     alt="<?= esc($profile->display_name) ?>"
                     class="w-24 h-24 sm:w-28 sm:h-28 rounded-full mx-auto mb-4 object-cover shadow-lg ring-4 ring-white/50">
                <?php else: ?>
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full mx-auto mb-4 bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center shadow-lg ring-4 ring-white/50">
                    <span class="text-4xl font-bold text-white"><?= strtoupper(substr($profile->display_name, 0, 1)) ?></span>
                </div>
                <?php endif; ?>

                <h1 class="text-2xl sm:text-3xl font-bold <?= $theme['text'] ?> mb-1">
                    <?= esc($profile->display_name) ?>
                </h1>
                <p class="text-sm <?= $theme['subtext'] ?> mb-3">@<?= esc($profile->username) ?></p>

                <?php if ($profile->bio): ?>
                <p class="<?= $theme['subtext'] ?> text-sm sm:text-base max-w-sm mx-auto leading-relaxed">
                    <?= nl2br(esc($profile->bio)) ?>
                </p>
                <?php endif; ?>
            </div>

            <!-- Links -->
            <?php if (!empty($links)): ?>
            <div class="space-y-3 mb-8">
                <?php foreach ($links as $link): ?>
                <a href="/go/<?= esc($link->id) ?>"
                   class="link-btn block w-full py-4 px-6 rounded-xl <?= $theme['btn'] ?> <?= $theme['btnHover'] ?> text-center font-medium shadow-sm">
                    <?php if ($link->icon): ?>
                    <span class="mr-2"><?= esc($link->icon) ?></span>
                    <?php endif; ?>
                    <?= esc($link->title) ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-center <?= $theme['subtext'] ?> py-8">Henuz link eklenmemis.</p>
            <?php endif; ?>

            <!-- QR Code Button -->
            <div class="text-center mb-8">
                <button onclick="toggleQR()"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg <?= $theme['subtext'] ?> hover:opacity-80 transition-opacity text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    QR Kodu Goster
                </button>
            </div>

            <!-- QR Code Modal -->
            <div id="qrModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" onclick="toggleQR()">
                <div class="<?= $theme['card'] ?> rounded-2xl p-6 max-w-xs w-full text-center shadow-2xl" onclick="event.stopPropagation()">
                    <h3 class="text-lg font-semibold <?= $theme['text'] ?> mb-4">QR Kodu</h3>
                    <img src="<?= profile_qr_url($profile->username) ?>"
                         alt="QR Code"
                         class="mx-auto mb-4 rounded-lg">
                    <p class="text-sm <?= $theme['subtext'] ?> mb-4">bunlar.online/<?= esc($profile->username) ?></p>
                    <a href="<?= profile_qr_url($profile->username) ?>"
                       download="<?= $profile->username ?>-qr.png"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition-colors text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        PNG Indir
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-1.5 <?= $theme['subtext'] ?> hover:opacity-80 transition-opacity text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    bunlar.online
                </a>
            </div>
        </div>
    </div>

    <script>
        function toggleQR() {
            const modal = document.getElementById('qrModal');
            modal.classList.toggle('hidden');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('qrModal').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
