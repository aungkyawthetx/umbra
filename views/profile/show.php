<?php ob_start(); ?>
<?php 
    $isOwnProfile = $authUser && $authUser['id'] === $user['id'];
    $isFollowing = false;
    if ($authUser) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT 1 FROM reading_lists WHERE reader_id = ? AND author_id = ?");
        $stmt->execute([$authUser['id'], $user['id']]);
        $isFollowing = (bool)$stmt->fetch();
    }
?>
<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-2xl p-8 mb-12">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="w-28 h-28 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 border-2 border-white dark:border-gray-800 flex items-center justify-center font-medium text-sm text-blue-600 dark:text-blue-300">
                <span class="text-5xl"> <?= e(strtoupper(substr($user['name'], 0, 2))) ?> </span>
            </div>
            <!-- Info -->
            <div class="flex-1 w-full">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                            <?= e($user['name'] ?? 'N/A') ?>
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400">
                           <?= e($user['username']) ?>
                        </p>
                    </div>
                    <?php if($isOwnProfile): ?>
                        <div class="flex items-center gap-2">
                            <a href="/write" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                <i class="fa-solid fa-feather-pointed text-xs"></i>
                                Write
                            </a>
                            <a href="/logout" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                Logout
                            </a>
                        </div>
                    <?php else: ?>
                        <?php if (!$authUser): ?>
                            <a href="/login" class="px-3 py-2 text-sm font-medium bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                                Login to follow
                            </a>
                        <?php elseif ($isFollowing): ?>
                            <form action="/reading-list/unfollow" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="username" value="<?= e($user['username']) ?>">
                                <button class="cursor-pointer inline-flex items-center gap-2 px-3 py-2 text-sm font-medium bg-gray-100 text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-slate-800 dark:text-gray-200 dark:border-slate-600 dark:hover:bg-slate-700 transition">
                                    <i class="fa-solid fa-user-minus text-xs"></i>
                                    Unfollow
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="/reading-list" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="username" value="<?= e($user['username']) ?>">
                                <button class="cursor-pointer inline-flex items-center gap-2 px-3 py-2 text-white text-sm bg-blue-500 hover:bg-blue-600 font-medium rounded-lg transition">
                                    <i class="fa-solid fa-user-plus text-xs"></i>
                                    Follow
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif ?>
                </div>

                <?php if ($isOwnProfile && isset($_GET['updated']) && $_GET['updated'] === '1'): ?>
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                        Profile bio updated.
                    </div>
                <?php endif; ?>

                <!-- Bio -->
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mb-3">
                    <?= e($user['bio'] ?? 'No bio provided.') ?>
                </p>

                <?php if($isOwnProfile): ?>
                    <details class="max-w-2xl mb-6">
                        <summary class="cursor-pointer inline-flex items-center gap-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                            Edit bio
                        </summary>
                        <form action="/profile/update" method="POST" class="mt-3">
                            <?= csrf_field() ?>
                            <textarea
                                id="bio"
                                name="bio"
                                rows="2"
                                maxlength="500"
                                class="w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-2 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Write something about yourself..."
                            ><?= e($user['bio'] ?? '') ?></textarea>
                            <div class="mt-3">
                                <button type="submit" class="cursor-pointer inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                                    Save Profile
                                </button>
                            </div>
                        </form>
                    </details>
                <?php endif; ?>

                <!-- Stats -->
                <div class="flex gap-8 text-sm">
                    <div>
                        <span class="font-semibold text-gray-900 dark:text-white"> <?= count($posts) ?> </span>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">Posts</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-900 dark:text-white"> <?= (int)($followersCount ?? 0) ?> </span>
                        <span class="text-gray-500 dark:text-gray-400 ml-1">Followers</span>
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
                        <?php if (!empty($post['cover_image'])): ?>
                            <img 
                                src="/uploads/<?= e($post['cover_image']) ?>" 
                                alt="<?= e($post['title']) ?>" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                No cover image
                            </div>
                        <?php endif; ?>
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
                        <h2 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-300 leading-snug line-clamp-2">
                            <?= e($post['title'] ?? 'N/A') ?>
                        </h2>
                        <?php if ($isOwnProfile && !empty($post['status']) && $post['status'] !== 'published'): ?>
                            <span class="inline-flex text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-200">
                                <?= e($post['status']) ?>
                            </span>
                        <?php endif; ?>
                        <!-- Actions -->
                        <div class="flex items-center justify-between">
                            <a  href="/blog/<?= (int)$post['id'] ?>" class="inline-flex items-center gap-2 text-sm font-medium text-blue-400 dark:text-blue-400 hover:underline">
                                Read more
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <?php if ($isOwnProfile): ?>
                                <div class="flex items-center gap-2">
                                    <a  href="/blog/edit?id=<?= (int)$post['id'] ?>" class="text-sm px-3 py-1 rounded border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                        Edit
                                    </a>
                                    <form method="POST" action="/blog/delete" onsubmit="return confirm('Delete this post?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
                                        <button class="text-sm px-3 py-1 rounded border border-red-300 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition cursor-pointer">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
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
