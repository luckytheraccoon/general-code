<!DOCTYPE html>
<html class="no-js" lang="{$language}">
    <head>
        <title>##COMPRAS_PUBLICAS_BY_GWT##</title>
        <link rel="icon" href="{getstaticurl filepath='/img/favicon.png'}">
        <meta http-equiv="Content-Type" content="text/html; charset={$CHARSET_ENCODING}">
        <meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{$PLATFORM_NAME}: plataforma electr&oacute;nica de contrata&ccedil;&atilde;o p&uacute;blica" />
        <meta name="keywords" content="compras, p&uacute;blicas, concursos, {$COMPANY_NAME}, contrata&ccedil;&atilde;o, procedimentos, ajustes directos, certificados" />
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:600,400,300' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="{getstaticurl filepath='/apps/LandingPage/styles/vendor.css'}">

        <link rel="stylesheet" href="{getstaticurl filepath='/apps/LandingPage/styles/font-awesome.min.css'}">
        <link rel="stylesheet" href="{getstaticurl filepath='/apps/LandingPage/styles/main.css'}">

        <script src="{getstaticurl filepath='/apps/LandingPage/scripts/modernizr.js'}"></script>

        <script src="{getstaticurl filepath='/apps/LandingPage/scripts/vendor.js'}"></script>

        <script src="{getstaticurl filepath='/apps/LandingPage/scripts/cookies.js'}"></script>
        <script src="{getstaticurl filepath='/js/js_functions.js'}"></script>
        <script src="{getstaticurl filepath='/apps/LandingPage/scripts/jquery.scrollTo.min.js'}"></script>

        <link rel="stylesheet" href="{getstaticurl filepath='/css/jquery-ui.css'}">
        <link rel="stylesheet" href="{getstaticurl filepath='/css/jquery.ui.dialog.css'}">
        <script src="{getstaticurl filepath='/js/jquery-ui-1.8.1.custom.min.js'}"></script>

        {literal}
            <script>
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-11791162-2']);
                _gaq.push(['_setDomainName', '.' + '{/literal}{$PLATFORM_URL}{literal}']);
                _gaq.push(['_trackPageview']);

                (function () {
                    var ga = document.createElement('script');
                    ga.type = 'text/javascript';
                    ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(ga, s);
                })();
            </script>
            <script src='https://www.google.com/recaptcha/api.js'></script>
        {/literal}

    </head>
    <body {if isset($javaWebStart)}class="login__entry"{/if}>
        <header class="main__header">
            <div class="container container-header">
                <div class="site-branding desktop-logo">
                    <a href="/" rel="home">	
                        <img class="logo-site header-logo-nav" src="{getstaticurl filepath='/apps/LandingPage/images/portugalGov.svg'}" alt="logo-white-PortugalGov">
                    </a>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="double-menu main-navigation register-nav">

                    <div class="menu-main-menu-container">
                        <ul id="primary-menu" class="menu">
                            <li class="menu-item">
                                <a href="{linkTo path='inscricaoFornecedor'}">##NG_REGISTAR##</a></li>
                            <li class="menu-item">
                                <a href="{linkTo path='login'}">##ENTRAR##</a>
                            </li>
                        </ul>
                    </div>				
                </nav><!-- #site-navigation -->

                <div id="hamburger" class="hamburger">
                    <div class="hamburger-inner"></div>
                </div>
            </div>
        </header>
        <div class="link-menu-pages txt-right">
            <div class="container">
                <div class="menu-anchors-container">
                    <ul id="anchors-menu" class="menu">
                        <li class="menu-item"><a href="?action=showConcursosPublicos">##NG_CONCURSOS##</a></li>
                        <li class="menu-item"><a href="{$PLATFORM_LINK_1}">##SUPORTE_C##</a></li>
                        <li class="menu-item"><a href="{$PLATFORM_LINK_2}">##ONLINE_STORE##</a></li>
                    </ul>
                </div>				
            </div>
        </div>