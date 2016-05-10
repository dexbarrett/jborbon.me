<div id="disqus_thread"></div>
<script>
var disqus_config = function () {
this.page.url = '{{ action('PostController@findBySlug', ['slug' => $postUrl]) }}';
};

(function() { 
var d = document, s = d.createElement('script');

s.src = '//jborbon.disqus.com/embed.js';

s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Tiene que tener JavaScript habilitado para ver los comentarios</noscript>