<div class="panel panel-default panelMenu borderless" style="height: 69px !important;">
	<div class="panel-body link-nav" style="padding-top: 40px;">
		<span style="color: black; font-size: 20px;"><?php echo e($user->name); ?></span>
		<div class="pull-right" style="margin-right: 20px;">
			<a href="/profile/<?php echo e($user->id); ?>/edit" class="geral" style="margin-right: 40px;"> <span>Geral</span> </a>
			<a href="/profile/<?php echo e($user->id); ?>/editDetails" class="outra"> <span>Outra</span> </a>
		</div>
	</div>
</div>
<div class="row">
    <hr style="margin-top: 0px; margin-left: 0; width: 100%;">
</div>