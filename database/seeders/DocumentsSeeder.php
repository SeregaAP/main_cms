<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentsSeeder extends Seeder
{
    /**
     * Массив документов с вашими полями
     */
    private function getDocuments()
    {
        return [
            // Главная страница
            [
                'id' => 1,
                'title' => 'Главная страница',
                'meta_title' => 'Главная | Интернет-магазин',
                'meta_description' => 'Добро пожаловать в наш интернет-магазин. Лучшие товары по выгодным ценам.',
                'alias' => 'index',
                'content' => '<h1>Добро пожаловать!</h1><p>Это главная страница вашего сайта.</p>',
                'parent_id' => null,
                'position' => 1,
                'published' => true,
                'show_in_menu' => true,
                'format' => 'html',
                'type' => 'document',
                'uri' => '/',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // О компании
            [
                'id' => 2,
                'title' => 'О компании',
                'meta_title' => 'О нашей компании | История и достижения',
                'meta_description' => 'Узнайте больше о нашей компании, наших ценностях и истории развития.',
                'alias' => 'about',
                'content' => '<h1>О нашей компании</h1><p>Мы работаем на рынке с 2010 года.</p>',
                'parent_id' => null,
                'position' => 2,
                'published' => true,
                'show_in_menu' => true,
                'format' => 'html',
                'type' => 'document',
                'uri' => '/about',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // Каталог товаров (категория)
            [
                'id' => 3,
                'title' => 'Каталог товаров',
                'meta_title' => 'Каталог товаров | Интернет-магазин',
                'meta_description' => 'Полный каталог всех товаров нашего магазина с ценами и описаниями.',
                'alias' => 'catalog',
                'content' => '<h1>Каталог товаров</h1><p>Выберите интересующую вас категорию.</p>',
                'parent_id' => null,
                'position' => 3,
                'published' => true,
                'show_in_menu' => true,
                'format' => 'html',
                'type' => 'category',
                'uri' => '/catalog',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // Электроника (подкатегория)
            [
                'id' => 4,
                'title' => 'Электроника',
                'meta_title' => 'Электроника | Смартфоны, ноутбуки, планшеты',
                'meta_description' => 'Широкий выбор электроники: смартфоны, ноутбуки, планшеты и аксессуары.',
                'alias' => 'electronics',
                'content' => '<h2>Электроника</h2><p>Все виды электронных устройств.</p>',
                'parent_id' => 3, // Дочерняя для Каталога
                'position' => 1,
                'published' => true,
                'show_in_menu' => true,
                'format' => 'html',
                'type' => 'category',
                'uri' => '/catalog/electronics',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // Смартфоны (подкатегория)
            [
                'id' => 5,
                'title' => 'Смартфоны',
                'meta_title' => 'Смартфоны | Apple, Samsung, Xiaomi купить',
                'meta_description' => 'Купить смартфон Apple iPhone, Samsung Galaxy, Xiaomi по лучшей цене.',
                'alias' => 'smartphones',
                'content' => '<h3>Смартфоны</h3><p>Современные смартфоны всех брендов.</p>',
                'parent_id' => 4, // Дочерняя для Электроники
                'position' => 1,
                'published' => true,
                'show_in_menu' => true,
                'format' => 'html',
                'type' => 'category',
                'uri' => '/catalog/electronics/smartphones',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // Пример товара
            [
                'id' => 6,
                'title' => 'iPhone 15 Pro 256GB',
                'meta_title' => 'Купить iPhone 15 Pro 256GB | Цена и характеристики',
                'meta_description' => 'Apple iPhone 15 Pro 256GB в титановом корпусе. Камера 48Мп, процессор A17 Pro.',
                'alias' => 'iphone-15-pro-256gb',
                'content' => '<h1>iPhone 15 Pro 256GB</h1><p>Новейший флагманский смартфон от Apple.</p>',
                'parent_id' => 5, // Дочерняя для Смартфоны
                'position' => 1,
                'published' => true,
                'show_in_menu' => false,
                'format' => 'html',
                'type' => 'product',
                'uri' => '/catalog/electronics/smartphones/iphone-15-pro-256gb',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // Контакты
            [
                'id' => 7,
                'title' => 'Контакты',
                'meta_title' => 'Контакты | Адрес, телефон, email',
                'meta_description' => 'Контактная информация нашего магазина: адрес, телефон, email, режим работы.',
                'alias' => 'contacts',
                'content' => '<h1>Контакты</h1><p>Телефон: +7 (999) 123-45-67</p>',
                'parent_id' => null,
                'position' => 4,
                'published' => true,
                'show_in_menu' => true,
                'format' => 'html',
                'type' => 'document',
                'uri' => '/contacts',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // XML фид товаров
            [
                'id' => 8,
                'title' => 'XML фид товаров',
                'meta_title' => null,
                'meta_description' => null,
                'alias' => 'products.xml',
                'content' => null,
                'parent_id' => null,
                'position' => 100,
                'published' => true,
                'show_in_menu' => false,
                'format' => 'xml',
                'type' => 'document',
                'uri' => '/products.xml',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // JSON API
            [
                'id' => 9,
                'title' => 'JSON API каталога',
                'meta_title' => null,
                'meta_description' => null,
                'alias' => 'api-catalog.json',
                'content' => null,
                'parent_id' => null,
                'position' => 101,
                'published' => true,
                'show_in_menu' => false,
                'format' => 'txt', // или 'json', если есть в enum
                'type' => 'document',
                'uri' => '/api/catalog.json',
                'is_cache' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
    }
    
    public function run()
    {
        $this->command->info('🔄 Создание документов...');
        
        $documents = $this->getDocuments();
        $inserted = 0;
        
        foreach ($documents as $document) {
            // Проверяем, существует ли уже документ с таким ID
            $exists = DB::table('documents')->where('id', $document['id'])->exists();
            
            if (!$exists) {
                DB::table('documents')->insert($document);
                $inserted++;
                $this->command->info("✓ {$document['title']} ({$document['type']})");
            } else {
                $this->command->info("⏭ Пропущен (ID {$document['id']} уже существует): {$document['title']}");
            }
        }
        
        $this->command->info("\n✅ Готово! Добавлено документов: {$inserted}");
        $this->showDocumentsTree();
    }
    
    /**
     * Показать дерево документов
     */
    private function showDocumentsTree()
    {
        $this->command->info("\n📁 Структура документов:");
        
        $documents = DB::table('documents')
            ->orderBy('position')
            ->get();
        
        // Группируем по parent_id для построения дерева
        $tree = [];
        foreach ($documents as $doc) {
            $tree[$doc->parent_id ?? 0][] = $doc;
        }
        
        // Рекурсивная функция отображения
        $this->printTree($tree, 0, 0);
    }
    
    private function printTree($tree, $parentId, $level)
    {
        if (!isset($tree[$parentId])) {
            return;
        }
        
        foreach ($tree[$parentId] as $doc) {
            $indent = str_repeat('  ', $level);
            $typeIcon = match($doc->type) {
                'product' => '🛒',
                'category' => '📁',
                default => '📄'
            };
            
            $cacheIcon = $doc->is_cache ? '⚡' : '⏳';
            $menuIcon = $doc->show_in_menu ? '📋' : '';
            
            $this->command->line("{$indent}{$typeIcon} {$cacheIcon} {$menuIcon} {$doc->title}");
            
            // Рекурсивно выводим детей
            $this->printTree($tree, $doc->id, $level + 1);
        }
    }
}