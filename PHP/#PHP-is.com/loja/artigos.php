<?php
$categorias = array ( "GF" => array ("0","Grandes Formatos"),
					  "ID" => array ("0", "Impressão digital"),
					  "ID1" => array ("ID", "Envelopes"),
					  "ID2" => array ("ID", "Papel 80g"),
					  "ID3" => array ("ID", "Cartolina"),
					  "IO" => array ("0", "Impressão offset"),
					  "AC" => array ("0", "Acabamentos")
					)  ;  // categorias [] [0]..., 
// artigos id => array (cat,nome,uni,preço) 	  	  
$artigos = array (
"I01"  => array ("ID2","Mono - Livros, teses e currículos","Pagina",".05"),
"I02"  => array ("ID2","Cores - Livros, teses e currículos","Pagina",".1"),
"I03"  => array ("ID3","Cartolina Cores - A4","Pagina",".15")
) ;
				
?>