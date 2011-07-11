<?php include(__DIR__.'/../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">Валидация</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="validation">
      <span id="index-0"></span><h1>Валидация<a class="headerlink" href="#validation" title="Permalink to this headline">¶</a></h1>
      <p>Валидация очень частая задача в веб приложениях. Данные введеные в форму должны быть валидированы. Данные также должны пройти валидацию перед записью в базу данных или передачи в web-службу.</p>
      <p>Symfony2 поставляется с компонентом <a class="reference external" href="https://github.com/symfony/Validator">Validator</a>, который выполняет эту задачу легко и прозрачно.
	Этот компонент основан на спецификации <a class="reference external" href="http://jcp.org/en/jsr/detail?id=303">JSR303 Bean Validation specification</a>. Что?
	Спецификация Java в PHP? Вы не ослышались, но это не так плохо, как кажется.
	Давайте посмотрим, как это можно использовать в PHP.</p>
      <div class="section" id="the-basics-of-validation">
	<h2>Основы валидации.<a class="headerlink" href="#the-basics-of-validation" title="Permalink to this headline">¶</a></h2>
	<p>Лучший способ понять валидацию - это увидеть ее в действии. Для начала предположим, что вы создали старый-добрый PHP объект, который необходимо использовать где-нибудь в вашем приложении:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>
<span class="p">}</span>
	  </pre></div>
	</div>
	<p>Пока это всего лишь обычный класс, созданный с какой-то целью. Цель валидации в том, чтобы сообщить вам, являются ли данные объекта валидными или же нет. Чтобы это заработало, вы должны сконфигурировать список правил (называемых <a class="reference internal" href="#validation-constraints"><em>ограничениями</em></a> (constraints)) которым должен следовать объект, что бы быть валидным. Эти правила могут быть определены с помощью различных форматов (YML, XML, аннотации или PHP). Чтобы гарантировать, что свойство <tt class="docutils literal"><span class="pre">$name</span></tt> не пустое, добавьте следующее:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 148px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">name</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"name"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="nv">$name</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'name'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
    <span class="p">}</span>
<span class="p">}</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="tip"></div><div class="admonition admonition-tip"><p class="first admonition-title">Примечание</p>
	    <p class="last">Protected и private свойства также могут быть валидированы, как геттеры (см. <cite>цели-ограничения-валидатора</cite>).</p>
	</div></div>
	<div class="section" id="using-the-validator-service">
	  <span id="index-1"></span><h3>Использование <tt class="docutils literal"><span class="pre">validator</span></tt> Service<a class="headerlink" href="#using-the-validator-service" title="Permalink to this headline">¶</a></h3>
	  <p>Чтобы на самом деле проверить объект <tt class="docutils literal"><span class="pre">Author</span></tt> используется метод <tt class="docutils literal"><span class="pre">validate</span></tt> в сервисе <tt class="docutils literal"><span class="pre">validator</span></tt> (класс <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/Validator.html" title="Symfony\Component\Validator\Validator"><span class="pre">Validator</span></a></tt>).
	    Работа <tt class="docutils literal"><span class="pre">валидатора</span></tt> проста: прочесть ограничения (т.е. правила)
	    класса и проверить удовлетвореют ли данные этим правилам или нет. Если валадация не пройдена, возвращается массив ошибок. Рассмотрим этот простой пример контроллера:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">use</span> <span class="nx">Symfony\Component\HttpFoundation\Response</span><span class="p">;</span>
<span class="c1">// ...</span>

<span class="k">public</span> <span class="k">function</span> <span class="nf">indexAction</span><span class="p">()</span>
<span class="p">{</span>
    <span class="nv">$author</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Acme\BlogBundle\Author</span><span class="p">();</span>
    <span class="c1">// ... do something to the $author object</span>

    <span class="nv">$validator</span> <span class="o">=</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'validator'</span><span class="p">);</span>
    <span class="nv">$errorList</span> <span class="o">=</span> <span class="nv">$validator</span><span class="o">-&gt;</span><span class="na">validate</span><span class="p">(</span><span class="nv">$author</span><span class="p">);</span>

    <span class="k">if</span> <span class="p">(</span><span class="nb">count</span><span class="p">(</span><span class="nv">$errorList</span><span class="p">)</span> <span class="o">&gt;</span> <span class="mi">0</span><span class="p">)</span> <span class="p">{</span>
        <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="nb">print_r</span><span class="p">(</span><span class="nv">$errorList</span><span class="p">,</span> <span class="k">true</span><span class="p">));</span>
    <span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
        <span class="k">return</span> <span class="k">new</span> <span class="nx">Response</span><span class="p">(</span><span class="s1">'The author is valid! Yes!'</span><span class="p">);</span>
    <span class="p">}</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Если свойство <tt class="docutils literal"><span class="pre">$name</span></tt> пусто, вы увидите следующее сообщение об ошибке:</p>
	  <div class="highlight-text"><div class="highlight"><pre>Acme\BlogBundle\Author.name:
    This value should not be blank
	    </pre></div>
	  </div>
	  <p>Если в это свойство <tt class="docutils literal"><span class="pre">name</span></tt> вставить значение, то вернется сообщение об успехе.</p>
	  <p>Каждая ошибка валидации (называющаяся "нарушение ограничения") представлена объектом <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolation.html" title="Symfony\Component\Validator\ConstraintViolation"><span class="pre">ConstraintViolation</span></a></tt> , в котором хранится сообщение с описанием ошибки. Кроме того, метод <tt class="docutils literal"><span class="pre">validate</span></tt> возвращает объект <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html" title="Symfony\Component\Validator\ConstraintViolationList"><span class="pre">ConstraintViolationList</span></a></tt>, который действует как массив. Это было долгое объяснение того, что вы можете использовать ошибки возвращаемые <tt class="docutils literal"><span class="pre">validate</span></tt> более продвинутыми способами. Начнем с рендеринга шаблона и присвоения массива ошибок переменной <tt class="docutils literal"><span class="pre">$errorList</span></tt>:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="k">if</span> <span class="p">(</span><span class="nb">count</span><span class="p">(</span><span class="nv">$errorList</span><span class="p">)</span> <span class="o">&gt;</span> <span class="mi">0</span><span class="p">)</span> <span class="p">{</span>
    <span class="k">return</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'AcmeBlogBundle:Author:validate.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'errorList'</span> <span class="o">=&gt;</span> <span class="nv">$errorList</span><span class="p">,</span>
    <span class="p">));</span>
<span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>В шаблоне вы можете вывести ошибки так, как хотите:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 202px; ">
	      <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-html+jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c">{# src/Acme/BlogBundle/Resources/views/Author/validate.html.twig #}</span>

<span class="nt">&lt;h3&gt;</span>The author has the following errors<span class="nt">&lt;/h3&gt;</span>
<span class="nt">&lt;ul&gt;</span>
<span class="cp">{%</span> <span class="k">for</span> <span class="nv">error</span> <span class="k">in</span> <span class="nv">errorList</span> <span class="cp">%}</span>
    <span class="nt">&lt;li&gt;</span><span class="cp">{{</span> <span class="nv">error.message</span> <span class="cp">}}</span><span class="nt">&lt;/li&gt;</span>
<span class="cp">{%</span> <span class="k">endfor</span> <span class="cp">%}</span>
<span class="nt">&lt;/ul&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-html+php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- src/Acme/BlogBundle/Resources/views/Author/validate.html.php --&gt;</span>

<span class="nt">&lt;h3&gt;</span>The author has the following errors<span class="nt">&lt;/h3&gt;</span>
<span class="nt">&lt;ul&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">foreach</span> <span class="p">(</span><span class="nv">$errorList</span> <span class="k">as</span> <span class="nv">$error</span><span class="p">)</span><span class="o">:</span> <span class="cp">?&gt;</span>
    <span class="nt">&lt;li&gt;</span><span class="cp">&lt;?php</span> <span class="k">echo</span> <span class="nv">$error</span><span class="o">-&gt;</span><span class="na">getMessage</span><span class="p">()</span> <span class="cp">?&gt;</span><span class="nt">&lt;/li&gt;</span>
<span class="cp">&lt;?php</span> <span class="k">endforeach</span><span class="p">;</span> <span class="cp">?&gt;</span>
<span class="nt">&lt;/ul&gt;</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
	<div class="section" id="validation-and-forms">
	  <span id="index-2"></span><h3>Валидация и формы<a class="headerlink" href="#validation-and-forms" title="Permalink to this headline">¶</a></h3>
	  <p>Сервис <tt class="docutils literal"><span class="pre">validator</span></tt> может быть использован в любое время для проверки любого объекта.
	    Однако в действительности, вы обычно будете работать с <tt class="docutils literal"><span class="pre">валидатором</span></tt> через класс <tt class="docutils literal"><span class="pre">Form</span></tt>. Класс <tt class="docutils literal"><span class="pre">Form</span></tt> использует сервис <tt class="docutils literal"><span class="pre">validator</span></tt> внутренне для проверки объекта после того, как данные были отправлены и связаны. Нарушения ограничений объекта преобразуются в объекты <tt class="docutils literal"><span class="pre">FieldError</span></tt>, которые затем могут отображаться с вашей формой:</p>
	  <div class="highlight-php"><div class="highlight"><pre><span class="nv">$author</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Acme\BlogBundle\Author</span><span class="p">();</span>
<span class="nv">$form</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Acme\BlogBundle\AuthorForm</span><span class="p">(</span><span class="s1">'author'</span><span class="p">,</span> <span class="nv">$author</span><span class="p">,</span> <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'validator'</span><span class="p">));</span>
<span class="nv">$form</span><span class="o">-&gt;</span><span class="na">bind</span><span class="p">(</span><span class="nv">$this</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'request'</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">request</span><span class="o">-&gt;</span><span class="na">get</span><span class="p">(</span><span class="s1">'customer'</span><span class="p">));</span>

<span class="k">if</span> <span class="p">(</span><span class="nv">$form</span><span class="o">-&gt;</span><span class="na">isValid</span><span class="p">())</span> <span class="p">{</span>
    <span class="c1">// process the Author object</span>
<span class="p">}</span> <span class="k">else</span> <span class="p">{</span>
    <span class="c1">// render the template with the errors</span>
    <span class="nv">$this</span><span class="o">-&gt;</span><span class="na">render</span><span class="p">(</span><span class="s1">'BlogBundle:Author:form.html.twig'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'form'</span> <span class="o">=&gt;</span> <span class="nv">$form</span><span class="p">));</span>
<span class="p">}</span>
	    </pre></div>
	  </div>
	  <p>Для большей информации, смотрите главу <a class="reference internal" href="forms.html"><em>Forms</em></a>.</p>
	</div>
      </div>
      <div class="section" id="configuration">
	<span id="index-3"></span><h2>Конфигурация<a class="headerlink" href="#configuration" title="Permalink to this headline">¶</a></h2>
	<p>Для использования Symfony2 валидатора, убедитесь, что он включен в кофигурации вашего приложения:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 112px; ">
	    <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># app/config/config.yml</span>
<span class="l-Scalar-Plain">framework</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">validation</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">enabled</span><span class="p-Indicator">:</span> <span class="nv">true</span><span class="p-Indicator">,</span> <span class="nv">enable_annotations</span><span class="p-Indicator">:</span> <span class="nv">true</span> <span class="p-Indicator">}</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- app/config/config.xml --&gt;</span>
<span class="nt">&lt;framework:config&gt;</span>
    <span class="nt">&lt;framework:validation</span> <span class="na">enabled=</span><span class="s">"true"</span> <span class="na">enable_annotations=</span><span class="s">"true"</span> <span class="nt">/&gt;</span>
<span class="nt">&lt;/framework:config&gt;</span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// app/config/config.php</span>
<span class="nv">$container</span><span class="o">-&gt;</span><span class="na">loadFromExtension</span><span class="p">(</span><span class="s1">'framework'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span><span class="s1">'validation'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'enabled'</span>     <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
    <span class="s1">'enable_annotations'</span> <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
	<div class="admonition-wrapper">
	  <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Примечание</p>
	    <p class="last">Конфигурация <tt class="docutils literal"><span class="pre">аннотаций</span></tt> должна быть установлена в значение <tt class="docutils literal"><span class="pre">true</span></tt> , только тогда, когда вы отображаете ограничения с помощью аннотаций.</p>
	</div></div>
      </div>
      <div class="section" id="constraints">
	<span id="validation-constraints"></span><span id="index-4"></span><h2>Ограничения<a class="headerlink" href="#constraints" title="Permalink to this headline">¶</a></h2>
	<p><tt class="docutils literal"><span class="pre">Валидатор</span></tt> разработан для проверки объектов на соответствия <em>ограничениям</em> (т.е.
	  правилам). Для валидации объекта, просто представьте одно или более ограничений в своем классе, а затем передайте их сервису <tt class="docutils literal"><span class="pre">validator</span></tt>.</p>
	<p>Ограничение это просто PHP объект, которое представляется в виде жесткого заявления. В реальной жизни, ограничение может быть представлено в виде: "Пирог не должен быть подгорелым". В Symfony2 ограничения похожи: они являются утверждениями, что условие истинно. Получив значение, ограничение сообщает сообщит вам, придерживается ли значение правилам ограничений.</p>
	<div class="section" id="supported-constraints">
	  <h3>Поддерживаемые ограничения<a class="headerlink" href="#supported-constraints" title="Permalink to this headline">¶</a></h3>
	  <p>Пакеты Symfony2 содержат большое число наиболее часто необходимых ограничений.
	    Полный список ограничений с различными деталями доступен в
	    <a class="reference internal" href="../reference/constraints.html"><em>справочном разделе ограничений</em></a>.</p>
	</div>
	<div class="section" id="constraint-configuration">
	  <span id="index-5"></span><h3>Конфигурация ограничений<a class="headerlink" href="#constraint-configuration" title="Permalink to this headline">¶</a></h3>
	  <p>Некоторые ограничения, такие как <a class="reference internal" href="../reference/constraints/NotBlank.html"><em>NotBlank</em></a>просты, в то время как другие, например <a class="reference internal" href="../reference/constraints/Choice.html"><em>Choice</em></a>
	    имеют несколько вариантов конфигураций. Доступные опции являются public свойствами ограничения и каждый может быть установлен путем передачи массива опций ограничению. Предположим, что класс <tt class="docutils literal"><span class="pre">Author</span></tt> содержит другое свойство - <tt class="docutils literal"><span class="pre">пол</span></tt>, которое быть установлено в "male" или "female":</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">gender</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Choice</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">choices</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">male</span><span class="p-Indicator">,</span> <span class="nv">female</span><span class="p-Indicator">],</span> <span class="nv">message</span><span class="p-Indicator">:</span> <span class="nv">Choose a valid gender.</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"gender"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Choice"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"choices"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;value&gt;</span>male<span class="nt">&lt;/value&gt;</span>
                <span class="nt">&lt;value&gt;</span>female<span class="nt">&lt;/value&gt;</span>
            <span class="nt">&lt;/option&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"message"</span><span class="nt">&gt;</span>Choose a valid gender.<span class="nt">&lt;/option&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\Choice(</span>
<span class="sd">     *     choices = { "male", "female" },</span>
<span class="sd">     *     message = "Choose a valid gender."</span>
<span class="sd">     * )</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="nv">$gender</span><span class="p">;</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">public</span> <span class="nv">$gender</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'gender'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Choice</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
            <span class="s1">'choices'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'male'</span><span class="p">,</span> <span class="s1">'female'</span><span class="p">),</span>
            <span class="s1">'message'</span> <span class="o">=&gt;</span> <span class="s1">'Choose a valid gender.'</span><span class="p">,</span>
        <span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Опции ограничений, могут быть всегда переданы в виде массива. Некоторые ограничения также позволяют вам передать значение одной, "default" опции, вместо массива. В случае с ограничением <tt class="docutils literal"><span class="pre">Choice</span></tt>, опции могут быть заданы следующим способом.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">gender</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">Choice</span><span class="p-Indicator">:</span> <span class="p-Indicator">[</span><span class="nv">male</span><span class="p-Indicator">,</span> <span class="nv">female</span><span class="p-Indicator">]</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"gender"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"Choice"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;value&gt;</span>male<span class="nt">&lt;/value&gt;</span>
            <span class="nt">&lt;value&gt;</span>female<span class="nt">&lt;/value&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\Choice({"male", "female"})</span>
<span class="sd">     */</span>
    <span class="k">protected</span> <span class="nv">$gender</span><span class="p">;</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\Choice</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">protected</span> <span class="nv">$gender</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'gender'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">Choice</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s1">'male'</span><span class="p">,</span> <span class="s1">'female'</span><span class="p">)));</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Не допускайте, того, чтобы два различных метода указания опций сбивало вас с толку. Если вы не уверены, обратитесь к документации API для ограничений или будьте осторожны, всегда передавая массив опций (первый метод, показанный выше).</p>
	</div>
      </div>
      <div class="section" id="constraint-targets">
	<span id="validator-constraint-targets"></span><span id="index-6"></span><h2>Цели ограничений<a class="headerlink" href="#constraint-targets" title="Permalink to this headline">¶</a></h2>
	<p>Ограничения могут быть применены к свойству класса или к открытому геттер-методу (например <tt class="docutils literal"><span class="pre">getFullName</span></tt>).</p>
	<div class="section" id="properties">
	  <span id="index-7"></span><h3>Свойства<a class="headerlink" href="#properties" title="Permalink to this headline">¶</a></h3>
	  <p>Проверка свойств класса является самой основной техникой валидации. Symfony2 позволяет вам проверять private, protected или public свойства. Следующий листинг показывает вам, как конфигурировать свойства <tt class="docutils literal"><span class="pre">$firstName</span></tt> и <tt class="docutils literal"><span class="pre">$lastName</span></tt>
	    класса <tt class="docutils literal"><span class="pre">Author</span></tt>, чтобы иметь по крайней-мере 3 символа.</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 220px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">properties</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">firstName</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MinLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">3</span>
        <span class="l-Scalar-Plain">lastName</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">NotBlank</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">~</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">MinLength</span><span class="p-Indicator">:</span> <span class="l-Scalar-Plain">3</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"firstName"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"MinLength"</span><span class="nt">&gt;</span>3<span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
    <span class="nt">&lt;property</span> <span class="na">name=</span><span class="s">"lastName"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"NotBlank"</span> <span class="nt">/&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"MinLength"</span><span class="nt">&gt;</span>3<span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/property&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     * @Assert\MinLength(3)</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$firstName</span><span class="p">;</span>

    <span class="sd">/**</span>
<span class="sd">     * @Assert\NotBlank()</span>
<span class="sd">     * @Assert\MinLength(3)</span>
<span class="sd">     */</span>
    <span class="k">private</span> <span class="nv">$lastName</span><span class="p">;</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\NotBlank</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\MinLength</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="k">private</span> <span class="nv">$firstName</span><span class="p">;</span>

    <span class="k">private</span> <span class="nv">$lastName</span><span class="p">;</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'firstName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'firstName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">MinLength</span><span class="p">(</span><span class="mi">3</span><span class="p">));</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'lastName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">NotBlank</span><span class="p">());</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addPropertyConstraint</span><span class="p">(</span><span class="s1">'lastName'</span><span class="p">,</span> <span class="k">new</span> <span class="nx">MinLength</span><span class="p">(</span><span class="mi">3</span><span class="p">));</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	</div>
	<div class="section" id="getters">
	  <span id="index-8"></span><h3>Геттеры<a class="headerlink" href="#getters" title="Permalink to this headline">¶</a></h3>
	  <p>Ограничение также может применено для возвращения значения метода. Symfony2 позволяет вам добавлять ограничение public методам, котрые начинаются с "get" или "is". В этом руководстве, оба этих методов называются "геттерами".</p>
	  <p>Преимущество этой техники в том, что она позоволяет вам проверить ваш объект динамически. В зависимости от состояния вашего объекта, метод может возвращать различные значения, которые затем проверяются.</p>
	  <p>Следующий листинг показывет вам, как использовать ограничение <a class="reference internal" href="../reference/constraints/True.html"><em>True</em></a>
	    для проверки является ли динамически генерируемый токен корректным:</p>
	  <div class="configuration-block jsactive clearfix">
	    <ul class="simple" style="height: 148px; ">
	      <li class="selected"><em><a href="#">YAML</a></em><div class="highlight-yaml" style="width: 690px; display: block; "><div class="highlight"><pre><span class="c1"># Acme/BlogBundle/Resources/config/validation.yml</span>
<span class="l-Scalar-Plain">Acme\BlogBundle\Author</span><span class="p-Indicator">:</span>
    <span class="l-Scalar-Plain">getters</span><span class="p-Indicator">:</span>
        <span class="l-Scalar-Plain">tokenValid</span><span class="p-Indicator">:</span>
            <span class="p-Indicator">-</span> <span class="l-Scalar-Plain">True</span><span class="p-Indicator">:</span> <span class="p-Indicator">{</span> <span class="nv">message</span><span class="p-Indicator">:</span> <span class="s">"The</span><span class="nv"> </span><span class="s">token</span><span class="nv"> </span><span class="s">is</span><span class="nv"> </span><span class="s">invalid"</span> <span class="p-Indicator">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">XML</a></em><div class="highlight-xml" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c">&lt;!-- Acme/BlogBundle/Resources/config/validation.xml --&gt;</span>
<span class="nt">&lt;class</span> <span class="na">name=</span><span class="s">"Acme\BlogBundle\Author"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;getter</span> <span class="na">property=</span><span class="s">"tokenValid"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;constraint</span> <span class="na">name=</span><span class="s">"True"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;option</span> <span class="na">name=</span><span class="s">"message"</span><span class="nt">&gt;</span>The token is invalid<span class="nt">&lt;/option&gt;</span>
        <span class="nt">&lt;/constraint&gt;</span>
    <span class="nt">&lt;/getter&gt;</span>
<span class="nt">&lt;/class&gt;</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">Annotations</a></em><div class="highlight-php-annotations" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints</span> <span class="k">as</span> <span class="nx">Assert</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>
    <span class="sd">/**</span>
<span class="sd">     * @Assert\True(message = "The token is invalid")</span>
<span class="sd">     */</span>
    <span class="k">public</span> <span class="k">function</span> <span class="nf">isTokenValid</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// return true or false</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	      <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="c1">// Acme/BlogBundle/Author.php</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Mapping\ClassMetadata</span><span class="p">;</span>
<span class="k">use</span> <span class="nx">Symfony\Component\Validator\Constraints\True</span><span class="p">;</span>

<span class="k">class</span> <span class="nc">Author</span>
<span class="p">{</span>

    <span class="k">public</span> <span class="k">static</span> <span class="k">function</span> <span class="nf">loadValidatorMetadata</span><span class="p">(</span><span class="nx">ClassMetadata</span> <span class="nv">$metadata</span><span class="p">)</span>
    <span class="p">{</span>
        <span class="nv">$metadata</span><span class="o">-&gt;</span><span class="na">addGetterConstraint</span><span class="p">(</span><span class="s1">'tokenValid'</span><span class="p">,</span> <span class="k">new</span> <span class="k">True</span><span class="p">(</span><span class="k">array</span><span class="p">(</span>
            <span class="s1">'message'</span> <span class="o">=&gt;</span> <span class="s1">'The token is invalid'</span><span class="p">,</span>
        <span class="p">)));</span>
    <span class="p">}</span>

    <span class="k">public</span> <span class="k">function</span> <span class="nf">isTokenValid</span><span class="p">()</span>
    <span class="p">{</span>
        <span class="c1">// return true or false</span>
    <span class="p">}</span>
<span class="p">}</span>
		  </pre></div>
		</div>
	      </li>
	    </ul>
	  </div>
	  <p>Public метод <tt class="docutils literal"><span class="pre">isTokenValid</span></tt> будет выполнять любую логику для определения, валиден ли внутренний токен и затем вернет <tt class="docutils literal"><span class="pre">true</span></tt> или <tt class="docutils literal"><span class="pre">false</span></tt>.</p>
	  <div class="admonition-wrapper">
	    <div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Примечание</p>
	      <p class="last">Внимательные из вас заметят, что префикс геттера ("get" или "is") опущен в отображении (mapping). Это позволяет вам перемещать ограничение свойства с тем же именем позже (или наоборот) без изменения логики валидации.</p>
	  </div></div>
	</div>
      </div>
      <div class="section" id="final-thoughts">
	<h2>Заключительные мысли<a class="headerlink" href="#final-thoughts" title="Permalink to this headline">¶</a></h2>
	<p>Symfony2 <tt class="docutils literal"><span class="pre">валидатор</span></tt> мощный инструмент, который может быть использован для гарантирования, что данные любого объекта валидны. Мощь валидации заключается в "ограничениях", представляющие собой правила, которые вы можете применить к свойствам или геттер-методам вашего объекта. И пока вы будете использовать фреймворк валидации вместе с формами, помните, что он может быть использован в любом месте для проверки любого объекта.</p>
      </div>
      <div class="section" id="learn-more-from-the-cookbook">
	<h2>Узнайте больше из книги рецептов<a class="headerlink" href="#learn-more-from-the-cookbook" title="Permalink to this headline">¶</a></h2>
	<ul class="simple">
	  <li><a class="reference internal" href="../cookbook/validation/custom_constraint.html"><em>How to create a Custom Validation Constraint</em></a></li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="Testing" href="testing.html">
      «&nbsp;Testing
    </a><span class="separator">|</span>
    <a accesskey="N" title="Forms" href="forms.html">
      Forms&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
