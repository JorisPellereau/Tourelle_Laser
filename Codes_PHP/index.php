<html>
    <head>
	<meta charset="utf-8"/>
        <title>Commande d'une tourelle laser</title>
	<link rel="stylesheet" href="style.css"/>
    </head>
    <body>
		<?php
			include("fonctions.php");
		?>
		<div><h1> Commande de la tourelle laser par liaison série</h1></div>
		<div id = "centre">
			<form name="cmd_servo" method="post" action="index.php">
			<p>
				<h2>Commande de la position :</h2></br>
				Commande en X <input type="range" min = "0" max = "255" value ="127" step="1" name="cmd_X"/></br>
				Commande en Y <input type="range" min = "0" max = "255" value="127" step="1" name="cmd_Y"/></br>
				<input type="submit" name="valider" value="OK"/>
			</p>
			</form>
		</div>

		<?php
                if(isset($_POST['valider'])) {
			$cmd_X=$_POST['cmd_X'];
                        $cmd_Y=$_POST['cmd_Y'];
                        echo 'Position en X : '.$cmd_X.'<br/>';
                        echo 'Position en Y : '.$cmd_Y.'</br>';
			$cmd = 'sudo python send_data_uart.py '.$cmd_X.' '.$cmd_Y;
//			echo $cmd.'</br>';	// Pour debug
                        $cmd = shell_exec($cmd);
//			echo $cmd;

			//-- Gestion de la base de donnee
			connectMaBase();	// Connection à la bdd
			$sql = 'UPDATE Positions_Tourelle SET Pos_X = '.$cmd_X.',Pos_Y = '.$cmd_Y.' WHERE ID=1';	// Commande pour MAJ les datas
//			$sql = 'INSERT INTO Positions_Tourelle VALUES("","'.$cmd_X.'","'.$cmd_Y.'")';		// Mise en place de la commande insertion nouvelle ligne avec datas
			mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());			// Envoi de la requete
			mysql_close();		// Deconnection à la bdd
			}
	        ?>

			<div id="centre">
				<p>
					<h2>Configuration de la communication série:</h2></br>
						<form name="form_com" method="post" action="index.php">
							Vitesse de transmission:</br></br>
							<input type="radio" name="bd" value="9600" checked >9600 bauds</br>
							<input type="radio" name="bd" value="4800">4800 bauds</br>
							<input type="radio" name="bd" value="2400">2400 bauds</br></br>

							Nombre de donnée : </br></br>
							<input type="radio" name="size_com" value="9">9 bits</br>
 							<input type="radio" name="size_com" value="8" checked >8 bits</br>
							<input type="radio" name="size_com" value="7" >7 bits</br>
							<input type="radio" name="size_com" value="6" >6 bits</br>
							<input type="radio" name="size_com" value="5" >5 bits</br></br>

							Parité : </br></br>
							<input type="radio" name="parity_com" value="Aucune" checked >Aucune</br>
							<input type="radio" name="parity_com" value="Impaire" >Impaire</br>
							<input type="radio" name="parity_com" value="Paire" >Paire</br></br>

							Nombre de bits de stop: </br></br>
							<input type="radio" name="stpb_com" value="1" checked >1 bit</br>
                                                        <input type="radio" name="stpb_com" value="2">2 bits</br></br>
							<input type="submit" name="okai" value = "Configurer"/></br></br>
						</form>
				</p>
			</div>
		<?php
			if(isset($_POST['okai'])) {
			$bd=$_POST['bd'];
			$size_com=$_POST['size_com'];
			$parity_com=$_POST['parity_com'];
			$stpb_com=$_POST['stpb_com'];
			/*
			echo $bd.' bauds </br>';
			echo $size_com.' bits </br>';
			echo $parity_com.'</br>';
			echo $stpb_com.' bits de stop </br>';
			*/
//			echo '<script>alert("La communication série est configurée et ouverte !!")</script>';
/*			$cmd = 'sudo python config_uart.py '.$bd.' '.$size_com.' '.$parity_com.' '.$stpb_com;
			echo $cmd.'</br>';
			$cmd = shell_exec($cmd);
                        echo $cmd;
			echo gettype($parity_com);*/

			 //-- Gestion de la base de donnee
                        connectMaBase();        // Connection à la bdd
			$sql = 'UPDATE Config_UART SET bauds = '.$bd.' ,nb_data = '.$size_com.' , parity = "'.$parity_com.'" , nb_stpb = '.$stpb_com.' WHERE ID = 1';
			mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());                 // Envoi de la requete
                        mysql_close();          // Deconnection à la bdd
			//--

			//--
			connectMaBase();		// Connexion à la BDD
			$sql = 'SELECT bauds, nb_data, parity, nb_stpb FROM Config_UART WHERE Id = 1'; // préparation commande lecture
			$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());		// Requete de lecture et msg erreur si besoin
			$data = mysql_fetch_array($req);	// Creaation tableau de la ligne lue
			echo '<script language="javascript">alert("La communication série est configurée et ouverte !! \nVitesse de transmission : '.$data['bauds'].' bauds\nNombre de donnees envoye : '.$data['nb_data'].' bits\nParity : '. $data['parity'].'\nNombre de bits de stop : '.$data['nb_stpb'].' bits")</script>';
//			echo '<script language="javascript">alert('La communication série est configurée et ouverte !! \n toto')</script>';
			mysql_free_result($req);		// Liberation de la memoire
			mysql_close();				// Fermeture connexion
			//--


			}
		?>
		<div>
			<form name="form_end" method="post" action="index.php">
				<br><input type="submit" name="stop_com" value="Off com série">
			</form>
		</div>
		<?php
			if(isset($_POST['stop_com'])) {
				$commande = shell_exec('sudo python stop_uart.py');	// Fermeture de la communication UART via le code python
//				echo $commande;
				echo '<script>alert("La communication série est fermée !!")</script>';
			}
		?>

    </body>

</html>
