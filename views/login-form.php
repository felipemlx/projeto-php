<?php
$this->layout('layout');
?>
    <main class="container">
        <div class="login-container">
            <div class="login-form">
            <form method="post">
                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input input name="email" type="email" required
                        placeholder="Digite seu usuário" id='usuario'>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="password" required placeholder="Digite sua senha"
                        id='senha'>
                </div>
                <div class="form-group">
                    <input type="submit" value="Entrar">
                </div>
                <div class="form-group">
                <p class="forgot-password"><a href="#">Esqueceu sua senha?</a></p>
            </div>
            </form>
        </div>
    </main>