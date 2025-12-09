<?php

namespace App\Http\Controllers\media\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MediaApiController extends Controller
{
    // -----------------------
    // 1. Дерево
    // -----------------------
    public function tree(Request $request)
    {
        $path = $request->query('path', '');
        $base = storage_path('app/public');
        $full = $path ? $base . '/' . $path : $base;

        if (!File::exists($full)) {
            return response()->json(['error' => 'Directory not found'], 404);
        }

        return response()->json($this->scan($full));
    }

    private function scan($dir)
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
                'children' => $this->scan($directory)
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

    // -----------------------
    // 2. Создание папки
    // -----------------------
    public function createFolder(Request $request)
    {
        $request->validate([
            'path' => 'nullable|string',
            'folder' => 'required|string'
        ]);

        $base = storage_path('app/public');
        $targetDir = rtrim($base . '/' . ($request->path ?? ''), '/');
        $full = $targetDir . '/' . $request->folder;

        if (File::exists($full)) {
            return response()->json(['success' => false, 'message' => 'Folder exists']);
        }

        File::makeDirectory($full, 0777, true);

        return response()->json(['success' => true]);
    }

    // -----------------------
    // 3. Удаление папки
    // -----------------------
    public function deleteFolder(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        $full = storage_path('app/public/' . $request->path);

        if (!File::isDirectory($full)) {
            return response()->json(['success' => false, 'message' => 'Folder not found']);
        }

        File::deleteDirectory($full);

        return response()->json(['success' => true]);
    }

    // -----------------------
    // 4. Переименование
    // -----------------------
    public function renameFolder(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
            'newName' => 'required|string'
        ]);

        $full = storage_path('app/public/' . $request->path);
        $newPath = storage_path('app/public/' . dirname($request->path) . '/' . $request->newName);

        if (!File::exists($full)) {
            return response()->json(['success' => false, 'message' => 'Folder not found']);
        }

        File::move($full, $newPath);

        return response()->json(['success' => true]);
    }

    // -----------------------
    // 5. Загрузка файла
    // -----------------------
    /*public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'nullable|string'
        ]);

        $path = $request->path ?? '';

        $stored = $request->file('file')->store($path, 'public');

        return response()->json([
            'success' => true,
            'path' => $stored
        ]);
    }*/
        /*
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'nullable|string'
        ]);
    
        $path = $request->path ?? '';
    
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName(); // <-- имя как у пользователя
    
        // сохраняем файл с исходным именем
        $stored = $file->storeAs($path, $originalName, 'public');
    
        return response()->json([
            'success' => true,
            'path' => $stored
        ]);
    }*/
        public function uploadFile(Request $request)
{
    $request->validate([
        'file' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
        'path' => 'nullable|string'
    ]);

    $path = $request->path ?? '';
    
    $file = $request->file('file');
    
    // 1. Берем оригинальное имя
    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $extension = $file->getClientOriginalExtension();
    
    // 2. Транслитерируем кириллицу и убираем спецсимволы
    $originalName = $this->transliterate($originalName);
    
    // 3. Заменяем пробелы и спецсимволы
    $safeName = preg_replace('/[^A-Za-z0-9_-]/', '-', $originalName);
    $safeName = preg_replace('/-+/', '-', $safeName); // убираем двойные дефисы
    $safeName = trim($safeName, '-');
    
    // 4. Приводим к нижнему регистру
    $safeName = strtolower($safeName);
    
    // 5. Если имя пустое после очистки
    if (empty($safeName)) {
        $safeName = 'image';
    }
    
    // 6. Генерируем уникальное имя (чтобы не перезаписать существующий файл)
    $filename = $safeName . '-' . time() . '.' . strtolower($extension);
    
    // Альтернатива: использовать хэш
    // $filename = md5($safeName . time()) . '.' . strtolower($extension);
    
    // 7. Сохраняем файл
    $storedPath = $file->storeAs($path, $filename, 'public');
    
    // 8. Получаем полный URL
    $fullUrl = asset('storage/' . $storedPath);
    
    return response()->json([
        'success' => true,
        'path' => $storedPath,
        'filename' => $filename,
        'url' => $fullUrl,
        'original_name' => $file->getClientOriginalName()
    ]);
}

// Функция для транслитерации
private function transliterate($string)
{
    $translit = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
        'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
        'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
        'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
        'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
        'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch',
        'Ш' => 'Sh', 'Щ' => 'Sch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
        'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
    ];
    
    return strtr($string, $translit);
}



}