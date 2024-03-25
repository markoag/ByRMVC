<?php require __DIR__ . '/../../includes/templates/datos.php'; ?>

<main class="contenedor seccion contenido-centrado">
    <h3>Nuestro Blog</h3>

    <?php
    foreach($entradas as $entrada) {
    ?>
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/<?php echo $entrada['imagen']; ?>.webp" type="image/webp">
                    <source srcset="build/img/<?php echo $entrada['imagen']; ?>.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/<?php echo $entrada['imagen']; ?>.jpg" alt="Texto Entrada Blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="/entrada">
                    <h4><?php echo $entrada['titulo']; ?></h4>
                    <p>Escrito el: <span><?php echo $entrada['fecha']; ?></span> por: <span><?php echo $entrada['autor']; ?></span> </p>

                    <p>
                        <?php echo $entrada['contenido']; ?>
                    </p>
                </a>
            </div>
        </article>
    <?php
    }
    ?>
</main>