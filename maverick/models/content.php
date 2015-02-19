<?php
class content
{
	static function get_article_list($page_num, $per_page, $authors)
	{
		$articles = array();
		
		$articles_md = content::get_markdown_templates(MAVERICK_VIEWSDIR . '_posts');
		rsort($articles_md);	// sort in date order with newest first
		
		$articles_md = array_slice($articles_md, ($page_num-1)*$per_page, $per_page);	// only get the articles we want for this particular page
		
		foreach($articles_md as $article)
			$articles[] = content::get_article_details($article, $authors);
		
		return $articles;
	}
	
	static function get_articles_total()
	{
		$articles_md = content::get_markdown_templates(MAVERICK_VIEWSDIR . '_posts');
		return count($articles_md);
	}
	
	static function get_authors($hide_leavers=false)
	{
		$authors_clean = array();
		$authors = yaml_parse_file(MAVERICK_VIEWSDIR . '_data/team.yml');

		// hide authors that have their display attribute set to no
		foreach($authors as $author)
		{
			if($hide_leavers && isset($author['display']) && !$author['display'] )
				continue;

			$authors_clean[$author['short_name']] = $author;
		}

		return $authors_clean;
	}
	
	static function get_author_default_images()
	{
		$images = array();
		$paths = glob(getcwd() . '/img/authors/default*.gif');
		
		foreach($paths as $path)
			$images[] = basename($path);
		
		return $images;
	}
	
	static function get_article($year, $month, $article)
	{
		$article = glob(MAVERICK_VIEWSDIR . "_posts/$year-$month*$article.md");
		$article = end($article);
		
		$content = '';
		
		$fh = fopen($article, 'r');
		$content = fread($fh, filesize($article) );
		fclose($fh);
		
		return array('file'=>basename($article), 'content'=>$content);
	}
	
	static function get_html_from_markdown($article)
	{
		$article = preg_replace('/---.+?---/s', '', $article);
		
		$parser = new \Michelf\MarkdownExtra;
		$parser->code_class_prefix = "language-";
		$html = $parser->transform($article);
		
		return $html;
	}
	
	static function get_details_from_markdown($article)
	{
		$details = array();
		preg_match_all('/^([a-z]+) ?: ([^\n]+)$/im', $article['content'], $matches);
		
		for($i=0; $i<count($matches[1]); $i++)
			$details[$matches[1][$i]] = $matches[2][$i];

		// add article date from the filename
		// TODO: check maybe to see if the filename pattern matches a date at the start
		$details['date'] = date("d M Y", strtotime(substr($article['file'], 0, 10) ) );

		
		return $details;
	}

	static function get_code_articles($authors)
	{
		$articles = array();
		
		$articles_md = content::get_markdown_templates(MAVERICK_VIEWSDIR . '_code');
		
		foreach($articles_md as $article)
			$articles[] = content::get_article_details($article, $authors);
		
		// sort the articles by their weight value
		usort($articles, function($a, $b){
			return ($a['weight'] > $b['weight']);
		});
		
		return $articles;
	}



	private static function get_markdown_templates($dir)
	{
		return glob("$dir/*.md");
	}
	
	private static function get_article_details($article, $authors)
	{
		$fh = fopen($article, 'r');
		
		$details_begun = false;
		$details_str = '';

		// select out only the front-yaml from the markdown file to be parsed separately
		while(true)
		{
			$buffer = fgets($fh);
			$details_str .= $buffer;
			$buffer = trim($buffer);
			
			if($buffer == '---')
			{
				if(!$details_begun)
					$details_begun = true;
				else
					break;
			}
		}
		$details = yaml_parse($details_str);
		
		fclose($fh);

		// set some basic details - set at the end because some articles already set these details and we want to overwrite them
		$details['filename'] = $article;
		$details['url'] = '#';
		
		// match article-style filenames that contain the date
		preg_match('/^(\d{4})-(\d\d)-(\d\d)-(.+)$/', basename($article), $name_parts);
		if(count($name_parts))
		{
			$details['url'] = preg_replace('/\.md$/', '', "/{$name_parts[1]}/{$name_parts[2]}/{$name_parts[4]}");
			$details['date'] = date('d M Y', strtotime("{$name_parts[1]}-{$name_parts[2]}-{$name_parts[3]}") );
			$details['date_str'] = "{$name_parts[1]}-{$name_parts[2]}-{$name_parts[3]}";
		}
		
		// set it for everything else
		if($details['url'] == '#')
			$details['url'] = preg_replace('/\.md$/', '', basename($article) );
		
		// set the author details
		if(isset($details['author']) && array_key_exists($details['author'], $authors) )
		{
			$author = $authors[$details['author'] ];
			
			$details['author'] = new stdClass();
			
			// set this authors details, with defaults if none exist
			foreach(array('name', 'surname', 'job_title', 'short_name', 'short_desc', 'avatar', 'email', 'web', 'twitter', 'github', 'team') as $detail)
				$details['author']->{$detail} = !empty($author[$detail])?$author[$detail]:'';
		}
		
		// set the team details - more for the code articles, as they can often have multiple people working on them
		if(isset($details['team']) )
		{
			$team = (array)$details['team'];
			
			foreach($team as $key=> $member)
			{
				$author = $authors[$member];
				
				$details['team'][$key] = new stdClass();
				
				// set this authors details, with defaults if none exist
				foreach(array('name', 'surname', 'job_title', 'short_name', 'short_desc', 'avatar', 'email', 'web', 'twitter', 'github', 'team') as $detail)
					$details['team'][$key]->{$detail} = !empty($author[$detail])?$author[$detail]:'';
			}
		}

		return $details;
	}
}