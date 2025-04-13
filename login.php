<?php
// login.php
session_start();
$conn = mysqli_connect('localhost', 'root', 'maxwell1983', 'sistema_remocao');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($conn, $query);
    $dados = mysqli_fetch_assoc($result);

    if ($dados && password_verify($senha, $dados['senha'])) {
        $_SESSION['usuario_id'] = $dados['id'];
        $_SESSION['usuario_nome'] = $dados['usuario'];
        $_SESSION['usuario_nivel'] = $dados['nivel'];
        header('Location: index.php');
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
        <div class="card">
                <div class="card-body text-center">
                    <img src="transmedi.png" class="img-fluid mb-3" alt="Logo do sistema">
                    <?php if (isset($erro)) echo "<div class='alert alert-danger'>$erro</div>"; ?>
                    <form method="post">
                        <div class="mb-3 text-start">
                            <label class="form-label">Usuário</label>
                            <input type="text" name="usuario" class="form-control" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>
                        <button class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
