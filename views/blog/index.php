<?php
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time / 60) . ' minutes ago';
    if ($time < 86400) return floor($time / 3600) . ' hours ago';
    return floor($time / 86400) . ' days ago';
}
?>

<?php ob_start(); ?>

<?php include __DIR__ . '/hero.php' ?>

<div class="mb-12">
    <h1 class="text-4xl font-bold text-gray-900 mb-4 dark:text-white">Latest Writings</h1>
    <p class="text-gray-600 dark:text-gray-300">Thoughtful stories and insights from the community</p>
</div>

<!-- Blog Posts Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php foreach ($posts as $post): ?>
        <article class="group bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-800 rounded-lg overflow-hidden transition hover:border-blue-500/40">
            <div class="h-48 overflow-hidden bg-gray-100">
                <a href="/blog?slug=<?= $post['slug'] ?>">
                    <?php if (!empty($post['cover_image'])): ?>
                        <img 
                            src="/uploads/<?= htmlspecialchars($post['cover_image']) ?>" 
                            alt="<?= htmlspecialchars($post['title']) ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        >
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-gray-50">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </a>
            </div>

            <div class="p-6">
                <p class="text-sm text-gray-500 mb-3">
                    <?= date('F j, Y', strtotime($post['created_at'])) ?>
                </p>

                <a href="/blog?slug=<?= $post['slug'] ?>">
                    <h2 class="text-xl dark:text-gray-300 font-semibold text-gray-900 mb-3 transition-colors">
                        <?= htmlspecialchars($post['title']) ?>
                    </h2>
                </a>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="/blog?slug=<?= $post['slug'] ?>" class="text-blue-500 hover:text-blue-600 font-medium text-sm transition-all">
                        Read more
                    </a>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
