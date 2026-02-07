<?php ob_start(); ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <nav class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
            <a href="/" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Home</a>
            <svg class="w-4 h-4 mx-2 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="font-medium text-gray-900 dark:text-white">New Blog</span>
        </nav>
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Write New Blog
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Share your ideas with clarity and purpose.
            </p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 md:p-8">
        <form method="POST" action="/write" enctype="multipart/form-data" class="space-y-8">
            <?= csrf_field() ?>
            <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                    Title
                </label>
                <div class="relative">
                    <input
                        name="title"
                        placeholder="Craft a compelling title for your blog post"
                        class="w-full p-5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:border-blue-400 dark:focus:border-blue-400 focus:outline-none placeholder:text-gray-400 dark:placeholder:text-gray-500 hover:bg-white dark:hover:bg-gray-800 text-gray-900 dark:text-white"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                    Tags
                </label>
                <input
                    name="tags"
                    placeholder="e.g. writing, minimalism, focus"
                    class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:border-blue-400 dark:focus:border-blue-400 focus:outline-none placeholder:text-gray-400 dark:placeholder:text-gray-500 hover:bg-white dark:hover:bg-gray-800 text-gray-900 dark:text-white"
                >
                <p class="text-xs text-gray-500 dark:text-gray-400">Comma-separated tags.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                        Status
                    </label>
                    <select
                        name="status"
                        class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:border-blue-400 dark:focus:border-blue-400 focus:outline-none text-gray-900 dark:text-white"
                    >
                        <option value="published">Publish now</option>
                        <option value="draft">Save as draft</option>
                        <option value="scheduled">Schedule</option>
                    </select>
                </div>
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                        Schedule For
                    </label>
                    <input
                        type="datetime-local"
                        name="scheduled_at"
                        class="w-full p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:border-blue-400 dark:focus:border-blue-400 focus:outline-none text-gray-900 dark:text-white"
                    >
                    <p class="text-xs text-gray-500 dark:text-gray-400">Only used when status is Schedule.</p>
                </div>
            </div>

            <label class="flex items-center gap-3 text-sm text-neutral-600 dark:text-gray-400 cursor-pointer">
                <span class="px-3 py-1.5 border border-gray-300 rounded hover:bg-neutral-100 dark:hover:bg-gray-700 dark:border-gray-600">
                    Attach image
                </span>
                <span class="file-name text-neutral-400">No file selected</span>
                <input
                    type="file"
                    name="image"
                    class="hidden"
                    onchange="this.previousElementSibling.textContent = this.files[0]?.name || 'No file selected'"
                >
            </label>

            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                        Content
                    </label>
                    <span class="text-xs text-gray-500 dark:text-gray-400" id="word-count">0 words</span>
                </div>
                <textarea
                    name="content"
                    rows="10"
                    placeholder="Begin writing your thoughts... Share something meaningful."
                    class="w-full p-5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:border-blue-400 dark:focus:border-blue-400 focus:outline-none placeholder:text-gray-400 dark:placeholder:text-gray-500 hover:bg-white dark:hover:bg-gray-800 text-gray-900 dark:text-white"
                    required
                    oninput="updateWordCount(this)"
                ></textarea>
                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 pt-2">
                    <span>Write with intention</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-8 border-t border-gray-100 dark:border-gray-700">
                <button type="reset" class="cursor-pointer px-6 py-2 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors font-medium">
                    Clear All
                </button>
                <button type="submit" class="cursor-pointer px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-500 dark:to-blue-600 hover:from-blue-600 hover:to-blue-700 dark:hover:from-blue-600 dark:hover:to-blue-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg dark:shadow-gray-900/30 transition-all active:scale-[0.98] flex items-center gap-3">
                    <i class="fa-solid fa-paper-plane"></i>
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateWordCount(textarea) {
        const text = textarea.value.trim();
        const wordCount = text === '' ? 0 : text.split(/\s+/).length;
        document.getElementById('word-count').textContent = `${wordCount} words`;
    }

    // Auto-expand textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="content"]');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight + 2) + 'px';
            });
        }
    });
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
