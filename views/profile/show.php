<?php ob_start(); ?>
<?php 
    $isOwnProfile = $authUser && $authUser['id'] === $user['id'];
?>
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
                    <?php if($isOwnProfile): ?>
                        <a href="/logout" class="flex items-center gap-2 px-3 py-2 text-sm font-medium
                                text-gray-600 dark:text-gray-300
                                hover:text-gray-900 dark:hover:text-white
                                hover:bg-gray-100 dark:hover:bg-gray-800
                                rounded-lg transition">
                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            Logout
                        </a>
                    <?php endif ?>
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
    <?php if(!empty($posts)): ?>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold dark:text-white">Latest Articles</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($posts as $post): ?>
                <article class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden transition-all duration-300 hover:border-blue-500/40 hover:shadow-lg dark:hover:shadow-blue-500/10">
                    <!-- Cover -->
                    <div class="relative h-52 overflow-hidden">
                        <img 
                            src="/uploads/<?= htmlspecialchars($post['cover_image']) ?>" 
                            alt="<?= htmlspecialchars($post['title']) ?>" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    </div>
                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>
                                <?= date('F j, Y', strtotime($post['created_at'])) ?>
                            </span>
                            <?php
                                $wordCount = str_word_count(strip_tags($post['content']));
                                $readingTime = max(1, ceil($wordCount / 200));
                            ?>
                            <span><?= $readingTime ?> min read</span>
                        </div>
                        <!-- Title -->
                        <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-gray-100 leading-snug line-clamp-2">
                            <?= htmlspecialchars($post['title']) ?>
                        </h2>
                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-2">
                            <a  href="/blog?slug=<?= $post['slug'] ?>" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                Read more
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <!-- Edit (author only) -->
                            <!-- <?php if (is_logged_in() && $_SESSION['user']['id'] === $post['user_id']): ?>
                                <a  href="/blog/edit?id=<?= $post['id'] ?>" class="text-sm px-3 py-1 rounded border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    Edit
                                </a>
                            <?php endif; ?>
                        </div> -->
                    </div>
                </article>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <p class="text-sm text-gray-600 dark:text-gray-300 italic">No Post yet.</p>
    <?php endif ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
