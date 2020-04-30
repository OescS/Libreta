<html>
	<title>
		Programa para almacenar datos personales
	</title>

	<head> 
		<!--<?php 
			setCookie(1);
  		?>-->
		<br><marquee><h3> LIBRETA PERSONAL </h3></marquee><br>
	</head>

	<body>
	<hr>
		<?php
		/*  Oscar eduardo sanchez
			Ing informatico
			10� semestre
			Php: Programa para almacenar datos personales
		*/
        
		include("libreta.class.php");
		//include("globales.inc.php");
		//$bd = new bd ("postgres");
		
		switch($_REQUEST['funcion'])
   		{
      		case "insertar":
          		insertar();
	  		break;
	  
      		case "listar":
         	    listar ();
	  		break;	
	   
      		case "buscar":
          		buscar();
	  		break; 
	  	  
	  		case "eliminar":
          		eliminar();
	  		break;    	
	  		
	  		case "eliminar2":
          		eliminar2();
	  		break;    	
	     
      		case "modificar":
      		    modificar();
	  		break;
	   	   
	   		case "formulario":
      		    formulario();
	  		break;
	  		
     		default : echo " 
     			  			<html>
                      			<body>
			   					<center>
			     					<table border=1> 
			     					<tr><td>
                  					<h1><i> No pudo ejecutar la funcion {$_REQUEST['funcion']} </i></h1>
			      					</td></tr>
			      					</table>
			   					</center>
			  		 			</body>
		      				</html>	       
			      		  ";  
		}		
	
/********************* Funcion que insertar ************************/
	
	function insertar()
	{
     	$valores = $_REQUEST;
	  if($_SERVER['REQUEST_METHOD']=="POST")
	   {
		 
		/* Me conecto con el servidor */	
		//$bd=new libreta(TIPO_BD,NOMBRE_HOST,NOMBRE_DB,USUARIO,CLAVE);		        
		//$bd=new libreta("mysql","localhost","libreta","root","");		
				
		/* Tercero hago la sentencia para insertar en la tabla datos */
	    $sql="insert into libreta (cedula,nombres,apellidos,tel,cel,dir,barrio,mail,ocupacion,sesion,sexo)
	    values ('{$_REQUEST['cedula']}','{$_REQUEST['nombres']}','{$_REQUEST['apellidos']}','{$_REQUEST['tel']}',
	    '{$_REQUEST['cel']}','{$_REQUEST['dir']}','{$_REQUEST['barrio']}','{$_REQUEST['mail']}','{$_REQUEST['ocupacion']}'
	    ,'{$_REQUEST['sesion']}','{$_REQUEST['sexo']}')";
		
		

	    /* Ejecuto la sentencia SQL */
	    $bd->ejecutar($sql);
	    
	    //$resultado=$bd->obtener();  	
	    
	 	/* Cuarto cierro la base de datos */  	
		$bd->cerrar();  
  	   }	
  	   formulario("insertar",$valores);
	}
	
/********************* Funcion que lista los datos ************************/
	
	function listar($where=" 1 = 1 ")
	{
		/* Me conecto con el servidor */		        
		//$bd=new libreta(TIPO_BD,NOMBRE_HOST,NOMBRE_DB,USUARIO,CLAVE);		
		$bd=new libreta("mysql","localhost","libreta","root","");
		/* Tercero hago la sentencia para listar los datos */
	    $sql="select * from libreta where $where";
	    	    
	    /* Ejecuto la sentencia SQL */
	    $resultado= mysql_query($sql);
	    
	    echo " 
	    		<br>
	    		<form action=libreta.php?funcion=eliminar method=post>
	    		<table border = 1>
	        	<thead> <th><input type=submit value='Eliminar'></th><th>Modificar </th><!--<th>Eliminar fila </th> para el eliminar de abajo-->
	        	<th> Nombres</th><th>Apellidos</th><th>Telefono</th><th>Celular</th><th>Direccion</th>
	        	<th>Barrio</th><th>Mail</th><th>Ocupacion</th><th>Sesion</th><th>Sexo</th> </thead>
	      		</tbody>
	    		
	    	 ";
	    	 
	    	     $contador=0;
     	while($valores=mysql_fetch_assoc($resultado))	   
         {
	       echo "
	             <tr>   
	             		<td><center><input type=checkbox name=eliminar[$contador] value={$valores['cedula']}></center></td>
		            	<td><a href=libreta.php?funcion=modificar&cedula={$valores['cedula']}>{$valores['cedula']}</a></td>
		            	<!--<td><a href=libreta.php?funcion=eliminar2&cedula={$valores['cedula']}>
		            	{$valores['cedula']}</a></td> para eliminar por fila -->
		            	<td>{$valores['nombres']}</td><td>{$valores['apellidos']}</td><td>{$valores['tel']}</td><td>{$valores['cel']}</td><td>{$valores['dir']}</td>
		            	<td>{$valores['barrio']}</td><td>{$valores['mail']}</td><td>{$valores['ocupacion']}</td><td>{$valores['sesion']}</td>
		            	<td>{$valores['sexo']}</td>
		    	</tr>
		   
		   ";  
		   $contador ++;
	     }
	    
	 	/* Cuarto cierro la base de datos */  	
        $bd->cerrar();  
  		
        echo
	    " 
	    	</tbody></table>
	   		</form> 
	    ";
		
	
	}
	
/********************* Funcion que busca informacion ************************/	
	
	function buscar()
	{
		if($_SERVER['REQUEST_METHOD']=="POST")
	   	 {
		   	 $where = "1=1";
		   	 
		   	 if(!empty($_REQUEST['cedula']))
	    	  {
	      		$where.=" and cedula like '%{$_REQUEST['cedula']}%'"; 
	    	  }  
	    	  	    	  	
	    	 listar($where);
         }
         
		 else
	     {  
		     form_buscar("buscar",$valor);	
         }
	 	
	}
	 
/********************* Funcion que muestra el formulario para hacer la busqueda ************************/	
	function form_buscar($funcion,$valores)
	{
		echo "
        <html>
	     <div align=center>
		 <h1><b><i>$funcion</i></b></h1>
		 </div>
		 
		 <body>
		   <form action=libreta.php?funcion=$funcion method=post>
		    <center>
		      <table border = 1 cellspacing=5 cellpadding=2 width = 100> 
		      	<tr><td><strong><em> Cedula </td>
				<td><input type=text name=cedula value='{$valores['cedula']}'>
			  </table> <br><center><input type=submit value='Enviar'></center>
		    </center>
		   </form>
	    </html>
	   ";
	}
/********************* Funcion que modifica la informacion ************************/	
	
	function modificar()
	{
		if($_SERVER['REQUEST_METHOD']=="POST")
         { 
          
	        /* Primero me conecto con el servidor */		        
			$conexion=mysql_connect("localhost","root","")or die ("No se puede conectar al servidor");
		
			/* Segundo ascedo a la base de datos*/
			mysql_select_db("libreta",$conexion)or die ("No se puede conectar a la base de datos");
			
	        $sql="update libreta set cedula='{$_REQUEST['cedula']}',nombres='{$_REQUEST['nombres']}',apellidos='{$_REQUEST['apellidos']}',tel='{$_REQUEST['tel']}',cel='{$_REQUEST['cel']}',dir='{$_REQUEST['dir']}',barrio='{$_REQUEST['barrio']}',mail='{$_REQUEST['mail']}',ocupacion='{$_REQUEST['ocupacion']}',sesion='{$_REQUEST['sesion']}',sexo='{$_REQUEST['sexo']}'
	        where cedula='{$_REQUEST['cedula']}' ";
	        
	        $resultado=mysql_query($sql); 
	        
	        /* Cierro la base de datos */
	        mysql_close($conexion);
			$valor = $_REQUEST ;
	                  
         }
		  else
              {
	       		 /* Primero me conecto con el servidor */		        
				 $conexion=mysql_connect("localhost","root","")or die ("No se puede conectar al servidor");
		
				 /* Segundo ascedo a la base de datos*/
				 mysql_select_db("libreta",$conexion)or die ("No se puede conectar a la base de datos");
				 
				 /* Ejecute el sql */
	   			 $sql="select * from libreta where cedula='{$_REQUEST['cedula']}'";
	   			 
	   			 $resultado=mysql_query($sql);
	   			 
	   			 $valor=mysql_fetch_assoc($resultado);
	   			 
	   			 /* Cierro la base de datos */
	   			 mysql_close($conexion);
	      	  }
		formulario("modificar",$valor);
	}
	
/********************* Funcion que elimina informacion ************************/	
	
	function eliminar()
	{
		/* Primero me conecto con el servidor */		        
		$conexion=mysql_connect("localhost","root","")or die ("No se puede conectar al servidor");
		
		/* Segundo ascedo a la base de datos*/
		mysql_select_db("libreta",$conexion)or die ("No se puede conectar a la base de datos");
		
		foreach($_REQUEST['eliminar'] as $valor)
	    {
		
			/* Tercero hago la sentencia para listar los datos */
	    	$sql="delete from libreta where cedula = $valor";
	    	    
	    	/* Cuarto Ejecuto la sentencia SQL */
	    	$resultado = mysql_query($sql);
		}
			/* Cierro la base de datos */
			mysql_close($conexion);
			
	    listar();
		
	}
	
/************************************************************************************************************************
				Funcion para eliminar por campo
************************************************************************************************************************/   
function eliminar2 ()
   {
     
	   /* Primero me conecto con el servidor */		        
		$conexion=mysql_connect("localhost","root","")or die ("No se puede conectar al servidor");
		
		/* Segundo ascedo a la base de datos*/
		mysql_select_db("libreta",$conexion)or die ("No se puede conectar a la base de datos");
		
	   $sql="delete from libreta where cedula='{$_REQUEST['cedula']}'";
	   $resultado=mysql_query($sql);
	   $valor=mysql_fetch_assoc($resultado);
	   mysql_close($conexion);
	   
	   /* Primero me conecto con el servidor */		        
		$conexion=mysql_connect("localhost","root","")or die ("No se puede conectar al servidor");
		
		/* Segundo ascedo a la base de datos*/
		mysql_select_db("libreta",$conexion)or die ("No se puede conectar a la base de datos");
		
		$sql="update libreta set cedula='{$_REQUEST['cedula']}',nombres='{$_REQUEST['nombres']}',apellidos='{$_REQUEST['apellidos']}',tel='{$_REQUEST['tel']}',cel='{$_REQUEST['cel']}',dir='{$_REQUEST['dir']}',barrio='{$_REQUEST['barrio']}',mail='{$_REQUEST['mail']}',ocupacion='{$_REQUEST['ocupacion']}',sesion='{$_REQUEST['sesion']}',sexo='{$_REQUEST['sexo']}'
	    where cedula='{$_REQUEST['cedula']}' ";
		
	   $resultado=mysql_query($sql); 
	   mysql_close($conexion);
		   
	   listar();
  }        	
	
/********************* Funcion que muestra el formulario ************************/	
	
	function formulario($funcion,$valores)
	{
		echo "
        <html>
	     <title> Funcion $funcion </title>  
		 <div align=center>
		 <h1><b><i>$funcion</i></b></h1>
		 </div>
		 
		 <body>
		   <form action=libreta.php?funcion=$funcion method=post>
		    <center>
		      <table border = 1 cellspacing=5 cellpadding=2 width = 100> 
		      	<tr><td><strong><em> Cedula </td>
				<td><input type=text size=28 name=cedula value='{$valores['cedula']}'>
				<tr><td><strong><em> Nombres </td>
				<td><input type=text size=28 name=nombres value='{$valores['nombres']}'>
				<tr><td><strong><em> Apellidos </td>
				<td><input type=text size=28 name=apellidos value='{$valores['apellidos']}'>
				<tr><td><strong><em> Direccion </td>
				<td><input type=text size=28 name=dir value='{$valores['dir']}'>
				<tr><td><strong><em> Telefono </td>
				<td><input type=text size=28 name=tel value='{$valores['tel']}'>
				<tr><td><strong><em> Celular </td>
				<td><input type=text size=28 name=cel value='{$valores['cel']}'>
				<tr><td><strong><em> Barrio </td>
				<td><input type=text size=28 name=barrio value='{$valores['barrio']}'>
				<tr><td><strong><em> Mail </td>
				<td><input type=text size=28 name=mail value='{$valores['mail']}'>
				<tr><td><strong><em> Ocupacion </td>
				<td><input type=text size=28 name=ocupacion value='{$valores['ocupacion']}'>
				<tr><td><strong><em> Sesion </td>
				<td><input type=text size=28 name=sesion value='{$valores['sesion']}'>
				<tr><td><strong><em> Sexo </td>
				<td><input type=text size=28 name=sexo value='{$valores['sexo']}'>
    		    </table> <br><center><input type=submit value='Enviar'></center>
		    </center>
		   </form>
	    </html>
	   "; 	  
		}
			      	
		?>
		
		  
	</body>

</html>