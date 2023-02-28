<section class="content12 " id="content12-2i">
		<div class="row justify-content-center" style="margin-top: 20px; background: #0f3b84;" >
			<nav id="menu">
				<label for="tm" id="toggle-menu">CATEGORIAS <span class="drop-icon">▾</span></label>
				<input type="checkbox" id="tm">
				<ul class="main-menu clearfix">
				<? 	$categorias = Categorias::get("categoria_parent = 1","categoria_id DESC");
					$a = 1;
					$html="";

					foreach ($categorias as $categoria):
						$html.= '<li>
								<a href="productos/'.$categoria["categoria_slugit"].'">'.$categoria["categoria_nombre"];
								$subcat = Categorias::get("categoria_parent = ".$categoria['categoria_id'],"categoria_nombre ASC");
								$subclose = 0;
								if(haveRows($subcat)){
									$subclose = 1;
									$html.='<span class="drop-icon">▾</span>
									<label title="Toggle Drop-down" class="drop-icon" for="sm1">▾</label></a>
									<input type="checkbox" id="sm1">
											<ul class="sub-menu">';
										foreach ($subcat as $sub) {
											$familias = Categorias::get("categoria_parent = ".$sub['categoria_id'],"categoria_nombre ASC");
											$fclose = 0;
											$html.='<li><a href="productos/'.$sub["categoria_slugit"].'">'.$sub["categoria_nombre"];
												if(haveRows($familias)){
														$fclose = 1;
														$html.='<span class="drop-icon">▾</span>
			            								<label title="Toggle Drop-down" class="drop-icon" for="sm2">▾</label></a>
			            								<input type="checkbox" id="sm2">
			            								<ul class="sub-menu">';
			            								foreach ($familias as $family) {
			            									$html.='<li><a href="productos/'.$family["categoria_slugit"].'">'.$family["categoria_nombre"].'</a></li>';
			            								}
			            								$html.='</ul>';
												}
												$html.= $fclose == 0 ? '</a>' : '';
											$html.='</li>';											
										}
										
									$html.='</ul>';
								}
						  		$html.= $subclose == 0 ? '</a>' : '';
						$html.='</li>';
						$a++;
					endforeach;
					echo $html;
				?>

				</ul>

			</nav>
		</div>
</section>