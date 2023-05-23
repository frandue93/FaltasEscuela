<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }
include_once("./lib/conexion.php");
class Matricula{
    private $año_escolar;
    private $codigo_A;
    private $codigo_P;
    private $convocatoria;
    private $expediente;
    private $nota1;
    private $nota2;
    private $nota3;
    private $notaFin;
    private $observaciones;

    public function __construct($codigo_A,$codigo_P,$convocatoria,$expediente,$año_escolar,$nota1=-1,$nota2=-1,$nota3=-1,$notaFin=-1,$observaciones=""){
        $this->codigo_P=$codigo_P;
        $this->codigo_A=$codigo_A;
        $this->convocatoria=$convocatoria;
        $this->expediente=$expediente;
        $this->año_escolar=$año_escolar;
        $this->nota1=$nota1;
        $this->nota2=$nota2;
        $this->nota3=$nota3;
        $this->notaFin=$notaFin;
        $this->observaciones=$observaciones;
    }

    public function guardaMatriculaBD(){
        
        $msg="";
        $sql="insert into matriculas values('$this->codigo_A','$this->codigo_P','$this->expediente','$this->año_escolar','$this->convocatoria','$this->nota1','$this->nota2','$this->nota3','$this->notaFin','$observaciones')";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Matricula guardada correctamente<br>";
        }else{
            $msg="Error al guardar la matricula en la BD ".$conexion->error;
        }
        Conexion::desconectarBD($conexion);
        return $msg;
    
    
    }

    public function mismaEsteAñoBD(){
        $existe = false;
        $sql="select * from matriculas 
        where codigo_A='$this->codigo_A' and expediente='$this->expediente' and año_escolar='$this->año_escolar'";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        if($res->num_rows>0){
            $existe =true;
        }
        Conexion::desconectarBD($conexion);
        $res->free();
        return $existe;
    }

    public function matriculadoOtroAñoBD(){
        $alguno=false;
        $cont=1;
        $sql="select * from matriculas 
        where codigo_A='$this->codigo_A'  and expediente='$this->expediente'";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        while($res->fetch_assoc()){
            $alguno = true;
            $cont++;
        }
        Conexion::desconectarBD($conexion);
        $res->free();
        if($alguno){
            return $cont;
        }else{
            return false;
        }
    }


    

    public function matriculasPorAlumnoBD(){
        
        if($this->año_escolar!=""){
        $sql="select alumnado.nombre as nombreAlumno,
            profesor.nombre as nombreProfesor,
            asignatura.nombre as nombreAsignatura,
             matriculas.convocatoria as convocatoria,
             matriculas.codigo_A as codigo_A,
             matriculas.nota1,
             matriculas.nota2,
             matriculas.nota3,
             matriculas.notaFin,
             matriculas.observaciones,
             grupo.nombre
             from matriculas
             join alumnado on matriculas.expediente = alumnado.expediente 
             join profesor on matriculas.codigo_P = profesor.codigo_P
             join asignatura on matriculas.codigo_A = asignatura.codigo_A
             join grupo on alumnado.codigo_G = grupo.codigo_G
             where matriculas.expediente = '$this->expediente' and matriculas.año_escolar = '$this->año_escolar'";
        }else{
            $sql="select alumnado.nombre as nombreAlumno,
            profesor.nombre as nombreProfesor,
            asignatura.nombre as nombreAsignatura,
             matriculas.convocatoria as convocatoria,
             matriculas.codigo_A as codigo_A,
             matriculas.nota1,
             matriculas.nota2,
             matriculas.nota3,
             matriculas.notaFin,
             matriculas.observaciones,
             grupo.nombre
             from matriculas
             join alumnado on matriculas.expediente = alumnado.expediente 
             join profesor on matriculas.codigo_P = profesor.codigo_P
             join asignatura on matriculas.codigo_A = asignatura.codigo_A
             join grupo on alumnado.codigo_G = grupo.codigo_G
             where matriculas.expediente = '$this->expediente'";
             }
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $matriculasTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $matriculasTot;
        }else{
            return false;
        }
    }

    public function eliminarMatriculaAlumnoBD(){
        $sql="delete from matriculas where codigo_A='$this->codigo_A' 
            and año_escolar='$this->año_escolar'";
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

    public function eliminarMatriculaBD(){
        $sql="delete from matriculas where codigo_A='$this->codigo_A' 
            and convocatoria='$this->convocatoria'
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

    public function alumnosPorMatriculaBD(){
        $curso=$_SESSION["curso"];
        $sql="select alumnado.nombre as nombreAlumno,
            alumnado.apellidos as apellidoAlumno,
            asignatura.nombre as nombreAsignatura,
            matriculas.expediente as expediente,
             matriculas.convocatoria as convocatoria
             from matriculas
             join alumnado on matriculas.expediente = alumnado.expediente 
             join asignatura on matriculas.codigo_A = asignatura.codigo_A
             where matriculas.codigo_A = '$this->codigo_A' and año_escolar= '$curso'";

           

        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $matriculasTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $matriculasTot;
        }else{
            return false;
        }
    }


    public function todosAlumnosBD(){
         $curso=$_SESSION["curso"];
        $sql="select alumnado.nombre as nombreAlumno,
            alumnado.apellidos as apellidoAlumno,
            asignatura.nombre as nombreAsignatura,
            matriculas.expediente as expediente,
             matriculas.convocatoria as convocatoria
             from matriculas
             join alumnado on matriculas.expediente = alumnado.expediente 
             join asignatura on matriculas.codigo_A = asignatura.codigo_A
             where año_escolar = '$curso'
            ";

           

        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $matriculasTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $matriculasTot;
        }else{
            return false;
        }

    }

    public function algunaMatricula(){
        $existe = false;
        $curso = $_SESSION["curso"];
        $sql="select * from matriculas where año_escolar= '$curso'";
        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        if($res->num_rows>0){
            $existe =true;
        }
        Conexion::desconectarBD($conexion);
        $res->free();
        return $existe;
    }

    public function modificaNotaBD(){
       
        $msg="";
        if($this->nota1>-1){
        $sql ="update matriculas set nota1='$this->nota1' where expediente='$this->expediente' and año_escolar='$this->año_escolar' and codigo_A='$this->codigo_A' and codigo_P='$this->codigo_P'";
        }if($this->nota2>-1){
        $sql ="update matriculas set nota2='$this->nota2' where expediente='$this->expediente' and año_escolar='$this->año_escolar' and codigo_A='$this->codigo_A' and codigo_P='$this->codigo_P'";
       }if($this->nota3>-1){
        $sql ="update matriculas set nota3='$this->nota3' where expediente='$this->expediente' and año_escolar='$this->año_escolar' and codigo_A='$this->codigo_A' and codigo_P='$this->codigo_P'";
       }if($this->notaFin>-1){
        $sql ="update matriculas set notaFin='$this->notaFin' where expediente='$this->expediente' and año_escolar='$this->año_escolar' and codigo_A='$this->codigo_A' and codigo_P='$this->codigo_P'";
       }if($this->observaciones!=""){
        $sql ="update matriculas set observaciones='$this->observaciones' where expediente='$this->expediente' and año_escolar='$this->año_escolar' and codigo_A='$this->codigo_A' and codigo_P='$this->codigo_P'";

       }
        
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Usuario modificado correctamente";
        }else{
            $msg="Error al modificar usuario en la BD".$conexion->error;
        }
        
        Conexion::desconectarBD($conexion);

        return $msg;

    }

    public function expedientesConMatBD(){
        $curso=$_SESSION["curso"];
        $sql="select distinct expediente
             from matriculas
             where año_escolar = '$curso'
            ";

           

        $conexion=Conexion::conectarBD();
        $res=$conexion->query($sql);
        
        $alguno=false;
        while($linea = $res->fetch_assoc()){
            $alguno = true;
            $matriculasTot[]=$linea;
        }
        $res->free();
        Conexion::desconectarBD($conexion);
        if($alguno){
            return $matriculasTot;
        }else{
            return false;
        }
    }

}

?>