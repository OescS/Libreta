<?php

 class libreta
 {
 
 
        var$tipo_bd="mysql";
        var$nombre_hots="localhost";
        var$nombre_bd="libreta";
        var$usuario="root";
        var$clave="";
        var$sql="";
 
     

      /*  function libreta($tipo_bd,$nombre_host,$nombre_bd,$usuario)*/
      function libreta($tipo_bd,$nombre_host,$nombre_bd,$usuario,$clave)
	{


           $this->TIPO_BD=$tipo_bd;


                   switch($this->tipo_bd)
                      {

                      case "pg": 
                       $this->conexion =pg_connect("host=$nombre_host dbname=$nombre_bd user=$usuario") 
                       or die ("NO ME PUDE CONECTAR");
                       break;

                      case "mysql": 
                       $this->conexion=mysql_connect("$nombre_host","$usuario","$clave");
                       mysql_select_db("libreta",$this->conexion)
                       or die ("no se pudo conectar");
                       
                      break;

                      default : echo"NO  PROVEO CONEXION A $tipo_bd";


                     }
       }


          function ejecutar($sql)
          {


                switch($this->tipo_bd)
                  {

                  case "pg": $this->resultado=pg_query($this->conexion,$sql);
                  break;


                 case "mysql": $this->resultado=mysql_query($sql,$this->conexion);

                 break;

                  }


         }

         function obtener()
            {
              switch($this->tipo_bd)
                {

                  case "pg":
                    $valores=pg_fetch_assoc($this->resultado);
                  break;

                  case "mysql": 
                    $valores=mysql_fetch_array($this->resultado);
                  break;
                }
                //if ($valores <> null)
                //{
                   return($valores);
                //}
           }




            function cerrar()               {
                  switch($this->tipo_bd)
                     {
                      case "pg":
                      pg_close($this->conexion);
                      break;


                     case "mysql":
                     mysql_close($this->conexion);
                     break;
                      }

                }
}

?>
<?php

