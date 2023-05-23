<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
include_once("./lib/conexion.php");


class Grupo{
    private $codigo_G;
    private $nombre;

    public function __construct($codigo_G,$nombre){
        $this->codigo_G=$codigo_G;
        $this->nombre=$nombre;
       
    }

    public function guardaGrupoBD(){
        $msg="";
        $sql="insert into grupo values(null,'$this->nombre')";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Grupo $this->nombre guardado correctamente";
        }else{
            $msg="Error al guardar el grupo en la BD ".$conexion->error;
        }
        Conexion::desconectarBD($conexion);
        return $msg;
    }

    public function todosGruposBD($inicio,$cuantos){
        $sql="select * from grupo limit $inicio,$cuantos";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $grupTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $grupTot;
        }else{
            return false;
        }
    }

    public function todosGruposSinLimiteBD(){
        $sql="select * from grupo";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $grupTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $grupTot;
        }else{
            return false;
        }
    }

    public function totalGruposBD(){
        $sql="select count(*) as total from grupo";

        $conexion = Conexion::conectarBD();
        $res=$conexion->query($sql);
        $fila=$res->fetch_assoc();
        $totalFilas=$fila["total"];
        Conexion::desconectarBD($conexion);

        return $totalFilas;

    }

    public function eliminarGrupoBD(){
        $sql="delete from grupo where codigo_G='$this->codigo_G'";
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

   

    public function eliminarAlumnosEnGrupoBD(){
        $sql="delete from alumnado where codigo_G='$this->codigo_G'";
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

    public function modificaGrupoBD(){
        $msg="";
        $sql ="update grupo set nombre='$this->nombre'
         where codigo_G='$this->codigo_G'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Grupo modificado correctamente";
        }else{
            $msg="Error al modificar el grupo en la BD".$conexion->error;
        }
        
        Conexion::desconectarBD($conexion);

        return $msg;
    }

    public function grupoConAlumnoBD(){
        $sql="select * from alumnado where codigo_G='$this->codigo_G'";
        $linea=NULL;
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        if($res->num_rows>0){
            $linea=$res->fetch_assoc();
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        return $linea;
    }


    public function buscarGrupoBD(){
        $sql="select * from grupo where codigo_G='$this->codigo_G'";
        $linea=NULL;
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        if($res->num_rows>0){
            $linea=$res->fetch_assoc();
            /*if(empty($_SESSION["nombre"])){
            $_SESSION["nombre"]=$linea["nombre"];
            $_SESSION["codigo_G"]=$linea["codigo_G"]
            
            }*/
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        return $linea;
    }

    public function alumnosEnGrupoBD(){
        $curso=$_SESSION["curso"];
        $sql="select distinct alumnado.*, matriculas.convocatoria
             from alumnado
             join matriculas on alumnado.expediente = matriculas.expediente
             where codigo_G = '$this->codigo_G' and matriculas.año_escolar = '$curso'";

        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $alumnosTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $alumnosTot;
        }else{
            return false;
        }
    }

    public function todosAlumnosEnGrupoBD(){
        $curso=$_SESSION["curso"];
        $sql="select distinct alumnado.*, matriculas.convocatoria
             from alumnado
             join matriculas on alumnado.expediente = matriculas.expediente
             where  matriculas.año_escolar = '$curso'";

        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $alumnosTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $alumnosTot;
        }else{
            return false;
        }
    }


  



}
?>