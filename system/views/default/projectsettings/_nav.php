<nav id="project_settings_nav" class="tabs">
	<ul>
		<li<?php echo iif(active_nav('/:slug/settings'), ' class="active"')?>><?php echo HTML::link(l('information'), "{$project->slug}/settings"); ?></li>
		<li<?php echo iif(active_nav('/:slug/settings/milestones(.*)'), ' class="active"')?>><?php echo HTML::link(l('milestones'), "{$project->slug}/settings/milestones"); ?></li>
		<li<?php echo iif(active_nav('/:slug/settings/components(.*)'), ' class="active"')?>><?php echo HTML::link(l('components'), "{$project->slug}/settings/components"); ?></li>
		<li<?php echo iif(active_nav('/:slug/settings/permissions/groups'), ' class="active"')?>><?php echo HTML::link(l('group_permissions'), "{$project->slug}/settings/permissions/groups"); ?></li>
		<li<?php echo iif(active_nav('/:slug/settings/permissions/roles'), ' class="active"')?>><?php echo HTML::link(l('role_permissions'), "{$project->slug}/settings/permissions/roles"); ?></li>
	</ul>
</nav>