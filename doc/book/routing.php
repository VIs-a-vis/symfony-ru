<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Routing</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="routing">
      <span id="index-0"></span><h1>Routing<a class="headerlink" href="#routing" title="Permalink to this headline">¶</a></h1>
      <p>Beautiful URLs are an absolute must for any serious web application. This
	means leaving behind ugly URLs like <tt class="docutils literal"><span class="pre">index.php?article_id=57</span></tt> in favor
	of something like <tt class="docutils literal"><span class="pre">/read/intro-to-symfony</span></tt>.</p>
      <p>Having flexibility is even more important. What if you need to change the
	URL of a page from <tt class="docutils literal"><span class="pre">/blog</span></tt> to <tt class="docutils literal"><span class="pre">/news</span></tt>? How many links should you need to
	hunt down and update to make the change? If you're using Symfony's router,
	the change is simple.</p>
      <p>The Symfony2 router lets you define creative URLs that you map to different
	areas of your application. By the end of this chapter, you'll be able to:</p>
      <ul class="simple">
	<li>Create complex routes that map to controllers</li>
	<li>Generate URLs inside templates and controllers</li>
	<li>Load routing resources from bundles (or anywhere else)</li>
	<li>Debug your routes</li>
      </ul>
      <div class="section" id="routing-in-action">
	<span id="index-1"></span><h2>Routing in Action<a class="headerlink" href="#routing-in-action" title="Permalink to this headline">¶</a></h2>
	<p>A <em>route</em> is a map from a URL pattern to a controller. For example, suppose
	  you want to match any URL like <tt class="docutils literal"><span class="pre">/blog/my-post</span></tt> or <tt class="docutils literal"><span class="pre">/blog/all-about-symfony</span></tt>
	  and send it to a controller that can look up and render that blog entry.
	  The route is simple:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/routing.yml</span>
<span class="l-Scalar-Plain">blog_show</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/blog/{slug}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeBlogBundle</span><span class="p-Indicator">:</span><span class="nv">Blog</span><span class="p-Indicator">:</span><span class="nv">show</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/routing.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>
<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"blog_show"</span> <span class="na">pattern=</span><span class="s">"/blog/{slug}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeBlogBundle:Blog:show<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/routing.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'blog_show'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/blog/{slug}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeBlogBundle:Blog:show'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The pattern defined by the <tt class="docutils literal"><span class="pre">blog_show</span></tt> route acts like <tt class="docutils literal"><span class="pre">/blog/*</span></tt> where
	  the wildcard is given the name <tt class="docutils literal"><span class="pre">slug</span></tt>. For the URL <tt class="docutils literal"><span class="pre">/blog/my-blog-post</span></tt>,
	  the <tt class="docutils literal"><span class="pre">slug</span></tt> variable gets a value of <tt class="docutils literal"><span class="pre">my-blog-post</span></tt>, which is available
	  for you to use in your controller (keep reading).</p>
	<p>The <tt class="docutils literal"><span class="pre">_controller</span></tt> parameter is a special key that tells Symfony which controller
	  should be executed when a URL matches this route. The <tt class="docutils literal"><span class="pre">_controller</span></tt> string
	  is called the <a class="reference internal" href="#controller-string-syntax"><em>logical name</em></a>. It follows a
	  pattern that points to a specific PHP class and method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/BlogBundle/Controller/BlogController.php</span>

<span class="k">namespace</span> <span class="nx">Acme</span><span class="o">\</span><span class="nx">BlogBundle</span><span class="o">\</span><span class="nx">Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">BlogController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$slug</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$blog</span> <span class="o">=</span> <span class="c1">// use the $slug varible to query the database</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeBlogBundle:Blog:show.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'blog'</span> <span class="o">=&gt;</span> <span class="nv">$blog</span><span class="p">,</span>
        <span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Congratulations! You've just created your first route and connected it to
	  a controller. Now, when you visit <tt class="docutils literal"><span class="pre">/blog/my-post</span></tt>, the <tt class="docutils literal"><span class="pre">showAction</span></tt> controller
	  will be executed and the <tt class="docutils literal"><span class="pre">$slug</span></tt> variable will be equal to <tt class="docutils literal"><span class="pre">my-post</span></tt>.</p>
	<p>This is the goal of the Symfony2 router: to map the URL of a request to a
	  controller. Along the way, you'll learn all sorts of tricks that make mapping
	  even the most complex URLs easy.</p>
      </div>
      <div class="section" id="routing-under-the-hood">
	<span id="index-2"></span><h2>Routing: Under the Hood<a class="headerlink" href="#routing-under-the-hood" title="Permalink to this headline">¶</a></h2>
	<p>When a request is made to your application, it contains an address to the
	  exact "resource" that the client is requesting. This address is called the
	  URL, (or URI), and could be <tt class="docutils literal"><span class="pre">/contact</span></tt>, <tt class="docutils literal"><span class="pre">/blog/read-me</span></tt>, or anything
	  else. Take the following HTTP request for example:</p>
	<div class="highlight-text"><div class="highlight"><pre>GET /blog/my-blog-post
	  </pre></div>
	</div>
	<p>The goal of the Symfony2 routing system is to parse this URL and determine
	  which controller should be executed. The whole process looks like this:</p>
	<ol class="arabic simple">
	  <li>The request is handled by the Symfony2 front controller (e.g. <tt class="docutils literal"><span class="pre">app.php</span></tt>);</li>
	  <li>The Symfony2 core (i.e. Kernel) asks the router to inspect the request;</li>
	  <li>The router matches the incoming URL to a specific route and returns information
	    about the route, including the controller that should be executed;</li>
	  <li>The Symfony2 Kernel executes the controller, which ultimately returns
	    a <tt class="docutils literal"><span class="pre">Response</span></tt> object.</li>
	</ol>
	<div class="figure align-center">
	  <img alt="Symfony2 request flow" src="../_images/request-flow.png">
	  <p class="caption">The routing is a tool that translates the incoming URL into a specific
	    controller to execute;</p>
	</div>
      </div>
      <div class="section" id="creating-routes">
	<span id="index-3"></span><h2>Creating Routes<a class="headerlink" href="#creating-routes" title="Permalink to this headline">¶</a></h2>
	<p>Symfony loads all the routes for your application from a single routing configuration
	  file. The file is usually <tt class="docutils literal"><span class="pre">app/config/routing.yml</span></tt>, but can be configured
	  to be anything (including an XML or PHP file) via the application configuration
	  file:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">router</span><span class="p-Indicator">:</span>        <span class="p-Indicator">{</span> <span class="nv">resource</span><span class="p-Indicator">:</span> <span class="s">"%kernel.root_dir%/config/routing.yml"</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><pre>&lt;!-- app/config/config.xml --&gt;
&lt;framework:config ...&gt;
    &lt;!-- ... --&gt;
    &lt;framework:router resource="%kernel.root_dir%/config/routing.xml" /&gt;
		  &lt;/framework:config&gt;</pre>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'router'</span>        <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'resource'</span> <span class="o">=&gt;</span> <span class="s1">'%kernel.root_dir%/config/routing.php'</span><span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">Even though all routes are loaded from a single file, it's common practice
	      to include additional routing resources from inside the file. See the
	      <a class="reference internal" href="#routing-include-external-resources"><em>Including External Routing Resources</em></a> section for more information.</p>
	</div></div>
	<div class="section" id="basic-route-configuration">
	  <h3>Basic Route Configuration<a class="headerlink" href="#basic-route-configuration" title="Permalink to this headline">¶</a></h3>
	  <p>Defining a route is easy, and a typical application will have lots of routes.
	    A basic route consists of just two parts: the <tt class="docutils literal"><span class="pre">pattern</span></tt> to match and a
	    <tt class="docutils literal"><span class="pre">defaults</span></tt> array:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">homepage</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Main</span><span class="p-Indicator">:</span><span class="nv">homepage</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"homepage"</span> <span class="na">pattern=</span><span class="s">"/"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeDemoBundle:Main:homepage<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>

<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'homepage'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDemoBundle:Main:homepage'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>This route matches the homepage (<tt class="docutils literal"><span class="pre">/</span></tt>) and maps it to the <tt class="docutils literal"><span class="pre">AcmeDemoBundle:Main:homepage</span></tt>
	    controller. The <tt class="docutils literal"><span class="pre">_controller</span></tt> string is translated by Symfony2 into an
	    actual PHP function and executed. That process will be explained shortly
	    in the <a class="reference internal" href="#controller-string-syntax"><em>Controller Naming Pattern</em></a> section.</p>
	</div>
	<div class="section" id="routing-with-placeholders">
	  <span id="index-4"></span><h3>Routing with Placeholders<a class="headerlink" href="#routing-with-placeholders" title="Permalink to this headline">¶</a></h3>
	  <p>Of course the routing system supports much more interesting routes. Many
	    routes will contain one or more named "wildcard" placeholders:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">blog_show</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/blog/{slug}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeBlogBundle</span><span class="p-Indicator">:</span><span class="nv">Blog</span><span class="p-Indicator">:</span><span class="nv">show</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"blog_show"</span> <span class="na">pattern=</span><span class="s">"/blog/{slug}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeBlogBundle:Blog:show<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'blog_show'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/blog/{slug}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeBlogBundle:Blog:show'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The pattern will match anything that looks like <tt class="docutils literal"><span class="pre">/blog/*</span></tt>. Even better,
	    the value matching the <tt class="docutils literal"><span class="pre">{slug}</span></tt> placeholder will be available inside your
	    controller. In other words, if the URL is <tt class="docutils literal"><span class="pre">/blog/hello-world</span></tt>, a <tt class="docutils literal"><span class="pre">$slug</span></tt>
	    variable, with a value of <tt class="docutils literal"><span class="pre">hello-world</span></tt>, will be available in the controller.
	    This can be used, for example, to load the blog post matching that string.</p>
	  <p>The pattern will <em>not</em>, however, match simply <tt class="docutils literal"><span class="pre">/blog</span></tt>. That's because,
	    by default, all placeholders are required. This can be changed by adding
	    a placeholder value to the <tt class="docutils literal"><span class="pre">defaults</span></tt> array.</p>
	</div>
	<div class="section" id="required-and-optional-placeholders">
	  <h3>Required and Optional Placeholders<a class="headerlink" href="#required-and-optional-placeholders" title="Permalink to this headline">¶</a></h3>
	  <p>To make things more exciting, add a new route that displays a list of all
	    the available blog posts for this imaginary blog application:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">blog</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/blog</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeBlogBundle</span><span class="p-Indicator">:</span><span class="nv">Blog</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"blog"</span> <span class="na">pattern=</span><span class="s">"/blog"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeBlogBundle:Blog:index<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'blog'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/blog'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeBlogBundle:Blog:index'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>So far, this route is as simple as possible - it contains no placeholders
	    and will only match the exact URL <tt class="docutils literal"><span class="pre">/blog</span></tt>. But what if you need this route
	    to support pagination, where <tt class="docutils literal"><span class="pre">/blog/2</span></tt> displays the second page of blog
	    entries? Update the route to have a new <tt class="docutils literal"><span class="pre">{page}</span></tt> placeholder:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">blog</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/blog/{page}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeBlogBundle</span><span class="p-Indicator">:</span><span class="nv">Blog</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"blog"</span> <span class="na">pattern=</span><span class="s">"/blog/{page}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeBlogBundle:Blog:index<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'blog'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/blog/{page}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeBlogBundle:Blog:index'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Like the <tt class="docutils literal"><span class="pre">{slug}</span></tt> placeholder before, the value matching <tt class="docutils literal"><span class="pre">{page}</span></tt> will
	    be available inside your controller. Its value can be used to determine which
	    set of blog posts to display for the given page.</p>
	  <p>But hold on! Since placeholders are required by default, this route will
	    no longer match on simply <tt class="docutils literal"><span class="pre">/blog</span></tt>. Instead, to see page 1 of the blog,
	    you'd need to use the URL <tt class="docutils literal"><span class="pre">/blog/1</span></tt>! Since that's no way for a rich web
	    app to behave, modify the route to make the <tt class="docutils literal"><span class="pre">{page}</span></tt> parameter optional.
	    This is done by including it in the <tt class="docutils literal"><span class="pre">defaults</span></tt> collection:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">blog</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/blog/{page}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeBlogBundle</span><span class="p-Indicator">:</span><span class="nv">Blog</span><span class="p-Indicator">:</span><span class="nv">index</span><span class="p-Indicator">,</span> <span class="nv">page</span><span class="p-Indicator">:</span> <span class="nv">1</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"blog"</span> <span class="na">pattern=</span><span class="s">"/blog/{page}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeBlogBundle:Blog:index<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"page"</span><span class="nt">&gt;</span>1<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'blog'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/blog/{page}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeBlogBundle:Blog:index'</span><span class="p">,</span>
    <span class="s1">'page'</span> <span class="o">=&gt;</span> <span class="mi">1</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>By adding <tt class="docutils literal"><span class="pre">page</span></tt> to the <tt class="docutils literal"><span class="pre">defaults</span></tt> key, the <tt class="docutils literal"><span class="pre">{page}</span></tt> placeholder is no
	    longer required. The URL <tt class="docutils literal"><span class="pre">/blog</span></tt> will match this route and the value of
	    the <tt class="docutils literal"><span class="pre">page</span></tt> parameter will be set to <tt class="docutils literal"><span class="pre">1</span></tt>. The URL <tt class="docutils literal"><span class="pre">/blog/2</span></tt> will also
	    match, giving the <tt class="docutils literal"><span class="pre">page</span></tt> parameter a value of <tt class="docutils literal"><span class="pre">2</span></tt>. Perfect.</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="43%">
	      <col width="57%">
	    </colgroup>
	    <tbody valign="top">
	      <tr><td>/blog</td>
		<td>{page} = 1</td>
	      </tr>
	      <tr><td>/blog/1</td>
		<td>{page} = 1</td>
	      </tr>
	      <tr><td>/blog/2</td>
		<td>{page} = 2</td>
	      </tr>
	    </tbody>
	  </table>
	</div>
	<div class="section" id="adding-requirements">
	  <span id="index-5"></span><h3>Adding Requirements<a class="headerlink" href="#adding-requirements" title="Permalink to this headline">¶</a></h3>
	  <p>Take a quick look at the routes that have been created so far:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 184px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">blog</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/blog/{page}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeBlogBundle</span><span class="p-Indicator">:</span><span class="nv">Blog</span><span class="p-Indicator">:</span><span class="nv">index</span><span class="p-Indicator">,</span> <span class="nv">page</span><span class="p-Indicator">:</span> <span class="nv">1</span> <span class="p-Indicator">}</span>

<span class="l-Scalar-Plain">blog_show</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/blog/{slug}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeBlogBundle</span><span class="p-Indicator">:</span><span class="nv">Blog</span><span class="p-Indicator">:</span><span class="nv">show</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"blog"</span> <span class="na">pattern=</span><span class="s">"/blog/{page}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeBlogBundle:Blog:index<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"page"</span><span class="nt">&gt;</span>1<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"blog_show"</span> <span class="na">pattern=</span><span class="s">"/blog/{slug}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeBlogBundle:Blog:show<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'blog'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/blog/{page}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeBlogBundle:Blog:index'</span><span class="p">,</span>
    <span class="s1">'page'</span> <span class="o">=&gt;</span> <span class="mi">1</span><span class="p">,</span>
<span class="p">)));</span>

<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'blog_show'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/blog/{show}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeBlogBundle:Blog:show'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Can you spot the problem? Notice that both routes have patterns that match
	    URL's that look like <tt class="docutils literal"><span class="pre">/blog/*</span></tt>. The Symfony router will always choose the
	    <strong>first</strong> matching route it finds. In other words, the <tt class="docutils literal"><span class="pre">blog_show</span></tt> route
	    will <em>never</em> be matched. Instead, a URL like <tt class="docutils literal"><span class="pre">/blog/my-blog-post</span></tt> will match
	    the first route (<tt class="docutils literal"><span class="pre">blog</span></tt>) and return a nonsense value of <tt class="docutils literal"><span class="pre">my-blog-post</span></tt>
	    to the <tt class="docutils literal"><span class="pre">{page}</span></tt> parameter.</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="40%">
	      <col width="14%">
	      <col width="46%">
	    </colgroup>
	    <thead valign="bottom">
	      <tr><th class="head">URL</th>
		<th class="head">route</th>
		<th class="head">parameters</th>
	      </tr>
	    </thead>
	    <tbody valign="top">
	      <tr><td>/blog/2</td>
		<td>blog</td>
		<td>{page} = 2</td>
	      </tr>
	      <tr><td>/blog/my-blog-post</td>
		<td>blog</td>
		<td>{page} = my-blog-post</td>
	      </tr>
	    </tbody>
	  </table>
	  <p>The answer to the problem is to add route <em>requirements</em>. The routes in this
	    example would work perfectly if the <tt class="docutils literal"><span class="pre">/blog/{page}</span></tt> pattern <em>only</em> matched
	    URLs where the <tt class="docutils literal"><span class="pre">{page}</span></tt> portion is an integer. Fortunately, regular expression
	    requirements can easily be added for each parameter. For example:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">blog</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/blog/{page}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeBlogBundle</span><span class="p-Indicator">:</span><span class="nv">Blog</span><span class="p-Indicator">:</span><span class="nv">index</span><span class="p-Indicator">,</span> <span class="nv">page</span><span class="p-Indicator">:</span> <span class="nv">1</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">requirements</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">page</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">\d+</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"blog"</span> <span class="na">pattern=</span><span class="s">"/blog/{page}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeBlogBundle:Blog:index<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"page"</span><span class="nt">&gt;</span>1<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"page"</span><span class="nt">&gt;</span>\d+<span class="nt">&lt;/requirement&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'blog'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/blog/{page}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeBlogBundle:Blog:index'</span><span class="p">,</span>
    <span class="s1">'page'</span> <span class="o">=&gt;</span> <span class="mi">1</span><span class="p">,</span>
<span class="p">),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'page'</span> <span class="o">=&gt;</span> <span class="s1">'\d+'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The <tt class="docutils literal"><span class="pre">\d+</span></tt> requirement is a regular expression that says that the value of
	    the <tt class="docutils literal"><span class="pre">{page}</span></tt> parameter must be a digit (i.e. a number). The <tt class="docutils literal"><span class="pre">blog</span></tt> route
	    will still match on a URL like <tt class="docutils literal"><span class="pre">/blog/2</span></tt> (because 2 is a number), but it
	    will no longer match a URL like <tt class="docutils literal"><span class="pre">/blog/my-blog-post</span></tt> (because <tt class="docutils literal"><span class="pre">my-blog-post</span></tt>
	    is <em>not</em> a number).</p>
	  <p>As a result, a URL like <tt class="docutils literal"><span class="pre">/blog/my-blog-post</span></tt> will now properly match the
	    <tt class="docutils literal"><span class="pre">blog_show</span></tt> route.</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="37%">
	      <col width="20%">
	      <col width="43%">
	    </colgroup>
	    <thead valign="bottom">
	      <tr><th class="head">URL</th>
		<th class="head">route</th>
		<th class="head">parameters</th>
	      </tr>
	    </thead>
	    <tbody valign="top">
	      <tr><td>/blog/2</td>
		<td>blog</td>
		<td>{page} = 2</td>
	      </tr>
	      <tr><td>/blog/my-blog-post</td>
		<td>blog_show</td>
		<td>{slug} = my-blog-post</td>
	      </tr>
	    </tbody>
	  </table>
	  <div class="admonition-wrapper">
	    <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Earlier Routes always Win</p>
	      <p class="last">What this all means is that the order of the routes is very important.
		If the <tt class="docutils literal"><span class="pre">blog_show</span></tt> route were placed above the <tt class="docutils literal"><span class="pre">blog</span></tt> route, the
		URL <tt class="docutils literal"><span class="pre">/blog/2</span></tt> would match <tt class="docutils literal"><span class="pre">blog_show</span></tt> instead of <tt class="docutils literal"><span class="pre">blog</span></tt> since the
		<tt class="docutils literal"><span class="pre">{slug}</span></tt> parameter of <tt class="docutils literal"><span class="pre">blog_show</span></tt> has no requirements. By using proper
		ordering and clever requirements, you can accomplish just about anything.</p>
	  </div></div>
	  <p>Since the parameter requirements are regular expressions, the complexity
	    and flexibility of each requirement is entirely up to you. Suppose the homepage
	    of your application is available in two different languages, based on the
	    URL:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">homepage</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/{culture}</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Main</span><span class="p-Indicator">:</span><span class="nv">homepage</span><span class="p-Indicator">,</span> <span class="nv">culture</span><span class="p-Indicator">:</span> <span class="nv">en</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">requirements</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">culture</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">en|fr</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"homepage"</span> <span class="na">pattern=</span><span class="s">"/{culture}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeDemoBundle:Main:homepage<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"culture"</span><span class="nt">&gt;</span>en<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"culture"</span><span class="nt">&gt;</span>en|fr<span class="nt">&lt;/requirement&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'homepage'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/{culture}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDemoBundle:Main:homepage'</span><span class="p">,</span>
    <span class="s1">'culture'</span> <span class="o">=&gt;</span> <span class="s1">'en'</span><span class="p">,</span>
<span class="p">),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'culture'</span> <span class="o">=&gt;</span> <span class="s1">'en|fr'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>For incoming requests, the <tt class="docutils literal"><span class="pre">{culture}</span></tt> portion of the URL is matched against
	    the regular expression <tt class="docutils literal"><span class="pre">(en|fr)</span></tt>.</p>
	  <table border="1" class="docutils">
	    <colgroup>
	      <col width="16%">
	      <col width="84%">
	    </colgroup>
	    <tbody valign="top">
	      <tr><td>/</td>
		<td>{culture} = en</td>
	      </tr>
	      <tr><td>/en</td>
		<td>{culture} = en</td>
	      </tr>
	      <tr><td>/fr</td>
		<td>{culture} = fr</td>
	      </tr>
	      <tr><td>/es</td>
		<td><em>won't match this route</em></td>
	      </tr>
	    </tbody>
	  </table>
	</div>
	<div class="section" id="adding-http-method-requirements">
	  <span id="index-6"></span><h3>Adding HTTP Method Requirements<a class="headerlink" href="#adding-http-method-requirements" title="Permalink to this headline">¶</a></h3>
	  <p>In addition to the URL, you can also match on the <em>method</em> of the incoming
	    request (i.e. GET, HEAD, POST, PUT, DELETE). Suppose you have a contact form
	    with two controllers - one for displaying the form (on a GET request) and one
	    for processing the form when it's submitted (on a POST request). This can
	    be accomplished with the following route configuration:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 256px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">contact</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/contact</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Main</span><span class="p-Indicator">:</span><span class="nv">contact</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">requirements</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">_method</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">GET</span>

<span class="l-Scalar-Plain">contact_process</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/contact</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Main</span><span class="p-Indicator">:</span><span class="nv">contactProcess</span> <span class="p-Indicator">}</span>
    <span class="l-Scalar-Plain">requirements</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">_method</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">POST</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"contact"</span> <span class="na">pattern=</span><span class="s">"/contact"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeDemoBundle:Main:contact<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"_method"</span><span class="nt">&gt;</span>GET<span class="nt">&lt;/requirement&gt;</span>
    <span class="nt">&lt;/route&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"contact_process"</span> <span class="na">pattern=</span><span class="s">"/contact"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeDemoBundle:Main:contactProcess<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"_method"</span><span class="nt">&gt;</span>POST<span class="nt">&lt;/requirement&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'contact'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/contact'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDemoBundle:Main:contact'</span><span class="p">,</span>
<span class="p">),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_method'</span> <span class="o">=&gt;</span> <span class="s1">'GET'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'contact_process'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/contact'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDemoBundle:Main:contactProcess'</span><span class="p">,</span>
<span class="p">),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_method'</span> <span class="o">=&gt;</span> <span class="s1">'POST'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Despite the fact that these two routes have identical patterns (<tt class="docutils literal"><span class="pre">/contact</span></tt>),
	    the first route will match only GET requests and the second route will match
	    only POST requests. This means that you can display the form and submit the
	    form via the same URL, while using distinct controllers for the two actions.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">If no <tt class="docutils literal"><span class="pre">_method</span></tt> requirement is specified, the route will match on
		<em>all</em> methods.</p>
	  </div></div>
	  <p>Like the other requirements, the <tt class="docutils literal"><span class="pre">_method</span></tt> requirement is parsed as a regular
	    expression. To match <tt class="docutils literal"><span class="pre">GET</span></tt> <em>or</em> <tt class="docutils literal"><span class="pre">POST</span></tt> requests, you can use <tt class="docutils literal"><span class="pre">GET|POST</span></tt>.</p>
	</div>
	<div class="section" id="advanced-routing-example">
	  <span id="index-7"></span><span id="id1"></span><h3>Advanced Routing Example<a class="headerlink" href="#advanced-routing-example" title="Permalink to this headline">¶</a></h3>
	  <p>At this point, you have everything you need to create a powerful routing
	    structure in Symfony. The following is an example of just how flexible the
	    routing system can be:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 184px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">article_show</span><span class="p-Indicator">:</span>
  <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/articles/{culture}/{year}/{title}.{_format}</span>
  <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeDemoBundle</span><span class="p-Indicator">:</span><span class="nv">Article</span><span class="p-Indicator">:</span><span class="nv">show</span><span class="p-Indicator">,</span> <span class="nv">_format</span><span class="p-Indicator">:</span> <span class="nv">html</span> <span class="p-Indicator">}</span>
  <span class="l-Scalar-Plain">requirements</span><span class="p-Indicator">:</span>
      <span class="l-Scalar-Plain">culture</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">en|fr</span>
      <span class="l-Scalar-Plain">_format</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">html|rss</span>
      <span class="l-Scalar-Plain">year</span><span class="p-Indicator">:</span>     <span class="l-Scalar-Plain">\d+</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"article_show"</span> <span class="na">pattern=</span><span class="s">"/articles/{culture}/{year}/{title}.{_format}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeDemoBundle:Article:show<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_format"</span><span class="nt">&gt;</span>html<span class="nt">&lt;/default&gt;</span>
        <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"culture"</span><span class="nt">&gt;</span>en|fr<span class="nt">&lt;/requirement&gt;</span>
        <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"_format"</span><span class="nt">&gt;</span>html|rss<span class="nt">&lt;/requirement&gt;</span>
        <span class="nt">&lt;requirement</span> <span class="na">key=</span><span class="s">"year"</span><span class="nt">&gt;</span>\d+<span class="nt">&lt;/requirement&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'homepage'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/articles/{culture}/{year}/{title}.{_format}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDemoBundle:Article:show'</span><span class="p">,</span>
    <span class="s1">'_format'</span> <span class="o">=&gt;</span> <span class="s1">'html'</span><span class="p">,</span>
<span class="p">),</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'culture'</span> <span class="o">=&gt;</span> <span class="s1">'en|fr'</span><span class="p">,</span>
    <span class="s1">'_format'</span> <span class="o">=&gt;</span> <span class="s1">'html|rss'</span><span class="p">,</span>
    <span class="s1">'year'</span> <span class="o">=&gt;</span> <span class="s1">'\d+'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>As you've seen, this route will only match if the <tt class="docutils literal"><span class="pre">{culture}</span></tt> portion of
	    the URL is either <tt class="docutils literal"><span class="pre">en</span></tt> or <tt class="docutils literal"><span class="pre">fr</span></tt> and if the <tt class="docutils literal"><span class="pre">{year}</span></tt> is a number. This
	    route also shows how you can use a period between placeholders instead of
	    a slash. URLs matching this route might look like:</p>
	  <blockquote>
	    <div><ul class="simple">
		<li><tt class="docutils literal"><span class="pre">/articles/en/2010/my-post</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">/articles/fr/2010/my-post.rss</span></tt></li>
	      </ul>
	  </div></blockquote>
	  <div class="admonition-wrapper">
	    <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">The Special <tt class="docutils literal"><span class="pre">_format</span></tt> Routing Parameter</p>
	      <p class="last">This example also highlights the special <tt class="docutils literal"><span class="pre">_format</span></tt> routing parameter.
		When using this parameter, the matched value becomes the "request format"
		of the <tt class="docutils literal"><span class="pre">Request</span></tt> object. Ultimately, the request format is used for such
		things such as setting the <tt class="docutils literal"><span class="pre">Content-Type</span></tt> of the response (e.g. a <tt class="docutils literal"><span class="pre">json</span></tt>
		request format translates into a <tt class="docutils literal"><span class="pre">Content-Type</span></tt> of <tt class="docutils literal"><span class="pre">application/json</span></tt>).
		It can also be used in the controller to render a different template for
		each value of <tt class="docutils literal"><span class="pre">_format</span></tt>. The <tt class="docutils literal"><span class="pre">_format</span></tt> parameter is a very powerful way
		to render the same content in different formats.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="controller-naming-pattern">
	<span id="controller-string-syntax"></span><span id="index-8"></span><h2>Controller Naming Pattern<a class="headerlink" href="#controller-naming-pattern" title="Permalink to this headline">¶</a></h2>
	<p>Every route must have a <tt class="docutils literal"><span class="pre">_controller</span></tt> parameter, which dictates which
	  controller should be executed when that route is matched. This parameter
	  uses a simple string pattern called the <em>logical controller name</em>, which
	  Symfony maps to a specific PHP method and class. The pattern has three parts,
	  each separated by a colon:</p>
	<blockquote>
	  <div><strong>bundle</strong>:<strong>controller</strong>:<strong>action</strong></div></blockquote>
	<p>For example, a <tt class="docutils literal"><span class="pre">_controller</span></tt> value of <tt class="docutils literal"><span class="pre">AcmeBlogBundle:Blog:show</span></tt> means:</p>
	<table border="1" class="docutils">
	  <colgroup>
	    <col width="34%">
	    <col width="38%">
	    <col width="28%">
	  </colgroup>
	  <thead valign="bottom">
	    <tr><th class="head">Bundle</th>
	      <th class="head">Controller Class</th>
	      <th class="head">Method Name</th>
	    </tr>
	  </thead>
	  <tbody valign="top">
	    <tr><td>AcmeBlogBundle</td>
	      <td>BlogController</td>
	      <td>showAction</td>
	    </tr>
	  </tbody>
	</table>
	<p>The controller might look like this:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/BlogBundle/Controller/BlogController.php</span>

<span class="k">namespace</span> <span class="nx">Acme\BlogBundle\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">BlogController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$slug</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Notice that Symfony adds the string <tt class="docutils literal"><span class="pre">Controller</span></tt> to the class name (<tt class="docutils literal"><span class="pre">Blog</span></tt>
	  =&gt; <tt class="docutils literal"><span class="pre">BlogController</span></tt>) and <tt class="docutils literal"><span class="pre">Action</span></tt> to the method name (<tt class="docutils literal"><span class="pre">show</span></tt> =&gt; <tt class="docutils literal"><span class="pre">showAction</span></tt>).</p>
	<p>You could also refer to this controller using its fully-qualified class name
	  and method: <tt class="docutils literal"><span class="pre">Acme\BlogBundle\Controller\BlogController::showAction</span></tt>.
	  But if you follow some simple conventions, the logical name is more concise
	  and allows more flexibility.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">In addition to using the logical name or the fully-qualified class name,
	      Symfony supports a third way of referring to a controller. This method
	      uses just one colon separator (e.g. <tt class="docutils literal"><span class="pre">service_name:indexAction</span></tt>) and
	      refers to the controller as a service (see <a class="reference internal" href="../cookbook/controller/service.html"><em>How to define Controllers as Services</em></a>).</p>
	</div></div>
      </div>
      <div class="section" id="route-parameters-and-controller-arguments">
	<h2>Route Parameters and Controller Arguments<a class="headerlink" href="#route-parameters-and-controller-arguments" title="Permalink to this headline">¶</a></h2>
	<p>The route parameters (e.g. <tt class="docutils literal"><span class="pre">{slug}</span></tt>) are especially important because
	  each is made available as an argument to the controller method:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$slug</span><span class="p">)</span>
<span class="p">{</span>
  <span class="c1">// ...</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>In reality, the entire <tt class="docutils literal"><span class="pre">defaults</span></tt> collection is merged with the parameter
	  values to form a single array. Each key of that array is available as an
	  argument on the controller.</p>
	<p>In other words, for each argument of your controller method, Symfony looks
	  for a route parameter of that name and assigns its value to that argument.
	  In the advanced example above, any combination (in any order) of the following
	  variables could be used as arguments to the <tt class="docutils literal"><span class="pre">showAction()</span></tt> method:</p>
	<ul class="simple">
	  <li><tt class="docutils literal"><span class="pre">$culture</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">$year</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">$title</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">$_format</span></tt></li>
	  <li><tt class="docutils literal"><span class="pre">$_controller</span></tt></li>
	</ul>
	<p>Since the placeholders and <tt class="docutils literal"><span class="pre">defaults</span></tt> collection are merged together, even
	  the <tt class="docutils literal"><span class="pre">$_controller</span></tt> variable is available. For a more detailed discussion,
	  see <a class="reference internal" href="controller.html#route-parameters-controller-arguments"><em>Route Parameters as Controller Arguments</em></a>.</p>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">You can also use a special <tt class="docutils literal"><span class="pre">$_route</span></tt> variable, which is set to the
	      name of the route that was matched.</p>
	</div></div>
      </div>
      <div class="section" id="including-external-routing-resources">
	<span id="routing-include-external-resources"></span><span id="index-9"></span><h2>Including External Routing Resources<a class="headerlink" href="#including-external-routing-resources" title="Permalink to this headline">¶</a></h2>
	<p>All routes are loaded via a single configuration file - usually <tt class="docutils literal"><span class="pre">app/config/routing.yml</span></tt>
	  (see <a class="reference internal" href="#creating-routes">Creating Routes</a> above). Commonly, however, you'll want to load routes
	  from other places, like a routing file that lives inside a bundle. This can
	  be done by "importing" that file:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/routing.yml</span>
<span class="l-Scalar-Plain">acme_hello</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">resource</span><span class="p-Indicator">:</span> <span class="s">"@AcmeHelloBundle/Resources/config/routing.yml"</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/routing.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"@AcmeHelloBundle/Resources/config/routing.xml"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/routing.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">addCollection</span><span class="p">(</span><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s2">"@AcmeHelloBundle/Resources/config/routing.php"</span><span class="p">));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">When importing resources from YAML, the key (e.g. <tt class="docutils literal"><span class="pre">acme_hello</span></tt>) is meaningless.
	      Just be sure that it's unique so no other lines override it.</p>
	</div></div>
	<p>The <tt class="docutils literal"><span class="pre">resource</span></tt> key loads the given routing resource. In this example the
	  resource is the full path to a file, where the <tt class="docutils literal"><span class="pre">@AcmeHelloBundle</span></tt> shortcut
	  syntax resolves to the path of that bundle. The imported file might look
	  like this:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 130px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre> <span class="c1"># src/Acme/HelloBundle/Resources/config/routing.yml</span>
<span class="l-Scalar-Plain">acme_hello</span><span class="p-Indicator">:</span>
     <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/hello/{name}</span>
     <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeHelloBundle</span><span class="p-Indicator">:</span><span class="nv">Hello</span><span class="p-Indicator">:</span><span class="nv">index</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/HelloBundle/Resources/config/routing.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"acme_hello"</span> <span class="na">pattern=</span><span class="s">"/hello/{name}"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeHelloBundle:Hello:index<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// src/Acme/HelloBundle/Resources/config/routing.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'acme_hello'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/hello/{name}'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeHelloBundle:Hello:index'</span><span class="p">,</span>
<span class="p">)));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>The routes from this file are parsed and loaded in the same way as the main
	  routing file.</p>
	<div class="section" id="prefixing-imported-routes">
	  <h3>Prefixing Imported Routes<a class="headerlink" href="#prefixing-imported-routes" title="Permalink to this headline">¶</a></h3>
	  <p>You can also choose to provide a "prefix" for the imported routes. For example,
	    suppose you want the <tt class="docutils literal"><span class="pre">acme_hello</span></tt> route to have a final pattern of <tt class="docutils literal"><span class="pre">/admin/hello/{name}</span></tt>
	    instead of simply <tt class="docutils literal"><span class="pre">/hello/{name}</span></tt>:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 130px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/routing.yml</span>
<span class="l-Scalar-Plain">acme_hello</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">resource</span><span class="p-Indicator">:</span> <span class="s">"@AcmeHelloBundle/Resources/config/routing.yml"</span>
    <span class="l-Scalar-Plain">prefix</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/admin</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/routing.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;import</span> <span class="na">resource=</span><span class="s">"@AcmeHelloBundle/Resources/config/routing.xml"</span> <span class="na">prefix=</span><span class="s">"/admin"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/routes&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/routing.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">addCollection</span><span class="p">(</span><span class="nv">$loader</span><span class="o">-&gt;</span><span class="na">import</span><span class="p">(</span><span class="s2">"@AcmeHelloBundle/Resources/config/routing.php"</span><span class="p">),</span> <span class="s1">'/admin'</span><span class="p">);</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>The string <tt class="docutils literal"><span class="pre">/admin</span></tt> will now be prepended to the pattern of each route
	    loaded from the new routing resource.</p>
	</div>
      </div>
      <div class="section" id="visualizing-debugging-routes">
	<span id="index-10"></span><h2>Visualizing &amp; Debugging Routes<a class="headerlink" href="#visualizing-debugging-routes" title="Permalink to this headline">¶</a></h2>
	<p>While adding and customizing routes, it's helpful to be able to visualize
	  and get detailed information about your routes. A great way to see every route
	  in your application is via the <tt class="docutils literal"><span class="pre">router:debug</span></tt> console command. Execute
	  the command by running the following from the root of your project.</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console router:debug
	  </pre></div>
	</div>
	<p>The command will print a helpful list of <em>all</em> the configured routes in
	  your application:</p>
	<div class="highlight-text"><div class="highlight"><pre>homepage              ANY       /
contact               GET       /contact
contact_process       POST      /contact
article_show          ANY       /articles/{culture}/{year}/{title}.{_format}
blog                  ANY       /blog/{page}
blog_show             ANY       /blog/{slug}
	  </pre></div>
	</div>
	<p>You can also get very specific information on a single route by including
	  the route name after the command:</p>
	<div class="highlight-bash"><div class="highlight"><pre><span class="nv">$ </span>php app/console router:debug article_show
	  </pre></div>
	</div>
      </div>
      <div class="section" id="generating-urls">
	<span id="index-11"></span><h2>Generating URLs<a class="headerlink" href="#generating-urls" title="Permalink to this headline">¶</a></h2>
	<p>The routing system should also be used to generate URLs. In reality, routing
	  is a bi-directional system: mapping the URL to a controller+parameters and
	  a route+parameters back to a URL. The
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Routing/Router.html#match()" title="Symfony\Component\Routing\Router::match()"><span class="pre">match()</span></a></tt> and
	  <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Routing/Router.html#generate()" title="Symfony\Component\Routing\Router::generate()"><span class="pre">generate()</span></a></tt> methods form this bi-directional
	  system. Take the <tt class="docutils literal"><span class="pre">blog_show</span></tt> example route from earlier:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$params</span> <span class="o">=</span> <span class="nv">$router</span><span class="o">-&gt;</span><span class="na">match</span><span class="p">(</span><span class="s1">'/blog/my-blog-post'</span><span class="p">);</span>
<span class="c1">// array('slug' =&gt; 'my-blog-post', '_controller' =&gt; 'AcmeBlogBundle:Blog:show')</span>

<span class="nv">$uri</span> <span class="o">=</span> <span class="nv">$router</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'blog_show'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'slug'</span> <span class="o">=&gt;</span> <span class="s1">'my-blog-post'</span><span class="p">));</span>
<span class="c1">// /blog/my-blog-post</span>
	  </pre></div>
	</div>
	<p>To generate a URL, you need to specify the name of the route (e.g. <tt class="docutils literal"><span class="pre">blog_show</span></tt>)
	  and any wildcards (e.g. <tt class="docutils literal"><span class="pre">slug</span> <span class="pre">=</span> <span class="pre">my-blog-post</span></tt>) used in the pattern for
	  that route. With this information, any URL can easily be generated:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">class</span> <span class="nc">MainController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">showAction</span><span class="p">(</span><span class="nv">$slug</span><span class="p">)</span>
    <span class="p">{</span>
      <span class="c1">// ...</span>

      <span class="nv">$url</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'router'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'blog_show'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'slug'</span> <span class="o">=&gt;</span> <span class="s1">'my-blog-post'</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>In an upcoming section, you'll learn how to generate URLs from inside templates.</p>
	<div class="section" id="generating-absolute-urls">
	  <span id="index-12"></span><h3>Generating Absolute URLs<a class="headerlink" href="#generating-absolute-urls" title="Permalink to this headline">¶</a></h3>
	  <p>By default, the router will generate relative URLs (e.g. <tt class="docutils literal"><span class="pre">/blog</span></tt>). To generate
	    an absolute URL, simply pass <tt class="docutils literal"><span class="pre">true</span></tt> to the third argument of the <tt class="docutils literal"><span class="pre">generate()</span></tt>
	    method:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$router</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'blog_show'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'slug'</span> <span class="o">=&gt;</span> <span class="s1">'my-blog-post'</span><span class="p">),</span> <span class="k">true</span><span class="p">);</span>
<span class="c1">// http://www.example.com/blog/my-blog-post</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p>The host that's used when generating an absolute URL is the host of
		the current <tt class="docutils literal"><span class="pre">Request</span></tt> object. This is detected automatically based
		on server information supplied by PHP. When generating absolute URLs for
		scripts run from the command line, you'll need to manually set the desired
		host on the <tt class="docutils literal"><span class="pre">Request</span></tt> object:</p>
	      <div class="last highlight-php"><div class="highlight"><pre><span class="nv">$request</span><span class="o">-&gt;</span><span class="na">headers</span><span class="o">-&gt;</span><span class="na">set</span><span class="p">(</span><span class="s1">'HOST'</span><span class="p">,</span> <span class="s1">'www.example.com'</span><span class="p">);</span>
		</pre></div>
	      </div>
	  </div></div>
	</div>
	<div class="section" id="generating-urls-with-query-strings">
	  <span id="index-13"></span><h3>Generating URLs with Query Strings<a class="headerlink" href="#generating-urls-with-query-strings" title="Permalink to this headline">¶</a></h3>
	  <p>The <tt class="docutils literal"><span class="pre">generate</span></tt> method takes an array of wildcard values to generate the URI.
	    But if you pass extra ones, they will be added to the URI as a query string:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$router</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'blog'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'page'</span> <span class="o">=&gt;</span> <span class="mi">2</span><span class="p">,</span> <span class="s1">'category'</span> <span class="o">=&gt;</span> <span class="s1">'Symfony'</span><span class="p">));</span>
<span class="c1">// /blog/2?category=Symfony</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="generating-urls-from-a-template">
	  <h3>Generating URLs from a template<a class="headerlink" href="#generating-urls-from-a-template" title="Permalink to this headline">¶</a></h3>
	  <p>The most common place to generate a URL is from within a template when linking
	    between pages in your application. This is done just as before, but using
	    a template helper function:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'blog_show'</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'slug'</span><span class="o">:</span> <span class="s1">'my-blog-post'</span> <span class="o">})</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>
  Read this blog post.
<span class="nt">&lt;/a&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;</span><span class="nx">a</span> <span class="nx">href</span><span class="o">=</span><span class="s2">"&lt;?php echo </span><span class="si">$view['router']</span><span class="s2">-&gt;generate('blog_show', array('slug' =&gt; 'my-blog-post')) ?&gt;"</span><span class="o">&gt;</span>
    <span class="nx">Read</span> <span class="k">this</span> <span class="nx">blog</span> <span class="nx">post</span><span class="o">.</span>
<span class="o">&lt;/</span><span class="nx">a</span><span class="o">&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Absolute URLs can also be generated.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 112px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">url</span><span class="o">(</span><span class="s1">'blog_show'</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'slug'</span><span class="o">:</span> <span class="s1">'my-blog-post'</span> <span class="o">})</span> <span class="cp">}}</span><span class="s">"</span><span class="nt">&gt;</span>
  Read this blog post.
<span class="nt">&lt;/a&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;</span><span class="nx">a</span> <span class="nx">href</span><span class="o">=</span><span class="s2">"&lt;?php echo </span><span class="si">$view['router']</span><span class="s2">-&gt;generate('blog_show', array('slug' =&gt; 'my-blog-post'), true) ?&gt;"</span><span class="o">&gt;</span>
    <span class="nx">Read</span> <span class="k">this</span> <span class="nx">blog</span> <span class="nx">post</span><span class="o">.</span>
<span class="o">&lt;/</span><span class="nx">a</span><span class="o">&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
      </div>
      <div class="section" id="summary">
	<h2>Summary<a class="headerlink" href="#summary" title="Permalink to this headline">¶</a></h2>
	<p>Routing is a system for mapping the URL of incoming requests to the controller
	  function that should be called to process the request. It both allows you
	  to specify beautiful URLs and keeps the functionality of your application
	  decoupled from those URLs. Routing is a two-way mechanism, meaning that it
	  should also be used to generate URLs.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/routing/scheme.html"><em>How to force routes to always use HTTPS</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="The Controller" href="controller.html">
      «&nbsp;The Controller
    </a><span class="separator">|</span>
    <a accesskey="N" title="Creating and using Templates" href="templating.html">
      Creating and using Templates&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
