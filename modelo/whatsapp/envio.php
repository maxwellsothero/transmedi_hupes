<?php

function enviazap($dados, $tipo = 'atualizacao') {
    $numero = '5571996933777'; // Seu número WhatsApp com DDI

    // Define o título com base no tipo
    $titulo = $tipo === 'cadastro' 
        ? "🆕 *Nova Remoção Cadastrada!*" 
        : "🔄 *Remoção Atualizada!*";

    $mensagem = "$titulo\n\n";

    foreach ($dados as $campo => $valor) {
        $rotulo = ucwords(strtolower(str_replace('_', ' ', $campo)));
        $mensagem .= "• *$rotulo*: $valor\n";
    }

    $payload = [
        "number" => $numero,
        "options" => [
            "delay" => 100,
            "presence" => "composing"
        ],
        "text" => $mensagem
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.localizameucarro.online/message/sendText/agiliza_zap",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "apikey: 6F6836494F8B-4DB3-B206-D37A66E2C40F"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        error_log("Erro ao enviar zap: $err");
    } else {
        error_log("Zap enviado: $response");
    }
}

