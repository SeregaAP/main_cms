<?php

namespace App\Helpers;

use App\Models\Document;

class SitemapHelper {
    public static function generate() {
        $docs = Document::where('published', 1)->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($docs as $doc) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(url($doc->uri)) . '</loc>';
            $xml .= '<lastmod>' . date('c', strtotime($doc->updated_at)) . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.5</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }
}