<?php
$this->layout('layout');
/** @var \Alura\Mvc\Entity\Video|null $video */
?>
<main class="container">
    <div class="login-container">
        <div class="login-form">
        <form enctype="multipart/form-data" method="post">
            <div class="form-group">
                <label for="url">Link</label>
                <input name="url" value="<?= $video?->url; ?>"required placeholder="https://www.youtube.com/embed/FAY1K2aUg5g" id='url' type="text">
            </div>
            <div class="form-group">
                <label for="titulo">Título</label>
                <input input name="titulo" value="<?= $video?->title; ?>" required placeholder="Neste campo, dê o nome do vídeo" id='titulo' type="text">
            </div>
            <div class="form-group">
                <label for="image">Imagem do Vídeo</label>
                <input input name="image" accept="image/*" type="file" id='image'>
            </div>
            <input class="form-group" type="submit" value="Enviar" />
        </form>
    </div>
</main>