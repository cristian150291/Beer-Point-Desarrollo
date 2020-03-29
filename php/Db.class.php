<?php

/* Clase encargada de gestionar las conexiones a la base de datos */
Class Db{

   private $servidor='localhost';
   private $usuario='postgres';
   private $password='cristian';
   private $base_datos='beerpoint';
   private $link;
   private $stmt;
   private $array;
   private $port='5432';
   

   static $_instance;

   /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/
   private function __construct(){
      $this->conectar();
   }

   /*Evitamos el clonaje del objeto. Patrón Singleton*/
   private function __clone(){ }

   /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
   public static function getInstance(){
      if (!(self::$_instance instanceof self)){
         self::$_instance=new self();
      }
      return self::$_instance;
   }

   /*Realiza la conexión a la base de datos.*/
   private function conectar(){
    $cadenaConexion = "host=$this->servidor port=$this->port dbname=$this->base_datos user=$this->usuario password=$this->password";
    $conexion = pg_connect($cadenaConexion) or die("Error en la Conexión: ".pg_last_error());     
      $this->link=pg_connect($cadenaConexion) or die("Error en la Conexión: ".pg_last_error());         
   }

   /*Método para ejecutar una sentencia sql*/
   public function ejecutar($sql){
      $this->stmt=pg_query($this->link,$sql);
      return $this->stmt;
   }

   /*Método para obtener una fila de resultados de la sentencia sql*/
   public function obtener_fila($stmt,$fila){
      if ($fila==0){
         $this->array=pg_fetch_array($stmt);
      }else{
        pg_lo_seek($stmt,$fila);
         $this->array=pg_fetch_array($stmt);
      }
      return $this->array;
   }

   /**Metodo para cerrar conexion postgres */
   public function cerrar_pg () {
      pg_close($this->link);
   }


}
?>