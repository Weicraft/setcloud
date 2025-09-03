<?php

class Master
{
    //Base de datos
    protected static $db;

    //Creación del arreglo de errores para las validaciones
    protected static $errores = [];

    //Definir la conexión a la BD
    public static function setDB($database)
    {
        self::$db = $database;
    }

    //U -> Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    //Traer los datos de la BD
    public static function consultarSQL($qry)
    {
        //Consultar la base de datos
        $result = self::$db->query($qry);

        //Iterar la base de datos
        $array = [];
        while ($registro = $result->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        //Liberar la memoria
        $result->free();

        //Retornar los resultados
        return $array;
    }

    //Creación del objeto
    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //Validación de errores
    public static function getErrores()
    {
        return self::$errores;
    }
}

class USERS extends Master
{

    //Arreglo pamodo_fact y U
    protected static $columnaDB = [
        'nombre',
        'usuario',
        'pass',
        'estado',
        'cargo'
    ];

    //Declarando las variables del objeto
    public $id_user;
    public $nombre;
    public $usuario;
    public $pass;
    public $estado;
    public $cargo;
    public $contar;

    //Construcción del objeto
    public function __construct($args = [])
    {

        $this->id_user = $args['id_user'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->usuario = $args['usuario'] ?? '';
        $this->pass = $args['pass'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->cargo = $args['cargo'] ?? '';
        $this->contar = $args['contar'] ?? '';
    }

    //C -> Guardar los datos
    public function crear($nombre, $usuario, $pass, $cargo)
    {
        $passwordHash = password_hash($pass, PASSWORD_BCRYPT);
     
     $qry = "INSERT INTO user (nombre, usuario, pass, estado, cargo)
        VALUES ('$nombre', '$usuario', '$passwordHash', 'A', '$cargo')";
        self::$db->query($qry);
    }

    //R -> Listar USERS
    public static function listarUser()
    {
        $qry = "SELECT * FROM user WHERE estado = 'A' ORDER BY id_user DESC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar USER por ID
    public static function listarUserId($id_user)
    {
        $qry = "SELECT * FROM user WHERE id_user = '$id_user' AND estado = 'A'";
        $result = self::consultarSQL($qry);

        return array_shift($result);
    }

    //R -> Listar USER por Usuario
    public static function listarUserUsuario($usuario)
    {
        $qry = "SELECT * FROM user WHERE usuario = '$usuario' AND estado = 'A'";
        $result = self::consultarSQL($qry);

        return array_shift($result);
    }

    //R -> CONTAR USUARIOS
    public static function contarUsers()
    {
        $qry = "SELECT count(*) as contar from user";
        $result = self::consultarSQL($qry);

        return array_shift($result);
    }

    //U -> Actualizar datos del USER:
    public function editUser(
        $id_user,
        $nombre,
        $usuario,
        $cargo
    ) {
        $qry = "UPDATE user SET nombre='$nombre', usuario='$usuario', cargo='$cargo' WHERE id_user='$id_user'";
        self::$db->query($qry);
    }

    //U -> Actualizar contraseña del USER:
    public function editPassUser(
        $id_user,
        $pass
    ) {
        $passwordHash = password_hash($pass, PASSWORD_BCRYPT);

        $qry = "UPDATE user SET pass='$passwordHash' WHERE id_user='$id_user'";
        self::$db->query($qry);
    }

    //U -> Eliminar USER:
    public function elimUser($id_user)
    {
        $qry = "UPDATE user SET estado='D' WHERE id_user='$id_user'";
        self::$db->query($qry);
    }

    //Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnaDB as $columna) {
            if ($columna === 'id_user') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Traer los datos de la BD
    public static function consultarSQL($qry)
    {
        //Consultar la base de datos
        $result = self::$db->query($qry);

        //Iterar la base de datos
        $array = [];
        while ($registro = $result->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }
        //Liberar la memoria
        $result->free();

        //Retornar los resultados
        return $array;
    }

    //Creación del objeto
    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //Sanitizar los datos
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
}

class NOVELA extends Master
{

    //Arreglo pamodo_fact y U
    protected static $columnaDB = [
        'id_novela',
        'novela',
        'director_n',
        'df_n',
        'script_n',
        'sonido_n',
        'estado'
    ];

    //Declarando las variables del objeto
    public $id_novela;
    public $novela;
    public $director_n;
    public $df_n;
    public $script_n;
    public $sonido_n;
    public $estado;

    //Construcción del objeto
    public function __construct($args = [])
    {

        $this->id_novela = $args['id_novela'] ?? '';
        $this->novela = $args['novela'] ?? '';
        $this->director_n = $args['director_n'] ?? '';
        $this->df_n = $args['df_n'] ?? '';
        $this->script_n = $args['script_n'] ?? '';
        $this->sonido_n = $args['sonido_n'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }

    //C -> Guardar los datos
    public function crear($novela, $director_n, $df_n, $script_n, $sonido_n)
    {
        $qry = "INSERT INTO novela (novela, director_n, df_n, script_n, sonido_n, estado)
        VALUES ('$novela', '$director_n', '$df_n', '$script_n', '$sonido_n', 'A')";
        self::$db->query($qry);
    }

    //R -> Listar NOVELAS
    public static function listarNovela()
    {
        $qry = "SELECT * FROM novela WHERE estado = 'A' ORDER BY id_novela DESC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar NOVELAS por ID
    public static function listarNovelaId($id_novela)
    {
        $qry = "SELECT * FROM novela WHERE id_novela = '$id_novela' AND estado = 'A'";
        $result = self::consultarSQL($qry);

        return array_shift($result);
    }

    //U -> Actualizar datos de la NOVELA:
    public function editNovela(
        $id_novela,
        $novela,
        $director_n,
        $df_n,
        $script_n,
        $sonido_n
    ) {
        $qry = "UPDATE novela SET novela='$novela', director_n='$director_n', df_n='$df_n', script_n='$script_n', sonido_n='$sonido_n'
         WHERE id_novela='$id_novela'";
        self::$db->query($qry);
    }

    //U -> Eliminar Novela:
    public function elimNovela($id_novela)
    {
        $qry = "UPDATE novela SET estado='D' WHERE id_novela='$id_novela'";
        self::$db->query($qry);
    }

    //Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnaDB as $columna) {
            if ($columna === 'id_novela') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Traer los datos de la BD
    public static function consultarSQL($qry)
    {
        //Consultar la base de datos
        $result = self::$db->query($qry);

        //Iterar la base de datos
        $array = [];
        while ($registro = $result->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }
        //Liberar la memoria
        $result->free();

        //Retornar los resultados
        return $array;
    }

    //Creación del objeto
    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //Sanitizar los datos
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
}

class HOJASPAUTA extends Master
{

    //Arreglo pamodo_fact y U
    protected static $columnaDB = [
        'num_hpauta',
        'id_novela',
        'id_ubic_rodaje',
        'id_momento_dia',
        'fecha',
        'director',
        'df',
        'script',
        'sonido',
        'dia_ficcion',
        'locacion',
        'personajes',
        'nota',
        'estado'
    ];

    //Declarando las variables del objeto
    public $id_hpauta;
    public $num_hpauta;
    public $id_novela;
    public $id_ubic_rodaje;
    public $id_momento_dia;
    public $fecha;
    public $director;
    public $df;
    public $script;
    public $sonido;
    public $dia_ficcion;
    public $locacion;
    public $personajes;
    public $nota;
    public $novela;
    public $estado;

    //Construcción del objeto
    public function __construct($args = [])
    {

        $this->id_hpauta = $args['id_hpauta'] ?? '';
        $this->num_hpauta = $args['num_hpauta'] ?? '';
        $this->id_novela = $args['id_novela'] ?? '';
        $this->id_ubic_rodaje = $args['id_ubic_rodaje'] ?? '';
        $this->id_momento_dia = $args['id_momento_dia'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->director = $args['director'] ?? '';
        $this->df = $args['df'] ?? '';
        $this->script = $args['script'] ?? '';
        $this->sonido = $args['sonido'] ?? '';
        $this->dia_ficcion = $args['dia_ficcion'] ?? '';
        $this->locacion = $args['locacion'] ?? '';
        $this->personajes = $args['personajes'] ?? '';
        $this->nota = $args['nota'] ?? '';
        $this->novela = $args['novela'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }

    //C -> Guardar los datos
    public function crear(
        $num_hpauta,
        $id_novela,
        $id_ubic_rodaje,
        $id_momento_dia,
        $fecha,
        $director,
        $df,
        $script,
        $sonido,
        $dia_ficcion,
        $locacion,
        $personajes
    ) {
        $qry = "INSERT INTO hoja_pauta (num_hpauta, id_novela, id_ubic_rodaje, id_momento_dia, fecha, director, df, script, sonido, dia_ficcion,
         locacion, personajes, estado)
        VALUES ('$num_hpauta', '$id_novela', '$id_ubic_rodaje', '$id_momento_dia', '$fecha', '$director', '$df', '$script', '$sonido', '$dia_ficcion',
        '$locacion', '$personajes', 'A')";
        self::$db->query($qry);
    }

    //R -> Listar HOJAS DE PAUTA
    public static function listarHojaPauta($novela)
    {
        $qry = "SELECT * FROM hoja_pauta 
        INNER JOIN novela ON novela.id_novela = hoja_pauta.id_novela
        WHERE hoja_pauta.id_novela = '$novela' AND hoja_pauta.estado = 'A'
        ORDER BY id_hpauta DESC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar ultima hoja Pauta
    public static function listarUntilaHojaPauta()
    {
        $qry = "SELECT * FROM hoja_pauta WHERE estado = 'A' ORDER BY id_hpauta DESC LIMIT 1";
        $result = self::consultarSQL($qry);

        return array_shift($result);
    }

    //R -> Listar HOJA DE PAUTA por ID
    public static function listarHojaPautaId($id_hpauta)
    {
        $qry = "SELECT * FROM hoja_pauta 
        INNER JOIN novela ON novela.id_novela = hoja_pauta.id_novela
        WHERE id_hpauta = '$id_hpauta' AND hoja_pauta.estado = 'A'";
        $result = self::consultarSQL($qry);

        return array_shift($result);
    }

    //R -> Listar todas las FECHAS
    public static function listarFechas()
    {
        $qry = "SELECT DISTINCT fecha FROM hoja_pauta WHERE estado = 'A' ORDER BY fecha DESC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar todas las HOJAS DE PAUTA por FECHAS
    public static function listarHojaPautaFechas($fecha, $novela)
    {
        $qry = "SELECT * FROM hoja_pauta 
        INNER JOIN novela ON novela.id_novela = hoja_pauta.id_novela
        WHERE hoja_pauta.id_novela = '$novela' AND fecha = '$fecha' AND hoja_pauta.estado = 'A'";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar todas las HOJAS DE PAUTA por CAPÍTULOS
    public static function listarHojaPautaCapitulo($capitulo, $novela)
    {
        $qry = "SELECT * FROM hoja_pauta 
        INNER JOIN registro_pautas ON registro_pautas.id_hpauta = hoja_pauta.id_hpauta
        WHERE capitulo = '$capitulo' AND id_novela = '$novela' AND hoja_pauta.estado = 'A' 
        GROUP BY hoja_pauta.id_hpauta 
        ORDER BY hoja_pauta.id_hpauta DESC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //U -> Actualizar datos generales de HOJAS PAUTA:
    public function editHpauta(
        $id_hpauta,
        $id_ubic_rodaje,
        $id_momento_dia,
        $fecha,
        $director,
        $df,
        $script,
        $sonido,
        $dia_ficcion,
        $locacion,
        $personajes,
    ) {
        $qry = "UPDATE hoja_pauta SET id_ubic_rodaje='$id_ubic_rodaje', id_momento_dia='$id_momento_dia', 
        fecha='$fecha', director='$director', df='$df', script='$script', sonido='$sonido', dia_ficcion='$dia_ficcion', locacion='$locacion', 
        personajes='$personajes'
         WHERE id_hpauta='$id_hpauta'";
        self::$db->query($qry);
    }

    //U -> Eliminar HOJA DE PAUTA:
    public function nuevaNota($id_hpauta, $nota)
    {
        $qry = "UPDATE hoja_pauta SET nota='$nota' WHERE id_hpauta='$id_hpauta'";
        self::$db->query($qry);
    }

    //U -> Eliminar HOJA DE PAUTA:
    public function elimHpauta($id_hpauta)
    {
        $qry = "UPDATE hoja_pauta SET estado='D' WHERE id_hpauta='$id_hpauta'";
        self::$db->query($qry);
    }

    //Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnaDB as $columna) {
            if ($columna === 'id_hpauta') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Traer los datos de la BD
    public static function consultarSQL($qry)
    {
        //Consultar la base de datos
        $result = self::$db->query($qry);

        //Iterar la base de datos
        $array = [];
        while ($registro = $result->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }
        //Liberar la memoria
        $result->free();

        //Retornar los resultados
        return $array;
    }

    //Creación del objeto
    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //Sanitizar los datos
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
}

class REGISTROPAUTAS extends Master
{

    //Arreglo pamodo_fact y U
    protected static $columnaDB = [
        'id_hpauta',
        'capitulo',
        'escena',
        'plano',
        'toma',
        'retoma',
        'clip_cam1',
        'time_cam1',
        'clip_cam2',
        'time_cam2',
        'clip_cam3',
        'time_cam3',
        'clip_cam4',
        'time_cam4',
        'clip_cam5',
        'time_cam5',
        'vb',
        'obs',
        'estado'
    ];

    //Declarando las variables del objeto
    public $id_registro_pauta;
    public $id_hpauta;
    public $capitulo;
    public $escena;
    public $plano;
    public $toma;
    public $retoma;
    public $clip_cam1;
    public $time_cam1;
    public $clip_cam2;
    public $time_cam2;
    public $clip_cam3;
    public $time_cam3;
    public $clip_cam4;
    public $time_cam4;
    public $clip_cam5;
    public $time_cam5;
    public $vb;
    public $obs;
    public $estado;

    //Construcción del objeto
    public function __construct($args = [])
    {

        $this->id_hpauta = $args['id_hpauta'] ?? '';
        $this->capitulo = $args['capitulo'] ?? '';
        $this->escena = $args['escena'] ?? '';
        $this->plano = $args['plano'] ?? '';
        $this->toma = $args['toma'] ?? '';
        $this->retoma = $args['retoma'] ?? '';
        $this->clip_cam1 = $args['clip_cam1'] ?? '';
        $this->time_cam1 = $args['time_cam1'] ?? '';
        $this->clip_cam2 = $args['clip_cam2'] ?? '';
        $this->time_cam2 = $args['time_cam2'] ?? '';
        $this->clip_cam3 = $args['clip_cam3'] ?? '';
        $this->time_cam3 = $args['time_cam3'] ?? '';
        $this->clip_cam4 = $args['clip_cam4'] ?? '';
        $this->time_cam4 = $args['time_cam4'] ?? '';
        $this->clip_cam5 = $args['clip_cam5'] ?? '';
        $this->time_cam5 = $args['time_cam5'] ?? '';
        $this->vb = $args['vb'] ?? '';
        $this->obs = $args['obs'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }

    //C -> Guardar los datos
    public function crear(
        $id_hpauta,
        $capitulo,
        $escena,
        $plano,
        $toma,
        $retoma,
        $clip_cam1,
        $time_cam1,
        $clip_cam2,
        $time_cam2,
        $clip_cam3,
        $time_cam3,
        $clip_cam4,
        $time_cam4,
        $clip_cam5,
        $time_cam5,
        $obs
    ) {
        $qry = "INSERT INTO registro_pautas (id_hpauta, capitulo, escena, plano, toma, retoma, clip_cam1, time_cam1, clip_cam2, time_cam2, clip_cam3,
         time_cam3, clip_cam4, time_cam4, clip_cam5, time_cam5, vb, obs, estado)
        VALUES ('$id_hpauta', '$capitulo', '$escena', '$plano', '$toma', '$retoma', '$clip_cam1', '$time_cam1', '$clip_cam2', '$time_cam2', '$clip_cam3',
        '$time_cam3', '$clip_cam4', '$time_cam4', '$clip_cam5', '$time_cam5', null, '$obs', 'A')";
        self::$db->query($qry);
    }

    //R -> Listar REGISTRO DE PAUTA por HOJA DE PAUTA
    public static function listarRegistroPautas($id_hpauta)
    {
        $qry = "SELECT * FROM registro_pautas
        WHERE id_hpauta = '$id_hpauta' AND estado = 'A'
        ORDER BY id_hpauta DESC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar REGISTRO DE PAUTA por ID
    public static function listarRegistroPautaID($id_registro_pauta)
    {
        $qry = "SELECT * FROM registro_pautas
        WHERE id_registro_pauta = '$id_registro_pauta' AND estado = 'A'
        ORDER BY id_registro_pauta DESC";
        $result = self::consultarSQL($qry);

        return array_shift($result);
    }

    //R -> Listar REGISTRO DE PAUTA por ID
    public static function listarVdID()
    {
        $qry = "SELECT id_registro_pauta, vb FROM registro_pautas ORDER BY id_registro_pauta DESC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar REGISTRO DE PAUTA con CAM 4
    public static function listarHpautaCam4($id_hpauta)
    {
        $qry = "SELECT * FROM registro_pautas WHERE clip_cam4 IS NOT NULL AND clip_cam4 <> '0' AND id_hpauta = '$id_hpauta'";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar REGISTRO DE PAUTA con CAM 5
    public static function listarHpautaCam5($id_hpauta)
    {
        $qry = "SELECT * FROM registro_pautas WHERE clip_cam4 IS NOT NULL AND clip_cam5 <> '0' AND id_hpauta = '$id_hpauta'";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar CAPÍTULOS DISTINTOS
    public static function listarCapitulos($id_novela)
    {
        $qry = "SELECT DISTINCT capitulo 
        FROM registro_pautas 
        INNER JOIN hoja_pauta ON hoja_pauta.id_hpauta = registro_pautas.id_hpauta
        WHERE capitulo IS NOT NULL 
        AND capitulo <> '0'
        AND id_novela = '$id_novela' 
        ORDER BY capitulo DESC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //U -> Actualizar REGISTRO DE PAUTAS:
    public function editRegistroPautas(
        $id_registro_pauta,
        $capitulo,
        $escena,
        $plano,
        $toma,
        $retoma,
        $clip_cam1,
        $time_cam1,
        $clip_cam2,
        $time_cam2,
        $clip_cam3,
        $time_cam3,
        $clip_cam4,
        $time_cam4,
        $clip_cam5,
        $time_cam5,
        $obs
    ) {
        $qry = "UPDATE registro_pautas SET capitulo='$capitulo', escena='$escena', plano='$plano', 
        toma='$toma', retoma='$retoma', clip_cam1='$clip_cam1', time_cam1='$time_cam1', clip_cam2='$clip_cam2', time_cam2='$time_cam2', 
        clip_cam3='$clip_cam3', time_cam3='$time_cam3', clip_cam4='$clip_cam4', time_cam4='$time_cam4', clip_cam5='$clip_cam5',
        time_cam5='$time_cam5', obs='$obs'
         WHERE id_registro_pauta='$id_registro_pauta'";
        self::$db->query($qry);
    }

    //U -> Eliminar REGISTRO DE PAUTA:
    public function elimRegistroPauta($id_registro_pauta)
    {
        $qry = "UPDATE registro_pautas SET estado='D' WHERE id_registro_pauta='$id_registro_pauta'";
        self::$db->query($qry);
    }

    //Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnaDB as $columna) {
            if ($columna === 'id_registro_pauta') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Traer los datos de la BD
    public static function consultarSQL($qry)
    {
        //Consultar la base de datos
        $result = self::$db->query($qry);

        //Iterar la base de datos
        $array = [];
        while ($registro = $result->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }
        //Liberar la memoria
        $result->free();

        //Retornar los resultados
        return $array;
    }

    //Creación del objeto
    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //Sanitizar los datos
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
}

class SESIONES extends Master
{

    //Arreglo para C y U
    protected static $columnaDB = ['id_orden', 'identificador', 'id_user', 'estado_sesion', 'sesion'];

    //Declarando las variables del objeto
    public $id_sesion;
    public $id_orden;
    public $identificador;
    public $id_user;
    public $estado_sesion;
    public $sesion;
    //Construcción del objeto
    public function __construct($args = [])
    {

        $this->id_sesion = $args['id_sesion'] ?? '';
        $this->id_orden = $args['id_orden'] ?? '';
        $this->identificador = $args['identificador'] ?? '';
        $this->id_user = $args['id_user'] ?? '';
        $this->estado_sesion = $args['estado_sesion'] ?? '';
        $this->sesion = $args['sesion'] ?? '';
    }

    //C -> Crear Sesion
    public function crearSesion($id_user)
    {

        $qry = "INSERT INTO sesiones (id_sesion, id_orden, identificador, id_user, estado_sesion, sesion) VALUES
        ('', 1, 1, '$id_user', 1, 'Módulo Gestión de Usuarios'),
        ('', 2, 2, '$id_user', 1, 'Crear/editar/eliminar Producción'),
        ('', 3, 3, '$id_user', 1, 'Crear/editar/eliminar Hojas de Pauta'),
        ('', 4, 4, '$id_user', 1, 'Crear/editar/eliminar Pautas'),
        ('', 5, 5, '$id_user', 1, 'Crear/editar Notas')";
        self::$db->query($qry);
    }

    //R -> Listar Sesiones
    public static function listarSesiones()
    {
        $qry = "SELECT * FROM sesiones
        ORDER BY id_orden ASC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar Sesiones
    public static function listarSesionesUsuario($usuario)
    {
        $qry = "SELECT * FROM sesiones
        WHERE id_user = '$usuario'
        ORDER BY id_orden ASC";
        $result = self::consultarSQL($qry);

        return $result;
    }

    //R -> Listar Sesiones por Usuario e identificador
    public static function listarSesionesPorIdentificacorUsuario($identificador, $usuario)
    {
        $qry = "SELECT * FROM sesiones
        WHERE identificador = '$identificador'
        AND id_user = '$usuario'";
        $result = self::consultarSQL($qry);

        return array_shift($result);
    }

    //U -> Prender Sesión:
    public function prenderSesion($identificador, $id_user)
    {
        $qry = "UPDATE sesiones SET estado_sesion='1'
         WHERE identificador='$identificador'
         AND id_user = '$id_user'";
        self::$db->query($qry);
    }

    //U -> Apagar Sesión:
    public function apagarSesiones($id_user)
    {
        $qry = "UPDATE sesiones SET estado_sesion='0'
        WHERE id_user = '$id_user'";
        self::$db->query($qry);
    }


    //Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnaDB as $columna) {
            if ($columna === 'id_sesion') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Traer los datos de la BD
    public static function consultarSQL($qry)
    {
        //Consultar la base de datos
        $result = self::$db->query($qry);

        //Iterar la base de datos
        $array = [];
        while ($registro = $result->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }
        //Liberar la memoria
        $result->free();

        //Retornar los resultados
        return $array;
    }

    //Creación del objeto
    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //Sanitizar los datos
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
}