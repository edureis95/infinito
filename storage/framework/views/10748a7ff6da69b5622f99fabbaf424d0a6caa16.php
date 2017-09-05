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

<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="icons.html"> Icons</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
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