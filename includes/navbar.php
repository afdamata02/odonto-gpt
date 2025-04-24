<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<nav class="navbar">
    <div class="container">
        <a href="index.php" class="navbar-brand">Odonto-GPT</a>
        <?php if (isset($_SESSION['usuario_logado'])): ?>
            <div style="float: right;">
                <a href="cadastro_paciente.php" class="btn btn-light" style="margin-right: 10px;">Cadastrar Paciente</a>
                <a href="agendar_consulta.php" class="btn btn-light" style="margin-right: 10px;">Agendar Consulta</a>
                <a href="registrar_pagamento.php" class="btn btn-light" style="margin-right: 10px;">Registrar Pagamento</a>
                <a href="logout.php" class="btn btn-danger">Sair</a>
            </div>
        <?php endif; ?>
    </div>
</nav> 