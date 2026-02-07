<section class="relative overflow-hidden">
    <div class="relative max-w-6xl mx-auto px-6 py-20 text-center">
        <div class="inline-flex items-center gap-2 mb-8 px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-full border border-gray-200 dark:border-slate-700">
            <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">UMBRA BLOG</span>
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight text-gray-900 dark:text-white mb-6">
            <span class="bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent">
                Write. Reflect.
            </span>
            <span class="text-gray-900 dark:text-gray-300 mt-2">Share.</span>
        </h1>
        <p class="text-md md:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-12 leading-relaxed">
            A minimalist space to publish your thoughts, essays, and ideas without distractions.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
            <?php if(is_logged_in()): ?>
                <a href="/write" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium transition">
                    Start Writing
                </a>
            <?php endif; ?>

            <?php if(!is_logged_in()): ?>
                <a href="/register" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium transition">
                    Get Started
                </a>
            <?php endif; ?>
            <a href="/posts" class="px-6 py-3 border font-medium border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Explore Posts
            </a>
        </div>
        
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">∞</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Free Forever</div>
            </div>
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">0%</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">No Distractions</div>
            </div>
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">100%</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Your Voice</div>
            </div>
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">∞</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Possibilities</div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <div class="w-6 h-10 border-2 border-gray-300 dark:border-slate-600 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-gray-400 dark:bg-slate-500 rounded-full mt-2 animate-bounce"></div>
            </div>
        </div>
    </div>
</section>