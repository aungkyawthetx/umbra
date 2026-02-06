<?php ob_start(); ?>

<article class="max-w-3xl mx-auto">
    <h1 class="text-xl md:text-2xl text-gray-800 font-medium dark:text-gray-100 leading-snug mb-4">
        <?= e($post['title']) ?>
    </h1>
    
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="font-medium text-md dark:text-gray-50"> <?= e($post['author_name']) ?> </h2>
            <p class="text-sm text-neutral-500 dark:text-gray-300 italic">
                Posted on: <?= date('F j, Y', strtotime($post['published_at'] ?? $post['created_at'])) ?>
            </p>
        </div>
        <a href="/posts" class="text-gray-800 font-medium hover:underline dark:text-gray-100">Back</a>
    </div>

    <?php if ($post['cover_image']): ?>
        <img src="/uploads/<?= e($post['cover_image']) ?>" class="rounded mb-10">
    <?php endif; ?>

    <p class="blog-content prose prose-neutral dark:prose-invert font-medium max-w-none leading-relaxed text-lg text-justify prose-p:my-6 prose-p:leading-8 prose-headings:mt-8 prose-headings:mb-4 prose-li:my-2"> 
        <?= nl2br(e($post['content'])) ?> 
    </p>

    <?php if (!empty($post['tags'])): ?>
        <div class="mt-8 flex flex-wrap gap-2 mb-2">
            <?php foreach (explode(',', $post['tags']) as $tag): ?>
                <a href="/posts?tag=<?= urlencode(trim($tag)) ?>" class="text-xs px-3 py-1 rounded-full border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    #<?= e(trim($tag)) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mt-10 flex items-center gap-4">
        <?php if (is_logged_in()): ?>
            <form method="POST" action="/like" class="inline-flex items-center gap-2" id="like-form">
                <?= csrf_field() ?>
                <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                <div class="flex items-center gap-2">
                    <button id="like-button" class="flex items-center gap-2 px-4 py-2 rounded-full border transition-all duration-200 <?= $likedByUser ? 'bg-red-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30' : 'border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' ?> cursor-pointer">
                        <svg class="w-5 h-5" fill="<?= $likedByUser ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        <span class="font-medium"><?= $likedByUser ? 'Liked' : 'Like' ?></span>
                    </button>
                    <span id="like-count" class="text-sm font-medium <?= $likedByUser ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' ?>">
                        <?= (int)$likesCount ?>
                    </span>
                </div>
            </form>
        <?php else: ?>
            <a href="/login" class="text-sm text-blue-500 hover:underline">Login to like</a>
            <span class="text-sm text-gray-500 dark:text-gray-400"><?= (int)$likesCount ?> likes</span>
        <?php endif; ?>
    </div>

    <div class="mt-12">
        <h3 class="text-lg font-semibold mb-4">Comments (<span id="comment-count"><?= count($comments) ?></span>)</h3>
        <?php if (is_logged_in()): ?>
            <form method="POST" action="/comment" class="mb-6" id="comment-form">
                <?= csrf_field() ?>
                <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                <textarea name="content" rows="3" class="w-full p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" placeholder="Write a thoughtful comment..." required></textarea>
                <button class="mt-3 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm cursor-pointer font-medium">Post Comment</button>
            </form>
        <?php else: ?>
            <a href="/login" class="text-sm text-blue-500 hover:underline">Login to comment</a>
        <?php endif; ?>

        <?php if (!empty($comments)): ?>
            <div class="space-y-4" id="comment-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            <?= e($comment['author_name']) ?> · <?= date('F j, Y', strtotime($comment['created_at'])) ?>
                        </div>
                        <p class="text-gray-800 dark:text-gray-100"><?= nl2br(e($comment['content'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-sm text-gray-500 dark:text-gray-400" id="comment-empty">No comments yet.</p>
        <?php endif; ?>
    </div>
</article>

<script>
    (function () {
        const likeForm = document.getElementById('like-form');
        if (likeForm) {
            likeForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(likeForm);
                const res = await fetch(likeForm.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                if (!res.ok) return;
                const data = await res.json();
                if (!data.ok) return;
                const countEl = document.getElementById('like-count');
                const btn = document.getElementById('like-button');
                if (countEl) countEl.textContent = `${data.count} likes`;
                if (btn) btn.textContent = data.liked ? 'Unlike' : 'Like';
            });
        }

        const commentForm = document.getElementById('comment-form');
        if (commentForm) {
            commentForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(commentForm);
                const res = await fetch(commentForm.action, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                if (!res.ok) return;
                const data = await res.json();
                if (!data.ok) return;

                const list = document.getElementById('comment-list');
                const empty = document.getElementById('comment-empty');
                const countEl = document.getElementById('comment-count');

                const wrapper = document.createElement('div');
                wrapper.className = 'p-4 border border-gray-200 dark:border-gray-700 rounded-lg';
                const date = new Date(data.comment.created_at);
                const displayDate = isNaN(date.getTime()) ? data.comment.created_at : date.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
                wrapper.innerHTML = `
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        ${data.comment.author_name} · ${displayDate}
                    </div>
                    <p class="text-gray-800 dark:text-gray-100"></p>
                `;
                wrapper.querySelector('p').textContent = data.comment.content;

                if (empty) empty.remove();
                if (list) {
                    list.prepend(wrapper);
                } else {
                    const container = document.createElement('div');
                    container.id = 'comment-list';
                    container.className = 'space-y-4';
                    container.appendChild(wrapper);
                    commentForm.insertAdjacentElement('afterend', container);
                }

                if (countEl) countEl.textContent = String(Number(countEl.textContent) + 1);
                commentForm.reset();
            });
        }
    })();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
