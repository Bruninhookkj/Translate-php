<?php
function traduzirComLibreTranslate($texto, $de = 'en', $para = 'pt') {
    $url = 'https://libretranslate.com/translate';

    $data = [
        'q' => $texto,
        'source' => $de,
        'target' => $para,
        'format' => 'text'
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        return "Erro ao traduzir com LibreTranslate";
    }

    $json = json_decode($response, true);
    return $json['translatedText'] ?? 'Erro na resposta';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $texto = $_POST['texto'] ?? '';
    $traducao = traduzirComLibreTranslate($texto);

    echo "<div style='padding: 20px; font-family: sans-serif;'>";
    echo "<h2>Resultado da Tradução:</h2>";
    echo "<p><strong>Original:</strong> $texto</p>";
    echo "<p><strong>Traduzido:</strong> $traducao</p>";
    echo "<a href='index.html'>Voltar</a>";
    echo "</div>";
} else {
    header("Location: index.html");
}
?>
