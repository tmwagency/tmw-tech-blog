<article class="content-inner entry entry--single" role="main">
	<h1 class="sectionTitle">Articles</h1>

	<div class="entry-content">
		<h1 class="entry-title entry-title--single"><?php echo data::get('details')['title']; ?></h1>
		<?php echo data::get('content'); ?>
	</div>

	<div class="entry-meta entry-meta--post">
		<div class="entry-date"><time>Posted on <?php echo date("d M Y", strtotime(data::get('details')['date'] ) ) ?></time></div>

		<div class="media entry-author">
			<img src="/img/authors/<?php echo data::get('authors')[data::get('details')['author'] ]['avatar']; ?>" alt="Picture of <?php echo data::get('authors')[data::get('details')['author'] ]['name']; ?>" class="media-img entry-author-img">
			<div class="media-body">
				<h3 class="entry-author-name"><a href="http://twitter.com/<?php echo data::get('authors')[data::get('details')['author'] ]['twitter']; ?>"><?php echo data::get('authors')[data::get('details')['author'] ]['name']; ?></a></h3>
				<p class="entry-author-desc"><?php echo data::get('authors')[data::get('details')['author'] ]['short_desc']; ?></p>
			</div>
		</div>

	</div>

	<?php if((bool)data::get('details')['comments']): ?>
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			var disqus_shortname = 'labstmw';

			<?php if(isset(data::get('details')['comments_id']) ): ?>
			var disqus_identifier = '<?php echo data::get('details')['comments_id']; ?>'; // required: replace example with your forum shortname
			<?php endif; ?>

			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	<?php endif; ?>

</article>

	<a class="openSource" href="/code">
		<h2>Check out our open source projects</h2>
		<p>We have loads of open source projects for you to try <br>Click here to have a look!</p>
	</a>

<!-- Pagination links 
<div class="pagination clearfix">
	<div class="container">
		{% if page.previous %}
			<a href="{{page.previous.url}}" class="pagination-item pagination-item--older"><b>Older post</b><br>{{ page.previous.title }}</a>
		{% endif %}
		{% if page.next %}
			<a href="{{page.next.url}}" class="pagination-item pagination-item--newer"><b>Newer post</b><br>{{ page.next.title }}</a>
		{% endif %}
	</div>
</div>-->