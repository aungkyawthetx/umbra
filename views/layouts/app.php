<?php
    $notificationUnreadCount = 0;
    if (is_logged_in()) {
        $db = Database::connect();
        $notificationCountStmt = $db->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
        $notificationCountStmt->execute([(int)$_SESSION['user']['id']]);
        $notificationUnreadCount = (int)$notificationCountStmt->fetchColumn();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="Umbra - A place for thoughts, a place for knowledge" />
    <meta property="og:description" content="A minimalist blog platform for thoughtful writing." />
    <meta property="og:image" content="https://umbra.lovestoblog.com/og-image.png" />
    <meta property="og:url" content="https://umbra.lovestoblog.com/" />
    <meta property="og:type" content="website" />
    <title>Umbra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <link rel="icon" href="/assets/images/favicon.ico"> -->
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

                        <div class="relative" id="desktop-notification-root">
                            <button
                                type="button"
                                id="notification-button"
                                class="relative p-2 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                aria-expanded="false"
                                aria-haspopup="true"
                                aria-label="Notifications"
                            >
                                <i class="fa-regular fa-bell text-gray-700 dark:text-gray-300"></i>
                                <span id="notification-badge" class="<?= $notificationUnreadCount > 0 ? '' : 'hidden ' ?>absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-blue-600 text-white text-[11px] leading-5 text-center font-semibold">
                                    <?= (int)$notificationUnreadCount ?>
                                </span>
                            </button>

                            <div id="notification-dropdown" class="hidden absolute right-0 mt-3 w-80 max-h-96 overflow-y-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-xl z-50">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Notifications</h3>
                                    <button type="button" id="notification-mark-all" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Mark all read</button>
                                </div>
                                <div id="notification-list" class="divide-y divide-gray-100 dark:divide-gray-800"></div>
                                <p id="notification-empty" class="hidden px-4 py-6 text-sm text-center text-gray-500 dark:text-gray-400">No notifications yet.</p>
                            </div>
                        </div>
                        
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
                        <button type="button" id="mobile-notification-button" class="flex items-center justify-between gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors w-full text-left">
                            <span class="flex items-center gap-3">
                                <i class="fa-regular fa-bell"></i>
                                Notifications
                            </span>
                            <span id="mobile-notification-badge" class="<?= $notificationUnreadCount > 0 ? '' : 'hidden ' ?>min-w-5 h-5 px-1 rounded-full bg-blue-600 text-white text-[11px] leading-5 text-center font-semibold">
                                <?= (int)$notificationUnreadCount ?>
                            </span>
                        </button>
                        <div id="mobile-notification-dropdown" class="hidden mx-4 mb-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Notifications</h3>
                                <button type="button" id="mobile-notification-mark-all" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">Mark all read</button>
                            </div>
                            <div id="mobile-notification-list" class="divide-y divide-gray-100 dark:divide-gray-800"></div>
                            <p id="mobile-notification-empty" class="hidden px-4 py-6 text-sm text-center text-gray-500 dark:text-gray-400">No notifications yet.</p>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-5xl mx-auto px-2 md:px-6 pt-28 pb-10 w-full">
        <?php if ($flash = pull_flash()): ?>
            <?php
                $flashType = $flash['type'] ?? 'info';
                $flashClasses = 'bg-blue-50 text-blue-900 border-blue-200 dark:bg-blue-900/30 dark:text-blue-100 dark:border-blue-800';
                if ($flashType === 'success') {
                    $flashClasses = 'bg-emerald-50 text-emerald-900 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-100 dark:border-emerald-800';
                } elseif ($flashType === 'error') {
                    $flashClasses = 'bg-rose-50 text-rose-900 border-rose-200 dark:bg-rose-900/30 dark:text-rose-100 dark:border-rose-800';
                } elseif ($flashType === 'warning') {
                    $flashClasses = 'bg-amber-50 text-amber-900 border-amber-200 dark:bg-amber-900/30 dark:text-amber-100 dark:border-amber-800';
                }
            ?>
            <div class="mb-6 rounded-2xl border px-4 py-3 text-sm <?= $flashClasses ?>">
                <?= e($flash['message'] ?? '') ?>
            </div>
        <?php endif; ?>

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

        const notificationButton = document.getElementById('notification-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationList = document.getElementById('notification-list');
        const notificationEmpty = document.getElementById('notification-empty');
        const notificationBadge = document.getElementById('notification-badge');
        const notificationMarkAll = document.getElementById('notification-mark-all');

        const mobileNotificationButton = document.getElementById('mobile-notification-button');
        const mobileNotificationDropdown = document.getElementById('mobile-notification-dropdown');
        const mobileNotificationList = document.getElementById('mobile-notification-list');
        const mobileNotificationEmpty = document.getElementById('mobile-notification-empty');
        const mobileNotificationBadge = document.getElementById('mobile-notification-badge');
        const mobileNotificationMarkAll = document.getElementById('mobile-notification-mark-all');

        const csrfToken = '<?= e(csrf_token()) ?>';

        function setUnreadCount(count) {
            const badges = [notificationBadge, mobileNotificationBadge];
            badges.forEach((badge) => {
                if (!badge) return;
                if (count > 0) {
                    badge.classList.remove('hidden');
                    badge.textContent = String(count);
                } else {
                    badge.classList.add('hidden');
                    badge.textContent = '0';
                }
            });
        }

        function renderNotificationRows(items, listEl, emptyEl) {
            if (!listEl || !emptyEl) return;
            listEl.innerHTML = '';

            if (!Array.isArray(items) || items.length === 0) {
                emptyEl.classList.remove('hidden');
                return;
            }

            emptyEl.classList.add('hidden');
            items.forEach((item) => {
                const row = document.createElement('a');
                row.href = item.url;
                row.className = `block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors ${item.is_read ? '' : 'bg-blue-50/50 dark:bg-blue-900/10'}`;
                row.dataset.notificationId = String(item.id);
                row.innerHTML = `
                    <p class="text-sm text-gray-800 dark:text-gray-100">${item.message}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${new Date(item.created_at).toLocaleString()}</p>
                `;
                listEl.appendChild(row);
            });
        }

        async function loadNotifications() {
            if (!notificationButton && !mobileNotificationButton) return;
            try {
                const res = await fetch(`/notifications?_=${Date.now()}`, {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store'
                });
                const data = await res.json();
                if (!data || !data.ok) return;

                setUnreadCount(Number(data.unread_count || 0));
                renderNotificationRows(data.notifications, notificationList, notificationEmpty);
                renderNotificationRows(data.notifications, mobileNotificationList, mobileNotificationEmpty);
            } catch (_) {}
        }

        async function markAllNotificationsRead() {
            try {
                const formData = new FormData();
                formData.append('_csrf', csrfToken);
                await fetch('/notifications/read', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: formData
                });
                await loadNotifications();
            } catch (_) {}
        }

        function bindNotificationClickMarkRead(container) {
            if (!container) return;
            container.addEventListener('click', async (event) => {
                const target = event.target.closest('[data-notification-id]');
                if (!target) return;
                const id = target.dataset.notificationId;
                try {
                    const formData = new FormData();
                    formData.append('_csrf', csrfToken);
                    formData.append('id', id);
                    await fetch('/notifications/read', {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                        body: formData
                    });
                    await loadNotifications();
                } catch (_) {}
            });
        }

        if (notificationButton && notificationDropdown) {
            notificationButton.addEventListener('click', async function () {
                notificationDropdown.classList.toggle('hidden');
                if (!notificationDropdown.classList.contains('hidden')) {
                    await loadNotifications();
                }
            });

            document.addEventListener('click', function (event) {
                const root = document.getElementById('desktop-notification-root');
                if (!root) return;
                if (!root.contains(event.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            });
        }

        if (mobileNotificationButton && mobileNotificationDropdown) {
            mobileNotificationButton.addEventListener('click', async function () {
                mobileNotificationDropdown.classList.toggle('hidden');
                if (!mobileNotificationDropdown.classList.contains('hidden')) {
                    await loadNotifications();
                }
            });
        }

        if (notificationMarkAll) {
            notificationMarkAll.addEventListener('click', markAllNotificationsRead);
        }
        if (mobileNotificationMarkAll) {
            mobileNotificationMarkAll.addEventListener('click', markAllNotificationsRead);
        }

        bindNotificationClickMarkRead(notificationList);
        bindNotificationClickMarkRead(mobileNotificationList);

        loadNotifications();
        setInterval(loadNotifications, 5000);

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') {
                loadNotifications();
            }
        });

        window.addEventListener('focus', loadNotifications);
    </script>
</body>
</html>
