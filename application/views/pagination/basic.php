<div class="col-sm-12">
	<ul class="pagination">
		<?php

		$start = 1;
		$num_pages = ($total_pages < 3) ? $total_pages : 3;

		// В начало

		if ($first_page != FALSE and $current_page > $num_pages)
		{
			?>
			<li>
				<a href="<?= HTML::chars($page->url($first_page)) ?>" class="nav1" title="В начало">&lt;&lt;</a>
			</li>
			<?php
		}

		// Предыдущая

		if ($previous_page != FALSE)
		{
			?>
			<li>
				<a href="<?= HTML::chars($page->url($previous_page)) ?>" class="nav2" title="Предыдущая">&lt;</a>
			</li>
			<?php
		}


		// Механика появления страниц

		if ($previous_page != FALSE and $current_page > $previous_page)
		{
			if ($next_page != FALSE and $next_page < $total_pages)
				$num_pages = $next_page + 1;
			else
				$num_pages = $total_pages;
		}

		if ($num_pages > 5)
			$start = $previous_page - 1;

		for($i = $start; $i <= $num_pages; $i++)
		{
			?>
			<li<? if ($i == $current_page) { ?> class="active" <? } ?>>
				<a href="<?= HTML::chars($page->url($i)) ?>" title="Страница <?= $i ?>"><?= $i ?></a>
			</li>
			<?
		}

		// Следующая

		if ($next_page != FALSE)
		{
			?>
			<li>
				<a href="<?= HTML::chars($page->url($next_page)) ?>" class="nav2" title="Следующая">&gt;</a>
			</li>
			<?php
		}


		// В конец

		if ($last_page != FALSE and $num_pages < $last_page)
		{
			?>
			<li>
				<a href="<?= HTML::chars($page->url($last_page)) ?>" class="nav1" title="В конец">&gt;&gt;</a>
			</li>
			<?php
		}
		?>
	</ul>
</div>