<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetingsController extends Controller
{
    public function index()
    {
        $pageTitle = 'Настройки';
        $buttons = [];
        
        // Получаем текущую локаль из настроек
        $locale = Setting::where('key', 'site_locale')->first()?->value ?? config('app.fallback_locale', 'ru');

        // Передаем список документов
        $documents = Document::all();

        // Получаем главную страницу
        $home = Setting::where('key', 'site_start')->first()?->value;

        return view('setings.index', compact('pageTitle', 'buttons', 'documents', 'home', 'locale'));
    }

    public function setHome(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id'
        ]);

        Setting::updateOrCreate(
            ['key' => 'site_start'],
            ['value' => $request->document_id]
        );

        return back()->with('success', 'Главная страница обновлена!');
    }

    public function setLocale(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:ru,en,kz'
        ]);

        $locale = $request->input('locale');

        // Сохраняем язык в таблице settings
        Setting::updateOrCreate(
            ['key' => 'site_locale'],
            ['value' => $locale]
        );

        // Не нужно устанавливать app()->setLocale() здесь, 
        // так как middleware сделает это для следующего запроса

        return back()->with('success', 'Язык изменён на ' . $this->getLocaleName($locale));
    }

    /**
     * Получить название языка для сообщения
     */
    private function getLocaleName($locale)
    {
        $locales = [
            'ru' => 'Русский',
            'en' => 'English', 
            'kz' => 'Қазақша'
        ];

        return $locales[$locale] ?? $locale;
    }
}