<?php ob_start(); ?>

<div class="max-w-5xl mx-auto px-0 md:px-6">
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
            Posts
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            <?= (int)$total ?> posts • Updated regularly  
        </p>
    </div>

    <form method="GET" action="/posts" class="mb-10 flex flex-col md:flex-row gap-4">
        <?php $hasFilters = trim((string)($q ?? '')) !== '' || trim((string)($tag ?? '')) !== ''; ?>
        <input
            type="text"
            name="q"
            value="<?= e($q ?? '') ?>"
            placeholder="Search posts..."
            class="flex-1 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 border border-gray-200 focus:outline-none dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"
        >
        <input
            type="text"
            name="tag"
            value="<?= e($tag ?? '') ?>"
            placeholder="Filter by tag"
            class="md:w-56 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"
        >
        <?php if ($hasFilters): ?>
            <a href="/posts" class="w-full md:w-auto py-2 px-5 font-medium bg-gray-200 hover:bg-gray-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-100 rounded-lg inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-xmark"></i>
                Clear
            </a>
        <?php else: ?>
            <button class="w-full md:w-auto py-2 px-5 font-medium bg-blue-500 hover:bg-blue-600 text-white rounded-lg inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search
            </button>
        <?php endif; ?>
    </form>

    <div class="space-y-12">
        <?php foreach ($posts as $post): ?>
        <article class="group">
            <div class="relative h-64 md:h-80 rounded-2xl overflow-hidden mb-6 bg-gray-100 dark:bg-gray-800">
                <a href="/blog/<?= (int)$post['id'] ?>">
                    <?php if (!empty($post['cover_image'])): ?>
                        <img 
                            src="/uploads/<?= e($post['cover_image']) ?>" 
                            alt="<?= e($post['title']) ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                            loading="lazy"
                        >
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-500 text-sm">No cover image</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
            </div>

            <div class="px-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-medium dark:text-gary-300"> <?= e($post['name'] ?? 'N/A') ?> </h3>
                    <time datetime="<?= date('Y-m-d', strtotime($post['created_at'])) ?>" class="text-sm text-gray-500 dark:text-gray-400">
                        <?= date('F j, Y', strtotime($post['created_at'])) ?>
                    </time>
                </div>

                <h2 class="text-lg md:text-3xl font-medium text-gray-900 dark:text-gray-100 mb-4 transition-colors">
                    <?php if(isset($post['title'])): ?>
                        <a href="/blog/<?= (int)$post['id'] ?>">
                            <?= e($post['title']) ?>
                        </a>
                    <?php else: ?>
                        <p class="italic font-normal text-gray-700 dark:text-gray-100">Title Not Found.</p>
                    <?php endif ?>
                </h2>

                <p class="blog-content text-gray-800 dark:text-gray-300 text-md md:text-lg leading-relaxed mb-6">
                    <?= e(mb_substr($post['content'], 0, 300, 'UTF-8')) ?> ...
                </p>

                <div class="flex items-center justify-between border-b pb-4 border-gray-300 dark:border-gray-700">
                    <a href="/blog/<?= (int)$post['id'] ?>" 
                       class="text-gary-900 hover:text-blue-500 dark:text-blue-400 hover:underline dark:hover:text-blue-300 font-medium flex items-center gap-3 group-hover:gap-4 transition-all">
                        Read more
                    </a>
                    
                    <?php
                        $wordCount = str_word_count(strip_tags($post['content']));
                        $readingTime = max(1, ceil($wordCount / 200));
                    ?>
                    <span class="text-sm text-gray-400 dark:text-gray-500">
                        <?= $readingTime ?> min read
                    </span>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="flex items-center justify-center gap-3 mt-12">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <a href="/posts?page=<?= $p ?>&q=<?= urlencode($q ?? '') ?>&tag=<?= urlencode($tag ?? '') ?>" class="px-3 py-2 rounded-lg border <?= $p === $page ? 'bg-blue-500 text-white border-blue-500' : 'border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' ?>">
                    <?= $p ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($posts)): ?>
    <div class="text-center py-20">
        <div class="w-24 h-24 mx-auto mb-6 text-gray-300 dark:text-gray-700">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">No posts yet</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">Start your writing journey today</p>
        <a href="/write" class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Write First Blog
        </a>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
