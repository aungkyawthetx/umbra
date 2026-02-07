<?php ob_start(); ?>

<div class="max-w-5xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Reading List</h1>
        <p class="text-gray-600 dark:text-gray-400">Authors you follow and their latest posts.</p>
    </div>

    <div class="mb-10">
        <h2 class="text-lg font-semibold mb-3">Authors</h2>
        <?php if (!empty($authors)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($authors as $author): ?>
                    <a href="/profile?username=<?= e($author['username']) ?>" class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <div class="text-sm text-gray-500 dark:text-gray-400">@<?= e($author['username']) ?></div>
                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100"><?= e($author['name']) ?></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400"><?= e($author['bio'] ?? '') ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-sm text-gray-500 dark:text-gray-400">You are not following anyone yet.</p>
        <?php endif; ?>
    </div>

    <div>
        <h2 class="text-lg font-semibold mb-3">Latest From Your Authors</h2>
        <?php if (!empty($posts)): ?>
            <div class="space-y-6">
                <?php foreach ($posts as $post): ?>
                    <article class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <?= e($post['author_name']) ?> · <?= date('F j, Y', strtotime($post['created_at'])) ?>
                        </div>
                        <h3 class="text-lg font-semibold">
                            <a href="/blog/<?= (int)$post['id'] ?>" class="hover:underline">
                                <?= e($post['title']) ?>
                            </a>
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            <?= e(mb_substr($post['content'], 0, 180, 'UTF-8')) ?>...
                        </p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-sm text-gray-500 dark:text-gray-400">No posts yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
