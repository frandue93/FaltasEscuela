
<?php

if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
    }


include_once("./lib/conexion.php");

class Alumno{
    private $expediente;
    private $nombre;
    private $apellidos;
    private $fecha;
    private $dni;
    private $direccion;
    private $telefonos;
    private $email;
    private $nompadres;
    private $observaciones;
    private $socio;
    private $codigo_G;

    public function __construct($expediente,$nombre,$apellidos,$fecha,$dni,$direccion,$telefonos,$email,$nompadres,$observaciones,$socio,$codigo_G){
        $this->expediente=$expediente;
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->fecha=$fecha;
        $this->dni=$dni;
        $this->direccion=$direccion;
        $this->telefonos=$telefonos;
        $this->email=$email;
        $this->nompadres=$nompadres;
        $this->observaciones=$observaciones;
        $this->socio=$socio;
        $this->codigo_G=$codigo_G;
    }


    
    public function guardaAlumnoBD(){
        $msg="";
        $sql = "insert into alumnado values(null,'$this->nombre','$this->apellidos','$this->fecha','$this->dni','$this->direccion','$this->telefonos','$this->nompadres','$this->socio','$this->observaciones','$this->email','$this->codigo_G')";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Alumno $this->nombre guardado correctamente";
        }else{
            $msg="Error al guardar alumno en la BD ".$conexion->error;

        }
        
        Conexion::desconectarBD($conexion);
        return $msg;
    }

    public function modificaAlumnoBD(){
        $msg="";
        $sql ="update alumnado set nombre='$this->nombre',apellidos='$this->apellidos',fecha_nacimiento='$this->fecha',dni='$this->dni',
        direccion='$this->direccion',telefonos='$this->telefonos',nombre_padres='$this->nompadres',socio_banda='$this->socio',
        observaciones='$this->observaciones',email='$this->email',codigo_G='$this->codigo_G' where expediente='$this->expediente'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $msg="Usuario modificado correctamente";
        }else{
            $msg="Error al modificar usuario en la BD".$conexion->error;
        }
        
        Conexion::desconectarBD($conexion);

        return $msg;

    }

    public function buscarAlumnoBD(){
        $sql="select * from alumnado where expediente='$this->expediente'";
        
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

    public function todosAlumnosBD($inicio,$cuantos){
        $codigo_profesor = $_SESSION['codigo_P']; 

        if(strcmp($_SESSION["admin"],"si")==0){
            $sql="select * from alumnado limit $inicio,$cuantos";
        }else{
            $sql="select * from alumnado 
            join matriculas on matriculas.expediente = alumnado.expediente
            where matriculas.codigo_P = '$codigo_profesor'";
        }
        
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

    public function todosAlumnosBDSinLimiteBD(){

        $sql="select * from alumnado";
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

    public function totalAlumnosBD(){
        $codigo_profesor=$_SESSION["codigo_P"];
        if(strcmp($_SESSION["admin"],"si")==0){
        $sql="select count(*) as total from alumnado";
        }else{
            $sql="select count(*) as total from alumnado 
            join matriculas on matriculas.expediente = alumnado.expediente
            where matriculas.codigo_P = '$codigo_profesor'";
        }

        $conexion = Conexion::conectarBD();
        $res=$conexion->query($sql);
        $fila=$res->fetch_assoc();
        $totalFilas=$fila["total"];
        Conexion::desconectarBD($conexion);

        return $totalFilas;


    }

    public function totalPorApellido(){
        $codigo_profesor=$_SESSION["codigo_P"];
        if(strcmp($_SESSION["admin"],"si")==0){
        $sql="select count(*) as total from alumnado
        where apellidos like '%$this->apellidos%'";
        }else{
            $sql="select count(*) as total from alumnado 
            join matriculas on matriculas.expediente = alumnado.expediente
            where matriculas.codigo_P = '$codigo_profesor' and apellidos like '%$this->apellidos%'";
        }

        $conexion = Conexion::conectarBD();
        $res=$conexion->query($sql);
        $fila=$res->fetch_assoc();
        $totalFilas=$fila["total"];
        Conexion::desconectarBD($conexion);

        return $totalFilas;
    }

    public function buscarApellidoBD($inicio,$cuantos){
        $codigo_profesor=$_SESSION["codigo_P"];
        if(strcmp($_SESSION["admin"],"si")==0){
        $sql="select * from alumnado where apellidos like '%$this->apellidos%' limit $inicio,$cuantos";
        }else{
            $sql="select * from alumnado join matriculas 
            on matriculas.expediente = alumnado.expediente 
            where apellidos like '%$this->apellidos%' and matriculas.codigo_P ='$codigo_profesor' limit $inicio,$cuantos";   
        }
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

    public function eliminarAlumnoBD(){
        $sql="delete from alumnado where expediente='$this->expediente'";
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

    public function alumnoEnMatriculaBD(){
        $sql="select expediente from matriculas where expediente='$this->expediente'";
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

    public function eliminarMatriculaEnAlumnoBD(){
        $linea =  false;
        $sql="delete from matriculas where expediente='$this->expediente'";
        $conexion=Conexion::conectarBD();
        if($conexion->query($sql)){
            $linea= true;
        }
        
       
        Conexion::desconectarBD($conexion);

        return $linea;
    }

    public function asignaturasAlumnoBD(){
        $sql="select asignatura.nombre,asignatura.codigo_A from asignatura
        join matriculas on matriculas.codigo_A = asignatura.codigo_A
        join alumnado on alumnado.expediente = matriculas.expediente
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

    public function profesoresAlumnoBD(){
        $sql="select profesor.nombre,profesor.codigo_P from profesor
        join matriculas on matriculas.codigo_P = profesor.codigo_P
        join alumnado on alumnado.expediente = matriculas.expediente
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



}

?>