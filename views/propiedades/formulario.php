<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo Propiedad"
        value="<?php echo s($propiedad->titulo) ?>">

    <label for="precio">Precio</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio Propiedad"
        value="<?php echo s($propiedad->precio) ?>">

    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

    <?php if ($propiedad->imagen): ?>
        <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="propiedad[descripcion]" maxlength="200"><?php echo s($propiedad->descripcion) ?></textarea>

</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9"
        value="<?php echo s($propiedad->habitaciones) ?>">

    <label for="bano">Baños</label>
    <input type="number" id="bano" name="propiedad[bano]" placeholder="Ej: 3" min="1" max="9"
        value="<?php echo s($propiedad->bano) ?>">

    <label for="estacionamiento">Estacionamientos</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 3" min="1" max="9"
        value="<?php echo s($propiedad->estacionamiento) ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedorID]" id="vendedor">
        <option value="" selected disabled>-- Seleccione --</option>
        <?php foreach ($vendedores as $vendedor): ?>
            <option <?php echo $propiedad->vendedorID === $vendedor->id ? 'selected' : ''; ?>
                value="<?php echo s($vendedor->id) ?>">
                <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?>
            </option>
        <?php endforeach; ?>
    </select>
</fieldset>