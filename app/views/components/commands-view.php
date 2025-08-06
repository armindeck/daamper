<details>
    <summary><?= Language("commands") ?></summary>
    <div class="flex-column t-14">
        <details>
            <summary><?= Language("images") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("local") ?>:</span>
                    <p class="campo" title="<img src=&quot;./assets/img/image.png&quot; loading=&quot;lazy&quot;>"><span class="text-command">img[</span><small>image.png</small><span class="text-command">]img;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("link") ?>:</span>
                    <p class="campo" title="<img src=&quot;https://.com/image.png&quot; loading=&quot;lazy&quot;>"><span class="text-command">img[</span><small>https://.com/image.png</small><span class="text-command">]img;</span></p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("video") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("link") ?>:</span>
                    <p class="campo" title="<iframe width=&quot;800&quot; height=&quot;450&quot; src=&quot;https://.com/video.mp4&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share&quot; allowfullscreen></iframe>"><span class="text-command">video-iframe[</span><small>https://.com/video.mp4</small><span class="text-command">]video-iframe;</span></p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("titles") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span>H1:</span>
                    <p class="campo" title="<h1><?= Language("title") ?></h1>"><span class="text-command">h1[</span><small><?= Language("title") ?></small><span class="text-command">]h1;</span></p>
                </label>
                <label class="flex-between">
                    <span>H2:</span>
                    <p class="campo" title="<h2><?= Language("title") ?></h2>"><span class="text-command">h2[</span><small><?= Language("title") ?></small><span class="text-command">]h2;</span></p>
                </label>
                <label class="flex-between">
                    <span>H3:</span>
                    <p class="campo" title="<h3><?= Language("title") ?></h3>"><span class="text-command">h3[</span><small><?= Language("title") ?></small><span class="text-command">]h3;</span></p>
                </label>
                <label class="flex-between">
                    <span>H4:</span>
                    <p class="campo" title="<h4><?= Language("title") ?></h4>"><span class="text-command">h4[</span><small><?= Language("title") ?></small><span class="text-command">]h4;</span></p>
                </label>
                <label class="flex-between">
                    <span>H5:</span>
                    <p class="campo" title="<h5><?= Language("title") ?></h5>"><span class="text-command">h5[</span><small><?= Language("title") ?></small><span class="text-command">]h5;</span></p>
                </label>
                <label class="flex-between">
                    <span>H6:</span>
                    <p class="campo" title="<h6><?= Language("title") ?></h6>"><span class="text-command">h6[</span><small><?= Language("title") ?></small><span class="text-command">]h6;</span></p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("list-and-items") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("list") ?>:</span>
                    <p class="campo" title="<ol><li><?= Language("content") ?></li></ol>">
                        <span class="text-command">list[</span>
                        <small>
                            <span class="text-command">item[</span><?= Language("content") ?><span class="text-command">]item;</span>
                        </small>
                        <span class="text-command">]list;</span>
                    </p>
                </label>
                <label class="flex-between">
                    <span><?= Language("items") ?>:</span>
                    <p class="campo" title="<ul><li><?= Language("content") ?></li></ul>">
                        <span class="text-command">items[</span>
                        <small>
                            <span class="text-command">item[</span><?= Language("content") ?><span class="text-command">]item;</span>
                        </small>
                        <span class="text-command">]items;</span>
                    </p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("icon") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span>Font Awesome:</span>
                    <p class="campo" title="<i class=&quot;fas fa-hamburger&quot;></i>"><span class="text-command">icon[</span><small>fas fa-hamburger <i class="fas fa-hamburger"></i></small><span class="text-command">]icon;</span></p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("links") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("link") ?>:</span>
                    <p class="campo" title="<a href=&quot;https://.com/&quot;><?= Language("text") ?></a>">
                        <span class="text-command">link[</span><small>https://.com/</small><span class="text-command">]/[</span><small><?= Language("text") ?></small><span class="text-command">]link;</span>
                    </p>
                </label>
                <label class="flex-between">
                    <span><?= Language("external") ?>:</span>
                    <p class="campo" title="<a target=&quot;_blank&quot; href=&quot;https://.com/&quot;><?= Language("text") ?></a>">
                        <span class="text-command">link-external[</span><small>https://.com/</small><span class="text-command">]/[</span><small><?= Language("text") ?></small><span class="text-command">]link;</span>
                    </p>
                </label>
                <label class="flex-between">
                    <span><?= Language("external-and-ignore") ?>:</span>
                    <p class="campo" title="<a target=&quot;_blank&quot; rel=&quot;nofollow noreferrer&quot; href=&quot;https://.com/&quot;><?= Language("text") ?></a>">
                        <span class="text-command">link-ignore[</span><small>https://.com/</small><span class="text-command">]/[</span><small><?= Language("text") ?></small><span class="text-command">]link;</span>
                    </p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("buttons") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("local-and-link") ?>:</span>
                    <p class="campo" title="<a class=&quot;boton&quot; href=&quot;https://.com/&quot;><?= Language("text") ?></a>">
                        <span class="text-command">button[</span><small>https://.com/</small><span class="text-command">]/[</span><small><?= Language("text") ?></small><span class="text-command">]button;</span>
                    </p>
                </label>
                <label class="flex-between">
                    <span><?= Language("external") ?>:</span>
                    <p class="campo" title="<a class=&quot;boton&quot; target=&quot;_blank&quot; href=&quot;https://.com/&quot;><?= Language("text") ?></a>">
                        <span class="text-command">button-external[</span><small>https://.com/</small><span class="text-command">]/[</span><small><?= Language("text") ?></small><span class="text-command">]button;</span>
                    </p>
                </label>
                <label class="flex-between">
                    <span><?= Language("external-and-ignore") ?>:</span>
                    <p class="campo" title="<a class=&quot;boton&quot; target=&quot;_blank&quot; rel=&quot;nofollow noreferrer&quot; href=&quot;https://.com/&quot;><?= Language("text") ?></a>">
                        <span class="text-command">button-ignore[</span><small>https://.com/</small><span class="text-command">]/[</span><small><?= Language("text") ?></small><span class="text-command">]button;</span>
                    </p>
                </label>
                <details>
                    <summary><?= Language("others") ?></summary>
                    <div class="flex-evenly">
                        <small class="campo" title="button-2[https://.com]/[Text]button;">button-2</small>
                        <small class="campo" title="button-2-external[https://.com]/[Text]button;">button-2-external</small>
                        <small class="campo" title="button-2-ignore[https://.com]/[Text]button;">button-2-ignore</small>
                        <small class="campo" title="button-mini[https://.com]/[Text]button;">button-mini</small>
                        <small class="campo" title="button-mini-external[https://.com]/[Text]button;">button-mini-external</small>
                        <small class="campo" title="button-mini-ignore[https://.com]/[Text]button;">button-mini-ignore</small>
                        <small class="campo" title="button-2-mini[https://.com]/[Text]button;">button-2-mini</small>
                        <small class="campo" title="button-2-mini-external[https://.com]/[Text]button;">button-2-mini-external</small>
                        <small class="campo" title="button-2-mini-ignore[https://.com]/[Text]button;">button-2-mini-ignore</small>
                    </div>
                </details>
            </div>
        </details>
        <details>
            <summary><?= Language("texts") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("paragraph") ?>:</span>
                    <p class="campo" title="<p><?= Language("text") ?></p>"><span class="text-command">p[</span><small><?= Language("text") ?></small><span class="text-command">]p;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("bold-text") ?>:</span>
                    <p class="campo" title="<strong><?= Language("text") ?></strong>"><span class="text-command">strong[</span><small><strong><?= Language("text") ?></strong></small><span class="text-command">]strong;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("bold-text") ?>:</span>
                    <p class="campo" title="<strong><?= Language("text") ?></strong>"><span class="text-command">*[</span><small><strong><?= Language("text") ?></strong></small><span class="text-command">]*;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("small-text") ?>:</span>
                    <p class="campo" title="<small><?= Language("text") ?></small>"><span class="text-command">small[</span><small><?= Language("text") ?></small><span class="text-command">]small;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("italic-text") ?>:</span>
                    <p class="campo" title="<i><?= Language("text") ?></i>"><span class="text-command">italic[</span><small><i><?= Language("text") ?></i></small><span class="text-command">]italic;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("italic-text") ?>:</span>
                    <p class="campo" title="<i>~ <?= Language("text") ?></i>"><span class="text-command">~[</span><small><i><?= Language("text") ?></i></small><span class="text-command">]~;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("text-field") ?>:</span>
                    <p class="campo" title="<span class=&quot;text-field&quot;><?= Language("text") ?></span>"><span class="text-command">text-field[</span><small><?= Language("text") ?></small><span class="text-command">]text-field;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("small-text-field") ?>:</span>
                    <p class="campo" title="<span class=&quot;text-field text-field-small&quot;><?= Language("text") ?></span>"><span class="text-command">text-field-small[</span><small><?= Language("text") ?></small><span class="text-command">]text-field;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("tiny-text-field") ?>:</span>
                    <p class="campo" title="<span class=&quot;text-field text-field-mini&quot;><?= Language("text") ?></span>"><span class="text-command">text-field-mini[</span><small><?= Language("text") ?></small><span class="text-command">]text-field;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("tiny-small-text-field") ?>:</span>
                    <p class="campo" title="<span class=&quot;text-field text-field-mini-small&quot;><?= Language("text") ?></span>"><span class="text-command">text-field-mini-small[</span><small><?= Language("text") ?></small><span class="text-command">]text-field;</span></p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("content") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("section") ?>:</span>
                    <p class="campo" title="<section><?= Language("content") ?></section>"><span class="text-command">section[</span><small><?= Language("content") ?></small><span class="text-command">]section;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("content") ?>:</span>
                    <p class="campo" title="<div class=&quot;con&quot;><?= Language("content") ?></div>"><span class="text-command">content[</span><small><?= Language("content") ?></small><span class="text-command">]content;</span></p>
                </label>
                <label class="flex-between">
                    <span>div:</span>
                    <p class="campo" title="<div><?= Language("content") ?></div>"><span class="text-command">div[</span><small><?= Language("content") ?></small><span class="text-command">]div;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("center") ?>:</span>
                    <p class="campo" title="<center><?= Language("content") ?></center>"><span class="text-command">center[</span><small><?= Language("content") ?></small><span class="text-command">]center;</span></p>
                </label>
                <label class="flex-between">
                    <span>details:</span>
                    <p class="campo" title="<details><?= Language("content") ?></section></details>"><span class="text-command">details[</span><small><?= Language("content") ?></small><span class="text-command">]details;</span></p>
                </label>
                <label class="flex-between">
                    <span>details open:</span>
                    <p class="campo" title="<details open><?= Language("content") ?></section></details>"><span class="text-command">details-open[</span><small><?= Language("content") ?></small><span class="text-command">]details;</span></p>
                </label>
                <label class="flex-between">
                    <span>summary:</span>
                    <p class="campo" title="<summary><?= Language("title") ?></summary><section>"><span class="text-command">summary[</span><small><?= Language("title") ?></small><span class="text-command">]summary;</span></p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("others") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("close-tag") ?>:</span>
                    <p class="campo" title="&quot;>"><span class="text-command">]/[</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("spacings") ?>:</span>
                    <p class="campo" title="<span style=&quot;margin-left: 16px;&quot;></span> / `--` / `---` / `----` / etc"><span class="text-command">`-`</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("ignore") ?>:</span>
                    <p class="campo" title="<?= htmlspecialchars("&lt;") ?>"><span class="text-command">`<`</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("ignore") ?>:</span>
                    <p class="campo" title="<?= htmlspecialchars("&gt;") ?>"><span class="text-command">`>`</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("ignore-commands") ?>:</span>
                    <p class="campo" title="p[<?= Language("text") ?>]p; | `strong[`<?= Language("text") ?>`]strong;` : strong[<?= Language("text") ?>]strong; | `link[`https://.com`]/[`<?= Language("text") ?>`]link;` : link[https://.com]/[<?= Language("text") ?>]link;"><span class="text-command">`p[`<?= Language("text") ?>`]p;`</span></p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("system") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("version") ?>:</span>
                    <p class="campo" title="<?= Daamper::$version["system"]["version"] ?>"><span class="text-command">cmd[version];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("state") ?>:</span>
                    <p class="campo" title="<?= Daamper::$version["system"]["state"] ?>"><span class="text-command">cmd[state];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("updated") ?>:</span>
                    <p class="campo" title="<?= Daamper::$version["system"]["updated"] ?>"><span class="text-command">cmd[updated];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("created") ?>:</span>
                    <p class="campo" title="<?= Daamper::$version["system"]["created"] ?>"><span class="text-command">cmd[created];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("license") ?>:</span>
                    <p class="campo" title="<?= Daamper::$version["system"]["license"] ?>"><span class="text-command">cmd[license];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("creator") ?>:</span>
                    <p class="campo" title="<?= Daamper::$info["author"] ?>"><span class="text-command">cmd[creator];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("social-name") ?>:</span>
                    <p class="campo" title="<?= Daamper::$info["author-page-name"] ?>"><span class="text-command">cmd[creator-page-name];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("social-link") ?>:</span>
                    <p class="campo" title="<?= Daamper::$info["author-page-url"] ?>"><span class="text-command">cmd[creator-page-link];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("social-networks") ?>:</span>
                    <?php $social_system = ""; foreach (Daamper::$info["social-networks"] as $key => $value) {
                        $social_system .= '<a target="_blank" href="'.($value["link"]).'"><i class="'.($value["icono"]).'"></i> '.($value["name"]).'</a> ';
                    } ?>
                    <p class="campo" title="<?= htmlspecialchars($social_system) ?>"><span class="text-command">cmd[creator-social-networks];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("directory") ?>:</span>
                    <p class="campo" title="<?= $Web["directorio"] ?>"><span class="text-command">cmd[directory];</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("image-directory") ?>:</span>
                    <p class="campo" title="<?= (isset($Web['config']['https_imagen']) ? $Web['config']['https_imagen'] : '') . 'assets/img/' ?>"><span class="text-command">cmd[directory_image_complete];</span></p>
                </label>
            </div>
        </details>
        <details>
            <summary><?= Language("ignore") ?></summary>
            <div class="flex-column">
                <label class="flex-between">
                    <span><?= Language("local-image") ?>:</span>
                    <p class="campo" title="<img loading=&quot;lazy&quot; src=&quot;./assets/img/image.png&quot;>"><span class="text-command">imgl{</span><small>image.png</small><span class="text-command">};</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("image-link") ?>:</span>
                    <p class="campo" title="<img loading=&quot;lazy&quot; src=&quot;https://.com/image.png&quot;>"><span class="text-command">img{</span><small>https://.com/image.png</small><span class="text-command">};</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("video") ?>:</span>
                    <p class="campo" title="<iframe width=&quot;800&quot; height=&quot;450&quot; src=&quot;https://.com/video.mp4&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share&quot; allowfullscreen></iframe>"><span class="text-command">iframe{</span><small>https://.com/video.mp4</small><span class="text-command">}iframe;</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("bold-text") ?>:</span>
                    <p class="campo" title="<strong><?= Language("text") ?></strong>"><span class="text-command">b[</span><small><strong><?= Language("text") ?></strong></small><span class="text-command">]/b</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("italic-text") ?>:</span>
                    <p class="campo" title="<?= Language("text") ?></i>"><small><i><?= Language("text") ?></i></small><span class="text-command">]/~</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("items") ?>:</span>
                    <p class="campo" title="<ul></ul>"><span class="text-command">ul[</span><span class="text-command">]/ul</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("section") ?>:</span>
                    <p class="campo" title="<?= Language("content") ?></section>"><small><?= Language("content") ?></small><span class="text-command">]/section</span></p>
                </label>
                <label class="flex-between">
                    <span>details:</span>
                    <p class="campo" title="<?= Language("content") ?></section></details>"><small><?= Language("content") ?></small><span class="text-command">]/details</span></p>
                </label>
                <label class="flex-between">
                    <span>details open:</span>
                    <p class="campo" title="<?= Language("content") ?></section></details>"><small><?= Language("content") ?></small><span class="text-command">]/details-open</span></p>
                </label>
                <label class="flex-between">
                    <span>summary:</span>
                    <p class="campo" title="<?= Language("title") ?></summary><section>"><small><?= Language("title") ?></small><span class="text-command">]/summary</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("title") ?>:</span>
                    <p class="campo" title="<?= Language("title") ?></h1>"><small><?= Language("title") ?></small><span class="text-command">]/h1</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("title") ?>:</span>
                    <p class="campo" title="<?= Language("title") ?></h2>"><small><?= Language("title") ?></small><span class="text-command">]/h2</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("title") ?>:</span>
                    <p class="campo" title="<?= Language("title") ?></h3>"><small><?= Language("title") ?></small><span class="text-command">]/h3</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("title") ?>:</span>
                    <p class="campo" title="<?= Language("title") ?></h4>"><small><?= Language("title") ?></small><span class="text-command">]/h4</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("title") ?>:</span>
                    <p class="campo" title="<?= Language("title") ?></h5>"><small><?= Language("title") ?></small><span class="text-command">]/h5</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("title") ?>:</span>
                    <p class="campo" title="<?= Language("title") ?></h6>"><small><?= Language("title") ?></small><span class="text-command">]/h6</span></p>
                </label>
                <label class="flex-between">
                    <span><?= Language("close-tag") ?>:</span>
                    <p class="campo" title="&quot;>"><span class="text-command">};</span></p>
                </label>
            </div>
        </details>
    </div>
</details>