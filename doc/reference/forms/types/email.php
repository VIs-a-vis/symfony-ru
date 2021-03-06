<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">email Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="email-field-type">
      <span id="index-0"></span><h1>email Field Type<a class="headerlink" href="#email-field-type" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><span class="pre">email</span></tt> field is a text field that is rendered using the HTML5
	<tt class="docutils literal"><span class="pre">&lt;input</span> <span class="pre">type="email"</span> <span class="pre">/&gt;</span></tt> tag.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="16%">
	  <col width="84%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Rendered as</td>
	    <td><tt class="docutils literal"><span class="pre">input</span></tt> <tt class="docutils literal"><span class="pre">email</span></tt> field (a text box)</td>
	  </tr>
	  <tr><td>Inherited
	      Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">max_length</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">required</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">label</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">read_only</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">trim</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">error_bubbling</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><a class="reference internal" href="text.html"><em>text</em></a></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/UrlType.html" title="Symfony\Component\Form\Extension\Core\Type\UrlType"><span class="pre">UrlType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="inherited-options">
	<h2>Inherited Options<a class="headerlink" href="#inherited-options" title="Permalink to this headline">¶</a></h2>
	<p>These options inherit from the <a class="reference internal" href="field.html"><em>field</em></a> type:</p>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">max_length</span></tt> [type: integer]</dt>
	      <dd><p class="first last">This option is used to add a <tt class="docutils literal"><span class="pre">max_length</span></tt> attribute, which is used by
		  some browsers to limit the amount of text in a field.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">required</span></tt> [type: Boolean, default: true]</dt>
	      <dd><p class="first last">The <tt class="docutils literal"><span class="pre">required</span></tt> option can be used to render an <a class="reference external" href="http://diveintohtml5.org/forms.html">HTML5 required attribute</a>.
		  Note that this is independent from validation: if you include the required
		  attribute on the field type but omit any required validation, the object
		  will appear to be valid to your application with a blank value. In other
		  words, this is a <em>nice</em> feature that will add client-side validation for
		  browsers that support HTML5. It's not, however, a replacement for true
		  server-side validation.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">label</span></tt> [type: string]</dt>
	      <dd><p class="first">Sets the label that will be used when rendering the field. If blank,
		  the label will be auto-generated based on the name of the field. The label
		  can also be directly set inside the template:</p>
		<div class="last highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">render_label</span><span class="o">(</span><span class="nv">form.name</span><span class="o">,</span> <span class="s1">'Name'</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">read_only</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If this option is true, the field will be rendered with the <tt class="docutils literal"><span class="pre">disabled</span></tt>
		  attribute so that the field is not editable.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">trim</span></tt> [type: Boolean, default: true]</dt>
	      <dd><p class="first last">If true, the whitespace of the submitted string value will be stripped
		  via the <tt class="docutils literal"><span class="pre">trim()</span></tt> function when the data is bound. This guarantees that
		  if a value is submitted with extra whitespace, it will be removed before
		  the value is merged back onto the underlying object.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">error_bubbling</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If true, any errors for this field will be passed to the parent field
		  or form. For example, if set to true on a normal field, any errors for
		  that field will be attached to the main form, not to the specific field.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="datetime Field Type" href="datetime.html">
      «&nbsp;datetime Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="entity Field Type" href="entity.html">
      entity Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
