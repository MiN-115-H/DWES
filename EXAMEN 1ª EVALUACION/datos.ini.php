<?php

function datosTareas(){

    $conectar = new Conexion('localhost','usr_tareas','usr_tareas','tareas');
    $conexion = $conectar->conectionPDO();

    $resultado = $conexion->query('
        SELECT id, nombre, descripcion, fecha_creacion, fecha_modificacion, fecha_finalizacion, completada, id_usr_crea, id_usr_mod, id_usr_comp	
        FROM tareas;
    ');

    echo '<h1>Listado tareas</h1>';
    echo '<br>';
    echo '<button onclick=location.href="./perfil.php">Perfil</button>';
    echo '<button onclick=location.href="./tareanueva.php">Nueva tarea</button>';
    echo '<button onclick=location.href="./canciones.php">Buscar canciones</button>';
    echo '<button onclick=location.href="./logout.php">Log Out</button>';


    echo '<table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Fecha de creación</th>
                <th>Fecha de modificación</th>
                <th>Fecha de finalización</th>
                <th>Id del creador</th>
                <th>Id del modificado</th>
                <th>Id del completista</th>
            </tr>';

    while ($registro = $resultado->fetch()) {

        $tarea = new Tarea(
            $registro['id'],
            $registro['nombre'],
            $registro['descripcion'],
            $registro['fecha_creacion'],
            $registro['fecha_modificacion'],
            $registro['fecha_finalizacion'],
            $registro['completada'],
            $registro['id_usr_crea'],
            $registro['id_usr_mod'],
            $registro['id_usr_comp']
        );

        echo '<tr>';
        echo '<td>'.$tarea->getNombre().'">'.'</td>';
        echo '<td>'.$tarea->getDescripcion().'">'.'</td>';
        echo '<td>'.$tarea->getFechaC().'</td>';
        echo '<td>'.$tarea->getFechaM().'</td>';
        echo '<td>'.$tarea->getFechaF().'</td>';
        echo '<td>'.$tarea->getCompletada().'</td>';
        echo '<td>'.$tarea->getId_usr_C().'</td>';
        echo '</tr>';
    }

    echo '</table>';


}

function formularioTarea() {

    $conectar = new Conexion('localhost','usr_tareas','usr_tareas','tareas');

    echo '<button onclick=location.href="./index.php">Volver</button>';
    echo '<h1>Crear nueva tarea</h1>';
    echo '<form action="tareanueva.php" method="post">';
    echo '<input type="text" required name="nombre" placeholder="Nombre de la tarea"/>';
    echo '<input type="text" required name="descripcion" placeholder="Descripción de la tarea"/>';
    echo '<label>Fecha de creación: </label>';
    echo '<input type="date" name="fechaCreacion"/>';
    echo '<input type="text" name="idCreador"/>';
    echo '<br>';
    echo '<br>';
    echo '<input id="reg-mod" type="submit" value="Registrar"/>';
    echo '</form>';
    
    if(isset($_POST["nombre"])){

        $conexion = $conectar->conectionPDO();

        $tarea = new Tarea(
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['fechaCreacion'],
            $_POST['idCreador']
        );

        $tarea->registrarTarea($conexion);
    }
}



?>

