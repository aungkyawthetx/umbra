<?php ob_start(); ?>

<div class="min-h-[70vh] flex items-center justify-center">
    <form method="POST" class="w-full max-w-md bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-xl p-8 shadow-sm">
        <?= csrf_field() ?>
        <h1 class="text-2xl font-semibold mb-8 text-center">
            Welcome back
        </h1>

        <!-- Email -->
        <div class="mb-5">
            <label class="block text-sm mb-2 text-gray-600 dark:text-gray-400">
                Email
            </label>
            <input 
                type="email" 
                name="email" 
                class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Enter your email"
                required
            >
        </div>

        <!-- Password -->
        <div class="mb-8">
            <label class="block text-sm mb-2 text-gray-600 dark:text-gray-400">
                Password
            </label>
            <input 
                type="password" 
                name="password"
                class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Enter your password"
                required
            >
        </div>

        <button class="w-full bg-blue-400 hover:bg-blue-500 text-white py-3 rounded-lg font-medium transition cursor-pointer">
            Login
        </button>

        <p class="text-sm text-center text-gray-500 dark:text-gray-400 mt-6">
            Don't have an account?
            <a href="/register" class="text-blue-400 hover:underline">
                Register
            </a>
        </p>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';

