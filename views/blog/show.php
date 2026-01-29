<?php ob_start(); ?>

<article class="max-w-3xl mx-auto">
    <?php if(isset($post['title'])): ?>
        <h1 class="text-xl md:text-2xl text-gray-800 font-medium dark:text-gray-100 leading-snug mb-4">
            <?= $post['title'] ?>
        </h1>
    <?php else: ?>
        <p class="italic text-xl md:text-3xl text-gray-700 dark:text-gray-200 mb-4">Title Not Found.</p>
    <?php endif ?>

    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="font-medium text-md dark:text-gray-50"> <?= $post['author_name'] ?> </h2>
            <p class="text-sm text-neutral-500 dark:text-gray-300 italic">
                Posted on: <?= date('F j, Y', strtotime($post['created_at'])) ?>
            </p>
        </div>
        <a href="/posts" class="text-gray-800 font-medium hover:underline dark:text-gray-100">Back</a>
    </div>

    <?php if ($post['cover_image']): ?>
        <img src="/uploads/<?= $post['cover_image'] ?>" class="rounded mb-10">
    <?php endif; ?>

    <p class="blog-content prose prose-neutral dark:prose-invert font-medium max-w-none leading-relaxed text-lg text-justify prose-p:my-6 prose-p:leading-8 prose-headings:mt-8 prose-headings:mb-4 prose-li:my-2"> 
        <?= nl2br($post['content']) ?> 
    </p>
</article>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
