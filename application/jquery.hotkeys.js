


<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <title>jquery.hotkeys.js at master from jeresig/jquery.hotkeys - GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />

    
    

    <meta content="authenticity_token" name="csrf-param" />
<meta content="6b1299a976f23168450206381d5ad13e7573b9e7" name="csrf-token" />

    <link href="https://a248.e.akamai.net/assets.github.com/stylesheets/bundle_github.css?b4b7d3dfc591909dc4259677aecf00c2b4bdd58c" media="screen" rel="stylesheet" type="text/css" />
    

    <script src="https://a248.e.akamai.net/assets.github.com/javascripts/bundle_jquery.js?1cda878e9113acce74087d5ff1a5e1c49fb94eeb" type="text/javascript"></script>
    <script src="https://a248.e.akamai.net/assets.github.com/javascripts/bundle_github.js?f85340baf697600405a21c9b45ac1a314f3ece97" type="text/javascript"></script>
    

      <link rel='permalink' href='/jeresig/jquery.hotkeys/blob/0451de18d57d3401bd4cc021facbe5fd63b5aae6/jquery.hotkeys.js'>
    

    <meta name="description" content="jquery.hotkeys - jQuery Hotkeys lets you watch for keyboard events anywhere in your code supporting almost any key combination." />
  <link href="https://github.com/jeresig/jquery.hotkeys/commits/master.atom" rel="alternate" title="Recent Commits to jquery.hotkeys:master" type="application/atom+xml" />

  </head>


  <body class="logged_out page-blob windows env-production ">
    


    

    <div id="main">
      <div id="header" class="true">
          <a class="logo" href="https://github.com">
            <img alt="github" class="default svg" height="45" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov6.svg" />
            <img alt="github" class="default png" height="45" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov6.png" />
            <!--[if (gt IE 8)|!(IE)]><!-->
            <img alt="github" class="hover svg" height="45" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov6-hover.svg" />
            <img alt="github" class="hover png" height="45" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov6-hover.png" />
            <!--<![endif]-->
          </a>

        <div class="topsearch">
    <!--
      make sure to use fully qualified URLs here since this nav
      is used on error pages on other domains
    -->
    <ul class="nav logged_out">
        <li class="pricing"><a href="https://github.com/plans">Signup and Pricing</a></li>
        <li class="explore"><a href="https://github.com/explore">Explore GitHub</a></li>
      <li class="features"><a href="https://github.com/features">Features</a></li>
        <li class="blog"><a href="https://github.com/blog">Blog</a></li>
      <li class="login"><a href="https://github.com/login?return_to=%2Fjeresig%2Fjquery.hotkeys%2Fblob%2Fmaster%2Fjquery.hotkeys.js">Login</a></li>
    </ul>
</div>

      </div>

      
            <div class="site">
      <div class="pagehead repohead vis-public fork  instapaper_ignore readability-menu">


      <div class="title-actions-bar">
        <h1>
          <a href="/jeresig">jeresig</a> /
          <strong><a href="/jeresig/jquery.hotkeys" class="js-current-repository">jquery.hotkeys</a></strong>
            <span class="fork-flag">
              <span class="text">forked from <a href="/tzuryby/jquery.hotkeys">tzuryby/jquery.hotkeys</a></span>
            </span>
        </h1>
        



            <ul class="pagehead-actions">

        <li>
            <a href="/jeresig/jquery.hotkeys/toggle_watch" class="minibutton btn-watch watch-button" data-method="post"><span><span class="icon"></span>Watch</span></a>
        </li>
            <li><a href="/jeresig/jquery.hotkeys/fork" class="minibutton btn-fork fork-button" data-method="post"><span><span class="icon"></span>Fork</span></a></li>

      <li class="repostats">
        <ul class="repo-stats">
          <li class="watchers ">
            <a href="/jeresig/jquery.hotkeys/watchers" title="Watchers" class="tooltipped downwards">
              638
            </a>
          </li>
          <li class="forks">
            <a href="/jeresig/jquery.hotkeys/network" title="Forks" class="tooltipped downwards">
              81
            </a>
          </li>
        </ul>
      </li>
    </ul>

      </div>

        

  <ul class="tabs">
    <li><a href="/jeresig/jquery.hotkeys" class="selected" highlight="repo_sourcerepo_downloadsrepo_commitsrepo_tagsrepo_branches">Code</a></li>
    <li><a href="/jeresig/jquery.hotkeys/network" highlight="repo_networkrepo_fork_queue">Network</a>
    <li><a href="/jeresig/jquery.hotkeys/pulls" highlight="repo_pulls">Pull Requests <span class='counter'>7</span></a></li>



    <li><a href="/jeresig/jquery.hotkeys/graphs" highlight="repo_graphsrepo_contributors">Stats &amp; Graphs</a></li>

  </ul>

  
<div class="frame frame-center tree-finder" style="display:none"
      data-tree-list-url="/jeresig/jquery.hotkeys/tree-list/0451de18d57d3401bd4cc021facbe5fd63b5aae6"
      data-blob-url-prefix="/jeresig/jquery.hotkeys/blob/0451de18d57d3401bd4cc021facbe5fd63b5aae6"
    >

  <div class="breadcrumb">
    <b><a href="/jeresig/jquery.hotkeys">jquery.hotkeys</a></b> /
    <input class="tree-finder-input" type="text" name="query" autocomplete="off" spellcheck="false">
  </div>

    <div class="octotip">
      <p>
        <a href="/jeresig/jquery.hotkeys/dismiss-tree-finder-help" class="dismiss js-dismiss-tree-list-help" title="Hide this notice forever">Dismiss</a>
        <strong>Octotip:</strong> You've activated the <em>file finder</em>
        by pressing <span class="kbd">t</span> Start typing to filter the
        file list. Use <span class="kbd badmono">↑</span> and
        <span class="kbd badmono">↓</span> to navigate,
        <span class="kbd">enter</span> to view files.
      </p>
    </div>

  <table class="tree-browser" cellpadding="0" cellspacing="0">
    <tr class="js-header"><th>&nbsp;</th><th>name</th></tr>
    <tr class="js-no-results no-results" style="display: none">
      <th colspan="2">No matching files</th>
    </tr>
    <tbody class="js-results-list">
    </tbody>
  </table>
</div>

<div id="jump-to-line" style="display:none">
  <h2>Jump to Line</h2>
  <form>
    <input class="textfield" type="text">
    <div class="full-button">
      <button type="submit" class="classy">
        <span>Go</span>
      </button>
    </div>
  </form>
</div>


<div class="subnav-bar">

  <ul class="actions">
    
      <li class="switcher">

        <div class="context-menu-container js-menu-container">
          <span class="text">Current branch:</span>
          <a href="#"
             class="minibutton bigger switcher context-menu-button js-menu-target js-commitish-button btn-branch repo-tree"
             data-master-branch="master"
             data-ref="master">
            <span><span class="icon"></span>master</span>
          </a>

          <div class="context-pane commitish-context js-menu-content">
            <a href="javascript:;" class="close js-menu-close"></a>
            <div class="title">Switch Branches/Tags</div>
            <div class="body pane-selector commitish-selector js-filterable-commitishes">
              <div class="filterbar">
                <div class="placeholder-field js-placeholder-field">
                  <label class="placeholder" for="context-commitish-filter-field" data-placeholder-mode="sticky">Filter branches/tags</label>
                  <input type="text" id="context-commitish-filter-field" class="commitish-filter" />
                </div>

                <ul class="tabs">
                  <li><a href="#" data-filter="branches" class="selected">Branches</a></li>
                  <li><a href="#" data-filter="tags">Tags</a></li>
                </ul>
              </div>

                <div class="commitish-item branch-commitish selector-item">
                  <h4>
                      <a href="/jeresig/jquery.hotkeys/blob/master/jquery.hotkeys.js" data-name="master">master</a>
                  </h4>
                </div>


              <div class="no-results" style="display:none">Nothing to show</div>
            </div>
          </div><!-- /.commitish-context-context -->
        </div>

      </li>
  </ul>

  <ul class="subnav">
    <li><a href="/jeresig/jquery.hotkeys" class="selected" highlight="repo_source">Files</a></li>
    <li><a href="/jeresig/jquery.hotkeys/commits/master" highlight="repo_commits">Commits</a></li>
    <li><a href="/jeresig/jquery.hotkeys/branches" class="" highlight="repo_branches">Branches <span class="counter">1</span></a></li>
    <li><a href="/jeresig/jquery.hotkeys/tags" class="blank" highlight="repo_tags">Tags <span class="counter">0</span></a></li>
    <li><a href="/jeresig/jquery.hotkeys/downloads" class="blank" highlight="repo_downloads">Downloads <span class="counter">0</span></a></li>
  </ul>

</div>

  
  
  


        

      </div><!-- /.pagehead -->

      




  
  <p class="last-commit">Latest commit to the <strong>master</strong> branch</p>

<div class="commit commit-tease js-details-container">
    <a href="/jeresig/jquery.hotkeys/commit/0451de18d57d3401bd4cc021facbe5fd63b5aae6" anchor="comments" class="comment-count">8 comments</a>
  <p class="commit-title ">
      <a href="/jeresig/jquery.hotkeys"><a href="/jeresig/jquery.hotkeys/commit/0451de18d57d3401bd4cc021facbe5fd63b5aae6" class="message">jQuery Hotkeys rewritten to work with jQuery 1.4.2. A bunch of old code ...</a></a>
      <a href="javascript:;" class="minibutton expander-minibutton js-details-target"><span>…</span></a>
  </p>
    <div class="commit-desc"><pre>...stripped and bugs fixed.</pre></div>
  <div class="commit-meta">
    <a href="/jeresig/jquery.hotkeys/commit/0451de18d57d3401bd4cc021facbe5fd63b5aae6" class="sha-block">commit <span class="sha">0451de18d5</span></a>

    <div class="authorship">
      <img class="gravatar" height="20" src="https://secure.gravatar.com/avatar/b3e04a46e85ad3e165d66f5d927eb609?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png" width="20" />
      <span class="author-name"><a href="/jeresig">jeresig</a></span>
      authored <time class="js-relative-date" datetime="2010-02-22T23:07:02-08:00" title="2010-02-22 23:07:02">February 22, 2010</time>

    </div>
  </div>
</div>


  <div id="slider">

    <div class="breadcrumb" data-path="jquery.hotkeys.js/">
      <b><a href="/jeresig/jquery.hotkeys/tree/0451de18d57d3401bd4cc021facbe5fd63b5aae6" class="js-rewrite-sha">jquery.hotkeys</a></b> / jquery.hotkeys.js       <span style="display:none" id="clippy_192" class="clippy-text">jquery.hotkeys.js</span>
      
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
              width="110"
              height="14"
              class="clippy"
              id="clippy" >
      <param name="movie" value="https://a248.e.akamai.net/assets.github.com/flash/clippy.swf?v5"/>
      <param name="allowScriptAccess" value="always" />
      <param name="quality" value="high" />
      <param name="scale" value="noscale" />
      <param NAME="FlashVars" value="id=clippy_192&amp;copied=copied!&amp;copyto=copy to clipboard">
      <param name="bgcolor" value="#FFFFFF">
      <param name="wmode" value="opaque">
      <embed src="https://a248.e.akamai.net/assets.github.com/flash/clippy.swf?v5"
             width="110"
             height="14"
             name="clippy"
             quality="high"
             allowScriptAccess="always"
             type="application/x-shockwave-flash"
             pluginspage="http://www.macromedia.com/go/getflashplayer"
             FlashVars="id=clippy_192&amp;copied=copied!&amp;copyto=copy to clipboard"
             bgcolor="#FFFFFF"
             wmode="opaque"
      />
      </object>
      

    </div>

    <div class="frames">
      <div class="frame frame-center" data-path="jquery.hotkeys.js/" data-permalink-url="/jeresig/jquery.hotkeys/blob/0451de18d57d3401bd4cc021facbe5fd63b5aae6/jquery.hotkeys.js" data-title="jquery.hotkeys.js at 0451de18d57d3401bd4cc021facbe5fd63b5aae6 from jeresig/jquery.hotkeys - GitHub" data-type="blob">
          <ul class="big-actions">
            <li><a class="file-edit-link minibutton js-rewrite-sha" href="/jeresig/jquery.hotkeys/edit/0451de18d57d3401bd4cc021facbe5fd63b5aae6/jquery.hotkeys.js" data-method="post"><span>Edit this file</span></a></li>
          </ul>

        <div id="files">
          <div class="file">
            <div class="meta">
              <div class="info">
                <span class="icon"><img alt="Txt" height="16" src="https://a248.e.akamai.net/assets.github.com/images/icons/txt.png" width="16" /></span>
                <span class="mode" title="File Mode">100644</span>
                  <span>99 lines (81 sloc)</span>
                <span>3.08 kb</span>
              </div>
              <ul class="actions">
                <li><a href="/jeresig/jquery.hotkeys/raw/0451de18d57d3401bd4cc021facbe5fd63b5aae6/jquery.hotkeys.js" id="raw-url">raw</a></li>
                  <li><a href="/jeresig/jquery.hotkeys/blame/0451de18d57d3401bd4cc021facbe5fd63b5aae6/jquery.hotkeys.js">blame</a></li>
                <li><a href="/jeresig/jquery.hotkeys/commits/0451de18d57d3401bd4cc021facbe5fd63b5aae6/jquery.hotkeys.js">history</a></li>
              </ul>
            </div>
              <div class="data type-javascript">
      <table cellpadding="0" cellspacing="0" class="lines">
        <tr>
          <td>
            <pre class="line_numbers"><span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
<span id="L29" rel="#L29">29</span>
<span id="L30" rel="#L30">30</span>
<span id="L31" rel="#L31">31</span>
<span id="L32" rel="#L32">32</span>
<span id="L33" rel="#L33">33</span>
<span id="L34" rel="#L34">34</span>
<span id="L35" rel="#L35">35</span>
<span id="L36" rel="#L36">36</span>
<span id="L37" rel="#L37">37</span>
<span id="L38" rel="#L38">38</span>
<span id="L39" rel="#L39">39</span>
<span id="L40" rel="#L40">40</span>
<span id="L41" rel="#L41">41</span>
<span id="L42" rel="#L42">42</span>
<span id="L43" rel="#L43">43</span>
<span id="L44" rel="#L44">44</span>
<span id="L45" rel="#L45">45</span>
<span id="L46" rel="#L46">46</span>
<span id="L47" rel="#L47">47</span>
<span id="L48" rel="#L48">48</span>
<span id="L49" rel="#L49">49</span>
<span id="L50" rel="#L50">50</span>
<span id="L51" rel="#L51">51</span>
<span id="L52" rel="#L52">52</span>
<span id="L53" rel="#L53">53</span>
<span id="L54" rel="#L54">54</span>
<span id="L55" rel="#L55">55</span>
<span id="L56" rel="#L56">56</span>
<span id="L57" rel="#L57">57</span>
<span id="L58" rel="#L58">58</span>
<span id="L59" rel="#L59">59</span>
<span id="L60" rel="#L60">60</span>
<span id="L61" rel="#L61">61</span>
<span id="L62" rel="#L62">62</span>
<span id="L63" rel="#L63">63</span>
<span id="L64" rel="#L64">64</span>
<span id="L65" rel="#L65">65</span>
<span id="L66" rel="#L66">66</span>
<span id="L67" rel="#L67">67</span>
<span id="L68" rel="#L68">68</span>
<span id="L69" rel="#L69">69</span>
<span id="L70" rel="#L70">70</span>
<span id="L71" rel="#L71">71</span>
<span id="L72" rel="#L72">72</span>
<span id="L73" rel="#L73">73</span>
<span id="L74" rel="#L74">74</span>
<span id="L75" rel="#L75">75</span>
<span id="L76" rel="#L76">76</span>
<span id="L77" rel="#L77">77</span>
<span id="L78" rel="#L78">78</span>
<span id="L79" rel="#L79">79</span>
<span id="L80" rel="#L80">80</span>
<span id="L81" rel="#L81">81</span>
<span id="L82" rel="#L82">82</span>
<span id="L83" rel="#L83">83</span>
<span id="L84" rel="#L84">84</span>
<span id="L85" rel="#L85">85</span>
<span id="L86" rel="#L86">86</span>
<span id="L87" rel="#L87">87</span>
<span id="L88" rel="#L88">88</span>
<span id="L89" rel="#L89">89</span>
<span id="L90" rel="#L90">90</span>
<span id="L91" rel="#L91">91</span>
<span id="L92" rel="#L92">92</span>
<span id="L93" rel="#L93">93</span>
<span id="L94" rel="#L94">94</span>
<span id="L95" rel="#L95">95</span>
<span id="L96" rel="#L96">96</span>
<span id="L97" rel="#L97">97</span>
<span id="L98" rel="#L98">98</span>
<span id="L99" rel="#L99">99</span>
</pre>
          </td>
          <td width="100%">
                <div class="highlight"><pre><div class='line' id='LC1'><span class="cm">/*</span></div><div class='line' id='LC2'><span class="cm"> * jQuery Hotkeys Plugin</span></div><div class='line' id='LC3'><span class="cm"> * Copyright 2010, John Resig</span></div><div class='line' id='LC4'><span class="cm"> * Dual licensed under the MIT or GPL Version 2 licenses.</span></div><div class='line' id='LC5'><span class="cm"> *</span></div><div class='line' id='LC6'><span class="cm"> * Based upon the plugin by Tzury Bar Yochay:</span></div><div class='line' id='LC7'><span class="cm"> * http://github.com/tzuryby/hotkeys</span></div><div class='line' id='LC8'><span class="cm"> *</span></div><div class='line' id='LC9'><span class="cm"> * Original idea by:</span></div><div class='line' id='LC10'><span class="cm"> * Binny V A, http://www.openjs.com/scripts/events/keyboard_shortcuts/</span></div><div class='line' id='LC11'><span class="cm">*/</span></div><div class='line' id='LC12'><br/></div><div class='line' id='LC13'><span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">jQuery</span><span class="p">){</span></div><div class='line' id='LC14'><br/></div><div class='line' id='LC15'>	<span class="nx">jQuery</span><span class="p">.</span><span class="nx">hotkeys</span> <span class="o">=</span> <span class="p">{</span></div><div class='line' id='LC16'>		<span class="nx">version</span><span class="o">:</span> <span class="s2">&quot;0.8&quot;</span><span class="p">,</span></div><div class='line' id='LC17'><br/></div><div class='line' id='LC18'>		<span class="nx">specialKeys</span><span class="o">:</span> <span class="p">{</span></div><div class='line' id='LC19'>			<span class="mi">8</span><span class="o">:</span> <span class="s2">&quot;backspace&quot;</span><span class="p">,</span> <span class="mi">9</span><span class="o">:</span> <span class="s2">&quot;tab&quot;</span><span class="p">,</span> <span class="mi">13</span><span class="o">:</span> <span class="s2">&quot;return&quot;</span><span class="p">,</span> <span class="mi">16</span><span class="o">:</span> <span class="s2">&quot;shift&quot;</span><span class="p">,</span> <span class="mi">17</span><span class="o">:</span> <span class="s2">&quot;ctrl&quot;</span><span class="p">,</span> <span class="mi">18</span><span class="o">:</span> <span class="s2">&quot;alt&quot;</span><span class="p">,</span> <span class="mi">19</span><span class="o">:</span> <span class="s2">&quot;pause&quot;</span><span class="p">,</span></div><div class='line' id='LC20'>			<span class="mi">20</span><span class="o">:</span> <span class="s2">&quot;capslock&quot;</span><span class="p">,</span> <span class="mi">27</span><span class="o">:</span> <span class="s2">&quot;esc&quot;</span><span class="p">,</span> <span class="mi">32</span><span class="o">:</span> <span class="s2">&quot;space&quot;</span><span class="p">,</span> <span class="mi">33</span><span class="o">:</span> <span class="s2">&quot;pageup&quot;</span><span class="p">,</span> <span class="mi">34</span><span class="o">:</span> <span class="s2">&quot;pagedown&quot;</span><span class="p">,</span> <span class="mi">35</span><span class="o">:</span> <span class="s2">&quot;end&quot;</span><span class="p">,</span> <span class="mi">36</span><span class="o">:</span> <span class="s2">&quot;home&quot;</span><span class="p">,</span></div><div class='line' id='LC21'>			<span class="mi">37</span><span class="o">:</span> <span class="s2">&quot;left&quot;</span><span class="p">,</span> <span class="mi">38</span><span class="o">:</span> <span class="s2">&quot;up&quot;</span><span class="p">,</span> <span class="mi">39</span><span class="o">:</span> <span class="s2">&quot;right&quot;</span><span class="p">,</span> <span class="mi">40</span><span class="o">:</span> <span class="s2">&quot;down&quot;</span><span class="p">,</span> <span class="mi">45</span><span class="o">:</span> <span class="s2">&quot;insert&quot;</span><span class="p">,</span> <span class="mi">46</span><span class="o">:</span> <span class="s2">&quot;del&quot;</span><span class="p">,</span> </div><div class='line' id='LC22'>			<span class="mi">96</span><span class="o">:</span> <span class="s2">&quot;0&quot;</span><span class="p">,</span> <span class="mi">97</span><span class="o">:</span> <span class="s2">&quot;1&quot;</span><span class="p">,</span> <span class="mi">98</span><span class="o">:</span> <span class="s2">&quot;2&quot;</span><span class="p">,</span> <span class="mi">99</span><span class="o">:</span> <span class="s2">&quot;3&quot;</span><span class="p">,</span> <span class="mi">100</span><span class="o">:</span> <span class="s2">&quot;4&quot;</span><span class="p">,</span> <span class="mi">101</span><span class="o">:</span> <span class="s2">&quot;5&quot;</span><span class="p">,</span> <span class="mi">102</span><span class="o">:</span> <span class="s2">&quot;6&quot;</span><span class="p">,</span> <span class="mi">103</span><span class="o">:</span> <span class="s2">&quot;7&quot;</span><span class="p">,</span></div><div class='line' id='LC23'>			<span class="mi">104</span><span class="o">:</span> <span class="s2">&quot;8&quot;</span><span class="p">,</span> <span class="mi">105</span><span class="o">:</span> <span class="s2">&quot;9&quot;</span><span class="p">,</span> <span class="mi">106</span><span class="o">:</span> <span class="s2">&quot;*&quot;</span><span class="p">,</span> <span class="mi">107</span><span class="o">:</span> <span class="s2">&quot;+&quot;</span><span class="p">,</span> <span class="mi">109</span><span class="o">:</span> <span class="s2">&quot;-&quot;</span><span class="p">,</span> <span class="mi">110</span><span class="o">:</span> <span class="s2">&quot;.&quot;</span><span class="p">,</span> <span class="mi">111</span> <span class="o">:</span> <span class="s2">&quot;/&quot;</span><span class="p">,</span> </div><div class='line' id='LC24'>			<span class="mi">112</span><span class="o">:</span> <span class="s2">&quot;f1&quot;</span><span class="p">,</span> <span class="mi">113</span><span class="o">:</span> <span class="s2">&quot;f2&quot;</span><span class="p">,</span> <span class="mi">114</span><span class="o">:</span> <span class="s2">&quot;f3&quot;</span><span class="p">,</span> <span class="mi">115</span><span class="o">:</span> <span class="s2">&quot;f4&quot;</span><span class="p">,</span> <span class="mi">116</span><span class="o">:</span> <span class="s2">&quot;f5&quot;</span><span class="p">,</span> <span class="mi">117</span><span class="o">:</span> <span class="s2">&quot;f6&quot;</span><span class="p">,</span> <span class="mi">118</span><span class="o">:</span> <span class="s2">&quot;f7&quot;</span><span class="p">,</span> <span class="mi">119</span><span class="o">:</span> <span class="s2">&quot;f8&quot;</span><span class="p">,</span> </div><div class='line' id='LC25'>			<span class="mi">120</span><span class="o">:</span> <span class="s2">&quot;f9&quot;</span><span class="p">,</span> <span class="mi">121</span><span class="o">:</span> <span class="s2">&quot;f10&quot;</span><span class="p">,</span> <span class="mi">122</span><span class="o">:</span> <span class="s2">&quot;f11&quot;</span><span class="p">,</span> <span class="mi">123</span><span class="o">:</span> <span class="s2">&quot;f12&quot;</span><span class="p">,</span> <span class="mi">144</span><span class="o">:</span> <span class="s2">&quot;numlock&quot;</span><span class="p">,</span> <span class="mi">145</span><span class="o">:</span> <span class="s2">&quot;scroll&quot;</span><span class="p">,</span> <span class="mi">191</span><span class="o">:</span> <span class="s2">&quot;/&quot;</span><span class="p">,</span> <span class="mi">224</span><span class="o">:</span> <span class="s2">&quot;meta&quot;</span></div><div class='line' id='LC26'>		<span class="p">},</span></div><div class='line' id='LC27'><br/></div><div class='line' id='LC28'>		<span class="nx">shiftNums</span><span class="o">:</span> <span class="p">{</span></div><div class='line' id='LC29'>			<span class="s2">&quot;`&quot;</span><span class="o">:</span> <span class="s2">&quot;~&quot;</span><span class="p">,</span> <span class="s2">&quot;1&quot;</span><span class="o">:</span> <span class="s2">&quot;!&quot;</span><span class="p">,</span> <span class="s2">&quot;2&quot;</span><span class="o">:</span> <span class="s2">&quot;@&quot;</span><span class="p">,</span> <span class="s2">&quot;3&quot;</span><span class="o">:</span> <span class="s2">&quot;#&quot;</span><span class="p">,</span> <span class="s2">&quot;4&quot;</span><span class="o">:</span> <span class="s2">&quot;$&quot;</span><span class="p">,</span> <span class="s2">&quot;5&quot;</span><span class="o">:</span> <span class="s2">&quot;%&quot;</span><span class="p">,</span> <span class="s2">&quot;6&quot;</span><span class="o">:</span> <span class="s2">&quot;^&quot;</span><span class="p">,</span> <span class="s2">&quot;7&quot;</span><span class="o">:</span> <span class="s2">&quot;&amp;&quot;</span><span class="p">,</span> </div><div class='line' id='LC30'>			<span class="s2">&quot;8&quot;</span><span class="o">:</span> <span class="s2">&quot;*&quot;</span><span class="p">,</span> <span class="s2">&quot;9&quot;</span><span class="o">:</span> <span class="s2">&quot;(&quot;</span><span class="p">,</span> <span class="s2">&quot;0&quot;</span><span class="o">:</span> <span class="s2">&quot;)&quot;</span><span class="p">,</span> <span class="s2">&quot;-&quot;</span><span class="o">:</span> <span class="s2">&quot;_&quot;</span><span class="p">,</span> <span class="s2">&quot;=&quot;</span><span class="o">:</span> <span class="s2">&quot;+&quot;</span><span class="p">,</span> <span class="s2">&quot;;&quot;</span><span class="o">:</span> <span class="s2">&quot;: &quot;</span><span class="p">,</span> <span class="s2">&quot;&#39;&quot;</span><span class="o">:</span> <span class="s2">&quot;\&quot;&quot;</span><span class="p">,</span> <span class="s2">&quot;,&quot;</span><span class="o">:</span> <span class="s2">&quot;&lt;&quot;</span><span class="p">,</span> </div><div class='line' id='LC31'>			<span class="s2">&quot;.&quot;</span><span class="o">:</span> <span class="s2">&quot;&gt;&quot;</span><span class="p">,</span>  <span class="s2">&quot;/&quot;</span><span class="o">:</span> <span class="s2">&quot;?&quot;</span><span class="p">,</span>  <span class="s2">&quot;\\&quot;</span><span class="o">:</span> <span class="s2">&quot;|&quot;</span></div><div class='line' id='LC32'>		<span class="p">}</span></div><div class='line' id='LC33'>	<span class="p">};</span></div><div class='line' id='LC34'><br/></div><div class='line' id='LC35'>	<span class="kd">function</span> <span class="nx">keyHandler</span><span class="p">(</span> <span class="nx">handleObj</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC36'>		<span class="c1">// Only care when a possible input has been specified</span></div><div class='line' id='LC37'>		<span class="k">if</span> <span class="p">(</span> <span class="k">typeof</span> <span class="nx">handleObj</span><span class="p">.</span><span class="nx">data</span> <span class="o">!==</span> <span class="s2">&quot;string&quot;</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC38'>			<span class="k">return</span><span class="p">;</span></div><div class='line' id='LC39'>		<span class="p">}</span></div><div class='line' id='LC40'><br/></div><div class='line' id='LC41'>		<span class="kd">var</span> <span class="nx">origHandler</span> <span class="o">=</span> <span class="nx">handleObj</span><span class="p">.</span><span class="nx">handler</span><span class="p">,</span></div><div class='line' id='LC42'>			<span class="nx">keys</span> <span class="o">=</span> <span class="nx">handleObj</span><span class="p">.</span><span class="nx">data</span><span class="p">.</span><span class="nx">toLowerCase</span><span class="p">().</span><span class="nx">split</span><span class="p">(</span><span class="s2">&quot; &quot;</span><span class="p">);</span></div><div class='line' id='LC43'><br/></div><div class='line' id='LC44'>		<span class="nx">handleObj</span><span class="p">.</span><span class="nx">handler</span> <span class="o">=</span> <span class="kd">function</span><span class="p">(</span> <span class="nx">event</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC45'>			<span class="c1">// Don&#39;t fire in text-accepting inputs that we didn&#39;t directly bind to</span></div><div class='line' id='LC46'>			<span class="k">if</span> <span class="p">(</span> <span class="k">this</span> <span class="o">!==</span> <span class="nx">event</span><span class="p">.</span><span class="nx">target</span> <span class="o">&amp;&amp;</span> <span class="p">(</span><span class="sr">/textarea|select/i</span><span class="p">.</span><span class="nx">test</span><span class="p">(</span> <span class="nx">event</span><span class="p">.</span><span class="nx">target</span><span class="p">.</span><span class="nx">nodeName</span> <span class="p">)</span> <span class="o">||</span></div><div class='line' id='LC47'>				 <span class="nx">event</span><span class="p">.</span><span class="nx">target</span><span class="p">.</span><span class="nx">type</span> <span class="o">===</span> <span class="s2">&quot;text&quot;</span><span class="p">)</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC48'>				<span class="k">return</span><span class="p">;</span></div><div class='line' id='LC49'>			<span class="p">}</span></div><div class='line' id='LC50'><br/></div><div class='line' id='LC51'>			<span class="c1">// Keypress represents characters, not special keys</span></div><div class='line' id='LC52'>			<span class="kd">var</span> <span class="nx">special</span> <span class="o">=</span> <span class="nx">event</span><span class="p">.</span><span class="nx">type</span> <span class="o">!==</span> <span class="s2">&quot;keypress&quot;</span> <span class="o">&amp;&amp;</span> <span class="nx">jQuery</span><span class="p">.</span><span class="nx">hotkeys</span><span class="p">.</span><span class="nx">specialKeys</span><span class="p">[</span> <span class="nx">event</span><span class="p">.</span><span class="nx">which</span> <span class="p">],</span></div><div class='line' id='LC53'>				<span class="nx">character</span> <span class="o">=</span> <span class="nb">String</span><span class="p">.</span><span class="nx">fromCharCode</span><span class="p">(</span> <span class="nx">event</span><span class="p">.</span><span class="nx">which</span> <span class="p">).</span><span class="nx">toLowerCase</span><span class="p">(),</span></div><div class='line' id='LC54'>				<span class="nx">key</span><span class="p">,</span> <span class="nx">modif</span> <span class="o">=</span> <span class="s2">&quot;&quot;</span><span class="p">,</span> <span class="nx">possible</span> <span class="o">=</span> <span class="p">{};</span></div><div class='line' id='LC55'><br/></div><div class='line' id='LC56'>			<span class="c1">// check combinations (alt|ctrl|shift+anything)</span></div><div class='line' id='LC57'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">event</span><span class="p">.</span><span class="nx">altKey</span> <span class="o">&amp;&amp;</span> <span class="nx">special</span> <span class="o">!==</span> <span class="s2">&quot;alt&quot;</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC58'>				<span class="nx">modif</span> <span class="o">+=</span> <span class="s2">&quot;alt+&quot;</span><span class="p">;</span></div><div class='line' id='LC59'>			<span class="p">}</span></div><div class='line' id='LC60'><br/></div><div class='line' id='LC61'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">event</span><span class="p">.</span><span class="nx">ctrlKey</span> <span class="o">&amp;&amp;</span> <span class="nx">special</span> <span class="o">!==</span> <span class="s2">&quot;ctrl&quot;</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC62'>				<span class="nx">modif</span> <span class="o">+=</span> <span class="s2">&quot;ctrl+&quot;</span><span class="p">;</span></div><div class='line' id='LC63'>			<span class="p">}</span></div><div class='line' id='LC64'><br/></div><div class='line' id='LC65'>			<span class="c1">// TODO: Need to make sure this works consistently across platforms</span></div><div class='line' id='LC66'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">event</span><span class="p">.</span><span class="nx">metaKey</span> <span class="o">&amp;&amp;</span> <span class="o">!</span><span class="nx">event</span><span class="p">.</span><span class="nx">ctrlKey</span> <span class="o">&amp;&amp;</span> <span class="nx">special</span> <span class="o">!==</span> <span class="s2">&quot;meta&quot;</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC67'>				<span class="nx">modif</span> <span class="o">+=</span> <span class="s2">&quot;meta+&quot;</span><span class="p">;</span></div><div class='line' id='LC68'>			<span class="p">}</span></div><div class='line' id='LC69'><br/></div><div class='line' id='LC70'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">event</span><span class="p">.</span><span class="nx">shiftKey</span> <span class="o">&amp;&amp;</span> <span class="nx">special</span> <span class="o">!==</span> <span class="s2">&quot;shift&quot;</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC71'>				<span class="nx">modif</span> <span class="o">+=</span> <span class="s2">&quot;shift+&quot;</span><span class="p">;</span></div><div class='line' id='LC72'>			<span class="p">}</span></div><div class='line' id='LC73'><br/></div><div class='line' id='LC74'>			<span class="k">if</span> <span class="p">(</span> <span class="nx">special</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC75'>				<span class="nx">possible</span><span class="p">[</span> <span class="nx">modif</span> <span class="o">+</span> <span class="nx">special</span> <span class="p">]</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC76'><br/></div><div class='line' id='LC77'>			<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC78'>				<span class="nx">possible</span><span class="p">[</span> <span class="nx">modif</span> <span class="o">+</span> <span class="nx">character</span> <span class="p">]</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC79'>				<span class="nx">possible</span><span class="p">[</span> <span class="nx">modif</span> <span class="o">+</span> <span class="nx">jQuery</span><span class="p">.</span><span class="nx">hotkeys</span><span class="p">.</span><span class="nx">shiftNums</span><span class="p">[</span> <span class="nx">character</span> <span class="p">]</span> <span class="p">]</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC80'><br/></div><div class='line' id='LC81'>				<span class="c1">// &quot;$&quot; can be triggered as &quot;Shift+4&quot; or &quot;Shift+$&quot; or just &quot;$&quot;</span></div><div class='line' id='LC82'>				<span class="k">if</span> <span class="p">(</span> <span class="nx">modif</span> <span class="o">===</span> <span class="s2">&quot;shift+&quot;</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC83'>					<span class="nx">possible</span><span class="p">[</span> <span class="nx">jQuery</span><span class="p">.</span><span class="nx">hotkeys</span><span class="p">.</span><span class="nx">shiftNums</span><span class="p">[</span> <span class="nx">character</span> <span class="p">]</span> <span class="p">]</span> <span class="o">=</span> <span class="kc">true</span><span class="p">;</span></div><div class='line' id='LC84'>				<span class="p">}</span></div><div class='line' id='LC85'>			<span class="p">}</span></div><div class='line' id='LC86'><br/></div><div class='line' id='LC87'>			<span class="k">for</span> <span class="p">(</span> <span class="kd">var</span> <span class="nx">i</span> <span class="o">=</span> <span class="mi">0</span><span class="p">,</span> <span class="nx">l</span> <span class="o">=</span> <span class="nx">keys</span><span class="p">.</span><span class="nx">length</span><span class="p">;</span> <span class="nx">i</span> <span class="o">&lt;</span> <span class="nx">l</span><span class="p">;</span> <span class="nx">i</span><span class="o">++</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC88'>				<span class="k">if</span> <span class="p">(</span> <span class="nx">possible</span><span class="p">[</span> <span class="nx">keys</span><span class="p">[</span><span class="nx">i</span><span class="p">]</span> <span class="p">]</span> <span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC89'>					<span class="k">return</span> <span class="nx">origHandler</span><span class="p">.</span><span class="nx">apply</span><span class="p">(</span> <span class="k">this</span><span class="p">,</span> <span class="nx">arguments</span> <span class="p">);</span></div><div class='line' id='LC90'>				<span class="p">}</span></div><div class='line' id='LC91'>			<span class="p">}</span></div><div class='line' id='LC92'>		<span class="p">};</span></div><div class='line' id='LC93'>	<span class="p">}</span></div><div class='line' id='LC94'><br/></div><div class='line' id='LC95'>	<span class="nx">jQuery</span><span class="p">.</span><span class="nx">each</span><span class="p">([</span> <span class="s2">&quot;keydown&quot;</span><span class="p">,</span> <span class="s2">&quot;keyup&quot;</span><span class="p">,</span> <span class="s2">&quot;keypress&quot;</span> <span class="p">],</span> <span class="kd">function</span><span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC96'>		<span class="nx">jQuery</span><span class="p">.</span><span class="nx">event</span><span class="p">.</span><span class="nx">special</span><span class="p">[</span> <span class="k">this</span> <span class="p">]</span> <span class="o">=</span> <span class="p">{</span> <span class="nx">add</span><span class="o">:</span> <span class="nx">keyHandler</span> <span class="p">};</span></div><div class='line' id='LC97'>	<span class="p">});</span></div><div class='line' id='LC98'><br/></div><div class='line' id='LC99'><span class="p">})(</span> <span class="nx">jQuery</span> <span class="p">);</span></div></pre></div>
          </td>
        </tr>
      </table>
  </div>

          </div>
        </div>
      </div>
    </div>

  </div>

<div class="frame frame-loading" style="display:none;" data-tree-list-url="/jeresig/jquery.hotkeys/tree-list/0451de18d57d3401bd4cc021facbe5fd63b5aae6" data-blob-url-prefix="/jeresig/jquery.hotkeys/blob/0451de18d57d3401bd4cc021facbe5fd63b5aae6">
  <img src="https://a248.e.akamai.net/assets.github.com/images/modules/ajax/big_spinner_336699.gif" height="32" width="32">
</div>

    </div>

    </div>

    <!-- footer -->
    <div id="footer" >
      
  <div class="upper_footer">
     <div class="site" class="clearfix">

       <!--[if IE]><h4 id="blacktocat_ie">GitHub Links</h4><![endif]-->
       <![if !IE]><h4 id="blacktocat">GitHub Links</h4><![endif]>

       <ul class="footer_nav">
         <h4>GitHub</h4>
         <li><a href="https://github.com/about">About</a></li>
         <li><a href="https://github.com/blog">Blog</a></li>
         <li><a href="https://github.com/features">Features</a></li>
         <li><a href="https://github.com/contact">Contact &amp; Support</a></li>
         <li><a href="https://github.com/training">Training</a></li>
         <li><a href="http://status.github.com/">Site Status</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Tools</h4>
         <li><a href="http://mac.github.com/">GitHub for Mac</a></li>
         <li><a href="http://mobile.github.com/">Issues for iPhone</a></li>
         <li><a href="https://gist.github.com">Gist: Code Snippets</a></li>
         <li><a href="http://fi.github.com/">Enterprise Install</a></li>
         <li><a href="http://jobs.github.com/">Job Board</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Extras</h4>
         <li><a href="http://shop.github.com/">GitHub Shop</a></li>
         <li><a href="http://octodex.github.com/">The Octodex</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Documentation</h4>
         <li><a href="http://help.github.com/">GitHub Help</a></li>
         <li><a href="http://developer.github.com/">Developer API</a></li>
         <li><a href="http://github.github.com/github-flavored-markdown/">GitHub Flavored Markdown</a></li>
         <li><a href="http://pages.github.com/">GitHub Pages</a></li>
       </ul>

     </div><!-- /.site -->
  </div><!-- /.upper_footer -->

<div class="lower_footer">
  <div class="site" class="clearfix">
    <!--[if IE]><div id="legal_ie"><![endif]-->
    <![if !IE]><div id="legal"><![endif]>
      <ul>
          <li><a href="https://github.com/site/terms">Terms of Service</a></li>
          <li><a href="https://github.com/site/privacy">Privacy</a></li>
          <li><a href="https://github.com/security">Security</a></li>
      </ul>

      <p>&copy; 2011 <span id="_rrt" title="0.05997s from fe3.rs.github.com">GitHub</span> Inc. All rights reserved.</p>
    </div><!-- /#legal or /#legal_ie-->

      <div class="sponsor">
        <a href="http://www.rackspace.com" class="logo">
          <img alt="Dedicated Server" height="36" src="https://a248.e.akamai.net/assets.github.com/images/modules/footer/rackspace_logo.png?v2" width="38" />
        </a>
        Powered by the <a href="http://www.rackspace.com ">Dedicated
        Servers</a> and<br/> <a href="http://www.rackspacecloud.com">Cloud
        Computing</a> of Rackspace Hosting<span>&reg;</span>
      </div>
  </div><!-- /.site -->
</div><!-- /.lower_footer -->

    </div><!-- /#footer -->

    

<div id="keyboard_shortcuts_pane" class="instapaper_ignore readability-extra" style="display:none">
  <h2>Keyboard Shortcuts <small><a href="#" class="js-see-all-keyboard-shortcuts">(see all)</a></small></h2>

  <div class="columns threecols">
    <div class="column first">
      <h3>Site wide shortcuts</h3>
      <dl class="keyboard-mappings">
        <dt>s</dt>
        <dd>Focus site search</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>?</dt>
        <dd>Bring up this help dialog</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column middle" style=&#39;display:none&#39;>
      <h3>Commit list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selection down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selection up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>c <em>or</em> o <em>or</em> enter</dt>
        <dd>Open commit</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>y</dt>
        <dd>Expand URL to its canonical form</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column last" style=&#39;display:none&#39;>
      <h3>Pull request list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selection down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selection up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>o <em>or</em> enter</dt>
        <dd>Open issue</dd>
      </dl>
    </div><!-- /.columns.last -->

  </div><!-- /.columns.equacols -->

  <div style=&#39;display:none&#39;>
    <div class="rule"></div>

    <h3>Issues</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selection down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selection up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>x</dt>
          <dd>Toggle selection</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open issue</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column middle">
        <dl class="keyboard-mappings">
          <dt>I</dt>
          <dd>Mark selection as read</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>U</dt>
          <dd>Mark selection as unread</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>e</dt>
          <dd>Close selection</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>y</dt>
          <dd>Remove selection from view</dd>
        </dl>
      </div><!-- /.column.middle -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>c</dt>
          <dd>Create issue</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Create label</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>i</dt>
          <dd>Back to inbox</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>u</dt>
          <dd>Back to issues</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>/</dt>
          <dd>Focus issues search</dd>
        </dl>
      </div>
    </div>
  </div>

  <div style=&#39;display:none&#39;>
    <div class="rule"></div>

    <h3>Issues Dashboard</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selection down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selection up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open issue</dd>
        </dl>
      </div><!-- /.column.first -->
    </div>
  </div>

  <div style=&#39;display:none&#39;>
    <div class="rule"></div>

    <h3>Network Graph</h3>
    <div class="columns equacols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt><span class="badmono">←</span> <em>or</em> h</dt>
          <dd>Scroll left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">→</span> <em>or</em> l</dt>
          <dd>Scroll right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↑</span> <em>or</em> k</dt>
          <dd>Scroll up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↓</span> <em>or</em> j</dt>
          <dd>Scroll down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Toggle visibility of head labels</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">←</span> <em>or</em> shift h</dt>
          <dd>Scroll all the way left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">→</span> <em>or</em> shift l</dt>
          <dd>Scroll all the way right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↑</span> <em>or</em> shift k</dt>
          <dd>Scroll all the way up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↓</span> <em>or</em> shift j</dt>
          <dd>Scroll all the way down</dd>
        </dl>
      </div><!-- /.column.last -->
    </div>
  </div>

  <div >
    <div class="rule"></div>
    <div class="columns threecols">
      <div class="column first" >
        <h3>Source Code Browsing</h3>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Activates the file finder</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Jump to line</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>w</dt>
          <dd>Switch branch/tag</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>y</dt>
          <dd>Expand URL to its canonical form</dd>
        </dl>
      </div>
    </div>
  </div>
</div>

    <div id="markdown-help" class="instapaper_ignore readability-extra">
  <h2>Markdown Cheat Sheet</h2>

  <div class="cheatsheet-content">

  <div class="mod">
    <div class="col">
      <h3>Format Text</h3>
      <p>Headers</p>
      <pre>
# This is an &lt;h1&gt; tag
## This is an &lt;h2&gt; tag
###### This is an &lt;h6&gt; tag</pre>
     <p>Text styles</p>
     <pre>
*This text will be italic*
_This will also be italic_
**This text will be bold**
__This will also be bold__

*You **can** combine them*
</pre>
    </div>
    <div class="col">
      <h3>Lists</h3>
      <p>Unordered</p>
      <pre>
* Item 1
* Item 2
  * Item 2a
  * Item 2b</pre>
     <p>Ordered</p>
     <pre>
1. Item 1
2. Item 2
3. Item 3
   * Item 3a
   * Item 3b</pre>
    </div>
    <div class="col">
      <h3>Miscellaneous</h3>
      <p>Images</p>
      <pre>
![GitHub Logo](/images/logo.png)
Format: ![Alt Text](url)
</pre>
     <p>Links</p>
     <pre>
http://github.com - automatic!
[GitHub](http://github.com)</pre>
<p>Blockquotes</p>
     <pre>
As Kanye West said:
> We're living the future so
> the present is our past.
</pre>
    </div>
  </div>
  <div class="rule"></div>

  <h3>Code Examples in Markdown</h3>
  <div class="col">
      <p>Syntax highlighting with <a href="http://github.github.com/github-flavored-markdown/" title="GitHub Flavored Markdown" target="_blank">GFM</a></p>
      <pre>
```javascript
function fancyAlert(arg) {
  if(arg) {
    $.facebox({div:'#foo'})
  }
}
```</pre>
    </div>
    <div class="col">
      <p>Or, indent your code 4 spaces</p>
      <pre>
Here is a Python code example
without syntax highlighting:

    def foo:
      if not bar:
        return true</pre>
    </div>
    <div class="col">
      <p>Inline code for comments</p>
      <pre>
I think you should use an
`&lt;addr&gt;` element here instead.</pre>
    </div>
  </div>

  </div>
</div>

    <div class="context-overlay"></div>

    
    
    
  </body>
</html>

