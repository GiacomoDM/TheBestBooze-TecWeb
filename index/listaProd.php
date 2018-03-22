<?php
if(!file_exists("connection_db.php") ||
        !file_exists("funLog.php") ||
        !file_exists("numeroProd.php") ||
        !file_exists('html/listaProd.txt') ||
        !file_exists("filtro.php"))
{ header('Location:404.php');exit; }
                include_once"numeroProd.php";
                include_once"connection_db.php";
                include_once"funLog.php";
                include_once"filtro.php";
                inizio();
                rigeneraId(false,false,false,false);
                if(empty($_SESSION['Admin']))
                        { header('Location:loginAm.php');exit; }
                global $conn;
                $pag = filter_input(INPUT_GET , 'pagina' , FILTER_UNSAFE_RAW , FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
                if(empty($pag))
                      { $pag = 0; }
                $pag = filtroBase($pag);
                if(!ctype_digit($pag))
                        { $conn->close();header('Location:404.php');exit; }
                $tasso = 10;
                ($pag > 0) ? $ini = ($pag * $tasso) - 1 : $ini = ($pag * $tasso);
                if($result = $conn->query("SELECT * FROM Prodotto LIMIT $ini , $tasso")){
                                $rig = numProd($conn);
                                if($rig < 0)
                                { $result->close();$conn->close();header('Location:404.php');exit; }
                                $numPag = intdiv($rig , 10);
                                if(($rig % 10) > 0)
                                        $numPag++;
                                if($pag > $numPag)
                                { $result->close();$conn->close();header('Location:404.php');exit; }
                                if($rig > 0){
                                $out = file_get_contents('html/listaProd.txt');
                                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                $cod =  $row['Codice'];
                                if($row['Sottocategoria'] === null)
                                $row['Sottocategoria'] = "NULL";
                                if($row['Anno'] === null)
                                $row['Anno'] = "NULL";
                                $row['Disponibile'] ? $row['Disponibile'] = 'SI' : $row['Disponibile'] = 'NO';
                                $out .= "<tr>";
                                $out .= "<th id='COD$cod'" . " scope='row'>$cod</th>";
                                $out .= "<td headers='NOM'>" . $row['Nome'] . "</td>";
                                $out .= "<td headers='PREZ'>" . $row['Prezzo'] . "</td>";
                                $out .= "<td headers='CAT'>" . $row['Categoria'] . "</td>";
				 $out .= "<td headers='SCAT'>" . $row['Sottocategoria'] . "</td>";
                                $out .= "<td headers='ANN'>" . $row['Anno'] . "</td>";
                                $out .= "<td headers='PROD'>" . $row['Produttore'] . "</td>";
                                $out .= "<td headers='LANG'>" . $row['Lingua'] . "</td>";
                                $out .= "<td headers='DISP'>" . $row['Disponibile'] . "</td>";
                                $out .= '<td headers="Modifica" class="hide"><a class="edit" href="modProd.php?COD=' . $cod . '&amp;pagina=' . $pag . '&amp;vnome=' . $row["Nome"] . '"><span>Modifica</span></a></td>';
                                $out .= "<td headers='Cambia' class='hide'><a class='switch' href='DelProd.php?COD=$cod&amp;pagina=$pag'><span>Cambia Disponibilità</span></a></td></tr>"; }
                                $out .= "</tbody></table>";
                                 $out .= "<div class='paging'><span>Vai alla pagina:</span><ul>";
                                $aux = $pag - 1;
                                if($pag > 0)
                                        $out .= "<li><a href='?pagina=" . $aux . "'>Pagina precedente</a></li>";
                                for($i = 0 ; $i < $numPag ; $i++){
                                        if($pag == $i)
                                                $out .= "<li class='active'><a>" . $i . "</a></li>";
                                        else
                                                $out .= "<li><a href='?pagina=$i'>" .
                                                        $i . "</a></li>";
                                }
                                $aux = $pag + 1;
                                if(($aux) < $numPag)
                                $out .= "<li><a href='?pagina=$aux'>
                                        Pagina successiva</a></li>";
                                $out .= "</ul></div></div></div></body></html>";
                                        }
                                else{
                                        $out = file_get_contents('html/listaVuota.txt');
                                        $out .= "<h1>Nessuno prodotto presente , non ci sono informazioni da visualizzare!</h1>";
                                        $out .= "</div></div></body></html>";
                                        }
                                        $result->free();
                                        echo $out;
                                         }
        else { header('Location:404.php');exit; }
?>
