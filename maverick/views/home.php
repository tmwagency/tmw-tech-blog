<div class="content-inner entries clearfix">
	<h1 class="sectionTitle">Articles</h1>
	
	<?php
	foreach(data::get('articles') as $article)
	{
		echo <<<ARTICLE
		<article class="entry entry--multiple clearfix">
			<div class="col-a">
				<h1 class="entry-title entry-title--entries">
					<a title="{$article['title']}" href="{$article['url']}">{$article['title']}</a>
				</h1>
				<div class="entry-meta entry-meta--listing">
					<time class="entry-date">{$article['date']}</time>
					•
					<span class="entry-authorName">By 
						<a href="http://twitter.com/{$article['author']->twitter}" target="_blank">{$article['author']->name}</a>
					</span>
				</div>
			</div>
			<div class="col-b">
				<p class="entry-excerpt">{$article['excerpt']}</p>
			</div>
		</article>
ARTICLE;
	}
	?>
</div>

<div class="pagination">
	<div class="container">
		<?php
		if(data::get('page_num') < data::get('page_total'))
		{
			$older_page = data::get('page_num')+1;
			echo <<<OLDER
			<a class="pagination-item pagination-item--older" href="/$older_page">
				<span class="icon-arrow-left-small"></span>Older
			</a>
OLDER;
		}
		
		if(data::get('page_num') < data::get('page_total') && data::get('page_num') > 1)
			echo '|';
		
		if(data::get('page_num') > 1)
		{
			$newer_page = data::get('page_num')-1;
			echo <<<OLDER
			<a class="pagination-item pagination-item--newer icon-arrow-right-small" href="/$newer_page">
				<span class="icon-arrow-right-small"></span>Newer
			</a>
OLDER;
		}
		?>
	</div>
</div>
