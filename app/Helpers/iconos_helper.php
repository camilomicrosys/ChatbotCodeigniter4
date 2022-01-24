<?php

function iconos()
{
    $iconoEnblanco       = "<i title='' class=''></i>";
    $iconoEditar         = " <i title='Editar' class='fas fa-edit'></i>";
    $iconoAtras          = " <i title='Regresar' class='fas fa-angle-double-left'></i>";
    $iconoGuardar        = " <i title='Guardar Datos' class='fas fa-save'></i>";
    $iconoCerrar         = " <i title='Cerrar' class='far fa-window-close'></i>";
    $iconoEliminar       = "<i title='Eliminar' class='fas fa-trash-alt'></i>";
    $iconoListar         = "<i title='Gestionar' class='fas fa-clipboard-list'></i>";
    $iconoAgregarPersona = "<i title='Crear Nuevo' class='fas fa-user-plus'></i>";
    $iconoAgregar        = "<i title='Crear Nuevo' class='fas fa-folder-plus'></i>";
    $iconoCrearModal     = "<i title='Crear Ahora' class='far fa-calendar-plus'></i>";
    $iconoGestionar      = "<i title='Gestionar' class='fas fa-puzzle-piece'>Gestionar</i>";
    $iconoDesblokear     = "<i title='Desbloquear' class='fas fa-lock-open'></i>";
    $iconoLiquidar       = "<i title='Liquidar' class='fas fa-cart-arrow-down'></i>";
    $iconoResetear       = "<i title='Liquidar' class='fas fa-hand-sparkles'></i>";
    $iconoReportes       = "<i title='Generar reporte' class='fas fa-align-left'></i>";

    $datos = array($iconoEnblanco, $iconoEditar, $iconoAtras, $iconoGuardar, $iconoCerrar, $iconoEliminar, $iconoListar, $iconoAgregarPersona, $iconoAgregar, $iconoCrearModal, $iconoGestionar, $iconoDesblokear, $iconoLiquidar, $iconoResetear, $iconoReportes);
    return $datos;
}


