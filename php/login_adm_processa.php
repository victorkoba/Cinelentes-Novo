<?php
session_start();
include 'conexao.php'; // Inclua o arquivo que conecta ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['senha'];

    // Consulta para verificar se o email existe no banco de dados
    $sql = "SELECT * FROM administradores WHERE email_adm = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Se o email foi encontrado no banco de dados
        if ($result && $result->num_rows > 0) {
            $adm = $result->fetch_assoc();

            // Verificando a senha com password_verify
            if (password_verify($password, $adm['senha_adm'])) {
                // Login válido
                $_SESSION['administrador'] = $adm['email_adm'];
                $_SESSION['id_usuario'] = $adm['id_adm'];

                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function(){
                            Swal.fire({
                                title: 'Login realizado com sucesso!',
                                icon: 'success',
                                confirmButtonText: 'Continuar'
                            }).then(function() {
                                window.location.href = 'pagina-inicial-adm.php'; // Redireciona para a página inicial do admin
                            });
                        });
                      </script>";
                exit;
            }
        }

        // Se o email ou senha estiverem errados
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function(){
                    Swal.fire({
                        title: 'Email ou senha incorretos!',
                        icon: 'error',
                        confirmButtonText: 'Tentar novamente'
                    }).then(function() {
                        window.location.href = 'login_adm.php'; // Redireciona para o login
                    });
                });
              </script>";

        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta.";
    }

    $conexao->close();
}
?>
