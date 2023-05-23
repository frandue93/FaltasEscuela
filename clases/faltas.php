<?php
include_once("./lib/conexion.php");


class Falta{
    private $codigo_A;
    private $expediente;
    private $fecha;
    private $tipo;
    private $codigo_P;
    private $codigo_F;

    public function __construct($codigo_F,$codigo_A,$expediente,$fecha,$tipo,$codigo_P){
        $this->codigo_A=$codigo_A;
        $this->expediente=$expediente;
        $this->fecha=$fecha;
        $this->tipo=$tipo;
        $this->codigo_P=$codigo_P;
        $this->codigo_F=$codigo_F;
    }


    public function guardaFaltaBD(){
        $sql="insert into faltas values (null,'$this->expediente','$this->codigo_A','$this->tipo','$this->fecha','$this->codigo_P')";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Falta guardadda correctamente";
        }else{
            $msg="Error al guardar la falta en la BD ".$conexion->error;

        }
        
        Conexion::desconectarBD($conexion);
        return $msg;
    }

    public function mostrarFaltasBD(){
        
            $sql="select asignatura.nombre as nombreAsignatura,
                        faltas.*,
                         profesor.nombre as nombreProfesor
                         from faltas
            join alumnado on alumnado.expediente = faltas.expediente
            join asignatura on asignatura.codigo_A = faltas.codigo_A
            join profesor on profesor.codigo_P = faltas.codigo_P
            where alumnado.expediente='$this->expediente'";
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


    public function eliminarFaltaBD(){
        $sql="delete from faltas where codigo_A='$this->codigo_A' 
            and codigo_P='$this->codigo_P'
            and codigo_F='$this->codigo_F'
            and expediente='$this->expediente'";
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

    public function alumnosConFaltas(){
        $sql="select distinct alumnado.* 
        from alumnado
        join faltas on faltas.expediente = alumnado.expediente";
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

    public function alumnoSelConFaltas(){
        $sql="select alumnado.expediente as exp,
        alumnado.apellidos as apellidos,
        alumnado.nombre as nombre 
        from alumnado
        join faltas on faltas.expediente = alumnado.expediente
        where alumnado.expediente='$this->expediente'";
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


}



?>