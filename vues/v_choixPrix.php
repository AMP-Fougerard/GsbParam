<script>
	function change() {
		elementMin=document.getElementById("min");
		// console.log(elementMin);
		elementMax=document.getElementById("max");
		// console.log(elementMax);
		valueMin=Math.round(elementMin.value);
		// console.log(valueMin);
		valueMax=Math.round(elementMax.value);
		// console.log(valueMax);
		if(valueMin && valueMax){
			elementMax.setAttribute("min",valueMin+1);
			if(valueMin>valueMax){
				elementMin.value=valueMax-1;
				valueMax=Math.round(elementMax.value);
				elementMin.setAttribute("max",valueMax-1);
			}
		}
		if(valueMax){
			elementMin.setAttribute("max",valueMax-1);
			if(valueMin>valueMax){
				elementMin.value=valueMax-1;
				valueMin=Math.round(elementMin.value);
				elementMax.setAttribute("min",valueMin+1);
			}
		}
	}
</script>
<div class="border position-absolute p-3 mt-5" style="height:225px ;width: 300px;">
	<form method="POST" action="index.php?uc=voirProduits&action=nosProduitsParPrix">
		<h4 class="text-center">Filtre</h4>
		<hr/>
		<div class="row">
			<div class="col form-group mx-auto">
				<label for="min">Minimum</label>
				<div class="input-group">
                    <input id="min" name="min" type="number" placeholder="Min" onchange="change()" class="form-control" min="0" max="<?php echo $prixMax-1; ?>" value="<?php echo $valueMin; ?>">  
                    <span class="input-group-text">€</span>
                </div>
			</div>
			<div class="col form-group mx-auto">
				<label for="max">Maximum</label>
				<div class="input-group">
                    <input id="max" name="max" type="number" placeholder="Max" onchange="change()" class="form-control" min="1" max="<?php echo $prixMax; ?>" value="<?php echo $valueMax; ?>">  
                    <span class="input-group-text">€</span>
                </div>
			</div>
		</div>
		<hr/>
		<div class="form-group text-center">
			<input type="submit" class="btn btn-primary" value="Filtrer" name="filtrer">
		</div>
	</form>
</div>