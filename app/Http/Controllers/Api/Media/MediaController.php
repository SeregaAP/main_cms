<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        return view('media.index');
    }
    
    public function media_folder()
    {
        return response()->json([
            'success' => true,
            'data' => $this->getFolderTree(public_path()),
        ]);
    }

    private function getFolderTree(string $path): array
    {
        $result = [];

        $exclude = ['vendor', 'storage', 'build', 'hot'];

        foreach (File::directories($path) as $directory) {
            $name = basename($directory);

            if (in_array($name, $exclude)) {
                continue;
            }

            $relativePath = trim(
                str_replace(public_path(), '', $directory),
                '/\\'
            );

            $children = $this->getFolderTree($directory);

            $result[] = [
                'type'         => 'folder',
                'name'         => $name,
                'path'         => $relativePath,
                'has_children' => !empty($children),
                'children'     => $children,
            ];
        }

        return $result;
    }

    public function media_files(Request $request)
    {
        // путь из запроса или public по умолчанию
        $relativePath = trim($request->get('path', ''), '/');
        $basePath = public_path();
    
        $fullPath = $relativePath
            ? realpath($basePath . DIRECTORY_SEPARATOR . $relativePath)
            : $basePath;
    
        // защита
        if (!$fullPath || !str_starts_with($fullPath, $basePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid path',
            ], 403);
        }
    
        if (!File::exists($fullPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Directory not found',
            ], 404);
        }
    
        $files = [];
    
        foreach (File::files($fullPath) as $file) {
            $relative = trim(
                str_replace(public_path(), '', $file->getPathname()),
                '/\\'
            );
    
            $files[] = [
                'name' => $file->getFilename(),
                'path' => $relative,
                'url'  => asset($relative),
                'ext'  => $file->getExtension(),
                'size' => $file->getSize(),
            ];
        }
    
        return response()->json([
            'success' => true,
            'path' => $relativePath ?: '/',
            'data' => $files,
        ]);
    }
}