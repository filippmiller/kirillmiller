<?php

$allsettings = array_merge($module['options'], $settings); ?>

<noscript class="module_GmediaList">
	<p>JavaScript is not enabled in your browser</p>
</noscript>
<script type="text/javascript">
	function gMediaListINIT()
	{
		var id = 'gMediaList'+Math.floor((1 + Math.random()) * 0x10000);
		var dataDIVs = document.body.getElementsByClassName('module_GmediaList');
		dataDIVs[dataDIVs.length-1].setAttribute('app-id', id);
		this[id] = {'settings':<?php echo json_encode($allsettings);?>, "appQuery":<?php echo json_encode($query);?>, "appApi":<?php echo json_encode(add_query_arg(array('gmedia-app' => 1, 'gmappversion' => 4, 'gmmodule' => 1), home_url('/'))); ?>};
	}
	gMediaListINIT();
 </script>