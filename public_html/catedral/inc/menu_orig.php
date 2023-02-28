<ul class="menu">
  <?
    foreach ($categorias as  $key => $catmenu) {
      echo '<li class="list">
              <a href="javascript:;">'.$catmenu["categoria_nombre"].'</a>';
              $subcategoriaNivel1 = Categorias::get("categoria_parent =".$catmenu['categoria_id'],"categoria_id DESC");
              if(haveRows($subcategoriaNivel1)){
                echo '<ul class="items">';
                  foreach ($subcategoriaNivel1 as $nivel1) {
                      $subCategoriaNivel3 = Categorias::get("categoria_parent =".$nivel1["categoria_id"],"categoria_id DESC");
                      $classList = haveRows($subCategoriaNivel3) ? 'class="list"' : '';
                      $enlace = haveRows($subCategoriaNivel3) ? "javascript:;" : "productos/".$nivel1["categoria_slugit"];
                      echo '<li '.$classList.'> <a href="'.$enlace.'" >'.$nivel1["categoria_nombre"].'</a>';
                        if(haveRows($subCategoriaNivel3)){
                          echo '<ul class="items">';
                          foreach ($subCategoriaNivel3 as $nivel3) {

                            echo '<li> <a href="productos/'.$nivel3["categoria_slugit"].'" >'.$nivel3["categoria_nombre"].'</a></li>';
                          }
                          echo '</ul>';
                        }
                      echo '</li>';
                  }
                echo '</ul>';
              }

      echo '</li>';
    }
    
  ?>
</ul>
<script>
var list = document.querySelectorAll('.list');

function accordion(e) {
    e.stopPropagation();
    if (this.classList.contains('active')) {
        this.classList.remove('active');
    } else
    if (this.parentElement.parentElement.classList.contains('active')) {
        this.classList.add('active');
    } else
    {
        for (i = 0; i < list.length; i++) {
            list[i].classList.remove('active');

        }
        this.classList.add('active');
    }
}
for (i = 0; i < list.length; i++) {
    list[i].addEventListener('click', accordion);
}
</script>
<?