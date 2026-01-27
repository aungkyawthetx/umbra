<?php ob_start(); ?>

<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-2xl p-8 mb-12">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="w-28 h-28 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 border-2 border-white dark:border-gray-800 flex items-center justify-center font-medium text-sm text-blue-600 dark:text-blue-300">
                <span class="text-5xl"> <?= strtoupper(substr($_SESSION['user']['fullname'], 0, 2)) ?> </span>
            </div>
            <!-- Info -->
            <div class="flex-1 w-full">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                            <?= $user['name'] ?? 'N/A' ?>
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400">
                           <?= $user['username'] ?>
                        </p>
                    </div>

                    <a href="/write" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-feather-pointed mr-1"></i> Write
                    </a>
                </div>

                <!-- Bio -->
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mb-6">
                    <?= $user['bio'] ?? 'No bio provided.' ?>
                </p>

                <!-- Stats -->
                <div class="flex gap-8 text-sm">
                    <div>
                        <span class="font-semibold text-gray-900 dark:text-white"> <?= count($posts) ?> </span>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">Posts</span>
                    </div>
                    <!-- <div>
                        <span class="font-semibold text-gray-900 dark:text-white">2.8K</span>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">Followers</span>
                    </div> -->
                </div>

            </div>
        </div>
    </div>

    <!-- Content Tabs -->
    <div class="mb-8">
        <div class="border-b border-gray-200 dark:border-slate-700">
            <nav class="flex space-x-8">
                <button class="tab-button py-4 px-1 border-b-2 border-purple-600 text-purple-600 dark:text-purple-400 font-medium flex items-center gap-2">
                    <i class="fas fa-newspaper"></i>
                    Posts
                    <span class="ml-2 bg-gray-100 dark:bg-slate-800 text-gray-800 dark:text-gray-300 text-xs px-2 py-1 rounded-full"> <?= count($posts) ?> </span>
                </button>
            </nav>
        </div>
    </div>

    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold dark:text-white">Latest Articles</h2>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($posts as $post): ?>
                <article class="group bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-800 rounded-lg overflow-hidden transition hover:border-blue-500/40">
                    <div class="relative overflow-hidden">
                        <img src="/uploads/<?= $post['cover_image'] ?>"
                            alt="<?= $post['title'] ?>" class="h-52 w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    </div>
                
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <p class="text-xs text-gray-500 dark:text-gray-400"> 
                                <?= date('F j, Y', strtotime($post['created_at'])) ?> • 
                                <?php
                                    $wordCount = str_word_count(strip_tags($post['content']));
                                    $readingTime = max(1, ceil($wordCount / 200));
                                ?>
                                <span class="text-sm text-gray-400 dark:text-gray-500">
                                    <?= $readingTime ?> min read
                                </span>
                            </p>
                        </div>
                        
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 leading-snug line-clamp-3">
                            <?= $post['title'] ?>
                        </h2>
                        <a href="blog.html" class="text-sm font-medium text-blue-500 dark:text-blue-400 hover:underline">
                            Read more
                        </a>
                    </div>
                </article>
            <?php endforeach ?>
        </div>
    </div>
    </div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
