<?php

namespace App\Http\Controllers\media; // с маленькой буквы

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\MediaFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class MediaController extends Controller
{
    public function index($path = null)
    {
        $pageTitle = __('bar_menu_file');
        $buttons = [
            [
                'href'  => route('templates.create'),
                'label' => __('add_template'), // ключ label соответствует Blade
                'class' => 'btn btn-secondary'
            ]
        ];

        $basePath = $path ? base_path($path) : storage_path('app/public');

        $trees = $this->scanDirectory($basePath);
        $trees = json_decode(json_encode($trees));
        //dd($trees);
        return view('media.index', compact(
            'pageTitle', 
            'buttons',
            'trees'
        ));
    }

    private function scanDirectory($dir)
    {
        $result = [];
        $basePath = storage_path('app/public'); // базовая директория
    
        foreach (\Illuminate\Support\Facades\File::directories($dir) as $directory) {
            // Сохраняем относительный путь вместо абсолютного
            $relativePath = str_replace($basePath, '', $directory);
            $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
            
            $result[] = (object)[
                'type' => 'directory',
                'name' => basename($directory),
                'path' => $relativePath, // сохраняем относительный путь
                'children' => $this->scanDirectory($directory)
            ];
        }
    
        foreach (\Illuminate\Support\Facades\File::files($dir) as $file) {
            $filePath = $file->getPathname();
            $relativePath = str_replace($basePath, '', $filePath);
            $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
            
            $result[] = (object)[
                'type' => 'file',
                'name' => $file->getFilename(),
                'path' => $relativePath,
                'url' => \Illuminate\Support\Facades\Storage::url($relativePath)
            ];
        }
        return $result;
    }
    
    

}