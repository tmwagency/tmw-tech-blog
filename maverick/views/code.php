<div class="content-inner clearfix">
	<h1 class="sectionTitle">Code @ TMW <small>Our open-source offerings</small></h1>
	
	<?php
	foreach(data::get('articles') as $article)
	{
		$links = $maintainers = '';
		foreach(array('github_url'=>'View the Repo on GitHub', 'docs'=>'Documentation', 'issues'=>'Issues', 'demo'=>'Demo', 'npm'=>'NPM') as $link => $text)
		{
			if(!empty($article[$link]) )
			$links .= <<<LINK
			<a class="links-item" href="{$article[$link]}">$text</a>
LINK;
		}
		
		foreach($article['team'] as $member)
		{
			var_dump($member);
		}
		
		echo <<<ARTICLE
		<article class="entry entry--multiple entry--code">
			<h2 class="entry-title entry-title--entries">
				<a href="{$article['url']}">{$article['title']}</a>
			</h2>
			<div class="entry-content">
				<p>{$article['subtitle']}</p>
			</div>
			<div class="links">
				$links
			</div>
			<p class="entry-maintainers l-list--floated unstyled">
				Maintained by: $maintainers
			</p>
		</article>
ARTICLE;

	}
	
	
	?>
</div>