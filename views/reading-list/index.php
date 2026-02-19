<?php ob_start(); ?>

<div class="max-w-5xl mx-auto space-y-10">
    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-gradient-to-r from-white to-gray-50 px-6 py-7 shadow-sm dark:border-slate-700 dark:from-slate-900 dark:to-slate-800">
        <p class="text-xs uppercase tracking-[0.22em] text-gray-500 dark:text-slate-400">Personal feed</p>
        <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Reading List</h1>
        <p class="mt-2 max-w-2xl text-gray-600 dark:text-slate-300">
            Keep up with the writers in your reading lists and jump straight into their latest work.
        </p>
    </section>

    <section>
        <div class="mb-4 flex items-end justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-slate-100">Authors</h2>
            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-slate-800 dark:text-slate-300">
                <?= count($authors) ?> following
            </span>
        </div>
        <?php if (!empty($authors)): ?>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <?php foreach ($authors as $author): ?>
                    <a href="/profile?username=<?= e($author['username']) ?>" class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-blue-300 hover:shadow-md dark:border-slate-700 dark:bg-slate-900 dark:hover:border-blue-500">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700 dark:bg-blue-950 dark:text-blue-200">
                            <?= e(strtoupper(substr($author['username'], 0, 1))) ?>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">@<?= e($author['username']) ?></div>
                        <div class="mt-0.5 text-lg font-semibold text-gray-900 group-hover:text-blue-700 dark:text-slate-100 dark:group-hover:text-blue-300">
                            <?= e($author['name']) ?>
                        </div>
                        <p class="mt-1 text-sm text-gray-600 dark:text-slate-400">
                            <?= e($author['bio'] ?? 'No bio available yet.') ?>
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rounded-xl border border-dashed border-gray-300 bg-white px-5 py-8 text-sm text-gray-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
                You have no authors in your reading list. Start adding some to see their latest posts here!
            </div>
        <?php endif; ?>
    </section>

    <section>
        <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-slate-100">Latest From Your Authors</h2>
        <?php if (!empty($posts)): ?>
            <div class="space-y-4">
                <?php foreach ($posts as $post): ?>
                    <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:border-blue-300 hover:shadow-md dark:border-slate-700 dark:bg-slate-900 dark:hover:border-blue-500">
                        <div class="mb-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-gray-500 dark:text-slate-400">
                            <span class="font-medium text-gray-700 dark:text-slate-300"><?= e($post['author_name']) ?></span>
                            <span aria-hidden="true">&bull;</span>
                            <time datetime="<?= e(date('c', strtotime($post['created_at']))) ?>">
                                <?= date('F j, Y', strtotime($post['created_at'])) ?>
                            </time>
                        </div>
                        <h3 class="text-xl font-semibold leading-tight text-gray-900 dark:text-slate-100">
                            <a href="/blog/<?= (int)$post['id'] ?>" class="hover:text-blue-500 hover:underline dark:hover:text-blue-300">
                                <?= e($post['title']) ?>
                            </a>
                        </h3>
                        <p class="mt-2 text-gray-700 dark:text-slate-300">
                            <?= e(mb_substr($post['content'], 0, 180, 'UTF-8')) ?>...
                        </p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rounded-xl border border-dashed border-gray-300 bg-white px-5 py-8 text-sm text-gray-600 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">
                No posts yet.
            </div>
        <?php endif; ?>
    </section>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
