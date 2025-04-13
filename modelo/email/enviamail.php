<?php

require 'src/SMTP.php';
require 'src/Exception.php';
require 'src/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviaEmail($dados, $tipo = 'atualizacao') {
    // Captura dados úteis
    $paciente = $dados['NOME_PACIENTE'] ?? 'Paciente';
    $data = !empty($dados['data_remocao']) ? date('d/m/Y', strtotime($dados['data_remocao'])) : 'Data não informada';

    // Define título baseado no tipo
    $tituloTexto = $tipo === 'cadastro' 
        ? "🆕 Nova Remoção • $paciente • $data"
        : "🔄 Remoção Atualizada • $paciente • $data";

    // Corpo do e-mail (HTML)
    $mensagem = "<h3>$tituloTexto</h3><ul style='font-family: Arial'>";
    foreach ($dados as $campo => $valor) {
        $rotulo = ucwords(strtolower(str_replace('_', ' ', $campo)));
        $mensagem .= "<li><strong>$rotulo:</strong> $valor</li>";
    }
    $mensagem .= "</ul>";

    // Cria e envia o e-mail
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'localizameucarro@gmail.com';
        $mail->Password   = 'gyut xblm fhop zhuf'; // senha de app do Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('localizameucarro@gmail.com', 'Sistema Transmedi');
        $mail->addAddress('falecompedro01@gmail.com', 'Responsável');

        $mail->isHTML(true);
        // Corrige codificação do assunto (UTF-8 com base64)
        $mail->Subject = "=?UTF-8?B?" . base64_encode($tituloTexto) . "?=";
        $mail->Body    = $mensagem;
        $mail->AltBody = strip_tags(str_replace(['<br>', '<li>','</li>'], ["\n", "- ", "\n"], $mensagem));

        if ($mail->send()) {
            error_log('✅ E-mail enviado com sucesso!');
        } else {
            error_log('❌ Erro ao enviar e-mail: ' . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        error_log("❌ Exceção ao enviar e-mail: {$mail->ErrorInfo}");
    }
}
