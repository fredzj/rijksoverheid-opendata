<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reisadviezen Dashboard</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">
	<style>
	body {
		font-size: small;
	}
	img {
		background-color: #fff;
	}
	</style>
	<script src="https://kit.fontawesome.com/da52944850.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container-fluid">

	<h1>Reisadviezen Dashboard</h1>

	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="traveladvice-tab"	data-bs-toggle="tab" data-bs-target="#traveladvice-tab-pane"	type="button" role="tab" aria-controls="traveladvice-tab-pane"		aria-selected="true">Traveladvice</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link"		id="contentblocks-tab"	data-bs-toggle="tab" data-bs-target="#contentblocks-tab-pane"	type="button" role="tab" aria-controls="contentblocks-tab-pane"	aria-selected="false">Traveladvice Paragraphs</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link"		id="files-tab"			data-bs-toggle="tab" data-bs-target="#files-tab-pane"			type="button" role="tab" aria-controls="files-tab-pane"		aria-selected="false">Traveladvice Maps</button>
		</li>
	</ul>
	
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active"	id="traveladvice-tab-pane"	role="tabpanel" aria-labelledby="traveladvice-tab"	tabindex="0">
			<?php	echo $html_traveladvice; ?>
		</div>
		<div class="tab-pane fade"				id="contentblocks-tab-pane"	role="tabpanel" aria-labelledby="contentblocks-tab"	tabindex="0">
			<?php	echo $html_contentblocks; ?>
		</div>
		<div class="tab-pane fade"				id="files-tab-pane"			role="tabpanel" aria-labelledby="files-tab"			tabindex="0">
			<?php	echo $html_files; ?>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/extensions/export/bootstrap-table-export.min.js"></script>
	<script>
		function customSort(sortName, sortOrder, data) {
			var order = sortOrder === 'desc' ? -1 : 1
			data.sort(function (a, b) {
			var aa = +((a[sortName] + '').replace(/[^\d]/g, ''))
			var bb = +((b[sortName] + '').replace(/[^\d]/g, ''))
			if (aa < bb) {
				return order * -1
			}
			if (aa > bb) {
				return order
			}
			return 0
			})
		}
	</script>
</div>
</body>
</html>