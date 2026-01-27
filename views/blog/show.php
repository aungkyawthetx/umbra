<?php ob_start(); ?>

<article class="max-w-3xl mx-auto">
    <h1 class="text-4xl font-semibold dark:text-gray-300 leading-tight mb-6">
        <?= $post['title'] ?>
    </h1>

    <div class="flex items-center justify-between mb-10">
        <p class="text-sm text-neutral-500 dark:text-gray-400">
            Posted on: <?= date('F j, Y', strtotime($post['created_at'])) ?>
        </p>
        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="text-gray-800 font-medium hover:underline dark:text-gray-300">Back</a>
    </div>

    <?php if ($post['cover_image']): ?>
        <img src="/uploads/<?= $post['cover_image'] ?>" class="rounded mb-10">
    <?php endif; ?>

    <div class="prose prose-neutral dark:text-gray-300 max-w-none">
        <?= nl2br($post['content']) ?>
    </div>
</article>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
