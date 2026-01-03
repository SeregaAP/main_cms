<?php
namespace App\Services;

use Illuminate\Support\Facades\Blade;
use App\Models\TvForm; 
use App\Services\TvService;
use App\Models\Document;

class DocumentContentRenderer
{
    protected TvService $tvService;

    public function __construct(TvService $tvService)
    {
        $this->tvService = $tvService;
    }

    /**
     * Обработать контент документа в зависимости от его формата.
     * Возвращает массив: [контент, contentType].
     */
    public function render(string $content, Document $document): array
    {
        // Получаем TV значения документа в виде ['name' => 'value']
        $tv = $this->tvService->getTvValuesByName($document);
    
        // Добавляем их в объект документа, если нужно
        $document->tv = $tv;
    
        $format = strtolower($document->format);
    
        // Передаем и document, и tv в Blade
        $data = [
            'document' => $document,
            'tv' => $tv,
        ];
    
        $processedContent = $this->processContentByFormat($content, $document, $format, $data);
        $contentType = $this->getContentType($processedContent, $format);
    
        return [$processedContent, $contentType];
    }

    /**
     * Обрабатываем контент по формату.
     */
    protected function processContentByFormat(string $content, Document $document, string $format, array $data): string
{
    switch ($format) {
        case 'html':
        case 'htm':
            return $this->renderBladeContent($content, $data);

        case 'txt':
        case 'text':
            return strip_tags($content);

        case 'xml':
            return $this->convertToXml($content, $document);

        case 'json':
            return $this->convertToJson($content, $document);

        default:
            return $this->containsHtml($content)
                ? $this->renderBladeContent($content, $data)
                : strip_tags($content);
    }
}

    protected function renderBladeContent(string $content, array $data): string
    {
        $hasBladeDirectives = preg_match('/\{\{.*?\}\}|\{!!.*?!!\}|@[a-zA-Z]+/', $content);

        if ($hasBladeDirectives) {
            try {
                return Blade::render($content, [
                    'document' => $data['document'] ?? null,
                    'tv' => $data['tv'] ?? [],
                ]);
            } catch (\Throwable $e) {
                \Log::error('Blade compilation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'content_sample' => substr($content, 0, 200)
                ]);
                return $content;
            }
        }

        return $content;
    }

    protected function convertToXml(string $content, Document $document): string
    {
        try {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><document/>');
            $xml->addAttribute('id', (string)($document->id ?? ''));
            $xml->addAttribute('name', (string)($document->name ?? ''));

            $meta = $xml->addChild('meta');
            $meta->addChild('created_at', (string)($document->created_at ?? now()));
            $meta->addChild('updated_at', (string)($document->updated_at ?? now()));

            $contentNode = $xml->addChild('content');
            $this->addCdata($contentNode, $content);

            return $xml->asXML();
        } catch (\Throwable $e) {
            \Log::error('XML conversion failed', ['error' => $e->getMessage()]);
            return '<?xml version="1.0" encoding="UTF-8"?><error>Failed to generate XML</error>';
        }
    }

    protected function addCdata(\SimpleXMLElement $node, string $cdata)
    {
        $dom = dom_import_simplexml($node);
        $dom->appendChild($dom->ownerDocument->createCDATASection($cdata));
    }

    protected function convertToJson(string $content, Document $document): string
    {
        $data = [
            'document' => [
                'id' => $document->id,
                'name' => $document->name,
                'format' => $document->format,
                'created_at' => $document->created_at,
                'updated_at' => $document->updated_at,
            ],
            'content' => $content,
            'tv' => $document->tv ?? [],
        ];

        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    protected function containsHtml(string $string): bool
    {
        return $string !== strip_tags($string) || preg_match('/<[a-z][\s\S]*>/i', $string);
    }

    protected function getContentType(string $content, string $format): string
    {
        return match ($format) {
            'txt', 'text' => 'text/plain; charset=utf-8',
            'xml' => 'application/xml; charset=utf-8',
            'html', 'htm' => 'text/html; charset=utf-8',
            'json' => 'application/json; charset=utf-8',
            default => $this->containsHtml($content) ? 'text/html; charset=utf-8' : 'text/plain; charset=utf-8',
        };
    }
}