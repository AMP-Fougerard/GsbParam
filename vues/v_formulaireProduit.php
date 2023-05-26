<script>
   lesContenances= [];

    function ajouterContenance() {
         rep = true;
         length=lesContenances.length;
         id=length;
         while(id in lesContenances){
            id++;
         }
         lesContenances[id]=[""];
                trb = document.createElement("tr");
                trb.setAttribute("id","tr"+ id);

                th1 = document.createElement("th");
                th1.appendChild(document.createTextNode("#"));
                th1.setAttribute("scope","row");

                td2 = document.createElement("td");
                td2.setAttribute("class","input-group");
                i1 = document.createElement("input");
                i1.setAttribute("id",id + "-prix");
                i1.setAttribute("name",id + "-prix");
                i1.setAttribute("class","form-control");
                i1.setAttribute("type","number");
                i1.setAttribute("value","");
                i1.setAttribute("min","0.01");
                i1.setAttribute("step","0.01");
                s1 = document.createElement("span");
                s1.setAttribute("class","input-group-text");
                s1.appendChild(document.createTextNode("€"));
                td2.appendChild(i1);
                td2.appendChild(s1);

                td3 = document.createElement("td");
                i2 = document.createElement("input");
                i2.setAttribute("id",id + "-stock");
                i2.setAttribute("name",id + "-stock");
                i2.setAttribute("type","number");
                i2.setAttribute("value","");
                i2.setAttribute("min","0");
                i2.setAttribute("class","form-control");
                i2.setAttribute("required",true);
                td3.appendChild(i2);

                td4 = document.createElement("td");
                i3 = document.createElement("input");
                i3.setAttribute("id",id + "-cont");
                i3.setAttribute("name",id + "-cont");
                i3.setAttribute("type","number");
                i3.setAttribute("value","");
                i3.setAttribute("min","0");
                i3.setAttribute("class","form-control"); 
                i3.setAttribute("required",true);
                td4.appendChild(i3);

                td5 = document.createElement("td");
                i4 = document.createElement("input");
                i4.setAttribute("id",id + "-unit");
                i4.setAttribute("name",id + "-unit");
                i4.setAttribute("type","text");
                i4.setAttribute("value","");
                i4.setAttribute("class","form-control");
                i4.setAttribute("required",true);
                i4.setAttribute("list","unites");
                td5.appendChild(i4);

                td6 = document.createElement("td");
                b = document.createElement("button");
                b.setAttribute("class","btn-close");
                b.setAttribute("id","close");
                b.setAttribute("name","close");
                b.setAttribute("onclick","enleverContenance('"+ id +"')");
                b.setAttribute("data-bs-dismiss","alert");
                td6.appendChild(b)

                trb.appendChild(th1);
                trb.appendChild(td2);
                trb.appendChild(td3);
                trb.appendChild(td4);
                trb.appendChild(td5);
                trb.appendChild(td6);

                document.getElementById('tbody').appendChild(trb);
        return rep;
    }

    function enleverContenance(id) {
        // Suppression de la ligne de l'élèment grâce à l'id donné si celui si existe
        rep = true;
        elem = document.getElementById("tr"+id);
        // console.log(elem);

        index = lesContenances.indexOf(id);
        lesContenances.splice(index, 1);
        if (elem != null) {
            elem.remove();
        } else {
            rep = false;
        }
        return rep;
    }

    function initTabCont(contenance) 
    {
        if ( typeof(contenance) == 'object' ) {
            for (var key in contenance) {
               lesContenances[key]=[contenance[key]['prix'],contenance[key]['stock'],contenance[key]['cont'],contenance[key]['unit']]

                trb = document.createElement("tr");
                trb.setAttribute("id","tr"+ key);

                th1 = document.createElement("th");
                th1.appendChild(document.createTextNode(key));
                th1.setAttribute("scope","row");

                td2 = document.createElement("td");
                td2.setAttribute("class","input-group");
                i1 = document.createElement("input");
                i1.setAttribute("id",key + "-prix");
                i1.setAttribute("name",key + "-prix");
                i1.setAttribute("class","form-control");
                i1.setAttribute("type","number");
                i1.setAttribute("value",contenance[key]['prix']);
                i1.setAttribute("min","0.01");
                i1.setAttribute("step","0.01");
                s1 = document.createElement("span");
                s1.setAttribute("class","input-group-text");
                s1.appendChild(document.createTextNode("€"));
                td2.appendChild(i1);
                td2.appendChild(s1);

                td3 = document.createElement("td");
                i2 = document.createElement("input");
                i2.setAttribute("id",key + "-stock");
                i2.setAttribute("name",key + "-stock");
                i2.setAttribute("type","number");
                i2.setAttribute("value",contenance[key]['stock']);
                i2.setAttribute("min","0");
                i2.setAttribute("class","form-control");
                i2.setAttribute("required",true);
                td3.appendChild(i2);

                td4 = document.createElement("td");
                i3 = document.createElement("input");
                i3.setAttribute("id",key + "-cont");
                i3.setAttribute("name",key + "-cont");
                i3.setAttribute("type","number");
                i3.setAttribute("value",contenance[key]['cont']);
                i3.setAttribute("min","0");
                i3.setAttribute("class","form-control");
                i3.setAttribute("required",true);
                td4.appendChild(i3);

                td5 = document.createElement("td");
                i4 = document.createElement("input");
                i4.setAttribute("id",key + "-unit");
                i4.setAttribute("name",key + "-unit");
                i4.setAttribute("type","text");
                i4.setAttribute("value",contenance[key]['unit']);
                i4.setAttribute("class","form-control");
                i4.setAttribute("required",true);
                i4.setAttribute("list","unites");
                td5.appendChild(i4);

                td6 = document.createElement("td");
                b = document.createElement("button");
                b.setAttribute("class","btn-close");
                b.setAttribute("id","close");
                b.setAttribute("name","close");
                b.setAttribute("onclick","enleverContenance('"+ key +"')");
                b.setAttribute("data-bs-dismiss","alert");
                td6.appendChild(b)

                trb.appendChild(th1);
                trb.appendChild(td2);
                trb.appendChild(td3);
                trb.appendChild(td4);
                trb.appendChild(td5);
                trb.appendChild(td6);

                tbody.appendChild(trb);
            }
        }
    }
</script>
<div id="formulaireProduit" class="container mb-5 rounded " style="width: 90%;">
<form method="post" action="index.php?uc=administrer&action=confirmerProduit" enctype="multipart/form-data">
   <fieldset class="container border">
      <p><small><b class="text-danger">*</b> Champs facultatif(s)</small></p>
      <legend class="text-center"><?php echo $action; ?> un produit</legend>
      
      <?php if($action=="Editer"){echo '<p class="text-center">Produit '.$id.'</p>';}?>
      
      <!-- permet de récupérer l'ancienne id -->
      <input type="hidden" id="id" name="id" value="<?php echo $id ?>">

      <div class="row mb-4">
      	<div class="border border-bottom-0 border-top-0 col-5 p-3" >
            <div class="form-group mb-2">
               <label for="name" class="control-label">Nom du produit</label>
               <input class="form-control" id="name" name="name" type="text" value="<?php echo $name ?>" size="10">
            </div>
            <div class="form-group mb-2">
         		<label for="desc" class="control-label">Description du produit</label>
         		<textarea class="form-control" id="desc" name="desc" cols="25" rows="3"><?php echo $desc ?></textarea>
         	</div>
         	<div class="form-group mb-2">
         		<label for="img" class="control-label">Image</label>
               <input class="form-control" id="img" type="file" name="img" accept="image/png, .jpeg, .jpg, image/gif">
               <?php if ($img != ''){
                  echo 'lien actuel : assets/'.$img; 
                  echo '<BR/>';
                  echo '<img src="assets/'.$img.'" alt="image" style="height: 150px;" />';
               } ?>
         	</div>
            <!-- permet de récupérer l'ancienne image si rien n'est sélectionné dans le input 'file' -->
            <input type="hidden" id="img" name="img" value="<?php echo $img ?>">
         </div>
         <div class="border border-bottom-0 border-top-0 col p-3">
            <div class="form-group mb-2">
               <label for="marque" class="control-label">Marque du produit</label>
               <input class="form-control" id="marque" name="marque" type="text" value="<?php echo $name ?>" size="10" list="marques">
               <datalist id="marques">
                  <?php foreach($lesMarques as $uneMarque){
                     echo '<option value="'.$uneMarque['nom_marque'].'">;';
                  }?>
               </datalist>
            </div>
         	<div class="form-group mb-2">
               <label for="categ" class="control-label">Catégorie du produit</label>
               <select class="form-control" id="categ" name="categ">
                  <option value="" selected >- choisir une catégorie -</option>
                  <?php $lesCategories = getLesCategories();
                     foreach($lesCategories as $uneCategorie){
                        $idCategorie = $uneCategorie['id'];
                        $libCategorie = $uneCategorie['libelle'];
                        if($categ==$idCategorie)
                           echo '<option value="'.$idCategorie.'" selected >'.$libCategorie.'</option>';
                        else
                           echo '<option value="'.$idCategorie.'" >'.$libCategorie.'</option>';
                     }
                  ?>
               </select>
            </div>
            <table class="table mb-2" id="tabCont" name="tabCont">
               <thead>
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Prix<b class="text-danger">*</b></th>
                     <th scope="col">Stock</th>
                     <th scope="col">Contenance</th>
                     <th scope="col">Unité</th>
                  </tr>
               </thead>
               <tbody id="tbody">
                  <tr id="tr1">
                     <th scope="row">Base</th>
                     <td class="input-group">
                        <input class="form-control" id="prix" type="number" name="prix" value="<?php echo $prix ?>" min="0.01" step="0.01">
                        <span class="input-group-text">€</span>
                     </td>
                     <td>
                        <input class="form-control" id="stock" type="number" name="stock" value="<?php echo $stock ?>" min="0">
                     </td>
                     <td>
                        <input class="form-control" id="cont" type="number" name="cont" value="<?php echo $cont ?>" min="0">
                     </td>
                     <td>
                        <input class="form-control" id="unit" type="text" name="unit" value="<?php echo $unit ?>" list="unites">
                        <datalist id="unites">
                           <?php foreach($lesUnit as $uneUnit){
                              echo '<option value="'.$uneUnit['unit'].'">;';
                           }?>
                        </datalist>
                     </td>
                  </tr>
               </tbody>
            </table>
            
            <p class="container text-center">
               <input class="btn btn-success" type="button" value="Ajouter contenance" name="Ajouter contenance" onclick="ajouterContenance()" style="width: 200px;">
            </p>
         </div>
      </div>
      <?php 
         if ($lesContenances != '' && $lesContenances) {
            echo "<script> initTabCont(".json_encode($lesContenances).");</script>";
         }
         // echo '<script>console.log(lesContenances);</script>';
         ?>
      <p class="container text-center">
         <input class="btn btn-success m-auto" type="submit" value="<?php echo $action; ?> le produit" name="btnconfirm">
         <input class="btn text-success border-success m-auto" style="width: 100px;" type="button" onclick="location.replace('index.php?uc=administrer')" value="Retour" name="retour">
      </p>
	</fieldset>
</form>
</div>