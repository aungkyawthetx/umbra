<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Umbra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-slate-100 theme-transition min-h-screen">
    <header class="fixed w-full bg-white/70 dark:bg-gray-800/70 backdrop-blur-md z-50 shadow-sm">
        <div class="max-w-5xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-semibold tracking-tight">
                Umbra
            </a>
            <nav class="flex gap-6 text-sm">
                <a href="/" class="hover:underline font-medium">Home</a>
                <a href="/write" class="hover:underline font-medium">Post</a>
                <a href="/profile?username=john" class="hover:underline font-medium">Profile</a>
            </nav>
        </div>
    </header>
    <main class="max-w-5xl mx-auto px-6 pt-28 pb-10">
        <?= $content ?>
    </main>
    <footer class="text-center text-sm text-neutral-500 py-10 dark:text-blue-300">
        &copy; <?=  date('Y') ?> <span class="italic">Umbra</span>. Built for thinking, not scrolling.
    </footer>
</body>
</html>
