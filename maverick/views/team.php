<div class="content-inner clearfix">
	<h1 class="sectionTitle">team <small>tect.tmw team and authors</small></h1>
	
	<?php
	foreach(data::get('team') as $member)
	{
		$desc = !empty($member['short_desc'])?$member['short_desc']:'';
		$web = !empty($member['web'])?"<a class=\"gridItem-desc\" href=\"{$member['web']}\">{$member['web']}</a>":'';
		
		$social_icons = '';
		foreach(array('twitter'=>'https://twitter.com/', 'github'=>'https://github.com/') as $social_link => $url)
		{
			if(!empty($member[$social_link]))
			{
				$social_icons .= <<<SOCIAL_LINK
				<a class="icon-small icon-$social_link" href="$url{$member[$social_link]}">{$member[$social_link]}</a>
SOCIAL_LINK;
			}
		}
		
		echo <<<MEMBER
		<article class="gridItem clearfix">
			<img src="/img/authors/{$member['avatar']}" alt="" class="gridItem-avatar"/>
			<h1 class="gridItem-name h3">{$member['name']}</h1>
			
			<div class="gridItem-back">
				<div class="gridItem-desc">$desc</div>
				$web
				<div class="gridItem-links">
					$social_icons
				</div>
			</div>
		</article>
MEMBER;
	}
	?>
</div>