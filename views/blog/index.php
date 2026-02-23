<?php ob_start(); ?>
<?php include __DIR__ . '/hero.php' ?>

<section class="mt-8 mb-16">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">More than a blog</h2>
        <p class="text-gray-600 dark:text-gray-300">Create, collect, and grow thoughtful writing with focused tools.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Write with focus</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">A clean editor that keeps attention on your words, not the noise.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Reading list</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Follow writers you love and keep their latest work in one place.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <div class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Clean publishing</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Simple publishing flow with cover images and clear typography.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
            <div class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Reader profiles</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Showcase your writing, likes, and reading list in one profile.</p>
        </div>
    </div>
</section>

<section class="mb-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">How it works</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Publish in minutes, share instantly, and build a thoughtful reading habit.</p>
        </div>
        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">Step 1</div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Write your story</h4>
                <p class="text-sm text-gray-600 dark:text-gray-300">Create a post, add a cover image, and publish when ready.</p>
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">Step 2</div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Share and connect</h4>
                <p class="text-sm text-gray-600 dark:text-gray-300">Get discovered through the community feed and profile links.</p>
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">Step 3</div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Build your list</h4>
                <p class="text-sm text-gray-600 dark:text-gray-300">Follow authors and keep their latest posts in your reading list.</p>
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5">
                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">Step 4</div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Keep the habit</h4>
                <p class="text-sm text-gray-600 dark:text-gray-300">Return anytime for fresh ideas and curated writing.</p>
            </div>
        </div>
    </div>
</section>

<section class="mb-16">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">Start writing today</h3>
            <p class="text-gray-600 dark:text-gray-300">Create your first post and join the Umbra community.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="/write" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition">Write a post</a>
            <a href="/posts" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Explore posts</a>
        </div>
    </div>
</section>

<?php if(!empty($posts)) : ?>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2 dark:text-white">Latest Writings</h2>
        <p class="text-gray-600 dark:text-gray-300">Thoughtful stories and insights from the community</p>
    </div>

    <!-- Blog Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($posts as $post): ?>
            <article class="group bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-800 rounded-lg overflow-hidden transition hover:border-blue-500/40">
                <div class="h-48 overflow-hidden bg-gray-100">
                    <a href="/blog/<?= (int)$post['id'] ?>">
                        <?php if (!empty($post['cover_image'])): ?>
                            <img  src="/uploads/<?= e($post['cover_image']) ?>" 
                                alt="<?= e($post['title']) ?>"
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

                    <a href="/blog/<?= (int)$post['id'] ?>">
                        <h2 class="text-lg md:text-xl text-gray-800 dark:text-gray-300 font-semibold mb-3 transition-colors">
                            <?= e($post['title'] ?? 'N/A') ?>
                        </h2>
                    </a>
                    
                    <div class="flex items-center justify-between">
                        <a href="/blog/<?= (int)$post['id'] ?>" class="text-blue-400 hover:text-blue-500 font-medium text-sm transition-all">
                            Read more
                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
