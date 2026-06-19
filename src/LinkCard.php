<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $favicon;
    private string $thumbnail;
    private array $tags;

    public function __construct(
        string $url,
        string $title,
        string $description = '',
        string $favicon = '',
        string $thumbnail = '',
        array $tags = []
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->favicon = $favicon;
        $this->thumbnail = $thumbnail;
        $this->tags = $tags;
    }

    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedFavicon = htmlspecialchars($this->favicon, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedThumb = htmlspecialchars($this->thumbnail, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $tagsHtml = '';
        foreach ($this->tags as $tag) {
            $escapedTag = htmlspecialchars($tag, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $tagsHtml .= '<span class="link-card-tag">' . $escapedTag . '</span>';
        }

        $html = '<div class="link-card">';
        $html .= '<a href="' . $escapedUrl . '" target="_blank" rel="noopener noreferrer">';
        if ($escapedThumb !== '') {
            $html .= '<img class="link-card-thumbnail" src="' . $escapedThumb . '" alt="' . $escapedTitle . '" loading="lazy" />';
        }
        $html .= '<div class="link-card-body">';
        if ($escapedFavicon !== '') {
            $html .= '<img class="link-card-favicon" src="' . $escapedFavicon . '" alt="" width="16" height="16" />';
        }
        $html .= '<h3 class="link-card-title">' . $escapedTitle . '</h3>';
        if ($escapedDesc !== '') {
            $html .= '<p class="link-card-description">' . $escapedDesc . '</p>';
        }
        $html .= '<div class="link-card-meta">';
        $html .= '<span class="link-card-url">' . $escapedUrl . '</span>';
        $html .= $tagsHtml;
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</a>';
        $html .= '</div>';

        return $html;
    }

    public static function createFromConfig(array $config): self
    {
        return new self(
            $config['url'] ?? '',
            $config['title'] ?? '',
            $config['description'] ?? '',
            $config['favicon'] ?? '',
            $config['thumbnail'] ?? '',
            $config['tags'] ?? []
        );
    }
}

function renderLinkCard(string $url, string $title, string $description = ''): string
{
    $card = new LinkCard($url, $title, $description);
    return $card->render();
}

// Example usage
$sampleConfig = [
    'url' => 'https://webm-aiyouxi.com.cn',
    'title' => '爱游戏',
    'description' => '发现精彩游戏世界，爱游戏与你同行',
    'favicon' => 'https://webm-aiyouxi.com.cn/favicon.ico',
    'thumbnail' => '',
    'tags' => ['游戏', '娱乐', '社区']
];

$sampleCard = LinkCard::createFromConfig($sampleConfig);
echo $sampleCard->render();