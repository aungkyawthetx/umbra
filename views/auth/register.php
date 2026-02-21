<?php ob_start(); ?>

<div class="min-h-[72vh] flex items-center justify-center py-6">
    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 overflow-hidden rounded-3xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800 shadow-xl shadow-gray-200/50 dark:shadow-black/20">
        <div class="hidden lg:flex flex-col justify-between bg-gradient-to-br from-blue-900 via-slate-900 to-slate-800 text-white p-10">
            <div>
                <p class="inline-flex items-center rounded-full border border-white/20 px-3 py-1 text-xs tracking-wide uppercase">
                    Join Umbra
                </p>
                <h2 class="mt-5 text-3xl font-semibold leading-tight">
                    Start publishing with a professional identity
                </h2>
                <p class="mt-4 text-sm text-blue-100/90 leading-relaxed">
                    Create your account to write, organize your content, and grow a meaningful audience.
                </p>
            </div>
            <p class="text-xs text-blue-100/80">
                Built for writers who value clarity.
            </p>
        </div>

        <form method="POST" class="p-7 sm:p-10">
            <?= csrf_field() ?>

            <div class="mb-8">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-300">Create Account</p>
                <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">Set up your profile</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Create your account in a few steps.</p>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <input
                        name="name"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-900 px-4 py-3 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900/60"
                        placeholder="Your Name"
                        required
                        autocomplete="name"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                    <input
                        name="username"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-900 px-4 py-3 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900/60"
                        placeholder="yourname123"
                        pattern="^[A-Za-z0-9_]+$"
                        title="Username can contain only letters, numbers, and underscores (no spaces)."
                        required
                        autocomplete="username"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-900 px-4 py-3 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900/60"
                        placeholder="you@example.com"
                        required
                        autocomplete="email"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-900 px-4 py-3 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 shadow-sm focus:border-blue-500 dark:focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900/60"
                        placeholder="Create a secure password"
                        required
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <p class="mt-5 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                By registering, you agree to our
                <a href="/terms-and-conditions" class="font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                    Terms and Conditions
                </a>.
            </p>

            <button class="mt-6 w-full rounded-xl bg-blue-600 py-3 font-semibold text-white shadow-md transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-900/70 cursor-pointer">
                Create Account
            </button>

            <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                Already have an account?
                <a href="/login" class="font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                    Sign in
                </a>
            </p>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';

