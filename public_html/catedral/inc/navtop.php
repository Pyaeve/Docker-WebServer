<?php 
	$categorias = $categorias = Categorias::get("categoria_parent = 1 AND categoria_id <> 2","categoria_id DESC");
	foreach($categorias as $categoria) {
		echo "<li>";
		echo "	<a href='productos/".$categoria["categoria_slugit"]."'>".$categoria["categoria_nombre"]."</a>";
		$subcategorias = $subcat = Categorias::get("categoria_parent = ".$categoria['categoria_id'],"categoria_nombre ASC");
		echo "	<ul>";
		foreach ($subcategorias as $sub) {
			echo "	<li>";
			$subcat = Categorias::get("categoria_parent = ".$sub['categoria_id'],"categoria_nombre ASC");
			echo "		<a href='productos/".$sub["categoria_slugit"]."'>";
			echo substr($sub["categoria_nombre"],0,25)."..";
			echo "		</a>";
			echo "		<ul>";
			foreach ($subcat as $sc) {
				echo " 		<li>";
				echo "			<a href='productos/".$sc["categoria_slugit"]."'>";
				echo substr($sc["categoria_nombre"],0,25)."..";
				echo "			</a>";
				echo "     	</li>";
			}
			echo "  	</ul>";
			echo "	</li>";
		}
		echo "	</ul>";
		echo "</li>";
	}
?>

