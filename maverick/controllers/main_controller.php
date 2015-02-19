<?php
class main_controller extends base_controller
{
	function __construct() {}
	
	function home($params=array())
	{
		$page_num = (empty($params[0]))?1:intval($params[0]);
		$per_page = 10;
		
		$authors = content::get_authors();
		$pages_total = ceil(content::get_articles_total() / $per_page);
		$article_list = content::get_article_list($page_num, $per_page, $authors);
				
		$view = view::make('includes/template')->with('page', 'home')->with('page_num', $page_num)->with('articles', $article_list)->with('page_total', $pages_total)->render();
	}

	function article($params=array())
	{
		list($year, $month, $article_name) = $params;

		$authors = content::get_authors();
		$article = content::get_article($year, $month, $article_name);
		$html = content::get_html_from_markdown($article['content']);
		$article_details = content::get_details_from_markdown($article);
		
		$view = view::make('includes/template')->with('page', 'article')->with('content', $html)->with('authors', $authors)->with('details', $article_details)->render();
	}
	
	function team()
	{
		$authors = content::get_authors(true);
		$author_default_images = content::get_author_default_images();
		//ksort($authors);	// TODO: how should the team members be sorted?
		
		foreach($authors as $author => &$details)
		{
			if(empty($details['avatar']))
				$details['avatar'] = $author_default_images[rand(0, count($author_default_images)-1)];
		}
		
		$view = view::make('includes/template')->with('page', 'team')->with('team', $authors)->render();
	}
	
	function code()
	{
		$authors = content::get_authors(true);
		$articles = content::get_code_articles($authors);
		
		$view = view::make('includes/template')->with('page', 'code')->with('articles', $articles)->render();
	}
	
	function code_article($params)
	{
		var_dump($params);
	}
}