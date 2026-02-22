<?php

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Core/Database.php';

class UserController extends Controller
{
  public function terms()
  {
    $this->view('pages/terms');
  }

  public function robots()
  {
    header('Content-Type: text/plain; charset=UTF-8');

    $base = base_url();
    echo "User-agent: *\n";
    echo "Allow: /\n";
    echo "Disallow: /login\n";
    echo "Disallow: /register\n";
    echo "Disallow: /write\n";
    echo "Disallow: /blog/edit\n";
    echo "Disallow: /notifications\n";
    echo "Disallow: /reading-list\n";
    echo "Disallow: /profile\n";
    echo "\n";
    echo "Sitemap: " . $base . "/sitemap.xml\n";
  }

  public function sitemap()
  {
    header('Content-Type: application/xml; charset=UTF-8');

    $db = Database::connect();
    $base = base_url();

    $static = [
      ['loc' => $base . '/', 'changefreq' => 'daily', 'priority' => '1.0', 'lastmod' => date('c')],
      ['loc' => $base . '/posts', 'changefreq' => 'daily', 'priority' => '0.9', 'lastmod' => date('c')],
      ['loc' => $base . '/terms-and-conditions', 'changefreq' => 'yearly', 'priority' => '0.3', 'lastmod' => date('c')]
    ];

    $postsStmt = $db->query("
      SELECT id, updated_at, created_at
      FROM posts
      WHERE status = 'published' OR (status = 'scheduled' AND scheduled_at <= NOW())
      ORDER BY COALESCE(updated_at, created_at) DESC
    ");
    $posts = $postsStmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

    foreach ($static as $url) {
      echo "  <url>\n";
      echo "    <loc>" . htmlspecialchars($url['loc'], ENT_QUOTES, 'UTF-8') . "</loc>\n";
      echo "    <lastmod>" . htmlspecialchars($url['lastmod'], ENT_QUOTES, 'UTF-8') . "</lastmod>\n";
      echo "    <changefreq>" . htmlspecialchars($url['changefreq'], ENT_QUOTES, 'UTF-8') . "</changefreq>\n";
      echo "    <priority>" . htmlspecialchars($url['priority'], ENT_QUOTES, 'UTF-8') . "</priority>\n";
      echo "  </url>\n";
    }

    foreach ($posts as $post) {
      $lastmod = $post['updated_at'] ?: $post['created_at'];
      echo "  <url>\n";
      echo "    <loc>" . htmlspecialchars($base . '/blog/' . (int)$post['id'], ENT_QUOTES, 'UTF-8') . "</loc>\n";
      if (!empty($lastmod)) {
        echo "    <lastmod>" . htmlspecialchars(date('c', strtotime($lastmod)), ENT_QUOTES, 'UTF-8') . "</lastmod>\n";
      }
      echo "    <changefreq>weekly</changefreq>\n";
      echo "    <priority>0.8</priority>\n";
      echo "  </url>\n";
    }

    echo "</urlset>";
  }
}
