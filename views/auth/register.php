<?php ob_start(); ?>

<div class="min-h-[70vh] flex items-center justify-center">
    <form method="POST"
          class="w-full max-w-md bg-white dark:bg-slate-800
                 border border-gray-200 dark:border-gray-700
                 rounded-xl p-8 shadow-sm">
        <?= csrf_field() ?>

        <h1 class="text-2xl font-semibold mb-8 text-center">
            Create account
        </h1>

        <div class="mb-5">
          <label class="block text-sm mb-2 text-gray-600 dark:text-gray-400">
            Full Name
          </label>
          <input 
            name="name"
            class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="Your Name"
            required
          >
        </div>

        <!-- Username -->
        <div class="mb-5">
          <label class="block text-sm mb-2 text-gray-600 dark:text-gray-400">
            Username
          </label>
          <input 
            name="username"
            class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400"
            placeholder="yourname123"
            required
          >
        </div>

        <!-- Email -->
        <div class="mb-5">
            <label class="block text-sm mb-2 text-gray-600 dark:text-gray-400">
                Email
            </label>
            <input 
                type="email" 
                name="email" 
                class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Your Email"
                required
            >
        </div>

        <!-- Password -->
        <div class="mb-2">
            <label class="block text-sm mb-2 text-gray-600 dark:text-gray-400">
                Password
            </label>
            <input 
                type="password" 
                name="password" 
                class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Password"
                required
            >
        </div>

        <p class="text-sm text-gray-500 dark:text-gray-400 text-center my-3 text-start">
            By registering, you agree to our
            <a href="/terms-and-conditions"
                class="text-blue-400 hover:text-blue-500 hover:underline font-medium">
                Terms and Conditions
            </a>.
        </p>


        <button class="w-full bg-blue-400 hover:bg-blue-500 text-white py-3 rounded-lg font-medium transition cursor-pointer">
            Register
        </button>

        <p class="text-sm text-center text-gray-500 dark:text-gray-400 mt-6">
            Already have an account?
            <a href="/login" class="text-blue-400 hover:underline">
                Login
            </a>
        </p>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';

