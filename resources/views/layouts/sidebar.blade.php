<div class="list-group sidebar fixed">
	<div class="home">
		<a href="#" class="list-group-item list-group-action no-border-nav"><div class="title"><p style="padding-left: 10%;">Home</p></div></a>
	</div>
	<div class="empresa">
		<a href="/structure" class="list-group-item list-group-action no-border-nav" id="empresa"> <div class="title"><p style="padding-left: 10%;">Empresa </p></div></a>
		<div class="empresa_sub" style="display: none;height:0%;">
			<a href="/structure" class="list-group-item list-group-action no-border-nav"> <p style="padding-left: 20%;">Estrutura</p></a>
			<a href="/company/2" class="list-group-item list-group-action no-border-nav"> <p style="padding-left: 20%;">Colaboradores</p></a>
			<a href="/scheduler" class="list-group-item list-group-action no-border-nav"> <p style="padding-left: 20%;">Calendário</p></a>
			<a href="#" class="list-group-item list-group-action no-border-nav"> <p style="padding-left: 20%;">Contactos</p></a>
		</div>
	</div>
	<div class="gestao_projetos">
			<a href="/projects" class="list-group-item list-group-action no-border-nav" id="projetos"><div class="title"> <p style="padding-left: 10%;">Gestão de Projetos</p></div></a>
		<div class="gestao_projetos_sub" style="display: none;height:0%;">
			<a href="/projects" class="list-group-item list-group-action no-border-nav"> <p style="padding-left: 20%;">Projetos</p></a>
			<a href="#" class="list-group-item list-group-action no-border-nav"> <p style="padding-left: 20%;">Atividades</p></a>
			<a href="/planning" class="list-group-item list-group-action no-border-nav"> <p style="padding-left: 20%;">Planeamento</p></a>
			<a href="#" class="list-group-item list-group-action no-border-nav"> <p style="padding-left: 20%;">Relatórios</p></a>
		</div>
	</div>
</div>        


<script>

	$(".empresa").hover(function(){
		$(".empresa_sub").finish();
		$( ".empresa_sub" ).animate({
			height: "197"
		});
		$(".empresa_sub").show();
	}, function(){
		$(".empresa_sub").finish();
		$( ".empresa_sub" ).animate({
			height: "0"
		},function() {
			$(".empresa_sub").hide();
		});
	});

	$(".gestao_projetos").hover(function(){
		$(".gestao_projetos_sub").finish();
		$( ".gestao_projetos_sub" ).animate({
			height: "197"
		});
		$(".gestao_projetos_sub").show();
	}, function(){
		$(".gestao_projetos_sub").finish();
		$( ".gestao_projetos_sub" ).animate({
			height: "0"
		},function() {
			$(".gestao_projetos_sub").hide();
		});
	});

</script>