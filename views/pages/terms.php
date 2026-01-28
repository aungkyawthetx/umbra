<?php ob_start(); ?>

<section class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-semibold mb-4">
      Terms and Conditions
    </h1>

    <p class="text-sm text-gray-500 dark:text-gray-400 mb-10">
      Last updated: <?= date('F d, Y') ?>
    </p>

    <!-- Content -->
    <div class="space-y-10 text-gray-700 dark:text-gray-300 leading-relaxed">
      <p>
        Welcome to <strong>Umbra</strong>. By accessing or using this website, you agree
        to be bound by these Terms and Conditions. If you do not agree, please do not
        use the platform.
      </p>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          1. Purpose of Umbra
        </h2>
        <p>
          Umbra is a writing-focused blog platform designed for thoughtful publishing
          and reading. It is not intended to function as a social media platform and
          does not prioritize engagement metrics such as likes, follows, or algorithmic feeds.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          2. User Accounts
        </h2>
        <p>
          To publish content on Umbra, you must create an account. You are responsible
          for maintaining the confidentiality of your account credentials and for all
          activity that occurs under your account.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          3. Content Ownership
        </h2>
        <p>
          You retain full ownership of the content you write and publish on Umbra.
          By publishing content, you grant Umbra a non-exclusive right to display,
          store, and distribute your content within the platform.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          4. Content Guidelines
        </h2>
        <ul class="list-disc pl-6 space-y-2">
          <li>Illegal or harmful content</li>
          <li>Hate speech, harassment, or discrimination</li>
          <li>Copyright or intellectual property violations</li>
          <li>Spam, misleading, or malicious content</li>
        </ul>
        <p class="mt-3">
          We reserve the right to remove content that violates these guidelines.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          5. Public Access & Reading
        </h2>
        <p>
          Published posts may be publicly accessible. Readers may view content
          without creating an account. Author profiles and writings may be visible
          to other users.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          6. Privacy & Data
        </h2>
        <p>
          Umbra collects only the information necessary to provide its services.
          Passwords are securely hashed and never stored in plain text.
          We do not sell user data to third parties.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          7. Platform Availability
        </h2>
        <p>
          Umbra is provided “as is”. We do not guarantee uninterrupted availability,
          error-free operation, or data preservation.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          8. Termination
        </h2>
        <p>
          We reserve the right to suspend or terminate accounts that violate these
          terms. Users may stop using the platform at any time.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          9. Limitation of Liability
        </h2>
        <p>
          Umbra is not responsible for user-generated content, opinions expressed
          by writers, or any loss resulting from the use of the platform.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          10. Changes to These Terms
        </h2>
        <p>
          These Terms and Conditions may be updated from time to time.
          Continued use of Umbra constitutes acceptance of the updated terms.
        </p>
      </section>

      <section>
        <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">
          11. Contact
        </h2>
        <p>
          If you have any questions about these Terms and Conditions,
          please contact: aungkyawthethimself@gmail.com
        </p>
      </section>

      <p class="pt-10 text-sm text-gray-500 dark:text-gray-400 italic">
        Umbra
      </p>
    </div>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';

