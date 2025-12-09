<?php
use App\Models\Document;

if (!function_exists('docUrl')) {
    function docUrl($id) {
        $doc = Document::find($id);
        return $doc ? url($doc->uri) : '#';
    }
}