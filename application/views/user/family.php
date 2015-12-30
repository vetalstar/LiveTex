<div class="inner cover cover-100">
	<div class="chart chart-center" id="family-tree"></div>
</div>
<script>
	var chart_config = {
		chart: {
			container: "#family-tree",

			connectors: {
				type: 'step'
			},
			node: {
				HTMLclass: 'nodeExample1'
			}
		},
		nodeStructure: {
			text: {
				name: "<?= $user->name . ' ' . $user->surname ?>"
				<? if (Auth::instance()->get_user()->id == Request::initial()->param('user_id')): ?>
				,desc: {
					val: 'Добавить родственника',
					href: '<?= Route::url('default', array('controller' => 'user', 'action' => 'relative')) ?>'
				}
				<? endif; ?>
			},
			<?= UTF8::trim($family_json, '{}') ?>
		}
	};
</script>