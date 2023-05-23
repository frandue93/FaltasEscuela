<?php
include_once("./lib/conexion.php");
class Profesor{
    private $nombre;
    private $clave;
    private $codigo_P;
    private $admin;

    public function __construct($codigo_P,$nombre,$clave,$admin){
        $this->codigo_P=$codigo_P;
        $this->nombre=$nombre;
        $this->clave=$clave;
        $this->admin=$admin;
    }

 

    public function guardaProfesorBD(){
        $msg="";
        $sql="insert into profesor values(null,'$this->nombre','$this->clave','$this->admin')";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Profesor $this->nombre guardado correctamente";
        }else{
            $msg="Error al guardar el profesor en la BD ".$conexion->error;
        }
        Conexion::desconectarBD($conexion);
        return $msg;
    }

    public function buscarProfesorBD(){
        $sql="select * from profesor where codigo_P='$this->codigo_P'";
        $linea=NULL;
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        if($res->num_rows>0){
            $linea=$res->fetch_assoc();
            if(empty($_SESSION["nombre"])){
            $_SESSION["nombre"]=$linea["nombre"];
            $_SESSION["codigo_P"]=$linea["codigo_P"];
            $_SESSION["clave"]=$linea["clave"];
            $_SESSION["admin"]=$linea["admin"];
            }
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        return $linea;
    }

    public function algunProfesorBD(){
        $sql="select * from profesor";
        $alguno = false;
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        if($res->num_rows>0){
            $alguno = true;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        return $alguno;
    }

    public function todosProfesoresBD($inicio,$cuantos){
        
        $sql="select * from profesor limit $inicio,$cuantos";
        
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $profesoresTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $profesoresTot;
        }else{
            return false;
        }
    }

    public function todosProfesoresSinLimiteBD(){
        
        $sql="select * from profesor ";
        
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $profesoresTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $profesoresTot;
        }else{
            return false;
        }
    }

    public function totalProfesoradoBD(){
        $sql="select count(*) as total from profesor";

        $conexion = Conexion::conectarBD();
        $res=$conexion->query($sql);
        $fila=$res->fetch_assoc();
        $totalFilas=$fila["total"];
        Conexion::desconectarBD($conexion);

        return $totalFilas;


    }

    public function siguenteIdProfesorBD(){
        $sql="select * from profesor";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $profesoresTot[]=$linea;
        }
        foreach($profesoresTot as $val){
            $ultimoValor = $val["codigo_P"];
        }
        $ultimoValor++;
        $res->free();
        Conexion::desconectarBD($conexion);
        $sql="insert into profesor values(null,'$this->nombre','$ultimoValor','$this->admin')";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Profesor $this->nombre guardado correctamente";
        }else{
            $msg="Error al guardar el profesor en la BD ".$conexion->error;
        }
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $msg;
        }else{
            return false;
        }
    }

    public function modificaProfesorBD(){
        $msg="";
        $sql ="update profesor set nombre='$this->nombre',clave='$this->clave'
         where codigo_P='$this->codigo_P'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Profesor modificado correctamente";
        }else{
            $msg="Error al modificar profesor en la BD".$conexion->error;
        }
        
        Conexion::desconectarBD($conexion);

        return $msg;
    }

    public function eliminarProfesorBD(){
        $linea =  false;
        $sql="delete from profesor where codigo_P='$this->codigo_P'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $linea= true;
        }
        
       
        Conexion::desconectarBD($conexion);

        return $linea;
    }

    public function profesorEnMatriculaBD(){
        $sql="select codigo_P from matriculas where codigo_P='$this->codigo_P'";
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

    public function eliminarMatriculaEnProfesorBD(){
        $linea =  false;
        $sql="delete from matriculas where codigo_P='$this->codigo_P'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $linea= true;
        }
        
       
        Conexion::desconectarBD($conexion);

        return $linea;
    }

    public function AlumnosDelProfesor(){
        $sql="select alumnado.*,
            matriculas.*,
            from matriculas
            join alumnado on matriculas.expediente = alumno.expediente
            where matriculas.codigo_P = '$this->codigo_P'";
            $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $alTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $alTot;
        }else{
            return false;
        }
    }

    


}



?>