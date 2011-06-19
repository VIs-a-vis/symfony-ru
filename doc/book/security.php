<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">
<div class="box_title">
    <h1 class="title_01">Security</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="security">
      <h1>Security<a class="headerlink" href="#security" title="Permalink to this headline">¶</a></h1>
      <p>Security is a two-step process whose goal is to prevent a user from accessing
	a resource that he/she should not have access to.</p>
      <p>In the first step of the process, the security system identifies who the user
	is by requiring the user to submit some sort of identification. This is called
	<strong>authentication</strong>, and it means that the system is trying to find out who
	you are.</p>
      <p>Once the system knows who you are, the next step is to determine if you should
	have access to a given resource. This part of the process is called <strong>authorization</strong>,
	and it means that the system is checking to see if you have privileges to
	perform a certain action.</p>
      <img alt="../_images/security_authentication_authorization.png" class="align-center" src="../_images/security_authentication_authorization.png">
      <p>Since the best way to learn is to see an example, let's dive right in.</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">Symfony's <a class="reference external" href="https://github.com/symfony/Security">security component</a> is available as a standalone PHP library
	    for use inside any PHP project.</p>
      </div></div>
      <div class="section" id="basic-example-http-authentication">
	<h2>Basic Example: HTTP Authentication<a class="headerlink" href="#basic-example-http-authentication" title="Permalink to this headline">¶</a></h2>
	<p>The security component can be configured via your application configuration.
	  In fact, most standard security setups are just matter of using the right
	  configuration. The following configuration tells Symfony to secure any URL
	  matching <tt class="docutils literal"><span class="pre">/admin/*</span></tt> and to ask the user for credentials using basic HTTP
	  authentication (i.e. the old-school username/password box):</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 418px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">secured_area</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>    <span class="l-Scalar-Plain">^/</span>
            <span class="l-Scalar-Plain">anonymous</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="l-Scalar-Plain">http_basic</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">realm</span><span class="p-Indicator">:</span> <span class="s">"Secured</span><span class="nv"> </span><span class="s">Demo</span><span class="nv"> </span><span class="s">Area"</span>

    <span class="l-Scalar-Plain">access_control</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">path</span><span class="p-Indicator">:</span> <span class="nv">^/admin</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="nv">ROLE_ADMIN</span> <span class="p-Indicator">}</span>

    <span class="l-Scalar-Plain">providers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">in_memory</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">users</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">ryan</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">ryanpass</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="s">'ROLE_USER'</span> <span class="p-Indicator">}</span>
                <span class="l-Scalar-Plain">admin</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">kitten</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="s">'ROLE_ADMIN'</span> <span class="p-Indicator">}</span>

    <span class="l-Scalar-Plain">encoders</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">Symfony\Component\Security\Core\User\User</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">plaintext</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;srv:container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/security"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:srv=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;config&gt;</span>
        <span class="nt">&lt;firewall</span> <span class="na">name=</span><span class="s">"secured_area"</span> <span class="na">pattern=</span><span class="s">"^/"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;anonymous</span> <span class="nt">/&gt;</span>
            <span class="nt">&lt;http-basic</span> <span class="na">realm=</span><span class="s">"Secured Demo Area"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/firewall&gt;</span>

        <span class="nt">&lt;access-control&gt;</span>
            <span class="nt">&lt;rule</span> <span class="na">path=</span><span class="s">"^/admin"</span> <span class="na">role=</span><span class="s">"ROLE_ADMIN"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/access-control&gt;</span>

        <span class="nt">&lt;provider</span> <span class="na">name=</span><span class="s">"in_memory"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;user</span> <span class="na">name=</span><span class="s">"ryan"</span> <span class="na">password=</span><span class="s">"ryanpass"</span> <span class="na">roles=</span><span class="s">"ROLE_USER"</span> <span class="nt">/&gt;</span>
            <span class="nt">&lt;user</span> <span class="na">name=</span><span class="s">"admin"</span> <span class="na">password=</span><span class="s">"kitten"</span> <span class="na">roles=</span><span class="s">"ROLE_ADMIN"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/provider&gt;</span>

        <span class="nt">&lt;encoder</span> <span class="na">class=</span><span class="s">"Symfony\Component\Security\Core\User\User"</span> <span class="na">algorithm=</span><span class="s">"plaintext"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/config&gt;</span>
<span class="nt">&lt;/srv:container&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'secured_area'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'pattern'</span> <span class="o">=&gt;</span> <span class="s1">'^/'</span><span class="p">,</span>
            <span class="s1">'anonymous'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
            <span class="s1">'http_basic'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'realm'</span> <span class="o">=&gt;</span> <span class="s1">'Secured Demo Area'</span><span class="p">,</span>
            <span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
    <span class="s1">'access_control'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="k">array</span><span class="p">(</span><span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'^/admin'</span><span class="p">,</span> <span class="s1">'role'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_ADMIN'</span><span class="p">),</span>
    <span class="p">),</span>
    <span class="s1">'providers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'in_memory'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'users'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'ryan'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'ryanpass'</span><span class="p">,</span> <span class="s1">'roles'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_USER'</span><span class="p">),</span>
                <span class="s1">'admin'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'kitten'</span><span class="p">,</span> <span class="s1">'roles'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_ADMIN'</span><span class="p">),</span>
            <span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
    <span class="s1">'encoders'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'Symfony\Component\Security\Core\User\User'</span> <span class="o">=&gt;</span> <span class="s1">'plaintext'</span><span class="p">,</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">A standard Symfony distribution separates the security configuration
	      into a separate file (e.g. <tt class="docutils literal"><span class="pre">app/config/security.yml</span></tt>). If you don't
	      have a separate security file, you can put the configuration directly
	      into your main config file (e.g. <tt class="docutils literal"><span class="pre">app/config/config.yml</span></tt>).</p>
	</div></div>
	<p>The end result of this configuration is a fully-functional security system
	  that looks like the following:</p>
	<ul class="simple">
	  <li>There are two users in the system (<tt class="docutils literal"><span class="pre">ryan</span></tt> and <tt class="docutils literal"><span class="pre">admin</span></tt>);</li>
	  <li>Users authenticate themselves via the basic HTTP authentication prompt;</li>
	  <li>Any URL matching <tt class="docutils literal"><span class="pre">/admin/*</span></tt> is secured, and only the <tt class="docutils literal"><span class="pre">admin</span></tt> user
	    can access it;</li>
	  <li>All URLs <em>not</em> matching <tt class="docutils literal"><span class="pre">/admin/*</span></tt> are accessible by all users (and the
	    user is never prompted to login).</li>
	</ul>
	<p>Let's look briefly at how security works and how each part of the configuration
	  comes into play.</p>
      </div>
      <div class="section" id="how-security-works-authentication-and-authorization">
	<h2>How Security Works: Authentication and Authorization<a class="headerlink" href="#how-security-works-authentication-and-authorization" title="Permalink to this headline">¶</a></h2>
	<p>Symfony's security system works by determining who a user is (i.e. authentication)
	  and then checking to see if that user should have access to a specific resource
	  or URL.</p>
	<div class="section" id="firewalls-authentication">
	  <h3>Firewalls (Authentication)<a class="headerlink" href="#firewalls-authentication" title="Permalink to this headline">¶</a></h3>
	  <p>When a user makes a request to a URL that's protected by a firewall, the
	    security system is activated. The job of the firewall is to determine whether
	    or not the user needs to be authenticated, and if he does, to send a response
	    back to the user initiating the authentication process.</p>
	  <p>A firewall is activated when the URL of an incoming request matches the configured
	    firewall's regular expression <tt class="docutils literal"><span class="pre">pattern</span></tt> config value. In this example, the
	    <tt class="docutils literal"><span class="pre">pattern</span></tt> (<tt class="docutils literal"><span class="pre">^/</span></tt>) will match <em>every</em> incoming request. The fact that the
	    firewall is activated does <em>not</em> mean, however, that the HTTP authentication
	    username and password box is displayed for every URL. For example, any user
	    can access <tt class="docutils literal"><span class="pre">/foo</span></tt> without being prompted to authenticate.</p>
	  <img alt="../_images/security_anonymous_user_access.png" class="align-center" src="../_images/security_anonymous_user_access.png">
	  <p>This works first because the firewall allows <em>anonymous users</em> via the <tt class="docutils literal"><span class="pre">anonymous</span></tt>
	    configuration parameter. In other words, the firewall doesn't require the
	    user to fully authenticate immediately. And because no special <tt class="docutils literal"><span class="pre">role</span></tt> is
	    needed to access <tt class="docutils literal"><span class="pre">/foo</span></tt> (under the <tt class="docutils literal"><span class="pre">access_control</span></tt> section), the request
	    can be fulfilled without ever asking the user to authenticate.</p>
	  <p>If you remove the <tt class="docutils literal"><span class="pre">anonymous</span></tt> key, the firewall will <em>always</em> make a user
	    fully authenticate immediately.</p>
	</div>
	<div class="section" id="access-controls-authorization">
	  <h3>Access Controls (Authorization)<a class="headerlink" href="#access-controls-authorization" title="Permalink to this headline">¶</a></h3>
	  <p>If a user requests <tt class="docutils literal"><span class="pre">/admin/foo</span></tt>, however, the process behaves differently.
	    This is because of the <tt class="docutils literal"><span class="pre">access_control</span></tt> configuration section that says
	    that any URL matching the regular expression pattern <tt class="docutils literal"><span class="pre">^/admin</span></tt> (i.e. <tt class="docutils literal"><span class="pre">/admin</span></tt>
	    or anything matching <tt class="docutils literal"><span class="pre">/admin/*</span></tt>) requires the <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt> role. Roles
	    are the basis for most authorization: a user can access <tt class="docutils literal"><span class="pre">/admin/foo</span></tt> only
	    if it has the <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt> role.</p>
	  <img alt="../_images/security_anonymous_user_denied_authorization.png" class="align-center" src="../_images/security_anonymous_user_denied_authorization.png">
	  <p>Like before, when the user originally makes the request, the firewall doesn't
	    ask for any identification. However, as soon as the access control layer
	    denies the user access (because the anonymous user doesn't have the <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt>
	    role), the firewall jumps into action and initiates the authentication process.
	    The authentication process depends on the authentication mechanism you're
	    using. For example, if you're using the form login authentication method,
	    the user will be redirected to the login page. If you're using HTTP authentication,
	    the user will be sent an HTTP 401 response so that the user sees the username
	    and password box.</p>
	  <p>The user now has the opportunity to submit its credentials back to the application.
	    If the credentials are valid, the original request can be re-tried.</p>
	  <img alt="../_images/security_ryan_no_role_admin_access.png" class="align-center" src="../_images/security_ryan_no_role_admin_access.png">
	  <p>In this example, the user <tt class="docutils literal"><span class="pre">ryan</span></tt> successfully authenticates with the firewall.
	    But since <tt class="docutils literal"><span class="pre">ryan</span></tt> doesn't have the <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt> role, he's still denied
	    access to <tt class="docutils literal"><span class="pre">/admin/foo</span></tt>. Ultimately, this means that the user will see some
	    sort of message indicating that access has been denied.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">When Symfony denies the user access, the user sees an error screen and
		receives a 403 HTTP status code (<tt class="docutils literal"><span class="pre">Forbidden</span></tt>). You can customize the
		access denied error screen by following the directions in the
		<a class="reference internal" href="../cookbook/controller/error_pages.html#cookbook-error-pages-by-status-code"><em>Error Pages</em></a> cookbook entry
		to customize the 403 error page.</p>
	  </div></div>
	  <p>Finally, if the <tt class="docutils literal"><span class="pre">admin</span></tt> user requests <tt class="docutils literal"><span class="pre">/admin/foo</span></tt>, a similar process
	    takes place, except now, after being authenticated, the access control layer
	    will let the request pass through:</p>
	  <img alt="../_images/security_admin_role_access.png" class="align-center" src="../_images/security_admin_role_access.png">
	  <p>The request flow when a user requests a protected resource is straightforward,
	    but incredibly flexible. As you'll see later, authentication can be handled
	    in any number of ways, including via a form login, X.509 certificate, or by
	    authenticating the user via Twitter. Regardless of the authentication method,
	    the request flow is always the same:</p>
	  <ol class="arabic simple">
	    <li>A user accesses a protected resource;</li>
	    <li>The application redirects the user to the login form;</li>
	    <li>The user submits its credentials (e.g. username/password);</li>
	    <li>The firewall authenticates the user;</li>
	    <li>The authenticated user re-tries the original request.</li>
	  </ol>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p>The <em>exact</em> process actually depends a little bit on which authentication
		mechanism you're using. For example, when using form login, the user
		submits its credentials to one URL that processes the form (e.g. <tt class="docutils literal"><span class="pre">/login_check</span></tt>)
		and then is redirected back to the originally requested URL (e.g. <tt class="docutils literal"><span class="pre">/admin/foo</span></tt>).
		But with HTTP authentication, the user submits its credentials directly
		to the original URL (e.g. <tt class="docutils literal"><span class="pre">/admin/foo</span></tt>) and then the page is returned
		to the user in that same request (i.e. no redirect).</p>
	      <p class="last">These types of idiosyncrasies shouldn't cause you any problems, but they're
		good to keep in mind.</p>
	  </div></div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">You'll also learn later how <em>anything</em> can be secured in Symfony2, including
		specific controllers, objects, or even PHP methods.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="using-a-traditional-login-form">
	<h2>Using a Traditional Login Form<a class="headerlink" href="#using-a-traditional-login-form" title="Permalink to this headline">¶</a></h2>
	<p>So far, you've seen how to blanket your application beneath a firewall and
	  then protect access to certain areas with roles. By using HTTP Authentication,
	  you can effortlessly tap into the native username/password box offered by
	  all browsers. However, Symfony supports many authentication mechanisms out
	  of the box. For details on all of them, see the
	  <a class="reference internal" href="../reference/configuration/security.html"><em>Security Configuration Reference</em></a>.</p>
	<p>In this section, you'll enhance this process by allowing the user to authenticate
	  via a traditional HTML login form.</p>
	<p>First, enable form login under your firewall:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 220px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">secured_area</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>    <span class="l-Scalar-Plain">^/</span>
            <span class="l-Scalar-Plain">anonymous</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="l-Scalar-Plain">form_login</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">login_path</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/login</span>
                <span class="l-Scalar-Plain">check_path</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">/login_check</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;srv:container</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/dic/security"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xmlns:srv=</span><span class="s">"http://symfony.com/schema/dic/services"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;config&gt;</span>
        <span class="nt">&lt;firewall</span> <span class="na">name=</span><span class="s">"secured_area"</span> <span class="na">pattern=</span><span class="s">"^/"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;anonymous</span> <span class="nt">/&gt;</span>
            <span class="nt">&lt;form-login</span> <span class="na">login_path=</span><span class="s">"/login"</span> <span class="na">check_path=</span><span class="s">"/login_check"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;/firewall&gt;</span>
    <span class="nt">&lt;/config&gt;</span>
<span class="nt">&lt;/srv:container&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'secured_area'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'pattern'</span> <span class="o">=&gt;</span> <span class="s1">'^/'</span><span class="p">,</span>
            <span class="s1">'anonymous'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
            <span class="s1">'form_login'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'login_path'</span> <span class="o">=&gt;</span> <span class="s1">'/login'</span><span class="p">,</span>
                <span class="s1">'check_path'</span> <span class="o">=&gt;</span> <span class="s1">'/login_check'</span><span class="p">,</span>
            <span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p>If you don't need to customize your <tt class="docutils literal"><span class="pre">login_path</span></tt> or <tt class="docutils literal"><span class="pre">check_path</span></tt>
	      values (the values used here are the default values), you can shorten
	      your configuration:</p>
	    <div class="last configuration-block jsactive clearfix">
	      <ul class="simple" style="height: 76px; ">
		<li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">form_login</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;form-login</span> <span class="nt">/&gt;</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="s1">'form_login'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
		    </pre></div>
		  </div>
		</li>
	      </ul>
	    </div>
	</div></div>
	<p>Now, when the security system initiates the authentication process, it will
	  redirect the user to the login form (<tt class="docutils literal"><span class="pre">/login</span></tt> by default). Implementing
	  this login form visually is your job. First, create two routes: one that
	  will display the login form (i.e. <tt class="docutils literal"><span class="pre">/login</span></tt>) and one that will handle the
	  login form submission (i.e. <tt class="docutils literal"><span class="pre">/login_check</span></tt>):</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 166px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/routing.yml</span>
<span class="l-Scalar-Plain">login</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/login</span>
    <span class="l-Scalar-Plain">defaults</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">_controller</span><span class="p-Indicator">:</span> <span class="nv">AcmeSecurityBundle</span><span class="p-Indicator">:</span><span class="nv">Security</span><span class="p-Indicator">:</span><span class="nv">login</span> <span class="p-Indicator">}</span>
<span class="l-Scalar-Plain">login_check</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/login_check</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/routing.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"login"</span> <span class="na">pattern=</span><span class="s">"/login"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;default</span> <span class="na">key=</span><span class="s">"_controller"</span><span class="nt">&gt;</span>AcmeSecurityBundle:Security:login<span class="nt">&lt;/default&gt;</span>
    <span class="nt">&lt;/route&gt;</span>
    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"login_check"</span> <span class="na">pattern=</span><span class="s">"/login_check"</span> <span class="nt">/&gt;</span>

<span class="nt">&lt;/routes&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/routing.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'login'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/login'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'_controller'</span> <span class="o">=&gt;</span> <span class="s1">'AcmeDemoBundle:Security:login'</span><span class="p">,</span>
<span class="p">)));</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'login_check'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/login_check'</span><span class="p">,</span> <span class="k">array</span><span class="p">()));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">You will <em>not</em> need to implement a controller for the <tt class="docutils literal"><span class="pre">/login_check</span></tt>
	      URL as the firewall will automatically catch and process any form submitted
	      to this URL. It's optional, but helpful, to create a route so that you
	      can use it to generate the form submission URL in the login template below.</p>
	</div></div>
	<p>Notice that the name of the <tt class="docutils literal"><span class="pre">login</span></tt> route isn't important. What's important
	  is that the URL of the route (<tt class="docutils literal"><span class="pre">/login</span></tt>) matches the <tt class="docutils literal"><span class="pre">check_path</span></tt> config
	  value, as that's where the security system will redirect users that need
	  to login.</p>
	<p>Next, create the controller that will display the login form:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/SecurityBundle/Controller/Main;</span>
<span class="k">namespace</span> <span class="nx">Acme\SecurityBundle\Controller</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Bundle\FrameworkBundle\Controller\Controller</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\SecurityContext</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">SecurityController</span> <span class="k">extends</span> <span class="nx">Controller</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">loginAction</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// get the login error if there is one</span>
        <span class="k">if</span> <span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">attributes</span><span class="o">-&gt;</span><span class="na">has</span><span class="p">(</span><span class="nx">SecurityContext</span><span class="o">::</span><span class="na">AUTHENTICATION_ERROR</span><span class="p">))</span> <span class="p">{</span>
            <span class="nv">$error</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">attributes</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="nx">SecurityContext</span><span class="o">::</span><span class="na">AUTHENTICATION_ERROR</span><span class="p">);</span>
        <span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
            <span class="nv">$error</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getSession</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="nx">SecurityContext</span><span class="o">::</span><span class="na">AUTHENTICATION_ERROR</span><span class="p">);</span>
        <span class="p">}</span>

        <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeSecurityBundle:Security:login.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
            <span class="c1">// last username entered by the user</span>
            <span class="s1">'last_username'</span> <span class="o">=&gt;</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getSession</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="nx">SecurityContext</span><span class="o">::</span><span class="na">LAST_USERNAME</span><span class="p">),</span>
            <span class="s1">'error'</span>         <span class="o">=&gt;</span> <span class="nv">$error</span><span class="p">,</span>
        <span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Don't let this controller confuse you. As you'll see in a moment, when the
	  user submits the form, the security system automatically handles the form
	  submission for you. If the user had submitted an invalid username or password,
	  this controller reads the form submission error from the security system so
	  that it can be displayed back to the user.</p>
	<p>In other words, your job is to display the login form and any login errors
	  that may have occurred, but the security system itself takes care of checking
	  the submitted username and password and authenticating the user.</p>
	<p>Finally, create the corresponding template:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 415px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/SecurityBundle/Resources/views/Security/login.html.twig #}</span>
<span class="cp">{%</span> <span class="k">if</span> <span class="nv">error</span> <span class="cp">%}</span>
    <span class="nt">&lt;div&gt;</span><span class="cp">{{</span> <span class="nv">error.message</span> <span class="cp">}}</span><span class="nt">&lt;/div&gt;</span>
<span class="cp">{%</span> <span class="k">endif</span> <span class="cp">%}</span>

<span class="nt">&lt;form</span> <span class="na">action=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">path</span><span class="o">(</span><span class="s1">'login_check'</span><span class="o">)</span> <span class="cp">}}</span><span class="s">"</span> <span class="na">method=</span><span class="s">"post"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;label</span> <span class="na">for=</span><span class="s">"username"</span><span class="nt">&gt;</span>Username:<span class="nt">&lt;/label&gt;</span>
    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="na">id=</span><span class="s">"username"</span> <span class="na">name=</span><span class="s">"_username"</span> <span class="na">value=</span><span class="s">"</span><span class="cp">{{</span> <span class="nv">last_username</span> <span class="cp">}}</span><span class="s">"</span> <span class="nt">/&gt;</span>

    <span class="nt">&lt;label</span> <span class="na">for=</span><span class="s">"password"</span><span class="nt">&gt;</span>Password:<span class="nt">&lt;/label&gt;</span>
    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"password"</span> <span class="na">id=</span><span class="s">"password"</span> <span class="na">name=</span><span class="s">"_password"</span> <span class="nt">/&gt;</span>

    <span class="c">{#</span>
<span class="c">        If you want to control the URL the user is redirected to on success (more details below)</span>
<span class="c">        &lt;input type="hidden" name="_target_path" value="/account" /&gt;</span>
<span class="c">    #}</span>

    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"submit"</span> <span class="na">name=</span><span class="s">"login"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/form&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="c1">// src/Acme/SecurityBundle/Resources/views/Security/login.html.php ?&gt;</span>
<span class="o">&lt;?</span><span class="nx">php</span> <span class="k">if</span> <span class="p">(</span><span class="nv">$error</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;div&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$error</span><span class="o">-&gt;</span><span class="na">getMessage</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="nt">&lt;/div&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endif</span><span class="p">;</span> <span class="cp">?&gt;</span>

<span class="nt">&lt;form</span> <span class="na">action=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'router'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">generate</span><span class="p">(</span><span class="s1">'login_check'</span><span class="p">)</span> <span class="cp">?&gt;</span><span class="s">"</span> <span class="na">method=</span><span class="s">"post"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;label</span> <span class="na">for=</span><span class="s">"username"</span><span class="nt">&gt;</span>Username:<span class="nt">&lt;/label&gt;</span>
    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"text"</span> <span class="na">id=</span><span class="s">"username"</span> <span class="na">name=</span><span class="s">"_username"</span> <span class="na">value=</span><span class="s">"</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$last_username</span> <span class="cp">?&gt;</span><span class="s">"</span> <span class="nt">/&gt;</span>

    <span class="nt">&lt;label</span> <span class="na">for=</span><span class="s">"password"</span><span class="nt">&gt;</span>Password:<span class="nt">&lt;/label&gt;</span>
    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"password"</span> <span class="na">id=</span><span class="s">"password"</span> <span class="na">name=</span><span class="s">"_password"</span> <span class="nt">/&gt;</span>

    <span class="c">&lt;!--</span>
<span class="c">        If you want to control the URL the user is redirected to on success (more details below)</span>
<span class="c">        &lt;input type="hidden" name="_target_path" value="/account" /&gt;</span>
<span class="c">    --&gt;</span>

    <span class="nt">&lt;input</span> <span class="na">type=</span><span class="s">"submit"</span> <span class="na">name=</span><span class="s">"login"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/form&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	    <p class="last">The <tt class="docutils literal"><span class="pre">error</span></tt> variable passed into the template is an instance of
	      <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Security/Core/Exception/AuthenticationException.html" title="Symfony\Component\Security\Core\Exception\AuthenticationException"><span class="pre">AuthenticationException</span></a></tt>.
	      It may contain more information - or even sensitive information - about
	      the authentication failure, so use it wisely!</p>
	</div></div>
	<p>The form has very few requirements. First, by submitting the form to <tt class="docutils literal"><span class="pre">/login_check</span></tt>
	  (via the <tt class="docutils literal"><span class="pre">login_check</span></tt> route), the security system will intercept the form
	  submission and process the form for you automatically. Second, the security
	  system expects the submitted fields to be called <tt class="docutils literal"><span class="pre">_username</span></tt> and <tt class="docutils literal"><span class="pre">_password</span></tt>
	  (these field names can be <em class="xref std std-ref">configured</em>).</p>
	<p>And that's it! When you submit the form, the security system will automatically
	  check the user's credentials and either authenticate the user or send the
	  user back to the login form where the error can be displayed.</p>
	<p>Let's review the whole process:</p>
	<ol class="arabic simple">
	  <li>The user tries to access a resource that is protected;</li>
	  <li>The firewall initiates the authentication process by redirecting the
	    user to the login form (<tt class="docutils literal"><span class="pre">/login</span></tt>);</li>
	  <li>The <tt class="docutils literal"><span class="pre">/login</span></tt> page renders login form via the route and controller created
	    in this example;</li>
	  <li>The user submits the login form to <tt class="docutils literal"><span class="pre">/login_check</span></tt>;</li>
	  <li>The security system intercepts the request, checks the user's submitted
	    credentials, authenticates the user if they are correct, and sends the
	    user back to the login form if they are not.</li>
	</ol>
	<p>By default, if the submitted credentials are correct, the user will be redirected
	  to the original page that was requested (e.g. <tt class="docutils literal"><span class="pre">/admin/foo</span></tt>). If the user
	  originally went straight to the login page, he'll be redirected to the homepage.
	  This can be highly customized, allowing you to, for example, redirect the
	  user to a specific URL.</p>
	<p>For more details on this and how to customize the form login process in general,
	  see <a class="reference internal" href="../cookbook/security/form_login.html"><em>How to customize your Form Login</em></a>.</p>
	<div class="admonition-wrapper">
	  <div class="sidebar"></div><div class="admonition admonition-sidebar"><p class="first sidebar-title">Avoid Common Pitfalls</p>
	    <p>When setting up your login form, watch out for a few common pitfalls.</p>
	    <p><strong>1. Create the correct routes</strong></p>
	    <p>First, be sure that you've defined the <tt class="docutils literal"><span class="pre">/login</span></tt> and <tt class="docutils literal"><span class="pre">/login_check</span></tt>
	      routes correctly and that they correspond to the <tt class="docutils literal"><span class="pre">login_path</span></tt> and
	      <tt class="docutils literal"><span class="pre">check_path</span></tt> config values. A misconfiguration here can mean that you're
	      redirected to a 404 page instead of the login page, or that submitting
	      the login form does nothing (you just see the login form over and over
	      again).</p>
	    <p><strong>2. Be sure the login page isn't secure</strong></p>
	    <p>Also, be sure that the login page does <em>not</em> require any roles to be
	      viewed. For example, the following configuration - which requires the
	      <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt> role for all URLs (including the <tt class="docutils literal"><span class="pre">/login</span></tt> URL), will
	      cause a redirect loop:</p>
	    <div class="configuration-block jsactive clearfix">
	      <ul class="simple" style="height: 94px; ">
		<li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">access_control</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">path</span><span class="p-Indicator">:</span> <span class="nv">^/</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="nv">ROLE_ADMIN</span> <span class="p-Indicator">}</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;access-control&gt;</span>
    <span class="nt">&lt;rule</span> <span class="na">path=</span><span class="s">"^/"</span> <span class="na">role=</span><span class="s">"ROLE_ADMIN"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/access-control&gt;</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="s1">'access_control'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'^/'</span><span class="p">,</span> <span class="s1">'role'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_ADMIN'</span><span class="p">),</span>
<span class="p">),</span>
		    </pre></div>
		  </div>
		</li>
	      </ul>
	    </div>
	    <p>Removing the access control on the <tt class="docutils literal"><span class="pre">/login</span></tt> URL fixes the problem:</p>
	    <div class="configuration-block jsactive clearfix">
	      <ul class="simple" style="height: 112px; ">
		<li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">access_control</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">path</span><span class="p-Indicator">:</span> <span class="nv">^/login</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="nv">IS_AUTHENTICATED_ANONYMOUSLY</span> <span class="p-Indicator">}</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">path</span><span class="p-Indicator">:</span> <span class="nv">^/</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="nv">ROLE_ADMIN</span> <span class="p-Indicator">}</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;access-control&gt;</span>
    <span class="nt">&lt;rule</span> <span class="na">path=</span><span class="s">"^/login"</span> <span class="na">role=</span><span class="s">"IS_AUTHENTICATED_ANONYMOUSLY"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;rule</span> <span class="na">path=</span><span class="s">"^/"</span> <span class="na">role=</span><span class="s">"ROLE_ADMIN"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/access-control&gt;</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="s1">'access_control'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'^/login'</span><span class="p">,</span> <span class="s1">'role'</span> <span class="o">=&gt;</span> <span class="s1">'IS_AUTHENTICATED_ANONYMOUSLY'</span><span class="p">),</span>
    <span class="k">array</span><span class="p">(</span><span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'^/'</span><span class="p">,</span> <span class="s1">'role'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_ADMIN'</span><span class="p">),</span>
<span class="p">),</span>
		    </pre></div>
		  </div>
		</li>
	      </ul>
	    </div>
	    <p>Also, if your firewall does <em>not</em> allow for anonymous users, you'll need
	      to create a special firewall that allows anonymous users for the login
	      page:</p>
	    <div class="configuration-block jsactive clearfix">
	      <ul class="simple" style="height: 184px; ">
		<li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">login_firewall</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>    <span class="l-Scalar-Plain">^/login$</span>
        <span class="l-Scalar-Plain">anonymous</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">~</span>
    <span class="l-Scalar-Plain">secured_area</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>    <span class="l-Scalar-Plain">^/</span>
        <span class="l-Scalar-Plain">login_form</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;firewall</span> <span class="na">name=</span><span class="s">"login_firewall"</span> <span class="na">pattern=</span><span class="s">"^/login$"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;anonymous</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/firewall&gt;</span>
<span class="nt">&lt;firewall</span> <span class="na">name=</span><span class="s">"secured_area"</span> <span class="na">pattern=</span><span class="s">"^/"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;login_form</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/firewall&gt;</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'login_firewall'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'pattern'</span> <span class="o">=&gt;</span> <span class="s1">'^/login$'</span><span class="p">,</span>
        <span class="s1">'anonymous'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
    <span class="p">),</span>
    <span class="s1">'secured_area'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'pattern'</span> <span class="o">=&gt;</span> <span class="s1">'^/'</span><span class="p">,</span>
        <span class="s1">'form_login'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
    <span class="p">),</span>
<span class="p">),</span>
		    </pre></div>
		  </div>
		</li>
	      </ul>
	    </div>
	    <p><strong>3. Be sure ``/login_check`` is behind a firewall</strong></p>
	    <p>Next, make sure that your <tt class="docutils literal"><span class="pre">check_path</span></tt> URL (e.g. <tt class="docutils literal"><span class="pre">/login_check</span></tt>)
	      is behind the firewall you're using for your form login (in this example,
	      the single firewall matches <em>all</em> URLs, including <tt class="docutils literal"><span class="pre">/login_check</span></tt>). If
	      <tt class="docutils literal"><span class="pre">/login_check</span></tt> doesn't match any firewall, you'll receive a <tt class="docutils literal"><span class="pre">Unable</span>
		<span class="pre">to</span> <span class="pre">find</span> <span class="pre">the</span> <span class="pre">controller</span> <span class="pre">for</span> <span class="pre">path</span> <span class="pre">"/login_check"</span></tt> exception.</p>
	    <p><strong>4. Multiple firewalls don't share security context</strong></p>
	    <p class="last">If you're using multiple firewalls and you authenticate against one firewall,
	      you will <em>not</em> be authenticated against any other firewalls automatically.
	      Different firewalls are like different security systems. That's why,
	      for most applications, having one main firewall is enough.</p>
	</div></div>
      </div>
      <div class="section" id="authorization">
	<h2>Authorization<a class="headerlink" href="#authorization" title="Permalink to this headline">¶</a></h2>
	<p>The first step in security is always authentication: the process of verifying
	  who the user is. With Symfony, authentication can be done in any way - via
	  a form login, basic HTTP Authentication, or even via Facebook.</p>
	<p>Once the user has been authenticated, authorization begins. Authorization
	  provides a standard and powerful way to decide if a user can access any resource
	  (a URL, a model object, a method call, ...). This works by assigning specific
	  roles to each user, and then requiring different roles for different resources.</p>
	<p>The process of authorization has two different sides:</p>
	<ol class="arabic simple">
	  <li>The user has a specific set of roles;</li>
	  <li>A resource requires a specific role in order to be accessed.</li>
	</ol>
	<p>In this section, you'll focus on how to secure different resources (e.g. URLs,
	  method calls, etc) with different roles. Later, you'll learn more about how
	  roles are created and assigned to users.</p>
	<div class="section" id="securing-specific-url-patterns">
	  <h3>Securing Specific URL Patterns<a class="headerlink" href="#securing-specific-url-patterns" title="Permalink to this headline">¶</a></h3>
	  <p>The most basic way to secure part of your application is to secure an entire
	    URL pattern. You've seen this already in the first example of this chapter,
	    where anything matching the regular expression pattern <tt class="docutils literal"><span class="pre">^/admin</span></tt> requires
	    the <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt> role.</p>
	  <p>You can define as many URL patterns as you need - each is a regular expression.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 166px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">access_control</span><span class="p-Indicator">:</span>
        <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">path</span><span class="p-Indicator">:</span> <span class="nv">^/admin/users</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="nv">ROLE_SUPER_ADMIN</span> <span class="p-Indicator">}</span>
        <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">path</span><span class="p-Indicator">:</span> <span class="nv">^/admin</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="nv">ROLE_ADMIN</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>
    <span class="nt">&lt;access-control&gt;</span>
        <span class="nt">&lt;rule</span> <span class="na">path=</span><span class="s">"^/admin/users"</span> <span class="na">role=</span><span class="s">"ROLE_SUPER_ADMIN"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;rule</span> <span class="na">path=</span><span class="s">"^/admin"</span> <span class="na">role=</span><span class="s">"ROLE_ADMIN"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/access-control&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'access_control'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="k">array</span><span class="p">(</span><span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'^/admin/users'</span><span class="p">,</span> <span class="s1">'role'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_SUPER_ADMIN'</span><span class="p">),</span>
        <span class="k">array</span><span class="p">(</span><span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'^/admin'</span><span class="p">,</span> <span class="s1">'role'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_ADMIN'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p class="last">Prepending the path with <tt class="docutils literal"><span class="pre">^</span></tt> ensures that only URLs <em>beginning</em> with
		the pattern are matched. For example, a path of simply <tt class="docutils literal"><span class="pre">/admin</span></tt> would
		match <tt class="docutils literal"><span class="pre">/admin/foo</span></tt> but also <tt class="docutils literal"><span class="pre">/foo/admin</span></tt>.</p>
	  </div></div>
	  <p>For each incoming request, Symfony2 tries to find a matching access control
	    rule (the first one wins). If the user isn't authenticated yet, the authentication
	    process is initiated (i.e. the user is given a chance to login). However,
	    if the user <em>is</em> authenticated but doesn't have the required role, an
	    <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/ComponentSecurity/Core/Exception/AccessDeniedException.html" title="Symfony\ComponentSecurity\Core\Exception\AccessDeniedException"><span class="pre">AccessDeniedException</span></a></tt>
	    exception is thrown, which you can handle and turn into a nice "access denied"
	    error page for the user. See <a class="reference internal" href="../cookbook/controller/error_pages.html"><em>How to customize Error Pages</em></a> for
	    more information.</p>
	  <p>Since Symfony uses the first access control rule it matches, a URL like <tt class="docutils literal"><span class="pre">/admin/users/new</span></tt>
	    will match the first rule and require only the <tt class="docutils literal"><span class="pre">ROLE_SUPER_ADMIN</span></tt> role.
	    Any URL like <tt class="docutils literal"><span class="pre">/admin/blog</span></tt> will match the second rule and require <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt>.</p>
	  <p>You can also force <tt class="docutils literal"><span class="pre">HTTP</span></tt> or <tt class="docutils literal"><span class="pre">HTTPS</span></tt> via an <tt class="docutils literal"><span class="pre">access_control</span></tt> entry.
	    For more information, see <a class="reference internal" href="../cookbook/security/force_https.html"><em>How to force HTTPS or HTTP for Different URLs</em></a>.</p>
	</div>
	<div class="section" id="securing-a-controller">
	  <h3>Securing a Controller<a class="headerlink" href="#securing-a-controller" title="Permalink to this headline">¶</a></h3>
	  <p>Protecting your application based on URL patterns is easy, but may not be
	    fine-grained enough in certain cases. When necessary, you can easily force
	    authorization from inside a controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\Exception\AccessDeniedException</span>
<span class="c1">// ...</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="k">if</span> <span class="p">(</span><span class="k">false</span> <span class="o">===</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.context'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">isGranted</span><span class="p">(</span><span class="s1">'ROLE_ADMIN'</span><span class="p">))</span> <span class="p">{</span>
        <span class="k">throw</span> <span class="k">new</span> <span class="nx">AccessDeniedException</span><span class="p">();</span>
    <span class="p">}</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>You can also choose to install and use the optional <tt class="docutils literal"><span class="pre">SecurityExtraBundle</span></tt>,
	    which can secure your controller using annotations:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">JMS\SecurityExtraBundle\Annotation\Secure</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @Secure(roles="ROLE_ADMIN")</span>
<span class="sd"> */</span>
<span class="k">public</span> <span class="k">function</span> <span class="nf">helloAction</span><span class="p">(</span><span class="nv">$name</span><span class="p">)</span>
<span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>For more information, see the <a class="reference external" href="https://github.com/schmittjoh/SecurityExtraBundle">SecurityExtraBundle</a> documentation. If you're
	    using Symfony's Standard Distribution, this bundle is available by default.
	    If not, you can easily download and install it.</p>
	</div>
	<div class="section" id="securing-other-services">
	  <h3>Securing other Services<a class="headerlink" href="#securing-other-services" title="Permalink to this headline">¶</a></h3>
	  <p>In fact, anything in Symfony can be protected using a strategy similar to
	    the one seen in the previous section. For example, suppose you have a service
	    (i.e. a PHP class) whose job is to send emails from one user to another.
	    You can restrict use of this class - no matter where it's being used from -
	    to users that have a specific role.</p>
	  <p>For more information on how you can use the security component to secure
	    different services and methods in your application, see <a class="reference internal" href="../cookbook/security/securing_services.html"><em>How to secure any Service or Method in your Application</em></a>.</p>
	</div>
	<div class="section" id="access-control-lists-acls-securing-individual-database-objects">
	  <h3>Access Control Lists (ACLs): Securing Individual Database Objects<a class="headerlink" href="#access-control-lists-acls-securing-individual-database-objects" title="Permalink to this headline">¶</a></h3>
	  <p>Imagine you are designing a blog system where your users can comment on your
	    posts. Now, you want a user to be able to edit his own comments, but not
	    those of other users. Also, as the admin user, you yourself want to be able
	    to edit <em>all</em> comments.</p>
	  <p>The security component comes with an optional access control list (ACL) system
	    that you can use when you need to control access to individual instances
	    of an object in your system. <em>Without</em> ACL, you can secure your system so that
	    only certain users can edit blog comments in general. But <em>with</em> ACL, you
	    can restrict or allow access on a comment-by-comment basis.</p>
	  <p>For more information, see the cookbook article: <a class="reference internal" href="../cookbook/security/acl.html"><em>Access Control Lists (ACLs)</em></a>.</p>
	</div>
      </div>
      <div class="section" id="users">
	<h2>Users<a class="headerlink" href="#users" title="Permalink to this headline">¶</a></h2>
	<p>In the previous sections, you learned how you can protect different resources
	  by requiring a set of <em>roles</em> for a resource. In this section we'll explore
	  the other side of authorization: users.</p>
	<div class="section" id="where-do-users-come-from-user-providers">
	  <h3>Where do Users come from? (<em>User Providers</em>)<a class="headerlink" href="#where-do-users-come-from-user-providers" title="Permalink to this headline">¶</a></h3>
	  <p>During authentication, the user submits a set of credentials (usually a username
	    and password). The job of the authentication system is to match those credentials
	    against some pool of users. So where does this list of users come from?</p>
	  <p>In Symfony2, users can come from anywhere - a configuration file, a database
	    table, a web service, or anything else you can dream up. Anything that provides
	    one or more users to the authentication system is known as a "user provider".
	    Symfony2 comes standard with the two most common user providers: one that
	    loads users from a configuration file and one that loads users from a database
	    table.</p>
	  <div class="section" id="specifying-users-in-a-configuration-file">
	    <h4>Specifying Users in a Configuration File<a class="headerlink" href="#specifying-users-in-a-configuration-file" title="Permalink to this headline">¶</a></h4>
	    <p>The easiest way to specify your users is directly in a configuration file.
	      In fact, you've seen this already in the example in this chapter.</p>
	    <div class="configuration-block jsactive clearfix">
	      <ul class="simple" style="height: 202px; ">
		<li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">providers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">default_provider</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">users</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">ryan</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">ryanpass</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="s">'ROLE_USER'</span> <span class="p-Indicator">}</span>
                <span class="l-Scalar-Plain">admin</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">kitten</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="s">'ROLE_ADMIN'</span> <span class="p-Indicator">}</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>
    <span class="nt">&lt;provider</span> <span class="na">name=</span><span class="s">"default_provider"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;user</span> <span class="na">name=</span><span class="s">"ryan"</span> <span class="na">password=</span><span class="s">"ryanpass"</span> <span class="na">roles=</span><span class="s">"ROLE_USER"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;user</span> <span class="na">name=</span><span class="s">"admin"</span> <span class="na">password=</span><span class="s">"kitten"</span> <span class="na">roles=</span><span class="s">"ROLE_ADMIN"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/provider&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'providers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'default_provider'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'users'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'ryan'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'ryanpass'</span><span class="p">,</span> <span class="s1">'roles'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_USER'</span><span class="p">),</span>
                <span class="s1">'admin'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'kitten'</span><span class="p">,</span> <span class="s1">'roles'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_ADMIN'</span><span class="p">),</span>
            <span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		    </pre></div>
		  </div>
		</li>
	      </ul>
	    </div>
	    <p>This user provider is called the "in-memory" user provider, since the users
	      aren't stored anywhere in a database. The actual user object is provided
	      by Symfony (<tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Security/Core/User/User.html" title="Symfony\Component\Security\Core\User\User"><span class="pre">User</span></a></tt>).</p>
	    <div class="admonition-wrapper">
	      <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
		<p class="last">Any user provider can load users directly from configuration by specifying
		  the <tt class="docutils literal"><span class="pre">users</span></tt> configuration parameter and listing the users beneath it.</p>
	    </div></div>
	    <div class="admonition-wrapper">
	      <div class="caution"></div><div class="admonition admonition-caution"><p class="first admonition-title">Caution</p>
		<p>If your username is completely numeric (e.g. <tt class="docutils literal"><span class="pre">77</span></tt>) or contains a dash
		  (e.g. <tt class="docutils literal"><span class="pre">user-name</span></tt>), you should use that alternative syntax when specifying
		  users in YAML:</p>
		<div class="last highlight-yaml"><div class="highlight"><pre><span class="l-Scalar-Plain">users</span><span class="p-Indicator">:</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">77</span><span class="p-Indicator">,</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">pass</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="s">'ROLE_USER'</span> <span class="p-Indicator">}</span>
    <span class="p-Indicator">-</span> <span class="p-Indicator">{</span> <span class="nv">name</span><span class="p-Indicator">:</span> <span class="nv">user-name</span><span class="p-Indicator">,</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">pass</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="s">'ROLE_USER'</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	    </div></div>
	    <p>For smaller sites, this method is quick and easy to setup. For more complex
	      systems, you'll want to load your users from the database.</p>
	  </div>
	  <div class="section" id="loading-users-from-the-database">
	    <h4>Loading Users from the Database<a class="headerlink" href="#loading-users-from-the-database" title="Permalink to this headline">¶</a></h4>
	    <p>If you'd like to load your users via the Doctrine ORM, you can easily do
	      this by creating a <tt class="docutils literal"><span class="pre">User</span></tt> class and configuring the <tt class="docutils literal"><span class="pre">entity</span></tt> provider.</p>
	    <p>With this approach, you'll first create your own <tt class="docutils literal"><span class="pre">User</span></tt> class, which will
	      be stored in the database.</p>
	    <div class="highlight-php"><div class="highlight"><pre><span class="c1">// src/Acme/UserBundle/Entity/User.php</span>
<span class="k">namespace</span> <span class="nx">Acme\UserBundle\Entity</span><span class="p">;</span>

<span class="k">use</span> <span class="nx">Symfony\Component\Security\Core\User\UserInterface</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Doctrine\ORM\Mapping</span> <span class="k">as</span> <span class="nx">ORM</span><span class="p">;</span>

<span class="sd">/**</span>
<span class="sd"> * @ORM\Entity</span>
<span class="sd"> */</span>
<span class="k">class</span> <span class="nc">User</span> <span class="k">implements</span> <span class="nx">UserInterface</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @ORM\Column(type="string", length="255")</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$username</span><span class="p">;</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
	      </pre></div>
	    </div>
	    <p>As far as the security system is concerned, the only requirement for your
	      custom user class is that it implements the <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Security/Core/User/UserInterface.html" title="Symfony\Component\Security\Core\User\UserInterface"><span class="pre">UserInterface</span></a></tt>
	      interface. This means that your concept of a "user" can be anything, as long
	      as it implements this interface.</p>
	    <div class="admonition-wrapper">
	      <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
		<p class="last">The user object will be serialized and saved in the session during requests,
		  therefore it is recommended that you <a class="reference external" href="http://php.net/manual/en/class.serializable.php">implement the Serializable interface</a>
		  in your user object.</p>
	    </div></div>
	    <p>Next, configure an <tt class="docutils literal"><span class="pre">entity</span></tt> user provider, and point it to your <tt class="docutils literal"><span class="pre">User</span></tt>
	      class:</p>
	    <div class="configuration-block jsactive clearfix">
	      <ul class="simple" style="height: 148px; ">
		<li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">providers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">main</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">entity</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">class</span><span class="p-Indicator">:</span> <span class="nv">Acme\UserBundle\Entity\User</span><span class="p-Indicator">,</span> <span class="nv">property</span><span class="p-Indicator">:</span> <span class="nv">username</span> <span class="p-Indicator">}</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/security.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;provider</span> <span class="na">name=</span><span class="s">"main"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;entity</span> <span class="na">class=</span><span class="s">"Acme\UserBundle\Entity\User"</span> <span class="na">property=</span><span class="s">"username"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/provider&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		    </pre></div>
		  </div>
		</li>
		<li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/security.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'providers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'main'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'entity'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'class'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\UserBundle\Entity\User'</span><span class="p">,</span> <span class="s1">'property'</span> <span class="o">=&gt;</span> <span class="s1">'username'</span><span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		    </pre></div>
		  </div>
		</li>
	      </ul>
	    </div>
	    <p>With the introduction of this new provider, the authentication system will
	      attempt to load a <tt class="docutils literal"><span class="pre">User</span></tt> object from the database by using the <tt class="docutils literal"><span class="pre">username</span></tt>
	      field of that class.</p>
	    <div class="admonition-wrapper">
	      <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
		<p class="last">This example is just meant to show you the basic idea behind the <tt class="docutils literal"><span class="pre">entity</span></tt>
		  provider. For a full working example, see <a class="reference internal" href="../cookbook/security/entity_provider.html"><em>How to load Security Users from the Database (the entity Provider)</em></a>.</p>
	    </div></div>
	    <p>For more information on creating your own custom provider (e.g. if you needed
	      to load users via a web service), see <a class="reference internal" href="../cookbook/security/custom_provider.html"><em>How to create a custom User Provider</em></a>.</p>
	  </div>
	</div>
	<div class="section" id="encoding-the-user-s-password">
	  <h3>Encoding the User's Password<a class="headerlink" href="#encoding-the-user-s-password" title="Permalink to this headline">¶</a></h3>
	  <p>So far, for simplicity, all the examples have stored the users' passwords
	    in plain text (whether those users are stored in a configuration file or in
	    a database somewhere). Of course, in a real application, you'll want to encode
	    your users' passwords for security reasons. This is easily accomplished by
	    mapping your User class to one of several built-in "encoders". For example,
	    to store your users in memory, but obscure their passwords via <tt class="docutils literal"><span class="pre">sha1</span></tt>,
	    do the following:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 325px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>
    <span class="l-Scalar-Plain">providers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">in_memory</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">users</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">ryan</span><span class="p-Indicator">:</span>  <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">bb87a29949f3a1ee0559f8a57357487151281386</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="s">'ROLE_USER'</span> <span class="p-Indicator">}</span>
                <span class="l-Scalar-Plain">admin</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">74913f5cd5f61ec0bcfdb775414c2fb3d161b620</span><span class="p-Indicator">,</span> <span class="nv">roles</span><span class="p-Indicator">:</span> <span class="s">'ROLE_ADMIN'</span> <span class="p-Indicator">}</span>

    <span class="l-Scalar-Plain">encoders</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">Symfony\Component\Security\Core\User\User</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">algorithm</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">sha1</span>
            <span class="l-Scalar-Plain">iterations</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">1</span>
            <span class="l-Scalar-Plain">encode_as_base64</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">false</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>
    <span class="nt">&lt;provider</span> <span class="na">name=</span><span class="s">"in_memory"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;user</span> <span class="na">name=</span><span class="s">"ryan"</span> <span class="na">password=</span><span class="s">"bb87a29949f3a1ee0559f8a57357487151281386"</span> <span class="na">roles=</span><span class="s">"ROLE_USER"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;user</span> <span class="na">name=</span><span class="s">"admin"</span> <span class="na">password=</span><span class="s">"74913f5cd5f61ec0bcfdb775414c2fb3d161b620"</span> <span class="na">roles=</span><span class="s">"ROLE_ADMIN"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/provider&gt;</span>

    <span class="nt">&lt;encoder</span> <span class="na">class=</span><span class="s">"Symfony\Component\Security\Core\User\User"</span> <span class="na">algorithm=</span><span class="s">"sha1"</span> <span class="na">iterations=</span><span class="s">"1"</span> <span class="na">encode_as_base64=</span><span class="s">"false"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>
    <span class="s1">'providers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'in_memory'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'users'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'ryan'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'bb87a29949f3a1ee0559f8a57357487151281386'</span><span class="p">,</span> <span class="s1">'roles'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_USER'</span><span class="p">),</span>
                <span class="s1">'admin'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'74913f5cd5f61ec0bcfdb775414c2fb3d161b620'</span><span class="p">,</span> <span class="s1">'roles'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_ADMIN'</span><span class="p">),</span>
            <span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
    <span class="s1">'encoders'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'Symfony\Component\Security\Core\User\User'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'algorithm'</span>         <span class="o">=&gt;</span> <span class="s1">'sha1'</span><span class="p">,</span>
            <span class="s1">'iterations'</span>        <span class="o">=&gt;</span> <span class="mi">1</span><span class="p">,</span>
            <span class="s1">'encode_as_base64'</span>  <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>By setting the <tt class="docutils literal"><span class="pre">iterations</span></tt> to <tt class="docutils literal"><span class="pre">1</span></tt> and the <tt class="docutils literal"><span class="pre">encode_as_base64</span></tt> to false,
	    the password is simply run through the <tt class="docutils literal"><span class="pre">sha1</span></tt> algorithm one time and without
	    any extra encoding. You can now calculate the hashed password either programmatically
	    (e.g. <tt class="docutils literal"><span class="pre">hash('sha1',</span> <span class="pre">'ryanpass')</span></tt>) or via some online tool like <a class="reference external" href="http://www.functions-online.com/sha1.html">functions-online.com</a></p>
	  <p>If you're creating your users dynamically (and storing them in a database),
	    you can use even tougher hashing algorithms and then rely on an actual password
	    encoder object to help you encode passwords. For example, suppose your User
	    object is <tt class="docutils literal"><span class="pre">Acme\UserBundle\Entity\User</span></tt> (like in the above example). First,
	    configure the encoder for that user:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 166px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="c1"># ...</span>

    <span class="l-Scalar-Plain">encoders</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">Acme\UserBundle\Entity\User</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">sha512</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>

    <span class="nt">&lt;encoder</span> <span class="na">class=</span><span class="s">"Acme\UserBundle\Entity\User"</span> <span class="na">algorithm=</span><span class="s">"sha512"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="c1">// ...</span>

    <span class="s1">'encoders'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'Acme\UserBundle\Entity\User'</span> <span class="o">=&gt;</span> <span class="s1">'sha512'</span><span class="p">,</span>
    <span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>In this case, you're using the stronger <tt class="docutils literal"><span class="pre">sha512</span></tt> algorithm. Also, since
	    you've simply specified the algorithm (<tt class="docutils literal"><span class="pre">sha512</span></tt>) as a string, the system
	    will default to hashing your password 5000 times in a row and then encoding
	    it as base64. In other words, the password has been greatly obfuscated so
	    that the hashed password can't be decoded (i.e. you can't determine the password
	    from the hashed password).</p>
	  <p>If you have some sort of registration form for users, you'll need to be able
	    to determine the hashed password so that you can set it on your user. No
	    matter what algorithm you configure for your user object, the hashed password
	    can always be determined in the following way from a controller:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$factory</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.encoder_factory'</span><span class="p">);</span>
<span class="nv">$user</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Acme\UserBundle\Entity\User</span><span class="p">();</span>

<span class="nv">$encoder</span> <span class="o">=</span> <span class="nv">$factory</span><span class="o">-&gt;</span><span class="na">getEncoder</span><span class="p">(</span><span class="nv">$user</span><span class="p">);</span>
<span class="nv">$password</span> <span class="o">=</span> <span class="nv">$encoder</span><span class="o">-&gt;</span><span class="na">encodePassword</span><span class="p">(</span><span class="s1">'ryanpass'</span><span class="p">,</span> <span class="nv">$user</span><span class="o">-&gt;</span><span class="na">getSalt</span><span class="p">());</span>
<span class="nv">$user</span><span class="o">-&gt;</span><span class="na">setPassword</span><span class="p">(</span><span class="nv">$password</span><span class="p">);</span>
	    </pre></div>
	  </div>
	</div>
	<div class="section" id="retrieving-the-user-object">
	  <h3>Retrieving the User Object<a class="headerlink" href="#retrieving-the-user-object" title="Permalink to this headline">¶</a></h3>
	  <p>After authentication, the <tt class="docutils literal"><span class="pre">User</span></tt> object of the current user can be accessed
	    via the <tt class="docutils literal"><span class="pre">security.context</span></tt> service. From inside a controller, this will
	    look like:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$user</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.context'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">getToken</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">getUser</span><span class="p">();</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	      <p class="last">Anonymous users are technically authenticated, meaning that the <tt class="docutils literal"><span class="pre">isAuthenticated()</span></tt>
		method of an anonymous user object will return true. To check if your
		user is actually authenticated, check for the <tt class="docutils literal"><span class="pre">IS_AUTHENTICATED_FULLY</span></tt>
		role.</p>
	  </div></div>
	</div>
	<div class="section" id="using-multiple-user-providers">
	  <h3>Using Multiple User Providers<a class="headerlink" href="#using-multiple-user-providers" title="Permalink to this headline">¶</a></h3>
	  <p>Each authentication mechanism (e.g. HTTP Authentication, form login, etc)
	    uses exactly one user provider, and will use the first declared user provider
	    by default. But what if you want to specify a few users via configuration
	    and the rest of your users in the database? This is possible by creating
	    a new provider that chains the two together:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 238px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">providers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">chain_provider</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">providers</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">in_memory</span><span class="p-Indicator">,</span> <span class="nv">user_db</span><span class="p-Indicator">]</span>
        <span class="l-Scalar-Plain">in_memory</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">users</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">foo</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">test</span> <span class="p-Indicator">}</span>
        <span class="l-Scalar-Plain">user_db</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">entity</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">class</span><span class="p-Indicator">:</span> <span class="nv">Acme\UserBundle\Entity\User</span><span class="p-Indicator">,</span> <span class="nv">property</span><span class="p-Indicator">:</span> <span class="nv">username</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;provider</span> <span class="na">name=</span><span class="s">="chain_provider"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;provider&gt;</span>in_memory<span class="nt">&lt;/provider&gt;</span>
        <span class="nt">&lt;provider&gt;</span>user_db<span class="nt">&lt;/provider&gt;</span>
    <span class="nt">&lt;/provider&gt;</span>
    <span class="nt">&lt;provider</span> <span class="na">name=</span><span class="s">"in_memory"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;user</span> <span class="na">name=</span><span class="s">"foo"</span> <span class="na">password=</span><span class="s">"test"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/provider&gt;</span>
    <span class="nt">&lt;provider</span> <span class="na">name=</span><span class="s">"user_db"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;entity</span> <span class="na">class=</span><span class="s">"Acme\UserBundle\Entity\User"</span> <span class="na">property=</span><span class="s">"username"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/provider&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'providers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'chain_provider'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'providers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'in_memory'</span><span class="p">,</span> <span class="s1">'user_db'</span><span class="p">),</span>
        <span class="p">),</span>
        <span class="s1">'in_memory'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'users'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'test'</span><span class="p">),</span>
            <span class="p">),</span>
        <span class="p">),</span>
        <span class="s1">'user_db'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'entity'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'class'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\UserBundle\Entity\User'</span><span class="p">,</span> <span class="s1">'property'</span> <span class="o">=&gt;</span> <span class="s1">'username'</span><span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Now, all authentication mechanisms will use the <tt class="docutils literal"><span class="pre">chain_provider</span></tt>, since
	    it's the first specified. The <tt class="docutils literal"><span class="pre">chain_provider</span></tt> will, in turn, try to load
	    the user from both the <tt class="docutils literal"><span class="pre">in_memory</span></tt> and <tt class="docutils literal"><span class="pre">user_db</span></tt> providers.</p>
	  <div class="admonition-wrapper">
	    <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Tip</p>
	      <p>If you have no reasons to separate your <tt class="docutils literal"><span class="pre">in_memory</span></tt> users from your
		<tt class="docutils literal"><span class="pre">user_db</span></tt> users, you can accomplish this even more easily by combining
		the two sources into a single provider:</p>
	      <div class="last configuration-block jsactive clearfix">
		<ul class="simple" style="height: 184px; ">
		  <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">providers</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">main_provider</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">users</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">foo</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">password</span><span class="p-Indicator">:</span> <span class="nv">test</span> <span class="p-Indicator">}</span>
            <span class="l-Scalar-Plain">entity</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">class</span><span class="p-Indicator">:</span> <span class="nv">Acme\UserBundle\Entity\User</span><span class="p-Indicator">,</span> <span class="nv">property</span><span class="p-Indicator">:</span> <span class="nv">username</span> <span class="p-Indicator">}</span>
		      </pre></div>
		    </div>
		  </li>
		  <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;provider</span> <span class="na">name=</span><span class="s">="main_provider"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;user</span> <span class="na">name=</span><span class="s">"foo"</span> <span class="na">password=</span><span class="s">"test"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;entity</span> <span class="na">class=</span><span class="s">"Acme\UserBundle\Entity\User"</span> <span class="na">property=</span><span class="s">"username"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/provider&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		      </pre></div>
		    </div>
		  </li>
		  <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'providers'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'main_provider'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="s1">'users'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'password'</span> <span class="o">=&gt;</span> <span class="s1">'test'</span><span class="p">),</span>
            <span class="p">),</span>
            <span class="s1">'entity'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'class'</span> <span class="o">=&gt;</span> <span class="s1">'Acme\UserBundle\Entity\User'</span><span class="p">,</span> <span class="s1">'property'</span> <span class="o">=&gt;</span> <span class="s1">'username'</span><span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		      </pre></div>
		    </div>
		  </li>
		</ul>
	      </div>
	  </div></div>
	  <p>You can also configure the firewall or individual authentication mechanisms
	    to use a specific provider. Again, unless a provider is specified explicitly,
	    the first provider is always used:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 238px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">secured_area</span><span class="p-Indicator">:</span>
            <span class="c1"># ...</span>
            <span class="l-Scalar-Plain">provider</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">user_db</span>
            <span class="l-Scalar-Plain">http_basic</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">realm</span><span class="p-Indicator">:</span> <span class="s">"Secured</span><span class="nv"> </span><span class="s">Demo</span><span class="nv"> </span><span class="s">Area"</span>
                <span class="l-Scalar-Plain">provider</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">in_memory</span>
            <span class="l-Scalar-Plain">form_login</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;firewall</span> <span class="na">name=</span><span class="s">"secured_area"</span> <span class="na">pattern=</span><span class="s">"^/"</span> <span class="na">provider=</span><span class="s">"user_db"</span><span class="nt">&gt;</span>
        <span class="c">&lt;!-- ... --&gt;</span>
        <span class="nt">&lt;http-basic</span> <span class="na">realm=</span><span class="s">"Secured Demo Area"</span> <span class="na">provider=</span><span class="s">"in_memory"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;form-login</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/firewall&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'secured_area'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="c1">// ...</span>
            <span class="s1">'provider'</span> <span class="o">=&gt;</span> <span class="s1">'user_db'</span><span class="p">,</span>
            <span class="s1">'http_basic'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
                <span class="c1">// ...</span>
                <span class="s1">'provider'</span> <span class="o">=&gt;</span> <span class="s1">'in_memory'</span><span class="p">,</span>
            <span class="p">),</span>
            <span class="s1">'form_login'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>In this example, if a user tries to login via HTTP authentication, the authentication
	    system will use the <tt class="docutils literal"><span class="pre">in_memory</span></tt> user provider. But if the user tries to
	    login via the form login, the <tt class="docutils literal"><span class="pre">user_db</span></tt> provider will be used (since it's
	    the default for the firewall as a whole).</p>
	  <p>For more information about user provider and firewall configuration, see
	    the <a class="reference internal" href="../reference/configuration/security.html"><em>Security Configuration Reference</em></a>.</p>
	</div>
      </div>
      <div class="section" id="roles">
	<h2>Roles<a class="headerlink" href="#roles" title="Permalink to this headline">¶</a></h2>
	<p>The idea of a "role" is key to the authorization process. Each user is assigned
	  a set of roles and then each resource requires one or more roles. If the user
	  has the required roles, access is granted. Otherwise access is denied.</p>
	<p>Roles are pretty simple, and are basically strings that you can invent and
	  use as needed (though roles are objects internally). For example, if you
	  need to start limiting access to the blog admin section of your website,
	  you could protect that section using a <tt class="docutils literal"><span class="pre">ROLE_BLOG_ADMIN</span></tt> role. This role
	  doesn't need to be defined anywhere - you can just start using it.</p>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">All roles <strong>must</strong> begin with the <tt class="docutils literal"><span class="pre">ROLE_</span></tt> prefix to be managed by
	      Symfony2. If you define your own roles with a dedicated <tt class="docutils literal"><span class="pre">Role</span></tt> class
	      (more advanced), don't use the <tt class="docutils literal"><span class="pre">ROLE_</span></tt> prefix.</p>
	</div></div>
	<div class="section" id="hierarchical-roles">
	  <h3>Hierarchical Roles<a class="headerlink" href="#hierarchical-roles" title="Permalink to this headline">¶</a></h3>
	  <p>Instead of associating many roles to users, you can define role inheritance
	    rules by creating a role hierarchy:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">role_hierarchy</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">ROLE_ADMIN</span><span class="p-Indicator">:</span>       <span class="l-Scalar-Plain">ROLE_USER</span>
        <span class="l-Scalar-Plain">ROLE_SUPER_ADMIN</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">ROLE_ADMIN</span><span class="p-Indicator">,</span> <span class="nv">ROLE_ALLOWED_TO_SWITCH</span><span class="p-Indicator">]</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/security.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;role-hierarchy&gt;</span>
        <span class="nt">&lt;role</span> <span class="na">id=</span><span class="s">"ROLE_ADMIN"</span><span class="nt">&gt;</span>ROLE_USER<span class="nt">&lt;/role&gt;</span>
        <span class="nt">&lt;role</span> <span class="na">id=</span><span class="s">"ROLE_SUPER_ADMIN"</span><span class="nt">&gt;</span>ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH<span class="nt">&lt;/role&gt;</span>
    <span class="nt">&lt;/role-hierarchy&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/security.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'role_hierarchy'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'ROLE_ADMIN'</span>       <span class="o">=&gt;</span> <span class="s1">'ROLE_USER'</span><span class="p">,</span>
        <span class="s1">'ROLE_SUPER_ADMIN'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'ROLE_ADMIN'</span><span class="p">,</span> <span class="s1">'ROLE_ALLOWED_TO_SWITCH'</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>In the above configuration, users with <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt> role will also have the
	    <tt class="docutils literal"><span class="pre">ROLE_USER</span></tt> role. The <tt class="docutils literal"><span class="pre">ROLE_SUPER_ADMIN</span></tt> role has <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt>, <tt class="docutils literal"><span class="pre">ROLE_ALLOWED_TO_SWITCH</span></tt>
	    and <tt class="docutils literal"><span class="pre">ROLE_USER</span></tt> (inherited from <tt class="docutils literal"><span class="pre">ROLE_ADMIN</span></tt>).</p>
	</div>
      </div>
      <div class="section" id="logging-out">
	<h2>Logging Out<a class="headerlink" href="#logging-out" title="Permalink to this headline">¶</a></h2>
	<p>Usually, you'll also want your users to be able to log out. Fortunately,
	  the firewall can handle this automatically for you when you activate the
	  <tt class="docutils literal"><span class="pre">logout</span></tt> config parameter:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 220px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">secured_area</span><span class="p-Indicator">:</span>
            <span class="c1"># ...</span>
            <span class="l-Scalar-Plain">logout</span><span class="p-Indicator">:</span>
                <span class="l-Scalar-Plain">path</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/logout</span>
                <span class="l-Scalar-Plain">target</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">/</span>
    <span class="c1"># ...</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;firewall</span> <span class="na">name=</span><span class="s">"secured_area"</span> <span class="na">pattern=</span><span class="s">"^/"</span><span class="nt">&gt;</span>
        <span class="c">&lt;!-- ... --&gt;</span>
        <span class="nt">&lt;logout</span> <span class="na">path=</span><span class="s">"/logout"</span> <span class="na">target=</span><span class="s">"/"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/firewall&gt;</span>
    <span class="c">&lt;!-- ... --&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'secured_area'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="c1">// ...</span>
            <span class="s1">'logout'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'path'</span> <span class="o">=&gt;</span> <span class="s1">'logout'</span><span class="p">,</span> <span class="s1">'target'</span> <span class="o">=&gt;</span> <span class="s1">'/'</span><span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
    <span class="c1">// ...</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Once this is configured under your firewall, sending a user to <tt class="docutils literal"><span class="pre">/logout</span></tt>
	  (or whatever you configure the <tt class="docutils literal"><span class="pre">path</span></tt> to be), will un-authenticate the
	  current user. The user will then be sent to the homepage (the value defined
	  by the <tt class="docutils literal"><span class="pre">target</span></tt> parameter). Both the <tt class="docutils literal"><span class="pre">path</span></tt> and <tt class="docutils literal"><span class="pre">target</span></tt> config parameters
	  default to what's specified here. In other words, unless you need to customize
	  them, you can omit them entirely and shorten your configuration:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 76px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="l-Scalar-Plain">logout</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="nt">&lt;logout</span> <span class="nt">/&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="s1">'logout'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Note that you will <em>not</em> need to implement a controller for the <tt class="docutils literal"><span class="pre">/logout</span></tt>
	  URL as the firewall takes care of everything. You may, however, want to create
	  a route so that you can use it to generate the URL:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/routing.yml</span>
<span class="l-Scalar-Plain">logout</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">pattern</span><span class="p-Indicator">:</span>   <span class="l-Scalar-Plain">/logout</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/routing.xml --&gt;</span>
<span class="cp">&lt;?xml version="1.0" encoding="UTF-8" ?&gt;</span>

<span class="nt">&lt;routes</span> <span class="na">xmlns=</span><span class="s">"http://symfony.com/schema/routing"</span>
    <span class="na">xmlns:xsi=</span><span class="s">"http://www.w3.org/2001/XMLSchema-instance"</span>
    <span class="na">xsi:schemaLocation=</span><span class="s">"http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd"</span><span class="nt">&gt;</span>

    <span class="nt">&lt;route</span> <span class="na">id=</span><span class="s">"logout"</span> <span class="na">pattern=</span><span class="s">"/logout"</span> <span class="nt">/&gt;</span>

<span class="nt">&lt;/routes&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/routing.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\RouteCollection</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Routing\Route</span><span class="p">;</span>

<span class="nv">$collection</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">RouteCollection</span><span class="p">();</span>
<span class="nv">$collection</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'logout'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Route</span><span class="p">(</span><span class="s1">'/logout'</span><span class="p">,</span> <span class="k">array</span><span class="p">()));</span>

<span class="k">return</span> <span class="nv">$collection</span><span class="p">;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>Once the user has been logged out, he will be redirected to whatever path
	  is defined by the <tt class="docutils literal"><span class="pre">target</span></tt> parameter above (e.g. the <tt class="docutils literal"><span class="pre">homepage</span></tt>). For
	  more information on configuring the logout, see the
	  <a class="reference internal" href="../reference/configuration/security.html"><em>Security Configuration Reference</em></a>.</p>
      </div>
      <div class="section" id="access-control-in-templates">
	<h2>Access Control in Templates<a class="headerlink" href="#access-control-in-templates" title="Permalink to this headline">¶</a></h2>
	<p>If you want to check if the current user has a role inside a template, use
	  the built-in helper function:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{%</span> <span class="k">if</span> <span class="nv">is_granted</span><span class="o">(</span><span class="s1">'ROLE_ADMIN'</span><span class="o">)</span> <span class="cp">%}</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"..."</span><span class="nt">&gt;</span>Delete<span class="nt">&lt;/a&gt;</span>
<span class="cp">{%</span> <span class="k">endif</span> <span class="cp">%}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="cp">&lt;?php</span> <span class="k">if</span> <span class="p">(</span><span class="nv">$view</span><span class="p">[</span><span class="s1">'security'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">isGranted</span><span class="p">(</span><span class="s1">'ROLE_ADMIN'</span><span class="p">))</span><span class="o">:</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"..."</span><span class="nt">&gt;</span>Delete<span class="nt">&lt;/a&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endif</span><span class="p">;</span> <span class="cp">?&gt;</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">If you use this function and are <em>not</em> at a URL where there is a firewall
	      active, an exception will be thrown. Again, it's almost always a good
	      idea to have a main firewall that covers all URLs (as has been shown
	      in this chapter).</p>
	</div></div>
      </div>
      <div class="section" id="access-control-in-controllers">
	<h2>Access Control in Controllers<a class="headerlink" href="#access-control-in-controllers" title="Permalink to this headline">¶</a></h2>
	<p>If you want to check if the current user has a role in your controller, use
	  the <tt class="docutils literal"><span class="pre">isGranted</span></tt> method of the security context:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="c1">// show different content to admin users</span>
    <span class="k">if</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'security.context'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">isGranted</span><span class="p">(</span><span class="s1">'ADMIN'</span><span class="p">))</span> <span class="p">{</span>
        <span class="c1">// Load admin content here</span>
    <span class="p">}</span>
    <span class="c1">// load other regular content here</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">A firewall must be active or an exception will be thrown when the <tt class="docutils literal"><span class="pre">isGranted</span></tt>
	      method is called. See the note above about templates for more details.</p>
	</div></div>
      </div>
      <div class="section" id="impersonating-a-user">
	<h2>Impersonating a User<a class="headerlink" href="#impersonating-a-user" title="Permalink to this headline">¶</a></h2>
	<p>Sometimes, it's useful to be able to switch from one user to another without
	  having to logout and login again (for instance when you are debugging or trying
	  to understand a bug a user sees that you can't reproduce). This can be easily
	  done by activating the <tt class="docutils literal"><span class="pre">switch_user</span></tt> firewall listener:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 166px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">main</span><span class="p-Indicator">:</span>
            <span class="c1"># ...</span>
            <span class="l-Scalar-Plain">switch_user</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">true</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/security.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;firewall&gt;</span>
        <span class="c">&lt;!-- ... --&gt;</span>
        <span class="nt">&lt;switch-user</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/firewall&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/security.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'main'</span><span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="c1">// ...</span>
            <span class="s1">'switch_user'</span> <span class="o">=&gt;</span> <span class="k">true</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<p>To switch to another user, just add a query string with the <tt class="docutils literal"><span class="pre">_switch_user</span></tt>
	  parameter and the username as the value to the current URL:</p>
	<blockquote>
	  <div><a class="reference external" href="http://example.com/somewhere?_switch_user=thomas">http://example.com/somewhere?_switch_user=thomas</a></div></blockquote>
	<p>To switch back to the original user, use the special <tt class="docutils literal"><span class="pre">_exit</span></tt> username:</p>
	<blockquote>
	  <div><a class="reference external" href="http://example.com/somewhere?_switch_user=_exit">http://example.com/somewhere?_switch_user=_exit</a></div></blockquote>
	<p>Of course, this feature needs to be made available to a small group of users.
	  By default, access is restricted to users having the <tt class="docutils literal"><span class="pre">ROLE_ALLOWED_TO_SWITCH</span></tt>
	  role. The name of this role can be modified via the <tt class="docutils literal"><span class="pre">role</span></tt> setting. For
	  extra security, you can also change the query parameter name via the <tt class="docutils literal"><span class="pre">parameter</span></tt>
	  setting:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 166px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">main</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">// ...</span>
            <span class="l-Scalar-Plain">switch_user</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">role</span><span class="p-Indicator">:</span> <span class="nv">ROLE_ADMIN</span><span class="p-Indicator">,</span> <span class="nv">parameter</span><span class="p-Indicator">:</span> <span class="nv">_want_to_be_this_user</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/security.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;firewall&gt;</span>
        <span class="c">&lt;!-- ... --&gt;</span>
        <span class="nt">&lt;switch-user</span> <span class="na">role=</span><span class="s">"ROLE_ADMIN"</span> <span class="na">parameter=</span><span class="s">"_want_to_be_this_user"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/firewall&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/security.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'main'</span><span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
            <span class="c1">// ...</span>
            <span class="s1">'switch_user'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'role'</span> <span class="o">=&gt;</span> <span class="s1">'ROLE_ADMIN'</span><span class="p">,</span> <span class="s1">'parameter'</span> <span class="o">=&gt;</span> <span class="s1">'_want_to_be_this_user'</span><span class="p">),</span>
        <span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="stateless-authentication">
	<h2>Stateless Authentication<a class="headerlink" href="#stateless-authentication" title="Permalink to this headline">¶</a></h2>
	<p>By default, Symfony2 relies on a cookie (the Session) to persist the security
	  context of the user. But if you use certificates or HTTP authentication for
	  instance, persistence is not needed as credentials are available for each
	  request. In that case, and if you don't need to store anything else between
	  requests, you can activate the stateless authentication (which means that no
	  cookie will be ever created by Symfony2):</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 166px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/security.yml</span>
<span class="l-Scalar-Plain">security</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">firewalls</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">main</span><span class="p-Indicator">:</span>
            <span class="l-Scalar-Plain">http_basic</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="l-Scalar-Plain">stateless</span><span class="p-Indicator">:</span>  <span class="l-Scalar-Plain">true</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/security.xml --&gt;</span>
<span class="nt">&lt;config&gt;</span>
    <span class="nt">&lt;firewall</span> <span class="na">stateless=</span><span class="s">"true"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;http-basic</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/firewall&gt;</span>
<span class="nt">&lt;/config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/security.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'security'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'firewalls'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'main'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'http_basic'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(),</span> <span class="s1">'stateless'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">),</span>
    <span class="p">),</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	    <p class="last">If you use a form login, Symfony2 will create a cookie even if you set
	      <tt class="docutils literal"><span class="pre">stateless</span></tt> to <tt class="docutils literal"><span class="pre">true</span></tt>.</p>
	</div></div>
      </div>
      <div class="section" id="final-words">
	<h2>Final Words<a class="headerlink" href="#final-words" title="Permalink to this headline">¶</a></h2>
	<p>Security can be a deep and complex issue to solve correctly in your application.
	  Fortunately, Symfony's security component follows a well-proven security
	  model based around <em>authentication</em> and <em>authorization</em>. Authentication,
	  which always happens first, is handled by a firewall whose job is to determine
	  the identity of the user through several different methods (e.g. HTTP authentication,
	  login form, etc). In the cookbook, you'll find examples of other methods
	  for handling authentication, including how to implement a "remember me" cookie
	  functionality.</p>
	<p>Once a user is authenticated, the authorization layer can determine whether
	  or not the user should have access to a specific resource. Most commonly,
	  <em>roles</em> are applied to URLs, classes or methods and if the current user
	  doesn't have that role, access is denied. The authorization layer, however,
	  is much deeper, and follows a system of "voting" so that multiple parties
	  can determine if the current user should have access to a given resource.
	  Find out more about this and other topics in the cookbook.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Learn more from the Cookbook<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/security/force_https.html"><em>Forcing HTTP/HTTPS</em></a></li>
	  <li><a class="reference internal" href="../cookbook/security/voters.html"><em>Blacklist users by IP address with a custom voter</em></a></li>
	  <li><a class="reference internal" href="../cookbook/security/acl.html"><em>Access Control Lists (ACLs)</em></a></li>
	  <li><a class="reference internal" href="../cookbook/security/remember_me.html"><em>How to add "Remember Me" Login Functionality</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Forms" href="forms.html">
      «&nbsp;Forms
    </a><span class="separator">|</span>
    <a accesskey="N" title="HTTP Cache" href="http_cache.html">
      HTTP Cache&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
