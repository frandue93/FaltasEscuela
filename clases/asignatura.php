<?php
include_once("./lib/conexion.php");

class Asignatura{
    private $codigo_A;
    private $duracion_semanal;
    private $nombre;

    public function __construct($codigo_A,$nombre,$duracion_semanal){
        $this->codigo_A=$codigo_A;
        $this->nombre=$nombre;
        $this->duracion_semanal=$duracion_semanal;
    }

   

    public function guardaAsignaturaBD(){
        $msg="";
        $sql="insert into asignatura values(null,'$this->nombre','$this->duracion_semanal')";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Asignatura $this->nombre guardada correctamente";
        }else{
            $msg="Error al guardar la asignatura en la BD ".$conexion->error;
        }
        Conexion::desconectarBD($conexion);
        return $msg;
    }

    public function todasAsignaturasBD($inicio,$cuantos){
        $sql="select * from asignatura limit $inicio,$cuantos";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $asigTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $asigTot;
        }else{
            return false;
        }
    }

    public function todasAsignaturasSinLimiteBD(){
        $sql="select * from asignatura";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $asigTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $asigTot;
        }else{
            return false;
        }
    }

    public function totalAsignaturasBD(){
        $sql="select count(*) as total from asignatura";

        $conexion = Conexion::conectarBD();
        $res=$conexion->query($sql);
        $fila=$res->fetch_assoc();
        $totalFilas=$fila["total"];
        Conexion::desconectarBD($conexion);

        return $totalFilas;


    }

    public function buscarAsignaturaBD(){
        $sql="select * from asignatura where codigo_A='$this->codigo_A'";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        if($res->num_rows > 0){
            $linea=$res->fetch_assoc();
        }else{
            $linea=false;
        }
        $res->free();
        Conexion::desconectarBD($conexion);

        return $linea;
    }

    public function modificaAsignaturaBD(){
        $msg="";
        $sql ="update asignatura set nombre='$this->nombre',duracion_semanal='$this->duracion_semanal'
         where codigo_A='$this->codigo_A'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Asignatura modificada correctamente";
        }else{
            $msg="Error al modificar asignatura en la BD".$conexion->error;
        }
        
        Conexion::desconectarBD($conexion);

        return $msg;

    }
    public function totalPorNombre(){
    
        $sql="select count(*) as total from asignatura
        where nombre like '%$this->nombre%'";
        

        $conexion = Conexion::conectarBD();
        $res=$conexion->query($sql);
        $fila=$res->fetch_assoc();
        $totalFilas=$fila["total"];
        Conexion::desconectarBD($conexion);

        return $totalFilas;
    }

    public function buscarPorNombrAsigBD($inicio,$cuantos){
        $sql="select * from asignatura where nombre like '%$this->nombre%' limit $inicio,$cuantos";
          $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $asignaturasTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $asignaturasTot;
        }else{
            return false;
        }
    }

    public function eliminarAsignaturaBD(){
        $sql="delete from asignatura where codigo_A='$this->codigo_A'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            return true;
        }else{
            return false;
        }
        
        $res->free();
        Conexion::desconectarBD($conexion);

        return $linea;
    }

    public function asignaturaEnMatriculaBD(){
        $sql="select codigo_A from matriculas where codigo_A='$this->codigo_A'";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
       while($linea = $res->fetch_assoc()){
        $alguno = true;
        $profMat[]=$linea;
       }
       $res->free();
       Conexion::desconectarBD($conexion);
       if($alguno){
        return $profMat;
       }else{
        return false;
       }
    }

    public function eliminarMatriculaEnAsignaturaBD(){
        $linea =  false;
        $sql="delete from matriculas where codigo_A='$this->codigo_A'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $linea= true;
        }
        
       
        Conexion::desconectarBD($conexion);

        return $linea;
    }


}