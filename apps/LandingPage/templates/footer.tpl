<!-- @TODO ADD the currently GA -->
{literal}
    <script>
        /*
         * @param {string} url
         * @param {string} nome
         * @param {int} popupWidth
         * @param {int} popupHeight
         * @returns {Window|popup.win}
         */
        function popup(url, nome, popupWidth, popupHeight) { // optional parameters: [, statusbar='no']
            var argv = arguments, wPlus = 0, hPlus = 0;
            var argc = arguments.length;
            var statusbar = (argc > 4) ? argv[4] : 'no';

            if (popupWidth > screen.width - 10) {
                popupWidth = screen.width - 10;
                wPlus = 5;
            }
            if (popupHeight > screen.height - 64) {
                popupHeight = screen.height - 66;
                hPlus = 33;
            }
            var esq = (screen.width / 2) - (popupWidth / 2) - wPlus;
            var cima = (screen.height / 2) - (popupHeight / 2) - hPlus;
            var win = window.open(url, nome, 'width=' + popupWidth + ',height=' + popupHeight + ',top=' + cima + ',left=' + esq + ',resizable=yes,scrollbars=yes,status=' + statusbar);
            win.focus();
            return win;
        }
    </script>
{/literal}

<div id="menu-burger-box" class="menu-burger-box">
    <div id="menuclose" class="menuclose">X</div>
    <div class="logo-mobile-menu-box txt-center">
        <a href="/" rel="home">	
            <img class="" src="{getstaticurl filepath='/apps/LandingPage/images/m-portugalgov-w.svg'}" alt="logo-white-PortugalGov">
        </a>
    </div>
    <div class="register-mobile-menu-box txt-center">
        <div class="menu-main-menu-container"><ul id="primary-m-menu" class="menu">
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10">
                    <a href="?action=inscricaoFornecedor">##NG_REGISTAR##</a>
                </li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-11">
                    <a href="?action=login">##ENTRAR##</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="txt-mobile-menu-box txt-center">
        <div class="menu-anchors-container"><ul id="anchors-m-menu" class="menu">
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-575">
                    <a href="?action=showConcursosPublicos">##NG_CONCURSOS##</a>
                </li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-14">
                    <a href="{$PLATFORM_LINK_1}">##SUPORTE_C##</a>
                </li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-155">
                    <a href="{$PLATFORM_LINK_2}">##ONLINE_STORE##</a>
                </li>
            </ul>
        </div>
    </div>
    <hr>
    <div class="footer-ham-menu txt-center">
        <div class="menu-footer-menu-container">
            <ul id="mobile-menu" class="menu">
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-124">
                    <a href="{$PLATFORM_LINK_3}">##SOBRE_GATEWIT##</a>
                </li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-16">
                    <a target="_blank" href="?action=downloadTOC">##NG_TERMOS_E_CONDICOES##</a>
                </li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-71">
                    <a href="{$PLATFORM_LINK_4}">##NG_POLITICA_DE_PRIVACIDADE##</a>
                </li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-179">
                    <a href="{$PLATFORM_LINK_5}">##NG_SUGESTOES_E_RECLAMACOES##</a>
                </li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-75">
                    <a href="{$PLATFORM_LINK_6}">##FAQ##</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="copyrights-mobile-menu-box txt-center">{'Y'|date} ##NG_CONSTRULINK_TODOS_OS_DIREITOS_RESERVADOS##</div>
</div>

<!--[if (gte IE 6)&(lte IE 8)]>
<script src="/apps/LandingPage/scripts/selectivizr.js"></script>
<![endif]-->

<script src="{getstaticurl filepath='/apps/LandingPage/scripts/popup_custom.min.js'}"></script>
<script src="{getstaticurl filepath='/apps/LandingPage/scripts/plugins.js'}"></script>
<script src="{getstaticurl filepath='/apps/LandingPage/scripts/main.js'}"></script>
</body>
</html>
