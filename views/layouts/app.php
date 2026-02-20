<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Umbra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@100..900&display=swap" rel="stylesheet">
    <link href="/assets/css/output.css" rel="stylesheet">
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-slate-100 theme-transition">
    <header class="fixed w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg z-50 border-b border-gray-200/50 dark:border-gray-700/50">
        <div class="max-w-5xl mx-auto px-6 py-3 md:py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-200">
                    Umbra
                </a>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="/" class="px-4 py-2 text-sm font-medium text-gray-800 dark:text-gray-300 hover:underline dark:hover:text-white transition-all duration-200">
                        Home
                    </a>
                    
                    <a href="/write" class="px-4 py-2 text-sm font-medium text-gray-800 dark:text-gray-300 hover:underline dark:hover:text-white transition-all duration-200">
                        Write
                    </a>
                    
                    <a href="/posts" class="px-4 py-2 text-sm font-medium text-gray-800 dark:text-gray-300 hover:underline dark:hover:text-white transition-all duration-200">
                        Posts
                    </a>
                    
                    <?php if(is_logged_in()): ?>
                        <a href="/reading-list" class="px-4 py-2 text-sm font-medium text-gray-800 dark:text-gray-300 hover:underline dark:hover:text-white transition-all duration-200">
                            Reading
                        </a>
                        <a href="/profile?username=<?= e($_SESSION['user']['username']) ?>" 
                            class="px-4 py-2 text-sm font-medium text-gray-800 dark:text-gray-300 hover:underline dark:hover:text-white transition-all duration-200">
                            Profile
                        </a>
                        
                        <div class="w-px h-6 bg-gray-200 dark:bg-gray-700 mx-2"></div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 border-2 border-white dark:border-gray-800 flex items-center justify-center font-medium text-sm text-blue-600 dark:text-blue-300">
                                <?= e(strtoupper(substr($_SESSION['user']['username'], 0, 1))) ?>
                            </div>
                            <span> <?= e($_SESSION['user']['username']) ?> </span>
                        </div>
                    <?php endif; ?>
                </nav>

                <!-- Menu Icon -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile nav -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-2 border-t border-gray-200 dark:border-gray-700 pt-4">
                <div class="flex flex-col gap-1">
                    <a href="/" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Home
                    </a>
                    <a href="/write" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Write
                    </a>
                    <a href="/posts" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Posts
                    </a>
                    <?php if(is_logged_in()): ?>
                        <a href="/reading-list" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <i class="fa-solid fa-list"></i>
                            Reading
                        </a>
                        <a href="/profile?username=<?= e($_SESSION['user']['username']) ?>" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-5xl mx-auto px-6 pt-28 pb-10 w-full">
        <?= $content ?>
    </main>
    <footer class="text-center text-xs tracking-wide text-neutral-500 py-10 dark:text-blue-300">
        &copy; <?= date('Y') ?> Umbra · Made with love ❤️ by Aung Kyaw Thet<br>
        <a href="/terms-and-conditions" class="hover:underline">Terms and Conditions</a>
    </footer>
    
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
