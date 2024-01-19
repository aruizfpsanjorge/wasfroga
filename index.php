<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>DAW: Docker Compose-rekin lanean</title>
		<link href="estiloak.css?v=<?php echo(rand()); ?>" rel="stylesheet">
	</head>
 
	<body>
        <?php
            if (isset($_POST['produktu'])) {
                $produktu = $_POST['produktu'];
                // echo $produktu;
            }

            // Konexioa sortu
            $servername = "dbfroga.cboi20ycqjno.us-east-1.rds.amazonaws.com";
            $database = "aws";
            $username = "admin";
            $password = "AdminInfor23";
            $conn = new mysqli($servername, $username, $password, $database);

            // Konexioa frogatu
            if (!$conn) {
                die("Errorea konexioan: " . $conn->connect_errno);
            }

            // Datuak eguneratu behar ditugun konprobatzen dugu
            if (isset($_POST['eguneratu'])) {
                // Kontsulta prestatzen dugu
                $denda = $_POST['denda'];
                $kopurua = $_POST['kopurua'];
                // echo print_r($denda);
                // echo print_r($kopurua);

                $kontsulta = $conn->stmt_init();
                $sql = "UPDATE stock SET kopurua=? WHERE denda=? AND produktu='$produktu'";
                $kontsulta->prepare($sql);

                // Bukle baten barnean exekutatzen dugu, denda kopurua bezain beste
                $conn->autocommit(true);
                for($i=0;$i<count($denda);$i++) {
                    // echo "kopurua[" . $i . "] = " . $kopurua[$i];
                    // echo $denda[$i];
                    $kontsulta->bind_param('ii', $kopurua[$i], $denda[$i]);
                    $kontsulta->execute();
                }

                // $conn->commit();
                $mensaje = "Datuak eguneratu dira.";
                $kontsulta->close();

            }
        ?>

		<header id="encabezado">
			<h1>DAW: Docker Compose</h1>			
		</header>

		<section id="contenido">
			<form id="form_aukeratu" action="index.php" method="post">
				<span>Produktua: </span>
				<select name="produktu">
					<?php
					// Select-a betetzen dugu produktu guztien informazioarekin
					if ($conn) {
						$sql = "SELECT kodea, izen_laburra FROM produktu";
						$emaitza = $conn->query($sql);
						if($emaitza) {
							$row = $emaitza->fetch_assoc();
							while ($row != null) {
								echo "<option value='${row['kodea']}'";
								// Produktu baten kodea jasotzen badugu select-ean produktu hori aukeratzen dugu
								if (isset($produktu) && $produktu == $row['kodea'])
								echo " selected='true'";
								echo ">${row['izen_laburra']}</option>";
								$row = $emaitza->fetch_assoc();
							}
							$emaitza->close();
						}
					}
					?>
				</select>
				<input type="submit" value="Stock-a erakutsi" name="bidali"/>
            </form>
			
            <h3>Produktuaren stock-a dendetan:</h3>        
            <?php
                // Produktu baten kodea jaso badugu, produktu horrek denda desberdinetan duen
				// stock-a erakusten dugu
                if ($conn && isset($produktu)) {
                    // Orain dendaren kodea behar dugu baita ere
                    $sql = "SELECT denda.kodea, denda.izena, stock.kopurua
                    FROM denda INNER JOIN stock ON denda.kodea=stock.denda
                    WHERE stock.produktu='$produktu'";
                    $emaitza = $conn->query($sql);
                    if($emaitza) {
                        // Lortutako datuekin formulario bat sortzen dugu
                        echo '<form id="form_eguneratu" action="index.php" method="post">';
                        $row = $emaitza->fetch_assoc();
                        while ($row != null) {                            
                            echo "<input type='hidden' name='produktu' value='$produktu'/>";
                            echo "<input type='hidden' name='denda[]' value='".$row['kodea']."'/>";
                            echo "<p>${row['izena']} denda: ";                           
                            echo "<input type='text' name='kopurua[]' size='4' ";
                            echo "value='".$row['kopurua']."'/> unitate.</p>";
                            $row = $emaitza->fetch_assoc();
                        }
                        $emaitza->close();
                        echo "<input type='submit' value='Eguneratu' name='eguneratu'/>";
                        echo "</form>";
                    }
                }
                ?>
		</section>

		<footer id="pie">
			<?php
			// Erroreren bat egotekotan orrialdearen oinan bistaratzen da
			if (!$conn)
				echo "<p>Errore bat gertatu da!</p>";
			else {
				echo "<p>CIFP San Jorge LHII</p>";
				$conn->close();
				unset($conn);
			}
			?>
		</footer>
	</body>
</html>
